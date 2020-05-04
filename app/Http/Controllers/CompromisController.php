<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Compromis;
use Auth;
use App\User;
use App\Filleul;
use App\Parametre;
use App\Facture;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Mail\PartageAffaire;
use App\Mail\ModifCompromis;
use Illuminate\Support\Facades\Route;
class CompromisController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    $page_filleul=null;
    if(Route::currentRouteName() == "compromis.filleul.index"){
        $page_filleul = "page_filleul";
    }
        $parametre = Parametre::first();
        $comm_parrain = unserialize($parametre->comm_parrain) ;
        if(auth::user()->role == "admin"){
            $page_filleul = null;
        }

         // On réccupère l'id des filleuls pour retrouver leurs affaires
         $filleuls = Filleul::where([['parrain_id',Auth::user()->id],['expire',false]])->select('user_id')->get()->toArray();
         $fill_ids = array();
         foreach ($filleuls as $fill) {

             $fill_ids[]= $fill['user_id'];
         }

        
        //########## TYPE AFFAIRE

                        
        $tab_compromisEncaissee_id = array();
        $tab_compromisEnattente_id = array();
        $tab_compromisPrevisionnel_id = array();

        $compromisEncaissee_id = Facture::where([['encaissee',1],['type','stylimmo']])->select('compromis_id')->get();
        $compromisEnattente_id = Facture::where([['encaissee',0],['type','stylimmo']])->select('compromis_id')->get();
        // $compromisPrevisionnel_id = Facture::where([['encaissee',1],['type','stylimmo']])->select('compromis_id')->get();

        foreach ($compromisEncaissee_id as $encaiss) {
        $tab_compromisEncaissee_id[] = $encaiss["compromis_id"];
        }
        foreach ($compromisEnattente_id as $attente) {
            $tab_compromisEnattente_id[] = $attente["compromis_id"];
        }
       


        if(auth::user()->role == "admin"){
            $compromisEncaissee = Compromis::whereIn('id',$tab_compromisEncaissee_id)->where('archive',false)->get();
            $compromisEnattente = Compromis::whereIn('id',$tab_compromisEnattente_id)->where('archive',false)->get();
            $compromisSousOffre = Compromis::where([['demande_facture','<',2],['pdf_compromis',null],['archive',false]])->get();
            $compromisSousCompromis = Compromis::where([['demande_facture','<',2],['pdf_compromis','<>',null],['archive',false]])->get();
        }else{

            // On reccupère les affaires du mandataire ou de ses filleuls
            
            $this->users_id []=  auth::user()->id;
            // Si le paramètre filleul existe, alors nous somme sur la page du filleul
            if($page_filleul != "mes_filleuls"){
               $this->users_id =  $fill_ids;
            }
           
           

            $compromisEncaissee = Compromis::whereIn('id',$tab_compromisEncaissee_id)->where('archive',false)->where(function($query){
                $query->whereIn('user_id',$this->users_id)
                ->orWhereIn('agent_id',$this->users_id);
            })->get();

            $compromisEnattente = Compromis::whereIn('id',$tab_compromisEnattente_id)->where('archive',false)->where(function($query){
                $query->whereIn('user_id',$this->users_id)
                ->orWhereIn('agent_id',$this->users_id);
            })->get();


            $compromisSousOffre = Compromis::where([['demande_facture','<',2],['pdf_compromis',null],['archive',false]])->where(function($query){
                $query->whereIn('user_id',$this->users_id)
                ->orWhereIn('agent_id',$this->users_id);
            })->get();

            $compromisSousCompromis = Compromis::where([['demande_facture','<',2],['pdf_compromis','<>',null],['archive',false]])->where(function($query){
                $query->whereIn('user_id',$this->users_id)
                ->orWhereIn('agent_id',$this->users_id);
            })->get();
        }
