<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Compromis;
use Auth;
use App\User;
use App\Filleul;
use App\Parametre;
use App\Facture;
use App\Avoir;
use App\Historique;
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
        $nb_jour_max_demande = $parametre->nb_jour_max_demande ;

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

        $compromisEncaissee_id = Facture::where([['encaissee',1],['type','stylimmo'],['a_avoir',0]])->select('compromis_id')->get();
        $compromisEnattente_id = Facture::where([['encaissee',0],['type','stylimmo'],['a_avoir',0]])->get();

        foreach ($compromisEncaissee_id as $encaiss) {
        $tab_compromisEncaissee_id[] = $encaiss["compromis_id"];
        }
        foreach ($compromisEnattente_id as $attente) {
            $tab_compromisEnattente_id[] = $attente["compromis_id"];
        }
       
// dd($compromisEnattente_id);

        if(auth::user()->role == "admin"){
            $compromisEncaissee = Compromis::whereIn('id',$tab_compromisEncaissee_id)->where([['archive',false],['cloture_affaire','<',2]])->get();
            $compromisEnattente = Compromis::whereIn('id',$tab_compromisEnattente_id)->where([['archive',false],['cloture_affaire','<',2]])->get();
            $compromisSousOffre = Compromis::where([['demande_facture','<',2],['pdf_compromis',null],['archive',false],['cloture_affaire','<',2]])->get();
            $compromisSousCompromis = Compromis::where([['demande_facture','<',2],['pdf_compromis','<>',null],['archive',false]])->get();
        }else{

            // On reccupère les affaires du mandataire ou de ses filleuls
            
            $this->users_id []=  auth::user()->id;
            // Si le paramètre filleul existe, alors nous somme sur la page du filleul
            if($page_filleul != "mes_filleuls"){
               $this->users_id =  $fill_ids;
            }
           
           

            $compromisEncaissee = Compromis::whereIn('id',$tab_compromisEncaissee_id)->where([['archive',false],['cloture_affaire','<',2]])->where(function($query){
                $query->where('user_id', auth::user()->id)
                ->orWhere('agent_id', auth::user()->id);
            })->get();

            $compromisEnattente = Compromis::whereIn('id',$tab_compromisEnattente_id)->where([['archive',false],['cloture_affaire','<',2]])->where(function($query){
                $query->where('user_id', auth::user()->id)
                ->orWhere('agent_id', auth::user()->id);
            })->get();


            $compromisSousOffre = Compromis::where([['demande_facture','<',2],['pdf_compromis',null],['archive',false],['cloture_affaire','<',2]])->where(function($query){
                $query->where('user_id', auth::user()->id)
                ->orWhere('agent_id', auth::user()->id);
            })->get();

            $compromisSousCompromis = Compromis::where([['demande_facture','<',2],['pdf_compromis','<>',null],['archive',false],['cloture_affaire','<',2]])->where(function($query){
                $query->where('user_id', auth::user()->id)
                ->orWhere('agent_id', auth::user()->id);
            })->get();
        }
