<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use App\User;
use App\Packpub;
use App\Contrat;
use App\Filleul;
use App\Parametre;
use App\Historique;
use App\Historiquecontrat;
use App\Article;
use App\Facture;
use App\Tva;
use Illuminate\Support\Facades\Mail;
use App\Mail\CreationMandataire;
use App\Mail\SendContratSignature;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File ;
use Illuminate\Support\Facades\Storage;
use Auth;
use PDF;
use iio\libmergepdf\Merger;



class ContratController extends Controller
{

     /**
     * Déserialiser le palier
     *
     * @return \Illuminate\Http\Response
     */
    public function palier_unserialize($param)
    {
        // on construit un tableau sans les &
        $palier = explode("&", $param);
        $array = array();
        foreach($palier as $pal)
        {
            // pour chaque element du tableau, on extrait la valeur
            $tmp = substr($pal , strpos($pal, "=") + 1, strlen($pal));
            array_push($array, $tmp);
        }
        // on divise le nouveau tableau de valeur en 4 tableau de même taille
        $chunk = array_chunk($array, 4);
        // syupprime le premier tableau de notre tableau
        array_shift($chunk);

        return $chunk;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($user_id)
    {
        //
        $parrains = User::where([['role','mandataire'], ['id','<>', Crypt::decrypt($user_id)]])->get();
        $modele = Contrat::where('est_modele',true)->first();
        $mandataire = User::where('id', Crypt::decrypt($user_id))->first();
        $packs_pub = Packpub::all();
        $passerelles = Article::where('a_expire', 0)->get();

        return view ('contrat.add', compact(['parrains','user_id','packs_pub','modele','mandataire','passerelles']));
    }

    /**
     * Creation du model de contrat.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($contrat_id)
    {
        //
        $contrat = Contrat::where('id',Crypt::decrypt($contrat_id))->first() ;         
        $packs_pub = Packpub::all();
        $parrains = User::where([['role','mandataire'], ['id','<>', $contrat->user->id]])->get();
        
        $parrain_id =   Filleul::where('user_id',$contrat->user->id)->select('parrain_id')->first();
        $parrain = $parrain_id != null ? User::where('id',$parrain_id['parrain_id'])->first() : null;
       
        
        $filleuls = Filleul::where('parrain_id', $contrat->user->id)->get();
        // dd($contrat->user);
        $comm_filleuls = array();
        foreach ($filleuls as $filleul) {
        
        // dd($filleul);
            $cont = Contrat::where('user_id', $filleul->user_id)->first() ;         
            
            $comm_filleuls[] = array( $cont->user ,unserialize($cont->comm_parrain)) ;
        }
        // dd($comm_filleuls);
        
        $palier_starter =  $contrat != null ?  $this->palier_unserialize($contrat->palier_starter) : null;
        $palier_expert =  $contrat != null ? $this->palier_unserialize($contrat->palier_expert) : null;
   
        $comm_parrain = unserialize($contrat->comm_parrain ); 

    
        return view ('contrat.edit', compact(['packs_pub','parrain','parrains','contrat','palier_starter','palier_expert','comm_parrain', 'comm_filleuls']));
  
    }


    /**
     * Modification du contrat
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $contrat_id)
    {
        $contrat = Contrat::where('id',Crypt::decrypt($contrat_id))->first() ;               

        // ######## SAUVEGARDE HISTORIQUE ######### 
    //  $test = $contrat->a_palier_expert == ($request->check_palier_expert == "true" ? true : false) ? false : true ;
     
    //  return "--$test";
     
    //  file_put_contents("data.txt",$contrat  );
        // dd($request->all());
        // $contrat->contrat_pdf == $request->contrat_pdf 
        $est_starter =  $request->est_starter == "true" ? true : false;
        Historiquecontrat::create([
        
            "user_id" => $contrat->user_id,
            // infos basiques 
            "forfait_entree" => $contrat->forfait_entree,
            "modif_forfait_entree" => $contrat->forfait_entree == ( $request->forfait_administratif + $request->forfait_carte_pro) ? false : true ,
            "forfait_administratif" => $contrat->forfait_administratif,
            "modif_forfait_administratif" => $contrat->forfait_administratif == $request->forfait_administratif ? false : true ,
            "forfait_carte_pro" => $contrat->forfait_carte_pro,
            "modif_forfait_carte_pro" => $contrat->forfait_carte_pro == $request->forfait_carte_pro ? false : true ,
            "forfait_pack_info" => $contrat->forfait_pack_info,
            "modif_forfait_pack_info" => $contrat->forfait_pack_info == $request->forfait_pack_info ? false : true ,
            
            
            "date_entree" => $contrat->date_entree,
            "modif_date_entree" => $contrat->date_entree->format('Y-m-d') == $request->date_entree ? false : true ,
            "date_deb_activite" => $contrat->date_deb_activite,
            "modif_date_deb_activite" => $contrat->date_deb_activite->format('Y-m-d') == $request->date_debut ? false : true ,
            "date_anniversaire" => $contrat->date_anniversaire, 

            "ca_depart" => $contrat->ca_depart,
            "modif_ca_depart" => $contrat->ca_depart == $request->ca_depart ? false : true ,
            "ca_depart_sty" => $contrat->ca_depart_sty,
            "modif_ca_depart_sty" => $contrat->ca_depart_sty == $request->ca_depart_sty ? false : true ,
            "est_demarrage_starter" => $contrat->est_demarrage_starter,
            "modif_est_demarrage_starter" => $contrat->est_demarrage_starter == $est_starter ? false : true ,
            "modif_est_soumis_fact_pub" => $contrat->est_soumis_fact_pub == $request->est_soumis_fact_pub ? false : true ,
            "est_soumis_fact_pub" =>$request->est_soumis_fact_pub == "true" ? true : false  ,
            "a_parrain" => $contrat->a_parrain,
            "modif_a_parrain" => $contrat->a_parrain == ($request->a_parrain == "true" ? true : false) ? false : true ,
            "parrain_id" => $contrat->parrain_id,
            
            "a_condition_parrain" => $contrat->a_condition_parrain,
            

// Commission direct pack starter
            "pourcentage_depart_starter" => $contrat->pourcentage_depart_starter,
            "modif_pourcentage_depart_starter" => $contrat->pourcentage_depart_starter == $request->pourcentage_depart_starter ? false : true ,
            "duree_max_starter" => $contrat->duree_max_starter,
            "modif_duree_max_starter" => $contrat->duree_max_starter == $request->duree_max_starter ? false : true ,
            "duree_gratuite_starter" => $contrat->duree_gratuite_starter,
            "modif_duree_gratuite_starter" => $contrat->duree_gratuite_starter == $request->duree_gratuite_starter ? false : true ,
            "a_palier_starter" => $contrat->a_palier_starter,
            "modif_a_palier_starter" => $contrat->a_palier_starter == ($request->check_palier_starter == "true" ? true : false) ? false : true ,
            
            "palier_starter" => $contrat->palier_starter,

//  Commission direct pack expert
            "pourcentage_depart_expert" => $contrat->pourcentage_depart_expert,
            "modif_pourcentage_depart_expert" => $contrat->pourcentage_depart_expert == $request->pourcentage_depart_expert ? false : true ,
            "duree_max_starter_expert" => $contrat->duree_max_starter_expert,
            "modif_duree_max_starter_expert" => $contrat->duree_max_starter_expert == $request->duree_max_starter ? false : true ,
            "nb_vente_passage_expert" => $contrat->nb_vente_passage_expert,
            "modif_nb_vente_passage_expert" => $contrat->nb_vente_passage_expert == $request->nb_vente_passage_expert ? false : true ,
            "duree_gratuite_expert" => $contrat->duree_gratuite_expert,
            "modif_duree_gratuite_expert" => $contrat->duree_gratuite_expert == $request->duree_gratuite_expert ? false : true ,
            
            "duree_pack_info_starter" => $contrat->duree_pack_info_starter,
            "modif_duree_pack_info_starter" => $contrat->duree_pack_info_starter == $request->duree_pack_info_starter ? false : true ,
            
            "duree_pack_info_expert" => $contrat->duree_pack_info_expert,
            "modif_duree_pack_info_expert" => $contrat->duree_pack_info_expert == $request->duree_pack_info_expert ? false : true ,
            
            // "nb_vente_gratuite_expert" => $contrat->nb_vente_gratuite_expert,
            // "modif_nb_vente_gratuite_expert" => $contrat->nb_vente_gratuite_expert == $request->nb_vente_gratuite_expert ? false : true ,
            
            "a_palier_expert" => $contrat->a_palier_expert,
            "modif_a_palier_expert" => $contrat->a_palier_expert == ($request->check_palier_expert == "true" ? true : false) ? false : true ,
            "palier_expert" => $contrat->palier_expert,
            
            "nombre_vente_min" => $contrat->nombre_vente_min,
            "modif_nombre_vente_min" => $contrat->nombre_vente_min == $request->nombre_vente_min ? false : true ,
            "nombre_mini_filleul" => $contrat->nombre_mini_filleul,
            "modif_nombre_mini_filleul" => $contrat->nombre_mini_filleul == $request->nombre_mini_filleul ? false : true ,
            "chiffre_affaire_mini" => $contrat->chiffre_affaire_mini,
            "modif_chiffre_affaire_mini" => $contrat->chiffre_affaire_mini == $request->chiffre_affaire_mini ? false : true ,
            "a_soustraitre" => $contrat->a_soustraitre,
            "modif_a_soustraitre" => $contrat->a_soustraitre == $request->a_soustraitre ? false : true ,
            "a_condition_expert" => $contrat->a_condition_expert,
            "est_soumis_tva" => $contrat->est_soumis_tva,
            "modif_est_soumis_tva" => $contrat->est_soumis_tva == ($request->est_soumis_tva  == "true"  ? true : false) ? false : true ,
            "deduis_jeton" => $contrat->deduis_jeton,
            "modif_deduis_jeton" => $contrat->deduis_jeton == ($request->deduis_jeton == "true"  ? true : false) ? false : true ,


// parrainage
            "prime_forfaitaire" => $contrat->prime_forfaitaire,
            "seuil_comm" => $contrat->seuil_comm,
            "modif_seuil_comm" => $contrat->seuil_comm == $request->seuil_comm ? false : true ,
            "comm_parrain" => $contrat->comm_parrain,


// Pack pub
            "packpub_id" => $contrat->packpub_id,
            "modif_packpub_id" => $contrat->packpub_id == $request->pack_pub ? false : true ,

// Démission
            "a_demission" => $contrat->a_demission,
            "modif_a_demission" => $contrat->a_demission == ($request->a_demission == "true" ? true : false ) ? false : true ,
            "date_demission" => $contrat->date_demission,
            "modif_date_demission" => $contrat->date_demission == $request->date_demission ? false : true ,
            "date_fin_preavis" => $contrat->date_fin_preavis,
            "modif_date_fin_preavis" => $contrat->date_fin_preavis == $request->date_fin_preavis ? false : true ,
            "date_fin_droit_suite" => $contrat->date_fin_droit_suite,
            "modif_date_fin_droit_suite" => $contrat->date_fin_droit_suite == $request->date_fin_droit_suite ? false : true ,
        
// Contrat et annexe pdf

            "contrat_pdf" => $contrat->contrat_pdf,
            "modif_contrat_pdf" =>  $request->contrat_pdf == null ? false : true ,
        ]);
        
        // ######## FIN SAUVEGARDE HISTORIQUE ######### 



        // infos basiques
        $contrat->forfait_entree = $request->forfait_administratif + $request->forfait_carte_pro;
        $contrat->forfait_administratif = $request->forfait_administratif;
        $contrat->forfait_carte_pro = $request->forfait_carte_pro;
        $contrat->forfait_pack_info = $request->forfait_pack_info;
        
    
        $contrat->date_entree = $request->date_entree;
        $contrat->date_deb_activite = $request->date_debut;
        if($contrat->ca_depart != $request->ca_depart){

            $contrat->user->chiffre_affaire = $contrat->user->chiffre_affaire - $contrat->ca_depart + $request->ca_depart;
            $contrat->ca_depart = $request->ca_depart;
            $contrat->user->update();
        }
        if($contrat->ca_depart_sty != $request->ca_depart_sty){
            $contrat->user->chiffre_affaire_sty = $contrat->user->chiffre_affaire_sty - $contrat->ca_depart_sty + $request->ca_depart_sty;
            $contrat->ca_depart_sty = $request->ca_depart_sty;
            $contrat->user->update();
        }
        
        
        $contrat->est_demarrage_starter = $request->est_starter == "true" ? true : false;
        
        
        // Commission direct pack starter 
        $mandataire =  $contrat->user;
 
     
        if($contrat->user->pack_actuel == "starter" && $contrat->pourcentage_depart_starter != $request->pourcentage_depart_starter){
            $mandataire->commission = $request->pourcentage_depart_starter;
            $mandataire->chiffre_affaire = 0;
            $mandataire->chiffre_affaire_sty = 0;
            $mandataire->update();
           
        }         
        $contrat->pourcentage_depart_starter = $request->pourcentage_depart_starter;
        $contrat->duree_max_starter = $request->duree_max_starter;
        $contrat->duree_gratuite_starter = $request->duree_gratuite_starter;
        $contrat->a_palier_starter = $request->check_palier_starter == "true" ? true : false;
        $contrat->palier_starter = $request->palier_starter;

        // Commission direct pack expert    
        if($contrat->user->pack_actuel== "expert" && $contrat->pourcentage_depart_expert != $request->pourcentage_depart_expert){
            $mandataire->commission = $request->pourcentage_depart_expert;
            $mandataire->chiffre_affaire = 0;
            $mandataire->chiffre_affaire_sty = 0;
            $mandataire->update();
            
        }       
        $contrat->pourcentage_depart_expert = $request->pourcentage_depart_expert;
        $contrat->duree_max_starter_expert = $request->duree_max_starter;
        $contrat->duree_gratuite_expert = $request->duree_gratuite_expert;
        $contrat->duree_pack_info_starter = $request->duree_pack_info_starter;
        $contrat->duree_pack_info_expert = $request->duree_pack_info_expert;
        
        
        // $contrat->nb_vente_gratuite_expert = $request->nb_vente_gratuite_expert;
        
        $contrat->nb_vente_passage_expert = $request->nb_vente_passage_expert;
        
        $contrat->a_palier_expert = $request->check_palier_expert == "true" ? true : false;
        $contrat->palier_expert = $request->palier_expert;
        $contrat->nombre_vente_min = $request->nombre_vente_min;
        $contrat->nombre_mini_filleul = $request->nombre_mini_filleul;
        $contrat->chiffre_affaire_mini = $request->chiffre_affaire;
        $contrat->a_soustraitre = $request->a_soustraitre;
        $contrat->a_condition_expert = $request->a_condition_expert == "true" ? true : false;

        $contrat->prime_forfaitaire = $request->prime_max_forfait_parrain;
        $contrat->packpub_id = $request->pack_pub;  
   

        
        // Modif du parrain

        $comm_parrain = array();

        $comm_parrain["p_1_1"] = $request->p_1_1;
        $comm_parrain["p_1_2"] = $request->p_1_2;
        $comm_parrain["p_1_3"] = $request->p_1_3;
        $comm_parrain["p_1_n"] = $request->p_1_n;
        $comm_parrain["p_2_1"] = $request->p_2_1;
        $comm_parrain["p_2_2"] = $request->p_2_2;
        $comm_parrain["p_2_3"] = $request->p_2_3;
        $comm_parrain["p_2_n"] = $request->p_2_n;
        $comm_parrain["p_3_1"] = $request->p_3_1;
        $comm_parrain["p_3_2"] = $request->p_3_2;
        $comm_parrain["p_3_3"] = $request->p_3_3;
        $comm_parrain["p_3_n"] = $request->p_3_n;
        $comm_parrain["seuil_parr_1"] = $request->seuil_parr_1;
        $comm_parrain["seuil_fill_1"] = $request->seuil_fill_1;
        $comm_parrain["seuil_parr_2"] = $request->seuil_parr_2;
        $comm_parrain["seuil_fill_2"] = $request->seuil_fill_2;
        $comm_parrain["seuil_parr_3"] = $request->seuil_parr_3;
        $comm_parrain["seuil_fill_3"] = $request->seuil_fill_3;
        
        $comm_parrain = serialize($comm_parrain);

        if($request->a_parrain == "true" &&  $contrat->a_parrain == false ){
           
                            
            $nb_filleul = Filleul::where([ ['parrain_id',$request->parrain_id]])->count();
            $parrain = User::where('id',$request->parrain_id)->first();
        
            // on détermine le nombre d'année depuis la date de début d'activité du parrain dans le but de determiner le cycle dans le quel nous somme
            $date_ent =  $parrain->contrat->date_entree->format('Y-m-d') >= "2019-01-01" ?  $parrain->contrat->date_entree : "2019-01-01";
            $nb_annee = intval( (strtotime(date('Y-m-d')) - strtotime($date_ent)) / (86400 *365) ) ;
            $cycle_actuel = intval($nb_annee / 3 ) + 1;
        
        

            if($nb_filleul > 0){

                // On détermine le rang du filleul dans le cycle


                $rang_filleuls = Filleul::where([['parrain_id',$request->parrain_id],['cycle',$cycle_actuel] ])->select('rang')->get()->toArray();
                $rangs = array();

                foreach ($rang_filleuls as $rang_fill) {
                    $rangs[] = $rang_fill["rang"];
                }
                $rang = sizeof($rangs) > 0 ? max($rangs)+1 : 1;
            

          
                }else{

                    $rang = 1;
                    $cycle_actuel = 1;
                }
                // $parametre = Parametre::first();
                $comm_parr= unserialize($comm_parrain) ;

                $r = $rang > 3 ? "n" : $rang ;
                $pourcentage = $comm_parr["p_1_".$r];

                // dd($pourcentage);
                // dd($cycle_actuel);
                Filleul::create([
                    "user_id" => $contrat->user->id,
                    "parrain_id" =>  $request->parrain_id,
                    "rang"=> $rang,
                    "cycle"=> $cycle_actuel,
                    "pourcentage"=> $pourcentage,
                    "expire" => false
                ]);


        } elseif($request->a_parrain == "true" &&  $contrat->a_parrain == true ){
            $filleul = Filleul::where('user_id',$contrat->user->id)->first();

            $filleul->parrain_id = $request->parrain_id;
            $filleul->update();
        }elseif($request->a_parrain == "false" &&  $contrat->a_parrain == true ){
            $filleul = Filleul::where('user_id',$contrat->user->id)->delete();

           
        }

        

        $contrat->a_parrain = $request->a_parrain == "true" ? true : false;
        $contrat->est_soumis_tva = $request->est_soumis_tva == "true" ? true : false;
        $contrat->est_soumis_fact_pub = $request->est_soumis_fact_pub == "true" ? true : false;
        
        $contrat->deduis_jeton = $request->deduis_jeton == "true" ? true : false;
        $contrat->parrain_id = $request->a_parrain== "true" ? $request->parrain_id : null;
        $contrat->a_condition_parrain = $request->a_condition_parrain == "true" ? true : false;
        
    //    return $request->p_1_1;

        
   

    $contrat->comm_parrain = $comm_parrain;
    $contrat->seuil_comm = $request->seuil_comm;
    

    // Démission

    $contrat->a_demission = $request->a_demission == "true" ? true : false;
    $contrat->date_demission = $request->date_demission;
    $contrat->date_fin_preavis = $request->date_fin_preavis;
    $contrat->date_fin_droit_suite = $request->date_fin_droit_suite;

    // date anniv pour jeton
    $date_anniversaire = $request->date_debut;
    $duree_max_starter = $request->duree_max_starter;

    if($request->est_starter == "true"){
        $date_anniversaire = date('Y-m-d', strtotime("+$duree_max_starter months", strtotime($request->date_debut)));

    }

    $contrat->date_anniversaire = $date_anniversaire;
    
    
    // Ajout du CONTRAT PDF

    
    
    
    
   

    $contrat->update();


        $action = Auth::user()->nom." ".Auth::user()->prenom." a modifié le contrat de $mandataire->nom $mandataire->prenom";
        $user_id = Auth::user()->id;
  
        Historique::createHistorique( $user_id,$contrat->id,"contrat",$action );
        
        // if($request->file('contrat_pdf') != null)
            // return  redirect()->route('contrat.edit', Crypt::encrypt($contrat->id))->with('ok','Le contrat a été modifié ');
        
        

        return 1;
                
    }




     /**
     * utilisation du model de contrat.
     *
     * @return \Illuminate\Http\Response
     */
    public function model_create($user_id)
    {
        //
        $packs_pub = Packpub::all();
        $modele = Contrat::where('est_modele',true)->first();
        $palier_starter =  $modele != null ?  $this->palier_unserialize($modele->palier_starter) : null;
        $palier_expert =  $modele != null ? $this->palier_unserialize($modele->palier_expert) : null;
        $parrains = User::where([['role','mandataire'], ['id','<>', Crypt::decrypt($user_id)]])->get();
        
        $comm_parrain = $modele->comm_parrain;

        $comm_parrain = unserialize($modele->comm_parrain); 
        
        // dd($comm_parrain);
        
        $user_id =$user_id;
        if($modele == null){
            return view ('contrat.add', compact(['parrains','user_id','packs_pub','modele']));
        }else{
            return view ('contrat.model_add', compact(['packs_pub','modele','palier_starter','palier_expert','user_id','parrains','comm_parrain']));
        }
    }

    /**
     * Creation du model de contrat.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_model_contrat()
    {
        //
        $packs_pub = Packpub::all();
        $modele = Contrat::where('est_modele',true)->first();
        $palier_starter =  $modele != null ?  $this->palier_unserialize($modele->palier_starter) : null;
        $palier_expert =  $modele != null ? $this->palier_unserialize($modele->palier_expert) : null;
        if($modele == null){
            return view ('parametre.modele_contrat.add', compact(['packs_pub']));
        }else{
            return view ('parametre.modele_contrat.edit', compact(['packs_pub','modele','palier_starter','palier_expert']));
        }
    }

    /**
     * Cre=éation de contrat du mandataire
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
        // parrainage

        // On serialise les conditions de parrainnage

        $comm_parrain = array();


        $comm_parrain["p_1_1"] = $request->p_1_1;
        $comm_parrain["p_1_2"] = $request->p_1_2;
        $comm_parrain["p_1_3"] = $request->p_1_3;
        $comm_parrain["p_1_n"] = $request->p_1_n;
        $comm_parrain["p_2_1"] = $request->p_2_1;
        $comm_parrain["p_2_2"] = $request->p_2_2;
        $comm_parrain["p_2_3"] = $request->p_2_3;
        $comm_parrain["p_2_n"] = $request->p_2_n;
        $comm_parrain["p_3_1"] = $request->p_3_1;
        $comm_parrain["p_3_2"] = $request->p_3_2;
        $comm_parrain["p_3_3"] = $request->p_3_3;
        $comm_parrain["p_3_n"] = $request->p_3_n;
        $comm_parrain["seuil_parr_1"] = $request->seuil_parr_1;
        $comm_parrain["seuil_fill_1"] = $request->seuil_fill_1;
        $comm_parrain["seuil_parr_2"] = $request->seuil_parr_2;
        $comm_parrain["seuil_fill_2"] = $request->seuil_fill_2;
        $comm_parrain["seuil_parr_3"] = $request->seuil_parr_3;
        $comm_parrain["seuil_fill_3"] = $request->seuil_fill_3;

        // return ($comm_parrain);
        $comm_parrain = serialize($comm_parrain);



        $date_anniversaire = $request->date_debut;
        $duree_max_starter = $request->duree_max_starter;

        if($request->est_starter == "true"){
            $date_anniversaire = date('Y-m-d', strtotime("+$duree_max_starter months", strtotime($request->date_debut)));

        }      
        
        // On vérifie que le contrat n'existe pas
        
        $cont = Contrat::where('user_id', Crypt::decrypt($request->user_id) )->first();
        if($cont != null) return 0;
        

        // return "".$request->forfait_administratif;
        $contrat = Contrat::create([
              // infos basiques
            "user_id" => Crypt::decrypt($request->user_id) ,
            "forfait_entree"=> $request->forfait_administratif + $request->forfait_carte_pro,
            "forfait_administratif"=>$request->forfait_administratif,
            "forfait_carte_pro"=>$request->forfait_carte_pro,
            "forfait_pack_info"=>$request->forfait_pack_info,
            
            "date_entree"=>$request->date_entree,
            "date_deb_activite"=>$request->date_debut,
            "ca_depart"=>$request->ca_depart,
            "ca_depart_sty"=>$request->ca_depart_sty,

            "est_demarrage_starter"=>  $request->est_starter == "true" ? true : false,
            "a_parrain"=>$request->a_parrain == "true" ? true : false,
            "parrain_id"=>$request->a_parrain== "true" ? $request->parrain_id : null,
            "a_condition_parrain"=>$request->a_condition_parrain == "true" ? true : false,
            "est_soumis_tva"=>$request->est_soumis_tva == "true" ? true : false,
            "est_soumis_fact_pub"=>$request->est_soumis_fact_pub == "true" ? true : false,
            "deduis_jeton"=>$request->deduis_jeton == "true" ? true : false,
            
            
            // Commission direct pack starter          
            "pourcentage_depart_starter"=>$request->pourcentage_depart_starter,
            "duree_max_starter"=>$request->duree_max_starter,
            "duree_gratuite_starter"=>$request->duree_gratuite_starter,
            "a_palier_starter"=>$request->check_palier_starter == "true" ? true : false,
            "palier_starter"=>$request->palier_starter,

            // Commission direct pack expert          
            "pourcentage_depart_expert"=>$request->pourcentage_depart_expert,
            "duree_max_starter_expert"=>$request->duree_max_expert,
            "nb_vente_passage_expert"=>$request->nb_vente_passage_expert,
            "duree_gratuite_expert"=>$request->duree_gratuite_expert,
            "duree_pack_info_starter"=>$request->duree_pack_info_starter,
            "duree_pack_info_expert"=>$request->duree_pack_info_expert,
            
            // "nb_vente_gratuite_expert"=>$request->nb_vente_gratuite_expert,
            
            "a_palier_expert"=>$request->check_palier_expert == "true" ? true : false,
            "palier_expert"=>$request->palier_expert,

            "nombre_vente_min"=>$request->nombre_vente_min,
            "nombre_mini_filleul"=>$request->nombre_mini_filleul,
            "chiffre_affaire_mini"=>$request->chiffre_affaire,
            "a_soustraitre"=>$request->a_soustraitre,
            "a_condition_expert"=>$request->a_condition_expert == "true" ? true : false,

            "prime_forfaitaire"=>$request->prime_max_forfait_parrain,
            "packpub_id"=>$request->pack_pub,
            "comm_parrain"=> $comm_parrain,
            "date_anniversaire"=> $date_anniversaire
            

        ]);
        // Génération du mot de passe
        
        $mandataire = User::where('id',Crypt::decrypt($request->user_id))->first();

        $datedeb = date_create($request->date_debut);
        $dateini = date_create('1899-12-30');
        $interval = date_diff($datedeb, $dateini);
        $password = "S". strtoupper (substr($mandataire->nom,0,1).substr($mandataire->nom,strlen($mandataire->nom)-1 ,1)). strtolower(substr($mandataire->prenom,0,1)).$interval->days.'@@';


        $mandataire->password = Hash::make($password) ;
        $mandataire->chiffre_affaire = $request->ca_depart;
        $mandataire->chiffre_affaire_sty = $request->ca_depart_sty;
        $mandataire->commission = $request->est_starter == "true" ? $request->pourcentage_depart_starter : $request->pourcentage_depart_expert ;
        $mandataire->pack_actuel = $request->est_starter == "true" ? "starter" : "expert" ;
        
        // Maj jeton ************************************************************************************************************************************************************************
        if($contrat->est_demarrage_starter == true && $contrat->deduis_jeton == true ){
            
            $mandataire->nb_mois_pub_restant = $mandataire->nb_mois_pub_restant - ($contrat->duree_gratuite_starter + $request->duree_pack_info_starter );
        
        }elseif($contrat->est_demarrage_starter == false && $contrat->deduis_jeton == true){
        
            $mandataire->nb_mois_pub_restant = $mandataire->nb_mois_pub_restant - ($contrat->duree_gratuite_expert + $request->duree_pack_info_expert );
                    
        }
        
        // ******************************************************************************************************
        
        $mandataire->update();
        
        
        // Ajout du parrain

        if($request->a_parrain == "true" ){


            $nb_filleul = Filleul::where([ ['parrain_id',$request->parrain_id]])->count();
            $parrain = User::where('id',$request->parrain_id)->first();

            // on détermine le nombre d'année depuis la date de début d'activité du parrain dans le but de determiner le cycle dans le quel nous somme
            $nb_annee = intval( (strtotime(date('Y-m-d')) - strtotime($parrain->contrat->date_entree->format('Y-m-d'))) / (86400 *365) ) ;
            $cycle_actuel = intval($nb_annee / 3 ) + 1;

            if($nb_filleul > 0){

                // On détermine le rang du filleul dans le cycle
                $rang_filleuls = Filleul::where([['parrain_id',$request->parrain_id],['cycle',$cycle_actuel] ])->select('rang')->get()->toArray();
                $rangs = array();

                foreach ($rang_filleuls as $rang_fill) {
                    $rangs[] = $rang_fill["rang"];
                }
                
                
                $rang = sizeof($rangs) > 0 ? max($rangs)+1 : 1;
                
         
            
            }else{

                $rang = 1;
                $cycle_actuel = 1;
            }

            // $parametre = Parametre::first();
            // $comm_parrain = unserialize($parametre->comm_parrain) ;

            $r = $rang > 3 ? "n" : $rang ;
           

            $comm  = unserialize($comm_parrain) ;
            $pourcentage = $comm["p_1_".$r];

         
            Filleul::create([
                "user_id" => Crypt::decrypt($request->user_id),
                "parrain_id" =>  $request->parrain_id,
                "rang"=> $rang,
                "cycle"=> $cycle_actuel,
                "pourcentage"=> $pourcentage,
                "expire" => false
            ]);

        }


        // ************ Création de la facture CCI et Forfait d'entree *************
        
        
        $numero = Facture::whereIn('type',['avoir','stylimmo','pack_pub','carte_visite','communication','autre','forfait_entree','cci'])->max('numero') + 1;
        
        $tva = Tva::coefficient_tva() ;
        
        $facture_cci = Facture::create([
            "numero"=> $numero,
            "user_id"=> $mandataire->id,
           
            "type"=> "cci",
            "encaissee"=> false,
            "montant_ht"=>  $request->forfait_carte_pro / $tva,
            "montant_ttc"=> $request->forfait_carte_pro ,
            "date_facture"=> date('Y-m-d'),
            "destinataire_est_mandataire"=> true,
       ]);
       
        $numero++;
        
        $facture_forfait = Facture::create([
            "numero"=> $numero,
            "user_id"=> $mandataire->id,
           
            "type"=> "forfait_entree",
            "encaissee"=> false,
            "montant_ht"=>  $request->forfait_administratif,
            "montant_ttc"=> $request->forfait_administratif * Tva::coefficient_tva(),
            "date_facture"=> date('Y-m-d'),
            "destinataire_est_mandataire"=> true,
       ]);
        
        
        // on sauvegarde les factures dans le repertoire du mandataire
        $path = storage_path('app/public/factures/factures_autres');
    
        if(!File::exists($path))
            File::makeDirectory($path, 0755, true);
            
            $facture = $facture_cci;
            $pdf_cci = PDF::loadView('facture.pdf_cci_forfait',compact(['facture']));
            
            $facture = $facture_forfait;        
            $pdf_forfait = PDF::loadView('facture.pdf_cci_forfait',compact(['facture']));
    
        
            $nom =  str_replace(['/', '\\', '<','>',':','|','?','*','#'],"-",$mandataire->nom) ;
            $prenom =  str_replace(['/', '\\', '<','>',':','|','?','*','#'],"-",$mandataire->prenom) ;
            
            $filename_cci = "F".$facture_cci->numero." ".$facture_cci->type." ".$facture_cci->montant_ttc."€ ".strtoupper($nom)." ".strtoupper(substr($prenom,0,1)).".pdf" ;
            $filename_forfait = "F".$facture_forfait->numero." ".$facture_forfait->type." ".$facture_forfait->montant_ttc."€ ".strtoupper($nom)." ".strtoupper(substr($prenom,0,1)).".pdf" ;
       
        
        $path_cci = $path.'/'.$filename_cci;
        $path_forfait = $path.'/'.$filename_forfait;
        
        $pdf_cci->save($path_cci);
        $pdf_forfait->save($path_forfait);
        
        $facture_cci->url = $path_cci;
        $facture_forfait->url = $path_forfait;
        $facture_cci->update();
        $facture_forfait->update();
        
        
        
        //********** Création du contrat et de l'annexe ************
        
        $path = storage_path('app/public/'.$contrat->user->id.'contrat/');
        
        if(!File::exists($path))
            File::makeDirectory($path, 0755, true);
        
           $parametre  = Parametre::first();
         
           $packs = Packpub::all();
         
           $palier_starter = Contrat::palier_unserialize($contrat->palier_starter);
           $palier_expert = Contrat::palier_unserialize($contrat->palier_expert);
       
           $comm_parrain = unserialize($parametre->comm_parrain);
         
        
         
       
         $contrat_pdf = PDF::loadView('contrat.contrat',compact('parametre','contrat'));
         
         $annexe_pdf = PDF::loadView('contrat.annexe_pdf',compact('parametre','contrat','palier_expert','palier_starter','packs','comm_parrain'));
         
         
         $path_contrat = $path.'contrat.pdf';
         $path_annexe = $path.'annexe.pdf';
         
         $contrat_pdf->save($path_contrat);
         $annexe_pdf->save($path_annexe);
    
    
       //   $contrat->contrat_envoye = true ;
    
         $contrat->update();
    
    

        Mail::to($mandataire->email_perso)->send(new CreationMandataire($mandataire,$password, $path_forfait, $path_cci,$path_contrat,$path_annexe));
 

        
        $action = Auth::user()->nom." ".Auth::user()->prenom." a crée le contrat de $mandataire->nom $mandataire->prenom";
        $user_id = Auth::user()->id;
  
        Historique::createHistorique( $user_id,$contrat->id,"contrat",$action );

     
                
        return 1;
                
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_model_contrat(Request $request)
    {
      
        // return $request->est_starter == "true" ? 1 : 0;
        // parrainage
        // return "".$request->forfait_administratif;
        
        $comm_parrain = array();

        $comm_parrain["p_1_1"] = $request->p_1_1;
        $comm_parrain["p_1_2"] = $request->p_1_2;
        $comm_parrain["p_1_3"] = $request->p_1_3;
        $comm_parrain["p_1_n"] = $request->p_1_n;
        $comm_parrain["p_2_1"] = $request->p_2_1;
        $comm_parrain["p_2_2"] = $request->p_2_2;
        $comm_parrain["p_2_3"] = $request->p_2_3;
        $comm_parrain["p_2_n"] = $request->p_2_n;
        $comm_parrain["p_3_1"] = $request->p_3_1;
        $comm_parrain["p_3_2"] = $request->p_3_2;
        $comm_parrain["p_3_3"] = $request->p_3_3;
        $comm_parrain["p_3_n"] = $request->p_3_n;
        $comm_parrain["seuil_parr_1"] = $request->seuil_parr_1;
        $comm_parrain["seuil_fill_1"] = $request->seuil_fill_1;
        $comm_parrain["seuil_parr_2"] = $request->seuil_parr_2;
        $comm_parrain["seuil_fill_2"] = $request->seuil_fill_2;
        $comm_parrain["seuil_parr_3"] = $request->seuil_parr_3;
        $comm_parrain["seuil_fill_3"] = $request->seuil_fill_3;
        
        $comm_parrain = serialize($comm_parrain);
        
        Contrat::create([
              // infos basiques
            "forfait_entree"=> $request->forfait_administratif + $request->forfait_carte_pro,
            "forfait_administratif"=>$request->forfait_administratif,
            "forfait_carte_pro"=>$request->forfait_carte_pro,
            "forfait_pack_info"=>$request->forfait_pack_info,
            
            "date_entree"=>$request->date_entree,
            "date_deb_activite"=>$request->date_debut,
            "ca_depart"=>$request->ca_depart,

            "est_demarrage_starter"=>  $request->est_starter == "true" ? true : false,
           
            
            // Commission direct pack starter          
            "pourcentage_depart_starter"=>$request->pourcentage_depart_starter,
            "duree_max_starter"=>$request->duree_max_starter,
            "duree_gratuite_starter"=>$request->duree_gratuite_starter,
            "a_palier_starter"=>$request->check_palier_starter == "true" ? true : false,
            "palier_starter"=>$request->palier_starter,
            "nb_vente_passage_expert"=>$request->nb_vente_passage_expert,
            

            // Commission direct pack expert          
            "pourcentage_depart_expert"=>$request->pourcentage_depart_expert,
            "duree_max_starter_expert"=>$request->duree_max_starter,
            "duree_gratuite_expert"=>$request->duree_gratuite_expert,
            "duree_pack_info_starter"=>$request->duree_pack_info_starter,
            "duree_pack_info_expert"=>$request->duree_pack_info_expert,
            
            
            // "nb_vente_gratuite_expert"=>$request->nb_vente_gratuite_expert,
            
            "a_palier_expert"=>$request->check_palier_expert == "true" ? true : false,
            "palier_expert"=>$request->palier_expert,
            "comm_parrain"=>$request->comm_parrain,
            
            "nombre_vente_min"=>$request->nombre_vente_min,
            "nombre_mini_filleul"=>$request->nombre_mini_filleul,
            "chiffre_affaire_mini"=>$request->chiffre_affaire,
            "a_soustraitre"=>$request->a_soustraitre,

            "prime_forfaitaire"=>$request->prime_max_forfait_parrain,
            "packpub_id"=>$request->pack_pub,

            "est_modele"=>true,

        ]);     

        return 1;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_model_contrat(Request $request)
    {
      
        $modele = Contrat::where('est_modele',true)->first();



      
        $comm_parrain = array();

        $comm_parrain["p_1_1"] = $request->p_1_1;
        $comm_parrain["p_1_2"] = $request->p_1_2;
        $comm_parrain["p_1_3"] = $request->p_1_3;
        $comm_parrain["p_1_n"] = $request->p_1_n;
        $comm_parrain["p_2_1"] = $request->p_2_1;
        $comm_parrain["p_2_2"] = $request->p_2_2;
        $comm_parrain["p_2_3"] = $request->p_2_3;
        $comm_parrain["p_2_n"] = $request->p_2_n;
        $comm_parrain["p_3_1"] = $request->p_3_1;
        $comm_parrain["p_3_2"] = $request->p_3_2;
        $comm_parrain["p_3_3"] = $request->p_3_3;
        $comm_parrain["p_3_n"] = $request->p_3_n;
        $comm_parrain["seuil_parr_1"] = $request->seuil_parr_1;
        $comm_parrain["seuil_fill_1"] = $request->seuil_fill_1;
        $comm_parrain["seuil_parr_2"] = $request->seuil_parr_2;
        $comm_parrain["seuil_fill_2"] = $request->seuil_fill_2;
        $comm_parrain["seuil_parr_3"] = $request->seuil_parr_3;
        $comm_parrain["seuil_fill_3"] = $request->seuil_fill_3;
        
        $comm_parrain = serialize($comm_parrain);
        
        
        // infos basiques
        $modele->forfait_entree = $request->forfait_administratif + $request->forfait_carte_pro;
        $modele->forfait_administratif = $request->forfait_administratif;
        $modele->forfait_carte_pro = $request->forfait_carte_pro;
        $modele->forfait_pack_info = $request->forfait_pack_info;
        
        $modele->date_entree = $request->date_entree;
        $modele->date_deb_activite = $request->date_debut;
        $modele->ca_depart = $request->ca_depart;
        
        $modele->est_demarrage_starter = $request->est_starter == "true" ? true : false;
        
        // Commission direct pack starter          
        $modele->pourcentage_depart_starter = $request->pourcentage_depart_starter;
        $modele->duree_max_starter = $request->duree_max_starter;
        $modele->duree_gratuite_starter = $request->duree_gratuite_starter;
        $modele->a_palier_starter = $request->check_palier_starter == "true" ? true : false;
        $modele->palier_starter = $request->palier_starter;
        $modele->nb_vente_passage_expert = $request->nb_vente_passage_expert;

        
        // Commission direct pack expert          
        $modele->pourcentage_depart_expert = $request->pourcentage_depart_expert;
        $modele->duree_max_starter_expert = $request->duree_max_starter;
        $modele->duree_gratuite_expert = $request->duree_gratuite_expert;
        $modele->duree_pack_info_starter = $request->duree_pack_info_starter;
        $modele->duree_pack_info_expert = $request->duree_pack_info_expert;
        
        
        // $modele->nb_vente_gratuite_expert = $request->nb_vente_gratuite_expert;
        
        $modele->a_palier_expert = $request->check_palier_expert == "true" ? true : false;
        $modele->palier_expert = $request->palier_expert;
        $modele->nombre_vente_min = $request->nombre_vente_min;
        $modele->nombre_mini_filleul = $request->nombre_mini_filleul;
        $modele->chiffre_affaire_mini = $request->chiffre_affaire;
        $modele->a_soustraitre = $request->a_soustraitre;
        $modele->comm_parrain = $comm_parrain;
        
        $modele->prime_forfaitaire = $request->prime_max_forfait_parrain;
        $modele->packpub_id = $request->pack_pub;  
   
        $modele->update();
        return 1;
                
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    /**
     * Mettre à jour toutes les date d'anniversaire.
     *
     * @return \Illuminate\Http\Response
     */
    public function maj_date_anniversaire()
    {
        $contrats = Contrat::all();

        foreach ($contrats as $contrat) {
            
            $date_anniversaire = $contrat->date_deb_activite;
            $duree_max_starter = $contrat->duree_max_starter;

            if($contrat->est_demarrage_starter == true){
                $date_anniversaire = date('Y-m-d', strtotime("+$duree_max_starter months", strtotime($contrat->date_deb_activite)));

            }

            $contrat->date_anniversaire = $date_anniversaire;
            $contrat->update();


        }
    }
    

        /**
     * Retourne l'historique des contrats
     *
     * @return \Illuminate\Http\Response
     */
    public function historique($contrat_id)
    {
        $contra = Contrat::where('id',Crypt::decrypt($contrat_id))->first() ;        
        $contrats = HistoriqueContrat::where('user_id',$contra->user_id)->get() ;        
        
        return view('contrat.historique.index', compact('contrats','contra'));

    }
    
    
    /**
     * Affiche un histoque de contrat
     *
     * @return \Illuminate\Http\Response
     */
    public function historique_show($contrat_id)
    {
        $contrat = HistoriqueContrat::where('id',Crypt::decrypt($contrat_id))->first() ;        
    
      
        $parrain_id =   Filleul::where('user_id',$contrat->user->id)->select('parrain_id')->first();
        $parrain = User::where('id',$parrain_id['parrain_id'])->first();
        
        
        $palier_starter =  $contrat != null ?  $this->palier_unserialize($contrat->palier_starter) : null;
        $palier_expert =  $contrat != null ? $this->palier_unserialize($contrat->palier_expert) : null;
        $comm_parrain = unserialize($contrat->comm_parrain ); 

     
    
//   dd($parrain);
        return view('contrat.historique.show', compact(['parrain','contrat','palier_starter','palier_expert','comm_parrain']));

    }
    
    /**
     * reinitialiser le contrat du mandataire
     *
     * @return \Illuminate\Http\Response
     */
    public function reinitialiser($contrat_id)
    {
        $contrat = Contrat::where('id',Crypt::decrypt($contrat_id))->first() ;       
        
        $mandataire = $contrat->user;
        
        if($contrat->est_demarrage_starter == true){
            $mandataire->pack_actuel = "starter";
            $mandataire->commission =  $contrat->pourcentage_depart_starter;
            
            $mandataire->update();
            return redirect()->route('mandataire.index')->with('ok'," le contrat de $mandataire->nom a été réinitialisé ==> Pack actuel : starter  ==> commission :  $mandataire->commission ");
        }else{
        
            $mandataire->pack_actuel = "expert";
            $mandataire->commission =  $contrat->pourcentage_depart_expert;
            $mandataire->update();
            
            return redirect()->route('mandataire.index')->with('ok'," le contrat de $mandataire->nom a été réinitialisé ==> Pack actuel : expert  ==> commission :  $mandataire->commission ");
            
            
        }
  
        
       

    }
    
    
    
    /**
     * Télécharger le contrat
     *
     * @return \Illuminate\Http\Response
     */
    public function telecharger_contrat($contrat_id)
    {
        $contrat =Contrat::where('id',Crypt::decrypt($contrat_id))->first() ;    
        
        return response()->download($contrat->contrat_pdf);

    }
    
      /**
     * Télécharger le contrat
     *
     * @return \Illuminate\Http\Response
     */
    public function telecharger_historiquecontrat($contrat_id)
    {
        $contrat = HistoriqueContrat::where('id',Crypt::decrypt($contrat_id))->first() ;    
        
        return response()->download($contrat->contrat_pdf);

    }
    
    
    
    
    
    
    
    /**
     * Envoyer le contrat signé par le mail
     *
     * @return \Illuminate\Http\Response
     */
    public function envoyer_contrat_mail($contrat_id)
    {
        // $contrat = HistoriqueContrat::where('id',Crypt::decrypt($contrat_id))->first() ;        

    }
    
    
    /**
     * Envoyer le contrat par mail pour signature
     *
     * @return \Illuminate\Http\Response
     */
    public function envoyer_contrat_non_signe_mail($contrat_id)
    {
    
    
 
         // on sauvegarde la modele de contrat
         $contrat  = Contrat::where('id',Crypt::decrypt($contrat_id))->first();
         $path = storage_path('app/public/'.$contrat->user->id.'contrat/');
    
         if(!File::exists($path))
             File::makeDirectory($path, 0755, true);
         
            $parametre  = Parametre::first();
          
            $packs = Packpub::all();
          
            $palier_starter = Contrat::palier_unserialize($contrat->palier_starter);
            $palier_expert = Contrat::palier_unserialize($contrat->palier_expert);
        
            $comm_parrain = unserialize($parametre->comm_parrain);
          
         
          
        
          $contrat_pdf = PDF::loadView('contrat.contrat',compact('parametre','contrat'));
          
          $annexe_pdf = PDF::loadView('contrat.annexe_pdf',compact('parametre','contrat','palier_expert','palier_starter','packs','comm_parrain'));
          
          
          $contrat_path = $path.'contrat.pdf';
          $annexe_path = $path.'annexe.pdf';
          
          $contrat_pdf->save($contrat_path);
          $annexe_pdf->save($annexe_path);
     
     
        //   $contrat->contrat_envoye = true ;
     
          $contrat->update();
     
          $contrat_pdf_path =  $path.'contrat.pdf';
          $annexe_pdf_path =  $path.'annexe.pdf';
     
    
    }

        
    /**
     * Télécharger le contrat à envoyer par mail
     *
     * @return \Illuminate\Http\Response
     */
    public function telecharger_contrat_non_signe($contrat_id)
    {
    
    
 
         // on sauvegarde la modele de contrat
         $contrat  = Contrat::where('id',Crypt::decrypt($contrat_id))->first();
         $path = storage_path('app/public/'.$contrat->user->id.'contrat/');
    
         if(!File::exists($path))
             File::makeDirectory($path, 0755, true);
         
            $parametre  = Parametre::first();
          
            $packs = Packpub::all();
          
            $palier_starter = Contrat::palier_unserialize($contrat->palier_starter);
            $palier_expert = Contrat::palier_unserialize($contrat->palier_expert);
        
            $comm_parrain = unserialize($parametre->comm_parrain);
          
         
          
        
          $contrat_pdf = PDF::loadView('contrat.contrat',compact('parametre','contrat'));
          
          $annexe_pdf = PDF::loadView('contrat.annexe_pdf',compact('parametre','contrat','palier_expert','palier_starter','packs','comm_parrain'));
          
          
          $contrat_path = $path.'contrat.pdf';
          $annexe_path = $path.'annexe.pdf';
          
          $contrat_pdf->save($contrat_path);
          $annexe_pdf->save($annexe_path);
     
     
        //   $contrat->contrat_envoye = true ;
     
          $contrat->update();
     
          $contrat_pdf_path =  $path.'contrat.pdf';
          $annexe_pdf_path =  $path.'annexe.pdf';
     
    
         
        $merger = new Merger;     
        $merger->addFile($contrat_pdf_path);
        $merger->addFile($annexe_pdf_path);

        $createdPdf = $merger->merge();
      
        return new Response($createdPdf, 200, array('Content-Type' => 'application/pdf'));
       
    }
    
    

}