// ############ FIN TYPE AFFAIRE

        $compromis = array();
        if(Auth::user()->role =="admin") {
            $compromis = Compromis::where([['je_renseigne_affaire',true],['archive',false]])->latest()->get();
            $compromisParrain = Compromis::where([['je_renseigne_affaire',true],['archive',false]])->latest()->get();
        }else{
            $compromis = Compromis::where([['user_id',Auth::user()->id],['je_renseigne_affaire',true],['archive',false]])->orWhere('agent_id',Auth::user()->id)->latest()->get();
            
        
           


            // ########### Mise en place des conditions de parrainnage ############
            // Vérifier le CA du parrain et du filleul sur les 12 derniers mois précédents la date de vente et qui respectent les critères et vérifier s'il sont à jour dans le reglèmement de leur factures stylimmo 
            // Dans cette partie on détermine le jour exaxt de il y'a 12 mois avant la date de vente
           
         
            $compromisParrain = Compromis::where('archive',false)->where(function($query){
                
                $filleuls = Filleul::where([['parrain_id',Auth::user()->id],['expire',false]])->select('user_id')->get()->toArray();
                $fill_ids = array();
                foreach ($filleuls as $fill) {
                    $fill_ids[]= $fill['user_id'];
                }

                $query->whereIn('user_id',$fill_ids )
                ->orWhereIn('agent_id',$fill_ids );
            })->latest()->get();
            $valide_compro_id = array();
        
            // foreach ($fill_ids as $fill_id) {
                
                if($compromisParrain != null){
                    foreach ($compromisParrain as $compro_parrain) {
    
                        $date_vente = $compro_parrain->date_vente->format('Y-m-d');
                        // date_12 est la date exacte 1 ans avant la data de vente
                        $date_12 =  strtotime( $date_vente. " -1 year"); 
                        $date_12 = date('Y-m-d',$date_12);
    
                        $ca_parrain =  Compromis::getCAStylimmo(Auth::user()->id,$date_12 ,$date_vente);
                        
                    //     On determine le filleul qui est  porteur  ou partage de l'affaire
                        $id_filleul_porteur = $compro_parrain->user_id;                      
                        $id_filleul_partage = $compro_parrain->agent_id;

                    // ## On dertermine le ca du filleul ou des filleuls si 2 filleuls partagent l'affaire

                        if($id_filleul_porteur != null && in_array($id_filleul_porteur, $fill_ids)) {
                            $ca_filleul_porteur = Compromis::getCAStylimmo($id_filleul_porteur, $date_12, $date_vente);
                            $filleul_porteur = Filleul::where('user_id',$id_filleul_porteur)->first();

                            // on vérifie si le ca depasse le seuil demandé SI LA CONDITION EST ACTIVEE
                            if($filleul_porteur->user->contrat->a_condition_parrain == true){

                           
                                // 1 on determine l'ancieneté du filleul
                                $date_deb_activ =  strtotime($filleul_porteur->user->contrat->date_deb_activite);                                              
                                $today = strtotime (date('Y-m-d'));
                                $anciennete_porteur = $today - $date_deb_activ;

                                if($anciennete_porteur <= 365*86400){
                                    $seuil_porteur = $comm_parrain["seuil_fill_1"];
                                    $seuil_parrain = $comm_parrain["seuil_parr_1"];
                                }
                                //si ancienneté est compris entre 1 et 2ans
                                elseif($anciennete_porteur > 365*86400 && $anciennete_porteur <= 365*86400*2){
                                    $seuil_porteur = $comm_parrain["seuil_fill_2"];
                                    $seuil_parrain = $comm_parrain["seuil_parr_2"];
                                }
                                // ancienneté sup à 2 ans
                                else{
                                    $seuil_porteur = $comm_parrain["seuil_fill_3"];
                                    $seuil_parrain = $comm_parrain["seuil_parr_3"];
                                }

                                // On  n'a les seuils et les ca on peut maintenant faire les comparaisons                                
                                if($ca_filleul_porteur >= $seuil_porteur && $ca_parrain >= $seuil_parrain ){
                                    $valide_compro_id [] = $compro_parrain->numero_mandat;
                                }
                            
                            }
                            else{
                                $valide_compro_id [] = $compro_parrain->numero_mandat;
                            }

                        }



                        if($id_filleul_partage != null && in_array($id_filleul_partage, $fill_ids)) {
                            $ca_filleul_partage = Compromis::getCAStylimmo($id_filleul_partage, $date_12, $date_vente);
                            $filleul_partage = Filleul::where('user_id',$id_filleul_partage)->first();
                            
                            // on vérifie si le ca depasse le seuil demandé SI LA CONDITION EST ACTIVEE
                            if($filleul_partage->user->contrat->a_condition_parrain == true){

                           
                                // 1 on determine l'ancieneté du filleul
                                $date_deb_activ =  strtotime($filleul_partage->user->contrat->date_deb_activite);                                              
                                $today = strtotime (date('Y-m-d'));
                                $anciennete_partage = $today - $date_deb_activ;

                                if($anciennete_partage <= 365*86400){
                                    $seuil_partage = $comm_parrain["seuil_fill_1"];
                                    $seuil_parrain = $comm_parrain["seuil_parr_1"];
                                }
                                //si ancienneté est compris entre 1 et 2 ans
                                elseif($anciennete_partage > 365*86400 && $anciennete_partage <= 365*86400*2){
                                    $seuil_partage = $comm_parrain["seuil_fill_2"];
                                    $seuil_parrain = $comm_parrain["seuil_parr_2"];
                                }
                                // ancienneté sup à 2 ans
                                else{
                                    $seuil_partage = $comm_parrain["seuil_fill_3"];
                                    $seuil_parrain = $comm_parrain["seuil_parr_3"];
                                }

                                // On  n'a les seuils et les ca on peut maintenant faire les comparaisons                                
                                if($ca_filleul_partage >= $seuil_partage && $ca_parrain >= $seuil_parrain ){
                                    $valide_compro_id [] = $compro_parrain->numero_mandat;
                                }
                            
                            }
                            else{
                                $valide_compro_id [] = $compro_parrain->numero_mandat;
                            }
                        }
                    


                        $ca_filleul =  Compromis::getCAStylimmo(Auth::user()->id,$date_12 ,$date_vente);
    
                    }
                }
    
            // }
           



// ###################


                $valide_compro_id = array_unique ($valide_compro_id);
                //  dd($valide_compro_id);











        return view ('compromis.index',compact('compromis','compromisParrain','fill_ids','valide_compro_id','compromisEncaissee','compromisEnattente','compromisSousOffre','compromisSousCompromis','page_filleul'));

        }
        //  dd($compromis);
        return view ('compromis.index',compact('compromis','compromisParrain','compromisEncaissee','compromisEnattente','compromisSousOffre','compromisSousCompromis','page_filleul'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $agents = User::where([['role','mandataire'],['id','<>',Auth::user()->id]])->orderBy("nom")->get();
        return view ('compromis.add',compact('agents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //  dd($request->all());
        // return $request->partage_reseau ;
        if($request->partage == "Non"  || ($request->partage == "Oui" &&  $request->je_porte_affaire == "on" ) ){
            $request->validate([
                'numero_mandat' => 'unique:compromis',
                'pdf_compromis' => 'file:pdf'
            ]);


            $compromis = Compromis::create([
                "user_id"=> Auth::user()->id,
                "est_partage_agent"=>$request->partage == "Non" ? false : true,
                "partage_reseau"=>$request->hors_reseau == "Non" ? true : false,
                "agent_id"=> ($request->partage == "Oui" && $request->hors_reseau == "Non" ) ? $request->agent_id : null,
                "nom_agent"=>$request->nom_agent,
                "pourcentage_agent"=>$request->pourcentage_agent,
                "je_porte_affaire"=>$request->je_porte_affaire == "on" ? true : false,
                "type_affaire"=> $request->type_affaire,
                "description_bien"=> $request->description_bien,
                "code_postal_bien"=> $request->code_postal_bien,
                "ville_bien"=> $request->ville_bien,
                "civilite_vendeur"=> $request->civilite_vendeur,
                "nom_vendeur"=> $request->nom_vendeur,
                // "prenom_vendeur"=>$request->prenom_vendeur,
                "adresse1_vendeur"=>$request->adresse1_vendeur,
                "adresse2_vendeur"=>$request->adresse2_vendeur,
                "code_postal_vendeur"=>$request->code_postal_vendeur,
                "ville_vendeur"=>$request->ville_vendeur,
                "civilite_acquereur"=>$request->civilite_acquereur,
                "nom_acquereur"=>$request->nom_acquereur,
                // "prenom_acquereur"=>$request->prenom_acquereur,
                "adresse1_acquereur"=>$request->adresse1_acquereur,
                "adresse2_acquereur"=>$request->adresse2_acquereur,
                "code_postal_acquereur"=>$request->code_postal_acquereur,
                "ville_acquereur"=>$request->ville_acquereur,
                // "raison_sociale_vendeur"=>$request->raison_sociale_vendeur,
                // "raison_sociale_acquereur"=>$request->raison_sociale_acquereur,
                "numero_mandat"=>$request->numero_mandat,
                "date_mandat"=>$request->date_mandat,
                "frais_agence"=>$request->frais_agence,
                "charge"=>$request->charge,
                "net_vendeur"=>$request->net_vendeur,
                "scp_notaire"=>$request->scp_notaire,
                "date_vente"=>$request->date_vente,
                "date_signature"=>$request->date_signature,
                "observations"=>$request->observations,
                
                
                ]);

                if($request->hasFile('pdf_compromis')){

                    $request->validate([
                        'pdf_compromis' => 'mimes:pdf',
                    ]);
                    $filename = 'pdf_compromis_'.$compromis->id.'.pdf';
                    $compromis->pdf_compromis = $filename;
                    // return response()->download(storage_path('app/pdf_compromis/pdf_compro.pdf'));
                    $request->pdf_compromis->storeAs('public/pdf_compromis',$filename);
                }
               
                $compromis->update();
        }else{
            $request->validate([
                'numero_mandat_porte_pas' => 'unique:compromis',
            ]);
            $compromis = Compromis::create([
                "user_id"=> Auth::user()->id,
                "est_partage_agent"=>$request->partage == "Non" ? false : true,
                "partage_reseau"=>$request->hors_reseau == "Non" ? true : false,
                "agent_id"=>$request->agent_id,
                "nom_agent"=>$request->nom_agent,
                "pourcentage_agent"=>$request->pourcentage_agent,
                "je_porte_affaire"=>$request->je_porte_affaire == "on" ? true : false,
                "numero_mandat_porte_pas"=>$request->numero_mandat_porte_pas,
                "je_renseigne_affaire"=>false,
                
            ]);

        }

        // dd($compromis);
 
            if($request->partage == "Oui" && $request->hors_reseau == "Non" && $request->agent_id != null){
                $agent = User::where('id',$request->agent_id)->first();
                
                // On check si le partage a un parrain 
                $parrain_agent = Filleul::where('user_id',$agent->id)->first();
                if($parrain_agent != null ){
                    $compromis->parrain_partage_id = $parrain_agent->parrain_id ;
                    $compromis->update();

                }

                $filleuls = Filleul::where([['parrain_id',Auth::user()->id],['expire',false]])->select('user_id')->get()->toArray();
                $fill_ids = array();
                foreach ($filleuls as $fill) {
                    $fill_ids[]= $fill['user_id'];
                }

                
                Mail::to($agent->email)->send(new PartageAffaire($compromis->user, $compromis));
                // Mail::to("gestion@stylimmo.com")->send(new PartageAffaire($compromis->user, $compromis));
            }

        return redirect()->route('compromis.show', ['id' => Crypt::encrypt($compromis->id)]); 
    }

    /**
     * Afficher le compromis
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $compromis = Compromis::where('id',$id)->first();
        $agents = User::where([['role','mandataire'],['id','<>',Auth::user()->id]])->get();
        $agence = User::where('id',$compromis->agent_id)->first();

        // dd($agence);
        return view('compromis.show', compact('compromis','agents','agence'));
    }

     /**
     *Télécharger le fichier pdf du compromis.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function telecharger_pdf_compromis($id)
    {
        
        $compromis = Compromis::where('id',$id)->first();
        

        return response()->download(storage_path('app/public/pdf_compromis/'.$compromis->pdf_compromis));
 
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * modifier le compromis
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Compromis $compromis)
    {
        // dd($request->all());
 
        if($request->partage == "Non"  || ($request->partage == "Oui" ) ){
            if($request->numero_mandat != $compromis->numero_mandat){
                $request->validate([
                    'numero_mandat' => 'required|numeric|unique:compromis',
                   
                ]);
            }
            $compromis->est_partage_agent = $request->partage == "Non" ? false : true;
            $compromis->partage_reseau = $request->hors_reseau == "Non" ? true : false;
            $compromis->type_affaire = $request->type_affaire;
            $compromis->nom_agent = $request->nom_agent;

            $compromis->agent_id = $request->agent_id;

            $compromis->description_bien = $request->description_bien;
            $compromis->code_postal_bien = $request->code_postal_bien;
            $compromis->ville_bien = $request->ville_bien;
            $compromis->civilite_vendeur = $request->civilite_vendeur;
            $compromis->nom_vendeur = $request->nom_vendeur;
            // $compromis->prenom_vendeur = $request->prenom_vendeur;
            $compromis->adresse1_vendeur = $request->adresse1_vendeur;
            $compromis->adresse2_vendeur = $request->adresse2_vendeur;
            $compromis->code_postal_vendeur = $request->code_postal_vendeur;
            $compromis->ville_vendeur = $request->ville_vendeur;
            $compromis->civilite_acquereur = $request->civilite_acquereur;
            $compromis->nom_acquereur = $request->nom_acquereur;
            // $compromis->prenom_acquereur = $request->prenom_acquereur;
            $compromis->adresse1_acquereur = $request->adresse1_acquereur;
            $compromis->adresse2_acquereur = $request->adresse2_acquereur;
            $compromis->code_postal_acquereur = $request->code_postal_acquereur;
            $compromis->ville_acquereur = $request->ville_acquereur;
            // $compromis->raison_sociale_vendeur = $request->raison_sociale_vendeur;
            // $compromis->raison_sociale_acquereur = $request->raison_sociale_acquereur;
            $compromis->numero_mandat = $request->numero_mandat;
            $compromis->date_mandat = $request->date_mandat;
            $compromis->montant_deduis_net = $request->montant_deduis;
            $compromis->frais_agence = $request->frais_agence;
            $compromis->charge = $request->charge;
            $compromis->net_vendeur = $request->net_vendeur;
            $compromis->scp_notaire = $request->scp_notaire;

            // Modification de la date de vente et notification par mail
           if($compromis->date_vente != null){
                if($compromis->date_vente->format('Y-m-d') != $request->date_vente){
                    
                    Mail::to("gestion@stylimmo.com")->send(new ModifCompromis($compromis, $request,"admin"));
                }
           }else{
                $compromis->date_vente = $request->date_vente;
           }

           if ($compromis->est_partage_agent == true && $compromis->agent_id != null){
                $user_partage = User::where("id",$compromis->agent_id)->first();
                Mail::to($user_partage->email)->send(new ModifCompromis($compromis, $request,"mandataire"));

           }
           $compromis->date_vente = $request->date_vente;
           $compromis->pourcentage_agent = $request->pourcentage_agent;

            $compromis->date_signature = $request->date_signature;
            $compromis->observations = $request->observations;


            if($request->hasFile('pdf_compromis')){

                $request->validate([
                    'pdf_compromis' => 'mimes:pdf',
                ]);
                $filename = 'pdf_compromis_'.$compromis->id.'.pdf';
              
                $request->pdf_compromis->storeAs('public/pdf_compromis',$filename);
                $compromis->pdf_compromis = $filename;
       
              

            }


           

        }elseif($request->partage == "Oui" &&  $request->je_porte_affaire == "Non"){ 

            if($request->numero_mandat_porte_pas != $compromis->numero_mandat_porte_pas){
                $request->validate([
                    'numero_mandat_porte_pas' => 'required|numeric|unique:compromis',
                ]);
            }

            // $compromis->est_partage_agent = $request->partage == "Non" ? false : true;
            // $compromis->partage_reseau = $request->partage_reseau;
            $compromis->agent_id = $request->agent_id;
            $compromis->nom_agent = $request->nom_agent;
            $compromis->pourcentage_agent = $request->pourcentage_agent;
            // $compromis->je_porte_affaire = $request->je_porte_affaire;
            $compromis->numero_mandat_porte_pas = $request->numero_mandat_porte_pas;

 
        }

        
        $compromis->update();
        $mandat = $compromis->numero_mandat;
    
        return redirect()->route('compromis.index')->with('ok', __("compromis modifié (mandat $mandat) ")  );
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
     * Cloturer une affaire
     *
     * @param  string  $compromis
     * @return \Illuminate\Http\Response
     */
    public function cloturer($compromis)
    {
        //
        $id = Crypt::decrypt($compromis);
        $compromis = Compromis::where('id',$id)->first();

        $compromis->cloture_affaire = true;
        $compromis->update();

        return redirect()->route('compromis.index')->with('ok', __("Affaire cloturée (mandat $compromis->numero_mandat)  "));
    }

  
    /**
     * Cloturer une affaire
     *
     * @return \Illuminate\Http\Response
     */
    public function index_type_compromis()
    {
        //
        
       
        $tab_compromisEncaissee_id = array();
        $tab_compromisEnattente_id = array();
        $tab_compromisPrevisionnel_id = array();

        $compromisEncaissee_id = Facture::where([['encaissee',1],['type','stylimmo']])->select('compromis_id')->get();
        $compromisEnattente_id = Facture::where([['encaissee',0],['type','stylimmo']])->select('compromis_id')->get();
        // $compromisPrevisionnel_id = Facture::where([['encaissee',1],['type','stylimmo']])->select('compromis_id')->get();

        foreach ($compromisEncaissee_id as $encaiss) {
           $tab_compromisEncaissee_id[] = $encaiss["compromis_id"];
        }
        foreach ($compromisEnattente_id as $attente) {
            $tab_compromisEnattente_id[] = $attente["compromis_id"];
         }
        //  foreach ($compromisPrevisionnel_id as $previ) {
        //     $tab_compromisPrevisionnel_id[] = $previ["compromis_id"];
        //  }
        // dd($tab_compromisEncaissee_id);

        
        if(auth::user()->role == "admin"){
            $compromisEncaissee = Compromis::whereIn('id',$tab_compromisEncaissee_id)->where('archive',false)->get();
            $compromisEnattente = Compromis::whereIn('id',$tab_compromisEnattente_id)->where('archive',false)->get();
            $compromisSousOffre = Compromis::where([['demande_facture','<',2],['pdf_compromis',null],['archive',false]])->get();
            $compromisSousCompromis = Compromis::where([['demande_facture','<',2],['pdf_compromis','<>',null],['archive',false]])->get();
        }else{
            $compromisEncaissee = Compromis::whereIn('id',$tab_compromisEncaissee_id)->where('archive',false)->where(function($query){
                $query->where('user_id',auth::user()->id)
                ->orWhere('agent_id',auth::user()->id);
            })->get();

            $compromisEnattente = Compromis::whereIn('id',$tab_compromisEnattente_id)->where('archive',false)->where(function($query){
                $query->where('user_id',auth::user()->id)
                ->orWhere('agent_id',auth::user()->id);
            })->get();


            $compromisSousOffre = Compromis::where([['demande_facture','<',2],['pdf_compromis',null],['archive',false]])->where(function($query){
                $query->where('user_id',auth::user()->id)
                ->orWhere('agent_id',auth::user()->id);
            })->get();

            $compromisSousCompromis = Compromis::where([['demande_facture','<',2],['pdf_compromis','<>',null],['archive',false]])->where(function($query){
                $query->where('user_id',auth::user()->id)
                ->orWhere('agent_id',auth::user()->id);
            })->get();
        }

        return view('compromis.type_affaire.index', compact('compromisEncaissee','compromisEnattente','compromisSousOffre','compromisSousCompromis'));
    }

    /**
     * Archiver une affaire 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function archiver(Compromis $compromis, Request $request)
    {
        $compromis->archive = true;
        $compromis->motif_archive = $request->motif_archive;
        return "".$compromis->update();

    }
    

    /**
     * Restaurer une affaire 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restaurer_archive(Compromis $compromis)
    {
        $compromis->archive = false;
        $compromis->motif_archive = null;
        return "".$compromis->update();

    }

    /**
     * Liste des archives
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function archive()
    {
        
        if(Auth::user()->role =="admin") {
            $compromis = Compromis::where([['je_renseigne_affaire',true],['archive',true]])->latest()->get();
        }else{
            $compromis = Compromis::where([['user_id',Auth::user()->id],['je_renseigne_affaire',true],['archive',true]])->orWhere([['agent_id',Auth::user()->id],['archive',true]])->latest()->get();
        
        }
        return view ('compromis.archive',compact('compromis'));


    }

}