// ############ FIN TYPE AFFAIRE

        $compromis = array();
        if(Auth::user()->role =="admin") {
            $compromis = Compromis::where([['je_renseigne_affaire',true],['archive',false],['cloture_affaire','<',2]])->latest()->get();
            $compromisParrain = Compromis::where([['je_renseigne_affaire',true],['archive',false],['cloture_affaire','<',2]])->latest()->get();
        }else{
            $compromis = Compromis::where([['user_id',Auth::user()->id],['je_renseigne_affaire',true],['archive',false],['cloture_affaire','<',2]])->orWhere([['agent_id',Auth::user()->id],['archive',false],['cloture_affaire','<',2]])->latest()->get();
            
        
           


            // ########### Mise en place des conditions de parrainnage ############
            // Vérifier le CA du parrain et du filleul sur les 12 derniers mois précédents la date de vente et qui respectent les critères et vérifier s'il sont à jour dans le reglèmement de leur factures stylimmo 
            // Dans cette partie on détermine le jour exaxt de il y'a 12 mois avant la date de vente
           
         
            // $compromisParrain = Compromis::where('archive',false)->where(function($query){
                
            //     $filleuls = Filleul::where([['parrain_id',Auth::user()->id],['expire',false]])->select('user_id')->get()->toArray();
            //     $fill_ids = array();
            //     foreach ($filleuls as $fill) {
            //         $fill_ids[]= $fill['user_id'];
            //     }

            //     $query->whereIn('user_id',$fill_ids )
            //     ->orWhereIn('agent_id',$fill_ids );
            // })->latest()->get();
            
            $filleuls = Filleul::where([['parrain_id',Auth::user()->id],['expire',false]])->select('user_id')->get()->toArray();
            $fill_ids = array();
            foreach ($filleuls as $fill) {
                $fill_ids[]= $fill['user_id'];
            }

            // Les affaires des filleuls qui portent l'affaire 
            $filleul1s = Compromis::where('archive',false)->whereIn('user_id',$fill_ids )->get();

            // Les affaires des filleuls qui ne portent pas l'affaire 
            $filleul2s = Compromis::where('archive',false)->whereIn('agent_id',$fill_ids )->get();

            
            $id_fill1 = array();
            foreach ($filleul1s as $fill1) {
               $id_fill1[] = $fill1->id;
            }
            $id_fill2 = array();
            foreach ($filleul2s as $fill2) {
               $id_fill2[] = $fill2->id;
            }


            $compromisParrain = $filleul2s->concat($filleul1s);
            $compro_ids1 = array_intersect($id_fill1, $id_fill2);
            $compro_ids2 = $compro_ids1;
            // dd($compro_ids2);
           

            $valide_compro_id = array();
        
            // foreach ($fill_ids as $fill_id) {
                
                if($compromisParrain != null){
                    foreach ($compromisParrain as $compro_parrain) {

                        if($compro_parrain->id_valide_parrain_porteur == Auth::user()->id || $compro_parrain->id_valide_parrain_partage == Auth::user()->id){
                            $valide_compro_id [] = $compro_parrain->id;

                        }

                    }
                }
    
            // }
           



// ###################



        return view ('compromis.index',compact('compromis','compromisParrain','fill_ids','compro_ids1','compro_ids2','valide_compro_id','compromisEncaissee','compromisEnattente','compromisSousOffre','compromisSousCompromis','page_filleul','nb_jour_max_demande'));

        }
        //  dd($compromis);
        return view ('compromis.index',compact('compromis','compromisParrain','compromisEncaissee','compromisEnattente','compromisSousOffre','compromisSousCompromis','page_filleul','nb_jour_max_demande'));
    }


    /**
     * Afficher les types de compromis à partir du dashbord.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_from_dashboard($annee)
    {

    
        //########## TYPE AFFAIRE

                        
        $tab_compromisEncaissee_id = array();
        $tab_compromisEnattente_id = array();
        $tab_compromisPrevisionnel_id = array();

        $compromisEncaissee_id = Facture::where([['date_encaissement','like',"%$annee%"],['encaissee',1],['a_avoir',0],['type','stylimmo']])->select('compromis_id')->get();
        $compromisEnattente_id = Facture::where([['date_facture','like',"%$annee%"],['encaissee',0],['a_avoir',0],['type','stylimmo']])->select('compromis_id')->get();

        foreach ($compromisEncaissee_id as $encaiss) {
        $tab_compromisEncaissee_id[] = $encaiss["compromis_id"];
        }
        foreach ($compromisEnattente_id as $attente) {
            $tab_compromisEnattente_id[] = $attente["compromis_id"];
        }
       


        if(auth::user()->role == "admin"){
            $compromisEncaissee = Compromis::whereIn('id',$tab_compromisEncaissee_id)->where('archive',false)->get();
            $compromisEnattente = Compromis::whereIn('id',$tab_compromisEnattente_id)->where('archive',false)->get();
            $compromisSousOffre = Compromis::where([['created_at','like',"%$annee%"],['demande_facture','<',2],['pdf_compromis',null],['archive',false]])->get();
            $compromisSousCompromis = Compromis::where([['date_vente','like',"%$annee%"],['demande_facture','<',2],['pdf_compromis','<>',null],['archive',false]])->get();
        }else{

            // On reccupère les affaires du mandataire ou de ses filleuls
            
            $this->users_id []=  auth::user()->id;
            // Si le paramètre filleul existe, alors nous somme sur la page du filleul
          
           

            $compromisEncaissee = Compromis::whereIn('id',$tab_compromisEncaissee_id)->where('archive',false)->where(function($query){
                $query->where('user_id',auth::user()->id)
                ->orWhere('agent_id',auth::user()->id);
            })->get();

            $compromisEnattente = Compromis::whereIn('id',$tab_compromisEnattente_id)->where('archive',false)->where(function($query){
                $query->where('user_id',auth::user()->id)
                ->orWhere('agent_id',auth::user()->id);
            })->get();


            $compromisSousOffre = Compromis::where([['demande_facture','<',2],['pdf_compromis',null],['archive',false],['created_at','like',"%$annee%"]])->where(function($query){
                $query->where('user_id',auth::user()->id)
                ->orWhere('agent_id',auth::user()->id);
            })->get();

            $compromisSousCompromis = Compromis::where([['demande_facture','<',2],['pdf_compromis','<>',null],['archive',false],['date_vente','like',"%$annee%"]])->where(function($query){
                $query->where('user_id',auth::user()->id)
                ->orWhere('agent_id',auth::user()->id);
            })->get();
        }
// ############ FIN TYPE AFFAIRE

        $compromis = array();
        // if(Auth::user()->role =="admin") {
        //     $compromis = Compromis::where([['je_renseigne_affaire',true],['archive',false]])->latest()->get();
        // }else{
        //     $compromis = Compromis::where([['user_id',Auth::user()->id],['je_renseigne_affaire',true],['archive',false]])->orWhere('agent_id',Auth::user()->id)->latest()->get();
            
        // }
      
        $compromis = $compromisEncaissee->concat($compromisEnattente)->concat($compromisSousOffre)->concat($compromisSousCompromis);
        $parametre = Parametre::first();     
        $nb_jour_max_demande = $parametre->nb_jour_max_demande ;
        return view ('compromis.index_from_dash',compact('compromis','compromisEncaissee','compromisEnattente','compromisSousOffre','compromisSousCompromis','annee','nb_jour_max_demande'));
       
    }


 /**
     * Afficher les types de compromis à partir du dashbord.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_from_dashboard_mes_affaires($annee)
    {

    
        //########## TYPE AFFAIRE

                   
        $tab_compromisEncaissee_id = array();
        $tab_compromisEnattente_id = array();
        $tab_compromisPrevisionnel_id = array();

        $compromisEncaissee_id =  Facture::where([['user_id',auth::user()->id],['reglee',true]])->whereIn('type',['honoraire','partage','parrainage','parrainage_partage'])->where('date_reglement','like',"%$annee%")->get();
        $compromisEnattente_id = Facture::where([['user_id',auth::user()->id],['reglee',false]])->whereIn('type',['honoraire','partage','parrainage','parrainage_partage'])->where('created_at','like',"%$annee%")->get();

        foreach ($compromisEncaissee_id as $encaiss) {
            $tab_compromisEncaissee_id[] = $encaiss["compromis_id"];
        }
        foreach ($compromisEnattente_id as $attente) {
            $tab_compromisEnattente_id[] = $attente["compromis_id"];
        }
       

            // On reccupère les affaires du mandataire 
          

            $compromisEncaissee = Compromis::whereIn('id',$tab_compromisEncaissee_id)->get();
        

            $compromisEnattente = Compromis::whereIn('id',$tab_compromisEnattente_id)->get();


            $compromisSousOffre = Compromis::where([['demande_facture','<',2],['pdf_compromis',null],['archive',false],['created_at','like',"%$annee%"]])->where(function($query){
                $query->where('user_id',auth::user()->id)
                ->orWhere('agent_id',auth::user()->id);
            })->get();

            $compromisSousCompromis = Compromis::where([['demande_facture','<',2],['pdf_compromis','<>',null],['archive',false],['date_vente','like',"%$annee%"]])->where(function($query){
                $query->where('user_id',auth::user()->id)
                ->orWhere('agent_id',auth::user()->id);
            })->get();

// ############ FIN TYPE AFFAIRE

        $compromis = array();

      
        $compromis = $compromisEncaissee->concat($compromisEnattente)->concat($compromisSousOffre)->concat($compromisSousCompromis);
        $parametre = Parametre::first();     
        $nb_jour_max_demande = $parametre->nb_jour_max_demande ;
        return view ('compromis.index_from_dash_mes_affaires',compact('compromis','compromisEncaissee','compromisEnattente','compromisSousOffre','compromisSousCompromis','annee','nb_jour_max_demande'));
       
    }



    /**
     * Affaires cloturées
     *
     * @return \Illuminate\Http\Response
     */
    public function affaire_cloture()
    {

        if(Auth::user()->role == "admin"){
            $compromis = Compromis::where([['cloture_affaire',2], ['archive', false]])->get();
        }else {
            $compromis = Compromis::where([['cloture_affaire',2], ['archive', false], ['user_id', Auth::user()->id]])->orWhere([['cloture_affaire',2], ['archive', false], ['agent_id', Auth::user()->id]])->get();

        }


        return view('compromis.affaire_cloture',compact('compromis'));
    }


    /**
     * Toutes les affaires
     *
     * @return \Illuminate\Http\Response
     */
    public function affaire_toutes()
    {
        // $compromis = Compromis::where([['cloture_affaire','<',2], ['archive', false]])->get();

        if(Auth::user()->role == "admin"){
            $compromis = Compromis::where([ ['archive', false]])->get();
        }else {
            $compromis = Compromis::where([ ['archive', false], ['user_id', Auth::user()->id]])->orWhere([['archive', false], ['agent_id', Auth::user()->id]])->get();

        }
        $parametre = Parametre::first();     
        $nb_jour_max_demande = $parametre->nb_jour_max_demande ;
        
        return view('compromis.affaire_toutes',compact('compromis','nb_jour_max_demande'));
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
        //   dd($request->all());
        // return $request->partage_reseau ;


    // on force le format des dates à cause des vieux navigateurs
    $date = date_create($request->date_mandat);
    $date_s = date_create($request->date_signature);
    $date_v = date_create($request->date_vente);

    if($request->date_signature != null && is_string($request->date_signature)  ){
        $date_s = date_create($request->date_signature);
        $date_signature = $date_s->format('Y-m-d');
 
    }else{
        $date_signature = null;
       

    }

    
    $date_mandat = $date->format('Y-m-d');
    $date_vente = $date_v->format('Y-m-d');
     
    $aff = Compromis::where('numero_mandat',$request->numero_mandat)->first();
    
  

        if($request->partage == "Non"  || ($request->partage == "Oui" &&  $request->je_porte_affaire == "on" ) ){
            
       
           
            if($request->type_affaire == "Vente"){
                $request->validate([
                    'numero_mandat' => 'unique:compromis',
                    'pdf_compromis' => 'file:pdf'
                ]);
                
               
            }else{
               
            
                if($aff != null && $aff->type_affaire == "Vente"){
                
                    
                    $request->validate([
                        'numero_mandat' => 'unique:compromis',
                        'pdf_compromis' => 'file:pdf'
                    ]);
        
                }else{
                  
                    $request->validate([                    
                        'pdf_compromis' => 'file:pdf'
                    ]);
                }
                
            }
           
           

            $compromis = Compromis::create([
                "user_id"=> Auth::user()->id,
                "est_partage_agent"=>$request->partage == "Non" ? false : true,
                "partage_reseau"=>$request->hors_reseau == "Non" ? true : false,
                "agent_id"=> ($request->partage == "Oui" && $request->hors_reseau == "Non" ) ? $request->agent_id : null,
                "nom_agent"=>$request->nom_agent,
                "adresse_agence"=>$request->adresse_agence,
                "code_postal_agence"=>$request->code_postal_agence,
                "ville_agence"=>$request->ville_agence,
                "qui_porte_externe"=>$request->qui_porte_externe,
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
                "date_mandat"=>$date_mandat,
                "frais_agence"=>$request->frais_agence,
                "charge"=>$request->charge,
                "net_vendeur"=>$request->net_vendeur,
                "scp_notaire"=>$request->scp_notaire,
                "date_vente"=>$date_vente,
                "date_signature"=>$date_signature,
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

           if( session('is_switch') == true ){
                $action = "a crée l'affaire $compromis->numero_mandat pour  ".Auth::user()->nom." ".Auth::user()->prenom;
                $user_id = session('admin_id');
           }else{
                $action = Auth::user()->nom." ".Auth::user()->prenom." a crée l'affaire $compromis->numero_mandat";
                $user_id = Auth::user()->id;
           }
          
            Historique::createHistorique( $user_id,$compromis->id,"compromis",$action );
            
            
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
        // on force le format des dates à cause des vieux navigateurs
        $date = date_create($request->date_mandat);
        $date_v = date_create($request->date_vente);

        if($request->date_signature != null  && is_string($request->date_signature)){
            $date_s = date_create($request->date_signature);
            $date_signature = $date_s->format('Y-m-d');
        }else{
            $date_signature = null;
        }



        $date_vente = $date_v->format('Y-m-d');
        $date_mandat = $date->format('Y-m-d');
 
       
        if($request->a_avoir == "true" && $compromis->getFactureStylimmo() != null ){
            $facture = $compromis->getFactureStylimmo();
             $motif = "Modification du compromis";
             $numero = Facture::whereIn('type',['avoir','stylimmo','pack_pub','carte_visite','communication','autre','forfait_entree','cci'])->max('numero') + 1;
 
            //   dd($numero);
             $avoir = Facture::store_avoir($facture->id, $numero, $motif);
             $compromis->demande_facture = 0 ;
             $compromis->facture_stylimmo_valide = 0 ;
             $action= "a généré une facture d'avoir pendant la modification de l'affaire ".$compromis->numero_mandat;
             Historique::createHistorique( Auth::user()->id, $avoir->id,"facture",$action );
        
             
        }


        if($request->partage == "Non"  || ($request->partage == "Oui" ) ){
            if($request->numero_mandat != $compromis->numero_mandat){
                
                if($request->type_affaire == "Vente"){
                    $request->validate([
                        'numero_mandat' => 'required|numeric|unique:compromis',
                       
                    ]);
                }
                
                
                
                
            }
            $compromis->est_partage_agent = $request->partage == "Non" ? false : true;
            $compromis->partage_reseau = $request->hors_reseau == "Non" ? true : false;
            $compromis->type_affaire = $request->type_affaire;
            $compromis->nom_agent = $request->nom_agent;

            $compromis->agent_id = ( $request->partage == "Oui" && $request->hors_reseau == "Non" )? $request->agent_id : null ;

            $compromis->description_bien = $request->description_bien;
            $compromis->code_postal_bien = $request->code_postal_bien;
            $compromis->ville_bien = $request->ville_bien;

            $compromis->civilite_vendeur = $request->civilite_vendeur;
            $compromis->nom_vendeur = $request->nom_vendeur;
            $compromis->adresse_agence = $request->adresse_agence;
            $compromis->code_postal_agence = $request->code_postal_agence;
            $compromis->ville_agence = $request->ville_agence;
            $compromis->qui_porte_externe = $request->qui_porte_externe;
            
     
            $compromis->adresse1_vendeur = $request->adresse1_vendeur;
            $compromis->adresse2_vendeur = $request->adresse2_vendeur;
            $compromis->code_postal_vendeur = $request->code_postal_vendeur;
            $compromis->ville_vendeur = $request->ville_vendeur;

            $compromis->civilite_acquereur = $request->civilite_acquereur;
            $compromis->nom_acquereur = $request->nom_acquereur;
            $compromis->adresse1_acquereur = $request->adresse1_acquereur;
            $compromis->adresse2_acquereur = $request->adresse2_acquereur;
            $compromis->code_postal_acquereur = $request->code_postal_acquereur;
            $compromis->ville_acquereur = $request->ville_acquereur;
            // $compromis->raison_sociale_vendeur = $request->raison_sociale_vendeur;
            // $compromis->raison_sociale_acquereur = $request->raison_sociale_acquereur;
            $compromis->numero_mandat = $request->numero_mandat;
            $compromis->date_mandat = $date_mandat;
            $compromis->montant_deduis_net = $request->montant_deduis;
            $compromis->frais_agence = $request->frais_agence;
            $compromis->charge = $request->charge;
            $compromis->net_vendeur = $request->net_vendeur;
            $compromis->scp_notaire = $request->scp_notaire;

            // Modification de la date de vente et notification par mail
           if($compromis->date_vente != null){
                if($compromis->date_vente->format('Y-m-d') != $date_vente){
                    
                    // Mail::to("gestion@stylimmo.com")->send(new ModifCompromis($compromis, $request,"admin"));
                }
           }else{
                $compromis->date_vente = $date_vente;
           }

           if ($compromis->est_partage_agent == true && $compromis->agent_id != null){
                $user_partage = User::where("id",$compromis->agent_id)->first();
                Mail::to($user_partage->email)->send(new ModifCompromis($compromis, $request,"mandataire"));

           }
           $compromis->date_vente = $date_vente;
           $compromis->pourcentage_agent = $request->pourcentage_agent;

            $compromis->date_signature = $date_signature;
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

        // Création de l'avoir si la facture stylimmo a déjà été crée 
        // if($compromis->facture_stylimmo_valide == true){
            

        // }

        if( session('is_switch') == true ){
            $action = "a modifié l'affaire $compromis->numero_mandat pour  ".Auth::user()->nom." ".Auth::user()->prenom;
            $user_id = session('admin_id');
       }else{
            $action = Auth::user()->nom." ".Auth::user()->prenom." a modifié l'affaire $compromis->numero_mandat";
            $user_id = Auth::user()->id;
       }
       Historique::createHistorique( $user_id,$compromis->id,"compromis",$action );
      

       if($request->a_avoir == "true" && $compromis->getFactureStylimmo() != null  && $compromis->cloture_affaire == 0){
            return redirect()->route('facture.generer_avoir_stylimmo',[Crypt::encrypt($avoir->id)])->with('ok', __("compromis modifié (mandat $mandat) ")  );
       }
    
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

        $compromis->cloture_affaire = 1;
        $compromis->update();

        if( session('is_switch') == true ){
            $action = "a réitéré l'affaire $compromis->numero_mandat pour  ".Auth::user()->nom." ".Auth::user()->prenom;
            $user_id = session('admin_id');
       }else{
            $action = Auth::user()->nom." ".Auth::user()->prenom." a réitéré l'affaire $compromis->numero_mandat";
            $user_id = Auth::user()->id;
       }
      
        Historique::createHistorique( $user_id,$compromis->id,"compromis",$action );

        $compromis->notif_reiterer_affaire();
        
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

        $compromisEncaissee_id = Facture::where([['encaissee',1],['a_avoir',0],['type','stylimmo']])->select('compromis_id')->get();
        $compromisEnattente_id = Facture::where([['encaissee',0],['a_avoir',0],['type','stylimmo']])->select('compromis_id')->get();

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
        $compromis->demande_facture = 0;


        $compromis->facture_stylimmo_valide = 0;

        if( session('is_switch') == true ){
            $action = "a archivé l'affaire $compromis->numero_mandat pour  ".Auth::user()->nom." ".Auth::user()->prenom;
            $user_id = session('admin_id');
       }else{
            $action = Auth::user()->nom." ".Auth::user()->prenom." a archivé l'affaire $compromis->numero_mandat";
            $user_id = Auth::user()->id;
       }
        
        Historique::createHistorique( $user_id,$compromis->id,"compromis",$action );

        if($compromis->getFactureStylimmo() != null ){
            $facture = $compromis->getFactureStylimmo();
             $motif = "Archivage du compromis";
             $numero = Facture::whereIn('type',['avoir','stylimmo','pack_pub','carte_visite','communication','autre','forfait_entree','cci'])->max('numero') + 1;
 
            //  dd($facture);
             $avoir = Facture::store_avoir($facture->id, $numero, $motif);
             
             $action= "a généré une facture d'avoir pendant l'archivage de l'affaire ".$compromis->numero_mandat;
             Historique::createHistorique( Auth::user()->id, $avoir->id,"facture",$action );
        
             $compromis->update();
             return "avoir";
             
        }

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

        if( session('is_switch') == true ){
            $action = "a restauré l'affaire $compromis->numero_mandat pour  ".Auth::user()->nom." ".Auth::user()->prenom;
            $user_id = session('admin_id');
       }else{
            $action = Auth::user()->nom." ".Auth::user()->prenom." a restauré l'affaire $compromis->numero_mandat";
            $user_id = Auth::user()->id;
       }
      
        Historique::createHistorique( $user_id,$compromis->id,"compromis",$action );
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

    /**
     * Créer un avoir
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function creer_avoir(Compromis $compromis)
    {
        $compromis->a_avoir = true;
        Avoir::create([
            "numero" =>  $numero,
            "facture_id" =>$compromis->getFactureStylimmo()->id,
            "date" => date()
        ]);
        
        return "".$compromis->update();

    }

    /**
     * Créer un avoir
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function etat_compromis($compromis)
    {
        $compromis = Compromis::where('id',Crypt::decrypt($compromis))->first();

        $filleulPorteur = Filleul::where('user_id', $compromis->user_id )->first();
        $filleulPartage = Filleul::where('user_id', $compromis->agent_id )->first();

        $parrainPorteur=  $filleulPorteur !=null ? User::where('id',  $filleulPorteur->parrain_id)->first() : null;
        $parrainPartage=  $filleulPartage !=null ? User::where('id',  $filleulPartage->parrain_id)->first() : null;

        return view('compromis.etat',compact('compromis','parrainPorteur','parrainPartage'));
    }
    
    
    /**
     * Modifier la date de vente du compromis
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function modifier_date_vente(Request $request, $compromis)
    {
        $compromis = Compromis::where('id',Crypt::decrypt($compromis))->first();


        $compromis->date_vente = $request->date_vente;
        
        $compromis->update();
        
        return redirect()->route('compromis.index')->with('ok', "La date de vente de l'affaire  $compromis->numero_mandat a été modifié");
    }
    
    
    

}
