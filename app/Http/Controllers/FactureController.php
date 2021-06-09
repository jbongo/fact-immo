<?php

namespace App\Http\Controllers;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Facture;
use App\User;
use App\Compromis;
use App\Filleul;
use App\Avoir;
use App\Parametre;
use App\Tva;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Mail\DemandeFactureStylimmo;
use App\Mail\EnvoyerFactureStylimmoMandataire;
use App\Mail\EncaissementFacture;
use App\Mail\NotifierValidationHonoraire;

use PDF;
use Illuminate\Support\Facades\File ;
use Illuminate\Support\Facades\Storage;
use App\Historique;


class FactureController extends Controller
{
    /**
     * Afficher toutes les factures
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //
    
        if(auth()->user()->role == "admin"){
            $factureStylimmos = Facture::whereIn('type',['stylimmo','avoir','pack_pub','carte_visite','communication','autre'])->latest()->get();
            $factureHonoraires = Facture::whereIn('type',['honoraire','partage','partage_externe','parrainage','parrainage_partage'])->latest()->get();
            $factureCommunications = Facture::where('type',['pack_pub','carte_visite'])->latest()->get();
            
            $nb_comm_non_regle  = Facture::where('reglee',false)->whereIn('type',['pack_pub','carte_visite'])->count();
            
        }else{
            $factureHonoraires = Facture::where('user_id',auth()->user()->id)->whereIn('type',['honoraire','partage','partage_externe','parrainage','parrainage_partage'])->latest()->get();
            $factureStylimmos = Facture::where('user_id',auth()->user()->id)->where('type',['stylimmo','avoir','pack_pub','carte_visite','communication','autre'])->latest()->get();
            $factureCommunications = Facture::where('user_id',auth()->user()->id)->whereIn('type',['pack_pub','carte_visite'])->latest()->get();
            
            $nb_comm_non_regle  = Facture::where([['user_id',auth()->user()->id],['reglee',false]])->whereIn('type',['pack_pub','carte_visite'])->count();
         

        }
        
        
        return view ('facture.index',compact(['factureHonoraires','factureStylimmos','factureCommunications','nb_comm_non_regle']));
    }
    
    
    
    /**
     * Afficher toutes les factures stylimmo
     *
     * @return \Illuminate\Http\Response
     */
    public function index_stylimmo()
    {
        //
        //
    
        if(auth()->user()->role == "admin"){
            $factureStylimmos = Facture::whereIn('type',['stylimmo'])->latest()->get();
            
        }else{
            $factureStylimmos = Facture::where('user_id',auth()->user()->id)->where('type',['stylimmo'])->latest()->get();
        }
        
        
        return view ('facture.index_stylimmo',compact(['factureStylimmos']));
    }
    
    
    
        /**
     * Afficher toutes les factures pub
     *
     * @return \Illuminate\Http\Response
     */
    public function index_pub()
    {
        //
        //
    
        if(auth()->user()->role == "admin"){
            $facturePubs = Facture::whereIn('type',['pack_pub'])->latest()->get();
            
        }else{
            $facturePubs = Facture::where('user_id',auth()->user()->id)->where('type',['pack_pub'])->latest()->get();
        }
        
        
        return view ('facture.index_pub',compact(['facturePubs']));
    }
    
    
    


    /**
     * demande de facture stylimmo par le mandataire
     *
     * @param  int  $compromis
     * @return \Illuminate\Http\Response
     */
    public function demander_facture($compromis_id)
    {
    
        $compromis = Compromis::where('id',Crypt::decrypt($compromis_id))->first();
        $mandataire = User::where('id',$compromis->user_id)->first();
        $numero = Facture::whereIn('type',['avoir','stylimmo','pack_pub','carte_visite','communication','autre'])->max('numero') + 1;

        return view ('demande_facture.demande',compact('compromis','mandataire','numero'));  
        // return redirect()->route('compromis.index')->with('ok', __('compromis modifié')  );

    }


    /**
     * demande de facture stylimmo par le mandataire
     *
     * @param  int  $compromis
     * @return \Illuminate\Http\Response
     */
    public function store_demande_facture(Request $request, $compromis_id)
    {
            // on force le format des dates à cause des vieux navigateurs
           
            $date_s = date_create($request->date_signature);
            $date_v = date_create($request->date_vente);
    
            

            $date_signature = $date_s->format('Y-m-d');
            $date_vente = $date_v->format('Y-m-d');

    
        $compromis = Compromis::where('id',Crypt::decrypt($compromis_id))->first();
        $compromis->date_vente = $date_vente;

        // Si le compromis est ajouté lors de la demande
        if($request->hasFile('pdf_compromis') ){
            $request->validate([
                'date_signature' => 'required',
                'pdf_compromis' => 'mimes:pdf'
            ]);

            $filename = 'pdf_compromis_'.$compromis->id.'.pdf';
            $compromis->pdf_compromis = $filename;
            // return response()->download(storage_path('app/pdf_compromis/pdf_compro.pdf'));
            $request->pdf_compromis->storeAs('public/pdf_compromis',$filename);
        }
        
        // dd($compromis);
        $compromis->date_signature = $date_signature;

        // 0 = facture non demandée, 1= facture demandée en attente de validation, 2 = demande traitée par stylimmo
        $compromis->demande_facture = 1;

        $compromis->update();

        $nb_demande_facture =  Compromis::where([['demande_facture',1],['archive',false]])->count();


        // dd($nb_demande_facture);

        $admins = User::where('role','admin')->get();

        foreach ($admins as $admin) {
           $admin->demande_facture = $nb_demande_facture;
           $admin->update();
        }

        Mail::to("gestion@stylimmo.com")->send(new DemandeFactureStylimmo($compromis->user));


       if( session('is_switch') == true ){
            $action = "a demandé une facture pour l'affaire $compromis->numero_mandat pour  ".Auth::user()->nom." ".Auth::user()->prenom;
            $user_id = session('admin_id');
       }else{
            $action = Auth::user()->nom." ".Auth::user()->prenom." a demandé une facture pour l'affaire  $compromis->numero_mandat";
            $user_id = Auth::user()->id;
       }
      
        Historique::createHistorique( $user_id,$compromis->id,"compromis",$action );


        // return view ('demande_facture.demande',compact('compromis'));    
        return redirect()->route('compromis.index')->with('ok', __('Demande de facture éffectuée')  );

    }




    /**
     *  lister les demandes de facture stylimmo
     *
     * @return \Illuminate\Http\Response
    */
    public  function demandes_stylimmo()
    {
        
        $compromis = Compromis::where([['demande_facture', 1],['archive',0]])->get();
        // dd($compromis);
        return view ('demande_facture.index',compact('compromis'));
    }

   
/**
 *  Afficher la demande de facture stylimmo
 *
 * @param  string  $compromis
 * @return \Illuminate\Http\Response
*/

    public  function show_demande_stylimmo($compromis)
    {
        
        $compromis = Compromis::where('id', Crypt::decrypt($compromis))->first();
        return view ('demande_facture.show',compact('compromis'));
    }



/**
 *  validation de la facture stylimmo
 *
 * @param  string  $compromis
 * @return \Illuminate\Http\Response
*/
public  function valider_facture_stylimmo( Request $request, $compromis)
{
    $numero = Facture::where([ ['type','stylimmo']])->max('numero') ;
    
    // la date d'une facture doit être supérieur ou égale à la facture précedente  et/ou inférieure ou égale à la facture suivante

    // #1 dans ce bloc on réccupère les numéros de facture qui viennent avant et/ou après le numéro de la facture suivante.. afin de comparer les dates
    $next_numeros = Facture::where([ ['type','stylimmo'], ['numero','>',$request['numero']] ])->select("numero")->orderBy('numero')->get()->toArray();
    $prev_numeros = Facture::where([ ['type','stylimmo'], ['numero','<',$request['numero']] ])->select("numero")->orderBy('numero','desc')->get()->toArray();
    // $next_nums = array();
    $next_nums = null;
    $prev_nums = null;
    if($next_numeros != null){
        foreach ($next_numeros as $next) {
            $next_nums [] = $next['numero'] ;
        }
    }
    
    if($prev_numeros != null){
        foreach ($prev_numeros as $next) {
            $prev_nums [] = $next['numero'] ;
        }
    }

    // Dans ce bloc on compare les dates
    if($prev_nums != null && $next_nums != null){

        $prev_fact = Facture::where([ ['type','stylimmo'], ['numero',$prev_nums[0]] ])->first();
        $next_fact = Facture::where([ ['type','stylimmo'], ['numero',$next_nums[0]] ])->first();

        $prev_date = $prev_fact->date_facture->format('Y-m-d');
        $next_date = $next_fact->date_facture->format('Y-m-d');
     
        $request->validate([
            'numero' => 'required|numeric|unique:factures',
            'date_facture' => "required|date|after_or_equal:$prev_date|before_or_equal:$next_date",
        ]);

    }elseif($prev_nums != null && $next_nums == null){
        $prev_fact = Facture::where([ ['type','stylimmo'], ['numero',$prev_nums[0]] ])->first();
        $prev_date = $prev_fact->date_facture->format('Y-m-d');
        $request->validate([
            'numero' => 'required|numeric|unique:factures',
            'date_facture' => "required|date|after_or_equal:$prev_date",
        ]);
     
    }elseif($prev_nums == null && $next_nums != null){
        $next_fact = Facture::where([ ['type','stylimmo'], ['numero',$next_nums[0]] ])->first();
        $next_date = $next_fact->date_facture->format('Y-m-d');
        $request->validate([
            'numero' => 'required|numeric|unique:factures',
            'date_facture' => "required|date|before_or_equal:$next_date",
        ]);

    }
    else{

    }
    

    // dd($request['numero']." est compris entre " .$prev_nums[0]." et ".$next_nums[0]);

   

    $numero = $request->numero;
    $compromis = Compromis::where('id', Crypt::decrypt($compromis))->first();
    $mandataire = $compromis->user;
    // save la facture

    $tva = Tva::coefficient_tva();
    
    $facture = Facture::where([ ['type','stylimmo'],['compromis_id',$compromis->id],['a_avoir', false]])->first();


    // Si la facture n'est pas déjà crée
    
    // calcul du montant de la facture en fonction du type de partage s'il y'a partage 
    
    $montant_ttc = $compromis->frais_agence;
    
    // Si on partage avec une agence externe
    if($compromis->est_partage_agent == true && $compromis->partage_reseau == false){
    // Si Styl et l'agence  OU  l'agence porte l'affaire chez le notaire, on ne facture facture pas la totalité des frais d'agence
        if($compromis->qui_porte_externe == 1 || $compromis->qui_porte_externe == 2){
        
            $montant_ttc = $montant_ttc * $compromis->pourcentage_agent / 100;
        }
    }
    
    $montant_ht = round ($montant_ttc/$tva ,2);
    
    if ($facture == null) {

            $facture = Facture::create([
            "numero"=> $numero,
            "user_id"=> $compromis->user_id,
            "compromis_id"=> $compromis->id,
            "type"=> "stylimmo",
            "encaissee"=> false,
            "montant_ht"=>  $montant_ht,
            "montant_ttc"=> $montant_ttc,
            "date_facture"=> $request->date_facture,

        ]);

        
            $compromis->facture_stylimmo_valide = true;
            $compromis->update();

            // on sauvegarde la facture dans le repertoire du mandataire
            $path = storage_path('app/public/'.$mandataire->id.'/factures');

            if(!File::exists($path))
                File::makeDirectory($path, 0755, true);
            
            $pdf = PDF::loadView('facture.pdf_stylimmo',compact(['compromis','mandataire','facture']));
            $path = $path.'/facture_'.$facture->numero.'.pdf';
            $pdf->save($path);
            
            $facture->url = $path;
            $compromis->demande_facture = 2;
            $facture->update();
            $compromis->update();

            $nb_demande_facture =  Compromis::where([['demande_facture',1],['archive',false]])->count();
            $admins = User::where('role','admin')->get();

            foreach ($admins as $admin) {
                $admin->demande_facture = $nb_demande_facture;
                $admin->update();
            }
            
            Mail::to($mandataire->email)->send(new EnvoyerFactureStylimmoMandataire($mandataire,$facture));
            // Mail::to("gestion@stylimmo.com")->send(new EnvoyerFactureStylimmoMandataire($mandataire,$facture));


                $action = Auth::user()->nom." ".Auth::user()->prenom." a validé la facture stylimmo $facture->numero";
                $user_id = Auth::user()->id;

        
            Historique::createHistorique( $user_id,$facture->id,"facture",$action );
       

    }else{
        $facture = Facture::where([ ['type','stylimmo'],['compromis_id',$compromis->id]])->first();
    // return view ('facture.generer_stylimmo',compact(['compromis','mandataire','facture']))->with('ok', __('Cette affaire a déjà une facture sans avoir') );

    }
    
    // fin save facture
// dd("ee");
    
    return view ('facture.generer_stylimmo',compact(['compromis','mandataire','facture','numero']))->with('ok', __('Facture envoyée au mandataire') );
    
}


/**
 *  Générer une facture stylimmo
 *
 * @param  string  $compromis
 * @return \Illuminate\Http\Response
*/
    public  function generer_facture_stylimmo($compromis)
    {
      
        $compromis = Compromis::where('id', Crypt::decrypt($compromis))->first();
        $mandataire = $compromis->user;
        $facture = Facture::where([ ['type','stylimmo'],['compromis_id',$compromis->id],['a_avoir',false]])->first();

        $numero = "";
        
        $numero = Facture::whereIn('type',['avoir','stylimmo','pack_pub','carte_visite','communication','autre'])->max('numero') + 1;

        $lastdate = Facture::where('numero',$numero-1)->select('date_facture')->first();

        $lastdate= $lastdate['date_facture'];
      
        return view ('facture.generer_stylimmo',compact(['compromis','numero','mandataire','facture','lastdate']));
      
    }

/**
 *  telecharger facture stylimmo
 *
 * @param  string  $compromis_id
 * @return \Illuminate\Http\Response
*/

    public  function download_pdf_facture_stylimmo($facture_id)
    {
    
    
        $facture = Facture::where('id', Crypt::decrypt($facture_id))->first();

        $compromis = Compromis::where('id', $facture->compromis_id)->first();
        $mandataire = $compromis->user;
 
        $filename = "F".$facture->numero." ".$facture->montant_ttc."€ ".strtoupper($mandataire->nom)." ".strtoupper(substr($mandataire->prenom,0,1)).".pdf" ;
        return response()->download($facture->url,$filename);
        
    
        // dd('ddd');
    //     $pdf = PDF::loadView('facture.pdf_stylimmo',compact(['compromis','mandataire','facture']));
    //     $path = storage_path('app/public/factures/'.$filename);
    //     // $pdf->save($path);
    //     // $pdf->download($path);
    //    return $pdf->download($filename);
      
    }
    
/**
 *  Envoyer facture stylimmo au mandataire
 *
 * @param  string  $facture_id
 * @return \Illuminate\Http\Response
*/

    public  function envoyer_facture_stylimmo($facture_id)
    {


        $facture = Facture::where('id', Crypt::decrypt($facture_id))->first();

        // dd($facture);

        $compromis = $facture->compromis;
        $mandataire = $compromis->user;

        // dd('ddd');
        Mail::to($mandataire->email)->send(new EnvoyerFactureStylimmoMandataire($mandataire,$facture));
        // Mail::to("gestion@stylimmo.com")->send(new EnvoyerFactureStylimmoMandataire($mandataire,$facture));

        return redirect()->route('facture.demande_stylimmo')->with('ok', __('Facture envoyée au mandataire')  );
        
    }

/**
 *  enaisser la facture stylimmo
 *
 * @param  int  $facture
 * @return \Illuminate\Http\Response
*/
      
    public  function encaisser_facture_stylimmo($facture_id, Request $request )
    {


        $facture = Facture::where('id', $facture_id)->first();
    
        $facture->encaissee = true;
        // $facture->date_encaissement = $date_encaissement;
        $facture->date_encaissement = $request->date_encaissement;
        $facture->update();

        if($facture->compromis != null){
            Mail::to($facture->compromis->user->email)->send(new EncaissementFacture($facture));
        }
    //    Mail::to("gestion@stylimmo.com")->send(new EncaissementFacture($facture));




    // ##### CALCUL ET DROIT DE PARRAINAGE 

    // On determine le compromis lié au compromis

    $compromis = $facture->compromis;


    if($compromis != null)
    {
    
    
    
    // ########## On calucul la note d'hono du Porteur et du partage  ##################################################################
    
            if($compromis->agent_id == null){
            
                $this->preparer_facture_honoraire_encaissement($compromis->id, true );
            
            }else{
            // facture du porteur de l'affaire
                $this->preparer_facture_honoraire_encaissement($compromis->id, true );
                // facture du partage de l'affaire
                $this->preparer_facture_honoraire_encaissement($compromis->id, false );
            
            }
    
    // #############################
    
    
    
    
    
    
            // ######## si l'affaire est partagée, on va vérifier si les mandataires ont un parrain Puis caluler leur commission
           
                $filleul1 = Filleul::where([['user_id',$compromis->user_id],['expire',0]])->first();

                $filleul2 = $compromis->agent_id != null ? Filleul::where([['user_id',$compromis->agent_id],['expire',0]])->first() : null;
            

                $date_encaissement = $facture->date_encaissement->format('Y-m-d');

                // date_12 est la date exacte 1 ans avant la date d'encaissment
                $date_12 =  strtotime( $date_encaissement. " -1 year"); 
                $date_12 = date('Y-m-d',$date_12);

                $deb_annee = date("Y")."-01-01";

        $retour = "";
                // Si le porteur de l'affaire à un parrain
                if($filleul1 != null ){

                    $mandataire1 = $filleul1->user ;
                    $parrain1 = User::where('id',$filleul1->parrain_id)->first();

                    $ca_parrain1 =  Compromis::getCAStylimmo($parrain1->id,$date_12 ,$date_encaissement);
                    $ca_filleul1 =  Compromis::getCAStylimmo($mandataire1->id,$date_12 ,$date_encaissement);

                    // on calcul le chiffre affaire de parrainage du parrain 


                    $comm_parrain1 = unserialize($mandataire1->contrat->comm_parrain);

                    
                            // 1 on determine l'ancieneté du filleul1
                            
                            $dt_ent =  $mandataire1->contrat->date_entree->format('Y-m-d') >= "2019-01-01" ?  $mandataire1->contrat->date_entree : "2019-01-01";
                            $date_entree =  strtotime($dt_ent);  

                            $today = strtotime (date('Y-m-d'));
                            $anciennete_porteur = $today - $date_entree;

                            if($anciennete_porteur <= 365*86400){
                                $seuil_porteur = $comm_parrain1["seuil_fill_1"];
                                $seuil_parrain = $comm_parrain1["seuil_parr_1"];
                            }
                            //si ancienneté est compris entre 1 et 2ans
                            elseif($anciennete_porteur > 365*86400 && $anciennete_porteur <= 365*86400*2){
                                $seuil_porteur = $comm_parrain1["seuil_fill_2"];
                                $seuil_parrain = $comm_parrain1["seuil_parr_2"];
                            }
                            // ancienneté sup à 2 ans
                            else{
                                $seuil_porteur = $comm_parrain1["seuil_fill_3"];
                                $seuil_parrain = $comm_parrain1["seuil_parr_3"];
                            }
                          
                         
                            
                            $date_fin = $compromis->getFactureStylimmo()->date_encaissement->format('Y-m-d');
                            
                            // Vérifier le CA du parrain et du filleul sur les 12 derniers mois précédents la date d'encaissement de la facture STYL et qui respectent les critères et vérifier s'il sont à jour dans le reglèmement de leur factures stylimmo 
                            // Dans cette partie on détermine le jour exaxt de il y'a 12 mois avant la date d'encaissement de la facture STYL
                               
        
                    
                            // date_fin est la date exacte 1 ans avant la date  d'encaissement de la facture STYL
                            $date_deb  =  strtotime( $date_fin. " -1 year"); 
                            $date_deb = date('Y-m-d',$date_deb);
        
        
        
                            // calcul du de la comm recu par le parrain de date_deb à date_fin                 
                            
                            
                            $facts_parrain = Facture::where([['user_id',$parrain1->id],['filleul_id',$filleul1->user->id], ['compromis_id','<>', $compromis->id ]])->whereIn('type',['parrainage','parrainage_partage'])->get();
                            $ca_parrain_parrainage = 0;
                            
                            // dd($date_deb);
                            foreach ($facts_parrain as $fact) {
                                
                                // echo $fact->compromis->getFactureStylimmo()->date_encaissement->format('Y-m-d')."<br>";
                                if($date_fin >= $fact->compromis->getFactureStylimmo()->date_encaissement->format('Y-m-d')   && $fact->compromis->getFactureStylimmo()->date_encaissement->format('Y-m-d') >= $date_deb ){
                                    $ca_parrain_parrainage+= $fact->montant_ht;
                                }
                            }
                            
                            
                            
                            
                            // On vérifie que le parrain n'a pas démissionné à la date d'encaissement 
                            $a_demission_parrain = false;

                            if($parrain1->contrat->a_demission == true  ){
                                if($parrain1->contrat->date_demission <= $compromis->getFactureStylimmo()->date_encaissement ){
                                    $a_demission_parrain = true;
                                }
                            }

                            // On vérifie que le filleul n'a pas démissionné à la date d'encaissement 
                            $a_demission_filleul = false;

                            if($mandataire1->contrat->a_demission == true  ){
                                if($mandataire1->contrat->date_demission <= $compromis->getFactureStylimmo()->date_encaissement ){
                                    $a_demission_filleul = true;
                                }
                            }
                            
                            $touch_comm = "non";
                            // dd("$parrain1->id -- ".$filleul1->user->id."  -- $ca_parrain_parrainage < ".$mandataire1->contrat->seuil_comm );
                            // dd("$ca_filleul1 >= $seuil_porteur && $ca_parrain1 >= $seuil_parrain && $ca_parrain_parrainage < $mandataire1->contrat->seuil_comm &&  $a_demission_parrain == false &&  $a_demission_filleul == false");
                            // On  n'a les seuils et les ca on peut maintenant faire les comparaisons     ## // on rajoutera les conditions de pack pub                           
                            if($ca_filleul1 >= $seuil_porteur && $ca_parrain1 >= $seuil_parrain && $ca_parrain_parrainage < $mandataire1->contrat->seuil_comm &&  $a_demission_parrain == false &&  $a_demission_filleul == false  ){
                                $compromis->id_valide_parrain_porteur = $parrain1->id;
                                $compromis->update();
                                $touch_comm = "oui";
                            }else{
                                $compromis->id_valide_parrain_porteur = null;
                                $compromis->update();
                            }


                            // SI TOUCHE_COMM == OUI ON CALCUL LA COMMISSION DU PARRAIN DU PORTEUR
                            // dd("$ca_filleul1 >= $seuil_porteur && $ca_parrain1 >= $seuil_parrain && $ca_parrain_parrainage < $mandataire1->contrat->seuil_comm &&  $a_demission_parrain == false &&  $a_demission_filleul == false ");
                            if($touch_comm == "oui"){
                            // dd($a_demission_parrain);
                            // dd("$ca_filleul1 >= $seuil_porteur && $ca_parrain1 >= $seuil_parrain && $ca_parrain_parrainage < $mandataire1->contrat->seuil_comm &&  $a_demission_parrain == false &&  $a_demission_filleul == false ");
                                 $this->store_facture_honoraire_parrainage( $compromis, $filleul1);
                            }
                            
                            // dd("ici");
                            
                            // ####################################################################
                            
                            $retour .= "parrain : ".$parrain1->nom.' '.$parrain1->prenom." ca parrain: ".$ca_parrain1." \n  filleul porteur: ".$mandataire1->nom.' '.$mandataire1->prenom." ca filleul porteur: ".$ca_filleul1." \n parrain touche comm ? : ".$touch_comm;
                        
                }

            

                // Si le partage a un parrain
                if($filleul2!= null){

                    $mandataire2 = $filleul2->user ;
                    $parrain2 = User::where('id',$filleul2->parrain_id)->first();

                    // Chiffre d'affaire du filleul et son parrain sur 1 ans avant la date d'encaissement,  
                    $ca_parrain2 =  Compromis::getCAStylimmo($parrain2->id,$date_12 ,$date_encaissement);
                    $ca_filleul2 =  Compromis::getCAStylimmo($mandataire2->id,$date_12 ,$date_encaissement);

                    $comm_parrain2 = unserialize($mandataire2->contrat->comm_parrain);

                    
                            // 1 on determine l'ancieneté du filleul1
                        
                            $dt_ent =  $mandataire2->contrat->date_entree->format('Y-m-d') >= "2019-01-01" ?  $mandataire2->contrat->date_entree : "2019-01-01";
                            $date_entree =  strtotime($dt_ent);                                              
                            $today = strtotime (date('Y-m-d'));
                            $anciennete_partage = $today - $date_entree;

                            if($anciennete_partage <= 365*86400){
                                $seuil_partage = $comm_parrain2["seuil_fill_1"];
                                $seuil_parrain = $comm_parrain2["seuil_parr_1"];
                            }
                            //si ancienneté est compris entre 1 et 2ans
                            elseif($anciennete_partage > 365*86400 && $anciennete_partage <= 365*86400*2){
                                $seuil_partage = $comm_parrain2["seuil_fill_2"];
                                $seuil_parrain = $comm_parrain2["seuil_parr_2"];
                            }
                            // ancienneté sup à 2 ans
                            else{
                                $seuil_partage = $comm_parrain2["seuil_fill_3"];
                                $seuil_parrain = $comm_parrain2["seuil_parr_3"];
                            }
             

                           
                            $date_fin = $compromis->getFactureStylimmo()->date_encaissement->format('Y-m-d');
                            
                            // Vérifier le CA du parrain et du filleul sur les 12 derniers mois précédents la date d'encaissement de la facture STYL et qui respectent les critères et vérifier s'il sont à jour dans le reglèmement de leur factures stylimmo 
                            // Dans cette partie on détermine le jour exaxt de il y'a 12 mois avant la date d'encaissement de la facture STYL
                               
    
                            // date_fin est la date exacte 1 ans avant la date  d'encaissement de la facture STYL
                            $date_deb  =  strtotime( $date_fin. " -1 year"); 
                            $date_deb = date('Y-m-d',$date_deb);
                            
                            
                            
                            
                            
                            // calcul du de la comm recu par le parrain de date_deb à date_fin 
                            $facts_parrain = Facture::where([['user_id',$parrain1->id],['filleul_id',$filleul1->user->id], ['compromis_id','<>', $compromis->id ]])->whereIn('type',['parrainage','parrainage_partage'])->get();
                            $ca_parrain_parrainage = 0;
                            
                            // dd($date_deb);
                            foreach ($facts_parrain as $fact) {
                                
                                // echo $fact->compromis->getFactureStylimmo()->date_encaissement->format('Y-m-d')."<br>";
                                if($date_fin >= $fact->compromis->getFactureStylimmo()->date_encaissement->format('Y-m-d')   && $fact->compromis->getFactureStylimmo()->date_encaissement->format('Y-m-d') >= $date_deb ){
                                    $ca_parrain_parrainage+= $fact->montant_ht;
                                }
                            }




                            // On vérifie que le parrain n'a pas démissionné à la date d'encaissement 
                            $a_demission_parrain = false;

                            if($parrain2->contrat->a_demission == true  ){
                                if($parrain2->contrat->date_demission <= $compromis->getFactureStylimmo()->date_encaissement ){
                                    $a_demission_parrain = true;
                                }
                            }

                            // On vérifie que le filleul n'a pas démissionné à la date d'encaissement 
                            $a_demission_filleul = false;

                            if($mandataire2->contrat->a_demission == true  ){
                                if($mandataire2->contrat->date_demission <= $compromis->getFactureStylimmo()->date_encaissement ){
                                    $a_demission_filleul = true;
                                }
                            }



                            $touch_comm = "non";
                            // On  n'a les seuils et les ca on peut maintenant faire les comparaisons     ## // on rajoutera les conditions de pack pub                           
                            if($ca_filleul2 >= $seuil_partage && $ca_parrain2 >= $seuil_parrain && $ca_parrain_parrainage < $mandataire2->contrat->seuil_comm  &&  $a_demission_parrain == false &&  $a_demission_filleul == false ){
                                $touch_comm = "oui";
                            
                                $compromis->id_valide_parrain_partage = $parrain2->id;
                                $compromis->update();
                            }else{
                                $compromis->id_valide_parrain_partage = null;
                                $compromis->update();
                            }
                            
                            
                            // SI TOUCHE_COMM == OUI ON CALCUL LA COMMISSION DU PARRAI DU PARTAGE 
                            
                            
                            if($touch_comm == "oui"){
                            
                                $this->store_facture_honoraire_parrainage($compromis, $filleul2);
                            }
                            
                            
                            // ####################################################################
                            $retour .= "parrain : ".$parrain2->nom.' '.$parrain2->prenom." ca parrain: ".$ca_parrain2." \n  filleul porteur: ".$mandataire2->nom.' '.$mandataire2->prenom." ca filleul porteur: ".$ca_filleul2." \n parrain touche comm ? : ".$touch_comm;


                }

    }
        
        $action = Auth::user()->nom." ".Auth::user()->prenom." a encaissé la facture stylimmo  $facture->numero";
        $user_id = Auth::user()->id;
    
      
        Historique::createHistorique( $user_id,$facture->id,"facture",$action );
        
        return $facture->numero;



        
    }



//    ############ FACTURES D'HONORAIRES ############


/**
 *  Préparation de la facture d'honoraire
 *
 * @param  int  $compromis
 * @return \Illuminate\Http\Response
*/

public  function preparer_facture_honoraire($compromis)
{
    
    $compromis = Compromis::where('id', Crypt::decrypt($compromis))->first();
    $mandataire = $compromis->user;
    
    $contrat = $mandataire->contrat;
    
    // On se positionne sur le pack actuel
    if($mandataire->pack_actuel == "starter"){
        $pourcent_dep =  $contrat->pourcentage_depart_starter;
        $paliers = $this->palier_unserialize( $contrat->palier_starter );
    }else{
        $pourcent_dep =  $contrat->pourcentage_depart_expert;
        $paliers = $this->palier_unserialize( $contrat->palier_expert );
    }

    // on modifie le palier pour ajouter le % de depart dans la colonne des % (palier[1])
    $p = $pourcent_dep ;
    for($i = 0 ; $i <count($paliers); $i++) {
        $p += $paliers[$i][1];
        $paliers[$i][1] = $p; 
    }

    $chiffre_affaire_styl = $mandataire->chiffre_affaire_styl( $mandataire->date_anniv(), $compromis->getFactureStylimmo()->date_encaissement->format('Y-m-d'));

   

    if($compromis->facture_honoraire_cree == false && $compromis->user->contrat->deduis_jeton == false ){
    
    
         // Si on partage avec une agence externe
        if($compromis->est_partage_agent == true && $compromis->partage_reseau == false){
            
            $montant_vnt_ht = ( $compromis->frais_agence *  (100 - $compromis->pourcentage_agent) / 100 ) /Tva::coefficient_tva();
        }else{
            $montant_vnt_ht = ($compromis->frais_agence/Tva::coefficient_tva()) ; 
                
        }
        
         
        // Calcul de la commission, on retire l'encaissé actuel pour ne pas faire de doublon pendant le calcul de com
        $niveau_actuel = $this->calcul_niveau($paliers, ($chiffre_affaire_styl - $montant_vnt_ht ));

    
        $formule = $this->calcul_com($paliers, $montant_vnt_ht, $chiffre_affaire_styl, $niveau_actuel-1, $mandataire);
        $deb_annee = date("Y")."-01-01";

        // On calcul le chiffre d'affaire encaissé du mandataire depuis le 1er janvier, pour voir s'il passe à la TVA
        $chiffre_affaire_encai = Facture::where('user_id',$mandataire->id)->whereIn('type',['honoraire','partage','parrainage','parrainage_partage'])->where('reglee',true)->where('date_reglement','>=',$deb_annee)->sum('montant_ht');

        $tva = Tva::coefficient_tva();
        if($contrat->est_soumis_tva == false ){

            if( $mandataire->statut == "auto-entrepeneur"){

                if($chiffre_affaire_encai < Parametre::montant_tva()){
                    $tva = 0;
                }else{
                    $contrat->est_soumis_tva = true;
                    $contrat->update();
                }
            }else{
                $tva = 0;
            }
        }


        
        $montant_ht = round ( $formule[1] ,2) ;
        $montant_ttc = round ($montant_ht*$tva,2);

        $facture = Facture::create([
            "numero"=> null,
            "user_id"=> $mandataire->id,
            "compromis_id"=> $compromis->id,
            "type"=> "honoraire",
            "encaissee"=> false,
            "montant_ht"=>   round($montant_ht,2),
            "montant_ttc"=> round($montant_ttc,2),
            "formule" => serialize($formule)
        ]);
        
        
        $compromis->facture_honoraire_cree = true;
        $compromis->update();
        // on incremente le chiffre d'affaire et on modifie s'il le faut le pourcentage
        $niveau = $this->calcul_niveau($paliers, $chiffre_affaire_styl );

        // ENVOI MAIL SI COMMISSION EVOLUE ######################################################################################################################################### 
        $mandataire->commission = $paliers[$niveau-1][1];
        $mandataire->update();

            // Faire la facture du parrain s'il y'a un parrain 

            $filleul = Filleul::where('user_id',$mandataire->id)->first();

           
        }
        elseif($compromis->facture_honoraire_cree == false && $compromis->user->contrat->deduis_jeton == true){
            $facture = null;
            $formule = null;
            
        }
        else{
            $facture = Facture::where([ ['type','honoraire'],['compromis_id',$compromis->id]])->first();
            
          
                $facture = Facture::where([ ['type','honoraire'],['compromis_id',$compromis->id]])->first();
            // dd($facture);
                
                $formule = unserialize( $facture->formule);
            
        }
        
        
    $factureStylimmo = Facture::where([ ['type','stylimmo'],['compromis_id',$compromis->id]])->first();
    
    $etat_jeton = Facture::etat_jeton($mandataire->id);
    
    return view ('facture.preparer_honoraire',compact(['compromis','mandataire','facture','factureStylimmo','formule','etat_jeton']));
    
}







/**
 *  Préparation de la facture d'honoraire de l'agence externe
 *
 * @param  int  $compromis
 * @return \Illuminate\Http\Response
*/

public  function preparer_facture_honoraire_partage_externe($compromis)
{
    
    
    
    $compromis = Compromis::where('id', Crypt::decrypt($compromis))->first();
    $mandataire = $compromis->user;
    
    
    // on vérifie s'il y'a partage avec un agent ou une agence externe
            
    if($compromis->est_partage_agent == true && $compromis->partage_reseau == false && $compromis->qui_porte_externe == 3 ){
                
        if($compromis->facture_honoraire_partage_externe_cree == false){

        
        $montant_ht_externe =  ( $compromis->frais_agence  * (100 - $compromis->pourcentage_agent)/100  ) /Tva::coefficient_tva() ; ;
        $montant_ttc_externe =  ( $compromis->frais_agence  * (100 - $compromis->pourcentage_agent)/100  ) ;
            $facture = Facture::create([
                "numero"=> null,
                "user_id"=> $mandataire->id,
                "compromis_id"=> $compromis->id,
                "type"=> "partage_externe",
                "encaissee"=> false,
                "montant_ht"=>   round($montant_ht_externe,2),
                "montant_ttc"=> round($montant_ttc_externe,2),
                "formule" => null
            ]);
            
            $compromis->facture_honoraire_partage_externe_cree = true;
            $compromis->update();
        
        }
        else{
            $facture = Facture::where([ ['type','partage_externe'],['compromis_id',$compromis->id]])->first();         
        }
    
    
        return view ('facture.preparer_honoraire_partage_externe',compact(['compromis','mandataire','facture']));
    
    }
    
        
    return false;
    
}














/**
 *  Préparation de la facture d'honoraire du parrain 
 *
 * @param  string  $compromis
 * @return \Illuminate\Http\Response
*/
public  function preparer_facture_honoraire_parrainage($compromis_id, $id_parrain = null)
{

    $compromis = Compromis::where('id',Crypt::decrypt($compromis_id))->first();
    // dd($id_parrain);
    $deux_filleuls = false;
    $facture = null;
    
    //  On détermine le filleul ou les filleuls s'il y'a partage entre les filleuls (même parrain)
    if($compromis->est_partage_agent == true){
        

        //on va comparer les parrains des filleuls (si les 2 en ont) pour voir si c'est le même
        $filleul1  = Filleul::where('user_id',$compromis->user_id)->first();
        $filleul2  = Filleul::where('user_id',$compromis->agent_id)->first();

        // Si les 2 filleuls ont un parrain
        if($filleul1 != null & $filleul2 != null){

            // si les 2 filleuls ont le même parrain  dans ce cas le parametre id_parain = id_filleul
            if($filleul1->parrain_id == $filleul2->parrain_id  ){
               
                // dd("2 filleuls");

                

               
                // id_parrain est en réalité l'id du filleul passé en parametre 
                // on determine le filleul passé en parametre
                $filleul = Filleul::where('user_id',$id_parrain)->first();
// dd($id_parrain);
                // On determine le parrain 
                $parrain = User::where('id',$filleul->parrain_id)->first();
                $deb_annee = date("Y")."-01-01";

                // on determine les chiffres d'affaires encaissé du parrain depuis le 1er janvier, pour voir s'il est soumis à la TVA
                $chiffre_affaire_parrain_encai = Facture::where('user_id',$parrain->id)->whereIn('type',['honoraire','partage','parrainage','parrainage_partage'])->where('reglee',true)->where('date_reglement','>=',$deb_annee)->sum('montant_ht');
            
            //    on reccupere le contrat du parrain
                $contrat = $parrain->contrat;
                $tva = Tva::coefficient_tva();
                    
                if($contrat->est_soumis_tva == false){
                
                    if($chiffre_affaire_parrain_encai < Parametre::montant_tva()){
                        $tva = 0;
                    }else{
                        $contrat->est_soumis_tva = true;
                        $contrat->update();
                    }

                }


                 //  On determine le pourcentage parrain du filleul
                $pourcentage_parrain =  Filleul::where('user_id',$id_parrain)->select('pourcentage')->first();
                $pourcentage_parrain = $pourcentage_parrain['pourcentage'];


                if($filleul->user_id == $compromis->user_id ){
                
                    $frais_agence = $compromis->frais_agence() * $compromis->pourcentage_agent/100 ;
                }else{
                    $frais_agence = $compromis->frais_agence() * (100 - $compromis->pourcentage_agent) /100 ;
                }
                         
                // On determine les montants ttc et ht du parrain 
                $montant_ht = round ( ($frais_agence * $pourcentage_parrain/100 )/Tva::coefficient_tva(),2);
                $montant_ttc = round($montant_ht*$tva,2);
                
                // on determine les droits de parrainage du parrain pour chacun de ses filleuls
                $result = Filleul::droitParrainage($parrain->id, $filleul->user_id, $compromis->id);

                // On vérifie que le parrain n'a pas dépassé le plafond de comm sur son filleul            

                if($result['ca_comm_parr'] >= $filleul->user->contrat->seuil_comm ){
                    $montant_ht = 0;
                    $montant_ttc = 0;
                }
                else{
                    if( $result['ca_comm_parr'] + $montant_ht  > $filleul->user->contrat->seuil_comm ){
                        $montant_ht = $filleul->user->contrat->seuil_comm - $result['ca_comm_parr'];
                        $montant_ttc = $montant_ht*$tva;

                    }
                }

        
         

                $facture = Facture::where([ ['type','parrainage'],['user_id',$parrain->id],['filleul_id',$filleul->user_id],['compromis_id',$compromis->id]])->first();

                if($facture == null ){

                  
                    // Si toutes les conditions pour toucher le parrainnage sont respectées
                    if($result["respect_condition"] == true){
            
                        // calcul du montant ht et ttc
                        
                        $type_facture = $filleul->user_id == $compromis->user_id ? "parrainage" : "parrainage_partage";
                        
                        $facture = Facture::create([
                            "numero"=> null,
                            "user_id"=> $parrain->id,
                            "filleul_id"=> $filleul->user_id,
                            "compromis_id"=> $compromis->id,
                            "type"=> $type_facture,
                            "encaissee"=> false,
                            "montant_ht"=>  $montant_ht,
                            "montant_ttc"=> $montant_ttc,
                        ]);
                        
                        
                        if($type_facture == "parrainage"){
                            $compromis->facture_honoraire_parrainage_cree = true;
                        
                        }else{
                            $compromis->facture_honoraire_parrainage_partage_cree = true;
                        }
                        
                        
                        $compromis->update();
                        }
                        else{
                        $facture = null;
            
                        }
                    }


                    // FACTURE PARRAINAGE DU FILLEUL QUI NE PORTE L'AFFAIRE 2


        #############################################

        $filleul = User::where('id',$id_parrain)->first();


        return view ('facture.preparer_honoraire_parrainage',compact(['compromis','parrain','filleul','facture','pourcentage_parrain','result']));



            } //Si les 2 n'ont pas le même parrain
            else{
            // dd('pas le meme parrain');

                // il faut mettre un params parrain_id, au cas où c'est l'admin qui fait la note, (cas de recalcul)
                if($id_parrain != null){
                    // dd($filleul1->user_id);
                    $filleul_id =  $filleul1->parrain_id == $id_parrain ? $filleul1->user_id : $filleul2->user_id ;
                }else{
                    $filleul_id =  $filleul1->parrain_id == auth::id() ? $filleul1->user_id : $filleul2->user_id ;
                }

                $filleul = User::where('id',$filleul_id)->first();
                $pourcentage_parrain =  Filleul::where('user_id',$filleul->id)->select('pourcentage')->first();
                $pourcentage_parrain = $pourcentage_parrain['pourcentage'];

                // lorsque le filleul porte l'affaire
                if($filleul->id == $compromis->user_id){                    
                    $frais_agence = $compromis->frais_agence() * $compromis->pourcentage_agent/100 ;
                }
                // lorsque le filleul ne porte pas l'affaire
                else{
                    $frais_agence = $compromis->frais_agence() * (100 - $compromis->pourcentage_agent) /100 ;
                }
                

                 // On determine le parrain 
                $parrain_id =  Filleul::where('user_id',$filleul->id)->select('parrain_id')->first();    
                $parrain = User::where('id',$parrain_id['parrain_id'])->first();
                $deb_annee = date("Y")."-01-01";
            // on determine le chiffre d'affaire encaissé du parrain depuis le 1er janvier, pour voir s'il est soumis à la TVA
                $chiffre_affaire_parrain_encai = Facture::where('user_id',$parrain->id)->whereIn('type',['honoraire','partage','parrainage','parrainage_partage'])->where('reglee',true)->where('date_reglement','>=',$deb_annee)->sum('montant_ht');
            //    on reccupere le contrat du parrain
                $contrat = $parrain->contrat;
                $tva = Tva::coefficient_tva();
                    
                if($contrat->est_soumis_tva == false){
                
                    if($chiffre_affaire_parrain_encai < Parametre::montant_tva()){
                        $tva = 0;
                    }else{
                        $contrat->est_soumis_tva = true;
                        $contrat->update();
                    }

                }


                $montant_ht = round ( ($frais_agence * $pourcentage_parrain/100 )/Tva::coefficient_tva(),2);
                $montant_ttc = round($montant_ht*$tva,2);

              
                // On vérifie que le parrain n'a pas dépassé le plafond de comm sur son filleul 
        
                $result = Filleul::droitParrainage($parrain->id, $filleul->id, $compromis->id);

                if($result['ca_comm_parr'] >= $filleul->contrat->seuil_comm ){
                    $montant_ht = 0;
                    $montant_ttc = 0;
                }
                else{
                    if( $result['ca_comm_parr'] + $montant_ht  > $filleul->contrat->seuil_comm ){
                        $montant_ht = $filleul->contrat->seuil_comm - $result['ca_comm_parr'];
                        $montant_ttc = $montant_ht*$tva;

                    }
                }

            }
            

        // Un seul parrain
        }else{
            // dd('1 seul parr');
            // on continue avec l'unique filleul
            if($filleul1 != null){
                // Lorsque le filleul porte l'affaire
                // dd('porte ');

                $filleul = User::where('id',$filleul1->user_id)->first();
                $pourcentage_parrain =  Filleul::where('user_id',$filleul->id)->select('pourcentage')->first();
                $pourcentage_parrain = $pourcentage_parrain['pourcentage'];


                // On determine le parrain 
                $parrain_id =  Filleul::where('user_id',$filleul->id)->select('parrain_id')->first();    
                $parrain = User::where('id',$parrain_id['parrain_id'])->first();
                $deb_annee = date("Y")."-01-01";
            // on determine le chiffre d'affaire encaissé du parrain depuis le 1er janvier, pour voir s'il est soumis à la TVA
                $chiffre_affaire_parrain_encai = Facture::where('user_id',$parrain->id)->whereIn('type',['honoraire','partage','parrainage','parrainage_partage'])->where('reglee',true)->where('date_reglement','>=',$deb_annee)->sum('montant_ht');
            //    on reccupere le contrat du parrain
                $contrat = $parrain->contrat;
                $tva = Tva::coefficient_tva();
                
                if($contrat->est_soumis_tva == false){
                
                    if($chiffre_affaire_parrain_encai < Parametre::montant_tva()){
                        $tva = 0;
                    }else{
                        $contrat->est_soumis_tva = true;
                        $contrat->update();
                    }

                }

                $frais_agence = $compromis->frais_agence() * $compromis->pourcentage_agent/100 ;
                $montant_ht = round ( ($frais_agence * $pourcentage_parrain/100 )/Tva::coefficient_tva() ,2);
                $montant_ttc = round( $montant_ht*$tva,2);
                // dd("unique filleul 1 ");

            }else{
                // Lorsque le filleul ne porte pas l'affaire
                $filleul = User::where('id',$filleul2->user_id)->first();
                $pourcentage_parrain =  Filleul::where('user_id',$filleul->id)->select('pourcentage')->first();
                $pourcentage_parrain = $pourcentage_parrain['pourcentage']; 

// dd('porte pas');
                // On determine le parrain 
                $parrain_id =  Filleul::where('user_id',$filleul->id)->select('parrain_id')->first();    
                $parrain = User::where('id',$parrain_id['parrain_id'])->first();
                $deb_annee = date("Y")."-01-01";
            // on determine le chiffre d'affaire encaissé du parrain depuis le 1er janvier, pour voir s'il est soumis à la TVA
                $chiffre_affaire_parrain_encai = Facture::where('user_id',$parrain->id)->whereIn('type',['honoraire','partage','parrainage','parrainage_partage'])->where('reglee',true)->where('date_reglement','>=',$deb_annee)->sum('montant_ht');
            //    on reccupere le contrat du parrain
                $contrat = $parrain->contrat;
                $tva = Tva::coefficient_tva();
                
                if($contrat->est_soumis_tva == false){
                
                    if($chiffre_affaire_parrain_encai < Parametre::montant_tva()){
                        $tva = 0;
                    }else{
                        $contrat->est_soumis_tva = true;
                        $contrat->update();
                    }

                }


                $frais_agence = $compromis->frais_agence() * (100 - $compromis->pourcentage_agent) /100 ;
                $montant_ht = round ( ($frais_agence * $pourcentage_parrain/100 )/Tva::coefficient_tva() ,2);
                $montant_ttc = round( $montant_ht*$tva,2);
                // dd($montant_ttc);
                //  dd("unique filleul 2 ");
                

            }

            $result = Filleul::droitParrainage($parrain->id, $filleul->id, $compromis->id);
       
            // On vérifie que le parrain n'a pas dépassé le plafond de comm sur son filleul 
        

            if($result['ca_comm_parr'] >= $filleul->contrat->seuil_comm ){
                $montant_ht = 0;
                $montant_ttc = 0;
            }
            else{
                if( $result['ca_comm_parr'] + $montant_ht  > $filleul->contrat->seuil_comm ){
                    $montant_ht = $filleul->contrat->seuil_comm - $result['ca_comm_parr'];
                    $montant_ttc = $montant_ht*$tva;

                }
            }

        }
        


// Si l'affaire n'est pas partagée ---- filleul sans partage
    }else{ 

        //   dd("un filleul sans partage");
        $filleul = User::where('id',$compromis->user_id)->first();
        $pourcentage_parrain =  Filleul::where('user_id',$filleul->id)->select('pourcentage')->first();
        $pourcentage_parrain = $pourcentage_parrain['pourcentage'];

        // On determine le parrain 
        $parrain_id =  Filleul::where('user_id',$filleul->id)->select('parrain_id')->first();    
        $parrain = User::where('id',$parrain_id['parrain_id'])->first();
        $deb_annee = date("Y")."-01-01";
      
    // on determine le chiffre d'affaire ht encaissé du parrain depuis le 1er janvier, pour voir s'il est soumis à la TVA
        $chiffre_affaire_parrain_encai = Facture::where('user_id',$parrain->id)->whereIn('type',['honoraire','partage','parrainage','parrainage_partage'])->where('reglee',true)->where('date_reglement','>=',$deb_annee)->sum('montant_ht');
    //    on reccupere le contrat du parrain
        $contrat = $parrain->contrat;
        $tva = Tva::coefficient_tva();
        
        if($contrat->est_soumis_tva == false){
        
            if($chiffre_affaire_parrain_encai < Parametre::montant_tva()){
                $tva = 0;
            }else{
                $contrat->est_soumis_tva = true;
                $contrat->update();
            }

        }

    // On vérifie que le parrain n'a pas dépassé le plafond de comm sur son filleul 
        
        $result = Filleul::droitParrainage($parrain->id, $filleul->id, $compromis->id);

        
        $montant_ht = round ( ($compromis->frais_agence()*$pourcentage_parrain/100 )/Tva::coefficient_tva() ,2);
        $montant_ttc =  round( $montant_ht*$tva,2);
     
    

        if($result['ca_comm_parr'] >= $filleul->contrat->seuil_comm ){
            $montant_ht = 0;
            $montant_ttc = 0;
        }
        else{
            if( $result['ca_comm_parr'] + $montant_ht  > $filleul->contrat->seuil_comm ){
                $montant_ht = $filleul->contrat->seuil_comm - $result['ca_comm_parr'];
                $montant_ttc = $montant_ht*$tva;

            }
        }


   
    }



  

    $parrain_id =  Filleul::where('user_id',$filleul->id)->select('parrain_id')->first();
    $pourcentage_parrain =  Filleul::where('user_id',$filleul->id)->select('pourcentage')->first();
    $pourcentage_parrain = $pourcentage_parrain['pourcentage'];
    $parrain = User::where('id',$parrain_id['parrain_id'])->first();
    
    // ########### On doit verifier si le parrain a droit à la comm ##########

    $type_facture = $filleul->id == $compromis->user_id ? "parrainage" : "parrainage_partage";
    
    if($type_facture == "parrainage" && $compromis->facture_honoraire_parrainage_cree == false ){
        // Si toutes les conditions pour toucher le parrainnage sont respectées
        if($result["respect_condition"] == true){

            // calcul du montant ht et ttc
            
            $facture = Facture::create([
                "numero"=> null,
                "user_id"=> $parrain_id['parrain_id'],
                "filleul_id"=> $filleul->id,
                "compromis_id"=> $compromis->id,
                "type"=> $type_facture,
                "encaissee"=> false,
                "montant_ht"=>  $montant_ht,
                "montant_ttc"=> $montant_ttc,
            ]);
            // on incremente le chiffre d'affaire du parrain
            // dd($parrain);
            // $parrain->chiffre_affaire += $facture->montant_ttc ; 
            // $parrain->update(); 
            
            $compromis->facture_honoraire_parrainage_cree = true;
            $compromis->update();
            }else{
            $facture = null;

            }
        }elseif($type_facture == "parrainage_partage" && $compromis->facture_honoraire_parrainage_partage_cree == false ){


            if($result["respect_condition"] == true ){

                $facture = Facture::create([
                    "numero"=> null,
                    "user_id"=> $parrain_id['parrain_id'],
                    "filleul_id"=> $filleul->id,
                    "compromis_id"=> $compromis->id,
                    "type"=> $type_facture,
                    "encaissee"=> false,
                    "montant_ht"=>  $montant_ht,
                    "montant_ttc"=> $montant_ttc,
                ]);
              
                $compromis->facture_honoraire_parrainage_partage_cree = true;                
                $compromis->update();
            }



        }else{
        
        
        
            if($type_facture == "parrainage"){
            
                $facture = Facture::where([ ['type','parrainage'],['user_id',$parrain->id],['compromis_id',$compromis->id]])->first();
            }else{
          
                $facture = Facture::where([ ['type','parrainage_partage'],['user_id',$parrain->id],['compromis_id',$compromis->id]])->first();
            }
        
        
        }


    return view ('facture.preparer_honoraire_parrainage',compact(['compromis','parrain','filleul','facture','pourcentage_parrain','result']));
    
}



public  function store_facture_honoraire_parrainage(Compromis $compromis, Filleul $filleul)
{
    

//    dd("creation facture parrain du filleul ".$filleul->user_id);

    $parrain_id = $filleul->parrain_id ; 
    $pourcentage_parrain = $filleul->pourcentage; 
    
    $tva = Tva::coefficient_tva();
    $parrain = User::where('id',$parrain_id)->first();
    // On vérifie si filleul est le porteur d'affaire
    if($compromis->user_id == $filleul->user_id){
        // sil y'a partage
        if($compromis->agent_id == null ){
            $pourcentage_partage = 1;
        }else{
            $pourcentage_partage = $compromis->pourcentage_agent/100;
        }
        
        
        
        // On determine les montants ttc et ht du parrain 
        $montant_ht = round ( ($compromis->frais_agence() * $pourcentage_partage * $pourcentage_parrain/100 )/Tva::coefficient_tva(),2);
        $montant_ttc = round($montant_ht*$tva,2);
        
        // on determine les droits de parrainage du parrain pour chacun de ses filleuls
        $result = Filleul::droitParrainage($parrain->id, $filleul->user_id, $compromis->id);

        // On vérifie que le parrain n'a pas dépassé le plafond de comm sur son filleul            

        if($result['ca_comm_parr'] >= $filleul->user->contrat->seuil_comm ){
            $montant_ht = 0;
            $montant_ttc = 0;
        }
        else{
            if( $result['ca_comm_parr'] + $montant_ht  > $filleul->user->contrat->seuil_comm ){
                $montant_ht = $filleul->user->contrat->seuil_comm - $result['ca_comm_parr'];
                $montant_ttc = $montant_ht*$tva;

            }
        }        
        
        
        
        
        
        
        // On fait la facture du parrain de celui qui a crée l'affaire
        if($compromis->facture_honoraire_parrainage_cree == false ){
            $tva = Tva::coefficient_tva();



            $facture = Facture::create([
                "numero"=> null,
                "user_id"=> $parrain->id,
                "filleul_id"=> $filleul->user_id,
                "compromis_id"=> $compromis->id,
                "type"=> "parrainage",
                "encaissee"=> false,
                "montant_ht"=>  round ($montant_ht ,2),
                "montant_ttc"=> round( $montant_ttc,2),
            ]);
            // dd($facture);
            // on incremente le chiffre d'affaire du parrain
            $parrain->chiffre_affaire += $facture->montant_ttc ; 
            $parrain->update(); 
            
            $compromis->facture_honoraire_parrainage_cree = true;
            $compromis->update();
        }
    // On vérifie si filleul est le partage
    }elseif($compromis->agent_id == $filleul->user_id){
        // On fait la facture du parrain du partage
        if($compromis->facture_honoraire_parrainage_partage_cree == false ){
            
         
                $pourcentage_partage = (100 - $compromis->pourcentage_agent)/100;
       
                $tva = Tva::coefficient_tva();
                
                  // On determine les montants ttc et ht du parrain 
                $montant_ht = round ( ($compromis->frais_agence() * $pourcentage_partage * $pourcentage_parrain/100 )/Tva::coefficient_tva(),2);
                $montant_ttc = round($montant_ht*$tva,2);
                
                // on determine les droits de parrainage du parrain pour chacun de ses filleuls
                $result = Filleul::droitParrainage($parrain->id, $filleul->user_id, $compromis->id);
        
                // On vérifie que le parrain n'a pas dépassé le plafond de comm sur son filleul            
        
                if($result['ca_comm_parr'] >= $filleul->user->contrat->seuil_comm ){
                    $montant_ht = 0;
                    $montant_ttc = 0;
                }
                else{
                    if( $result['ca_comm_parr'] + $montant_ht  > $filleul->user->contrat->seuil_comm ){
                        $montant_ht = $filleul->user->contrat->seuil_comm - $result['ca_comm_parr'];
                        $montant_ttc = $montant_ht*$tva;
        
                    }
                }        
                
                
            
            $facture = Facture::create([
                "numero"=> null,
                "user_id"=> $parrain->id,
                "filleul_id"=> $filleul->user_id,
                "compromis_id"=> $compromis->id,
                "type"=> "parrainage_partage",
                "encaissee"=> false,
                "montant_ht"=>  round ($montant_ht,2),
                "montant_ttc"=> round( $montant_ttc,2),
            ]);
            // dd($facture);
            // on incremente le chiffre d'affaire du parrain
            // $parrain->chiffre_affaire += $facture->montant_ttc ; 
            // $parrain->update(); 
            
            $compromis->facture_honoraire_parrainage_partage_cree = true;
            $compromis->update();
        }
    }

    

    //  On fait la facture du parrain de celui qui ne porte pas l'affaire (le partage)
    // facture_honoraire_parrainage_partage_cree
    
}


/**
 *  Préparation de la facture d'honoraire pour le partage 
 *
 * @param  string  $compromis
 * @param  int  $mandataire_id
 * @return \Illuminate\Http\Response
*/

public  function preparer_facture_honoraire_partage($compromis,$mandataire_id = null)
{
   
    $compromis = Compromis::where('id', Crypt::decrypt($compromis))->first();

    if($compromis->je_porte_affaire == 1 && $compromis->est_partage_agent == 1 && (Auth()->user()->id == $compromis->user_id || $mandataire_id == $compromis->user_id  )){

        $mandataire_partage = User::where('id',$compromis->agent_id)->first();
        $mandataire = $compromis->user;
        $pourcentage_partage = $compromis->pourcentage_agent;
    }else{
// mandataire qui ne porte  pas l'affaire


        $mandataire_partage = $compromis->user;
        $mandataire = User::where('id',$compromis->agent_id)->first();
        $pourcentage_partage = 100 - $compromis->pourcentage_agent;    
    }

   
    $factureStylimmo = Facture::where([ ['type','stylimmo'],['compromis_id',$compromis->id]])->first();

    $contrat = $mandataire->contrat;

    // On se positionne sur le pack actuel
    if($mandataire->pack_actuel == "starter"){
        $pourcent_dep =  $contrat->pourcentage_depart_starter;
        $paliers = $this->palier_unserialize( $contrat->palier_starter );
    }else{
        $pourcent_dep =  $contrat->pourcentage_depart_expert;
        $paliers = $this->palier_unserialize( $contrat->palier_expert );
    }

    // on modifie le palier pour ajouter le % de depart dans la colonne des % (palier[1])
    $p = $pourcent_dep ;
    for($i = 0 ; $i <count($paliers); $i++) {
        $p += $paliers[$i][1];
        $paliers[$i][1] = $p; 
    }

    $tva = Tva::coefficient_tva();
    $deb_annee = date("Y")."-01-01";

    // On calcul le chiffre d'affaire encaissé du mandataire depuis le 1er janvier, pour voir s'il passe à la TVA
    $chiffre_affaire_encai = Facture::where('user_id',$mandataire->id)->whereIn('type',['honoraire','partage','parrainage','parrainage_partage'])->where('reglee',true)->where('date_reglement','>=',$deb_annee)->sum('montant_ht');
    
    if($contrat->est_soumis_tva == false){
    
        if($chiffre_affaire_encai < Parametre::montant_tva()){
            $tva = 0;
        }else{
            $contrat->est_soumis_tva = true;
            $contrat->update();
        }

    }
    
    $chiffre_affaire_styl = $mandataire->chiffre_affaire_styl( $mandataire->date_anniv(), $compromis->getFactureStylimmo()->date_encaissement->format('Y-m-d'));


    if($compromis->je_porte_affaire == 1 && $compromis->est_partage_agent == 1 && (Auth()->user()->id == $compromis->user_id || $mandataire_id == $compromis->user_id) ){

// facture du mandataire qui porte l'affaire
        if($compromis->facture_honoraire_partage_porteur_cree == false && ($mandataire->contrat->deduis_jeton == false || ($mandataire->contrat->deduis_jeton == true && $mandataire->nb_mois_pub_restant <= 0) ) ){
            $montant_vnt_ht = ($compromis->frais_agence()/Tva::coefficient_tva()) ;
            // Calcul de la commission, on retire l'encaissé actuel pour ne pas faire de doublon pendant le calcul de com
            $niveau_actuel = $this->calcul_niveau($paliers, ($chiffre_affaire_styl - $montant_vnt_ht ));

            $formule = $this->calcul_com($paliers, $montant_vnt_ht*$pourcentage_partage/100, $chiffre_affaire_styl, $niveau_actuel-1, $mandataire);

           
                $montant_ht = round ( $formule[1] ,2) ;
                $montant_ttc = round ($montant_ht*$tva,2);
            
                $facture = Facture::create([
                    "numero"=> null,
                    "user_id"=> $mandataire->id,
                    "compromis_id"=> $compromis->id,
                    "type"=> "partage",
                    "encaissee"=> false,
                    "montant_ht"=>  $montant_ht,
                    "montant_ttc"=> $montant_ttc,
                    "formule" => serialize($formule)
                ]);   
            
        
            
            
            $compromis->facture_honoraire_partage_porteur_cree = true;
            $compromis->update();

            // on incremente le chiffre d'affaire et on modifie s'il le faut le pourcentage
       
            $niveau = $this->calcul_niveau($paliers, $chiffre_affaire_styl );
            $mandataire->commission = $paliers[$niveau-1][1];
            $mandataire->update();

            // Faire la facture du parrain de celui pas l'affaire s'il a un parrain 

            $filleul = Filleul::where('user_id',$mandataire->id)->first();
           
        

        }
        elseif($compromis->facture_honoraire_partage_porteur_cree == false && $mandataire->contrat->deduis_jeton == true && $mandataire->nb_mois_pub_restant > 0 ){
       
            $facture = null;
            $formule = null;
        }
        else{
                       
            

            $facture = Facture::where([ ['type','partage'],['user_id',$mandataire->id],['compromis_id',$compromis->id]])->first();
            
   
            $formule = unserialize( $facture->formule);
        }
    }
// facture du mandataire qui ne porte pas l'affaire
    else{

        if($compromis->facture_honoraire_partage_cree == false && ($mandataire->contrat->deduis_jeton == false || ($mandataire->contrat->deduis_jeton == true && $mandataire->nb_mois_pub_restant <= 0) )){
            // dd("creer");
            $montant_vnt_ht = ($compromis->frais_agence()/Tva::coefficient_tva()) ;

            // Calcul de la commission, on retire l'encaissé actuel pour ne pas faire de doublon pendant le calcul de com
            $niveau_actuel = $this->calcul_niveau($paliers, ($chiffre_affaire_styl - $montant_vnt_ht ));

            $formule = $this->calcul_com($paliers, $montant_vnt_ht*$pourcentage_partage/100, $chiffre_affaire_styl, $niveau_actuel-1, $mandataire);

            
            $montant_ht = round ( $formule[1] ,2) ;
            $montant_ttc = round ($montant_ht*$tva,2);

            $facture = Facture::create([
                "numero"=> null,
                "user_id"=> $mandataire->id,
                "compromis_id"=> $compromis->id,
                "type"=> "partage",
                "encaissee"=> false,
                "montant_ht"=>  $montant_ht,
                "montant_ttc"=> $montant_ttc,
                "formule" => serialize($formule)
            ]);   

            
            $compromis->facture_honoraire_partage_cree = true;
            $compromis->update();

            // on incremente le chiffre d'affaire et on modifie s'il le faut le pourcentage
      
            $niveau = $this->calcul_niveau($paliers, $chiffre_affaire_styl );
            $mandataire->commission = $paliers[$niveau-1][1];
            $mandataire->update();

            // // Faire la facture du parrain de celui qui ne porte pas l'affaire s'il a un parrain 

            $filleul =  ($mandataire_partage != null ) ? Filleul::where('user_id',$mandataire_partage->id)->first() : null;

         
          

        }
        elseif($compromis->facture_honoraire_partage_cree == false && $mandataire->contrat->deduis_jeton == true && $mandataire->nb_mois_pub_restant > 0){
            // dd("nullll");
       
            $facture = null;
            $formule = null;
        }        
        else{
            // dd("reccuperer");
           
            if($mandataire_id == null){
                $facture = Facture::where([ ['type','partage'],['user_id',$mandataire->id],['compromis_id',$compromis->id]])->first();

            }else{
                
                $facture = Facture::where([ ['type','partage'],['user_id',$mandataire_id],['compromis_id',$compromis->id]])->first();
               
            }
            // dd($compromis->facture_honoraire_partage_cree );
    
       
            
            
            if($facture != null){
                $formule = unserialize( $facture->formule);
            }
            else{
                $formule = null;
            }
        }

    }
//  dd($formule);
    $etat_jeton = Facture::etat_jeton($mandataire->id); 

    return view ('facture.preparer_honoraire_partage',compact(['compromis','factureStylimmo','mandataire','mandataire_partage','facture','pourcentage_partage','formule','etat_jeton']));
    
}
    
    
    
    
    
    
    
/**
 *  Préparation de la facture d'honoraire DU PORTEUR ET/OU PARTAGE PENDANT L'ENCAISSEMENT DE LA FACTURE STYL
 *
 * @param  int  $compromis
 * @return \Illuminate\Http\Response
*/

public  function preparer_facture_honoraire_encaissement($compromis_id, $leporteur )
{
    
    $compromis = Compromis::where('id', $compromis_id)->first();
    
    $type_facture = "honoraire";
    // on vérifie si l'affaire est partagée 
    
    if($compromis->agent_id !=null ){
        $type_facture = "partage";
    
    }
 
    
    if($leporteur == false ){
        $mandataire = User::where('id', $compromis->agent_id)->first();
        
    }
    else{
        $mandataire = $compromis->user;
    }
    
   
        ###########################################################################
    
    $contrat = $mandataire->contrat;
    
    // On se positionne sur le pack actuel
    if($mandataire->pack_actuel == "starter"){
        $pourcent_dep =  $contrat->pourcentage_depart_starter;
        $paliers = $this->palier_unserialize( $contrat->palier_starter );
    }else{
        $pourcent_dep =  $contrat->pourcentage_depart_expert;
        $paliers = $this->palier_unserialize( $contrat->palier_expert );
    }

    // on modifie le palier pour ajouter le % de depart dans la colonne des % (palier[1])
    $p = $pourcent_dep ;
    for($i = 0 ; $i <count($paliers); $i++) {
        $p += $paliers[$i][1];
        $paliers[$i][1] = $p; 
    }

    $chiffre_affaire_styl = $mandataire->chiffre_affaire_styl( $mandataire->date_anniv(), $compromis->getFactureStylimmo()->date_encaissement->format('Y-m-d'));

   
 

        
        if( $type_facture == "partage") {
            // si lacfture de partage est déjà créee
            if($leporteur == true && $compromis->facture_honoraire_partage_cree == true){
                return true;
            }
            if($leporteur == false && $compromis->facture_honoraire_partage_porteur_cree == true ){
                return true;
            }
        
            $montant_vnt_ht =  ( $leporteur == true ) ?  ( $compromis->frais_agence() * $compromis->pourcentage_agent/100 ) / Tva::coefficient_tva()  :   ($compromis->frais_agence() * (100 - $compromis->pourcentage_agent)/100) /Tva::coefficient_tva() ;
            
           
        }else {
            // Si la facture d'honoraire est déjà créee
            if( $compromis->facture_honoraire_cree == true){
                return true;
            }
            
            
                  // Si on partage avec une agence externe
            if($compromis->est_partage_agent == true && $compromis->partage_reseau == false){
                
                $montant_vnt_ht = ( $compromis->frais_agence *  (100 - $compromis->pourcentage_agent) / 100 ) /Tva::coefficient_tva();
            }else{
                $montant_vnt_ht = ($compromis->frais_agence/Tva::coefficient_tva()) ; 
                    
            }
            
            
        
        }

             
            // Calcul de la commission, on retire l'encaissé actuel pour ne pas faire de doublon pendant le calcul de com
            $niveau_actuel = $this->calcul_niveau($paliers, ($chiffre_affaire_styl - $montant_vnt_ht ));
    
        
            $formule = $this->calcul_com($paliers, $montant_vnt_ht, $chiffre_affaire_styl, $niveau_actuel-1, $mandataire);
            $deb_annee = date("Y")."-01-01";
    
            // On calcul le chiffre d'affaire encaissé du mandataire depuis le 1er janvier, pour voir s'il passe à la TVA
            $chiffre_affaire_encai = Facture::where('user_id',$mandataire->id)->whereIn('type',['honoraire','partage','parrainage','parrainage_partage'])->where('reglee',true)->where('date_reglement','>=',$deb_annee)->sum('montant_ht');
    
            $tva = Tva::coefficient_tva();
            
            if($contrat->est_soumis_tva == false ){
    
                if( $mandataire->statut == "auto-entrepeneur"){
    
                    if($chiffre_affaire_encai < Parametre::montant_tva()){
                        $tva = 0;
                    }else{
                        $contrat->est_soumis_tva = true;
                        $contrat->update();
                    }
                }else{
                    $tva = 0;
                }
            }
    
    
            
            $montant_ht = round ( $formule[1] ,2) ;
            $montant_ttc = round ($montant_ht*$tva,2);
    
            $facture = Facture::create([
                "numero"=> null,
                "user_id"=> $mandataire->id,
                "compromis_id"=> $compromis->id,
                "type"=> $type_facture,
                "encaissee"=> false,
                "montant_ht"=>   round($montant_ht,2),
                "montant_ttc"=> round($montant_ttc,2),
                "formule" => serialize($formule)
            ]);
            
            
            
            
            if ($type_facture == "honoraire"){
                $compromis->facture_honoraire_cree = true;
            
            }else{
                if($leporteur == true){
                    $compromis->facture_honoraire_partage_cree = true;
                
                }else{
                    $compromis->facture_honoraire_partage_porteur_cree = true;
                
                }
            }
            
            
            // on vérifie s'il y'a partage avec un agent ou une agence externe
            
            if($compromis->est_partage_agent == true && $compromis->partage_reseau == false && $compromis->qui_porte_externe == 3 ){
                
                if($compromis->facture_honoraire_partage_externe_cree == false){
       
                
                $montant_ht_externe =  ( $compromis->frais_agence  * (100 - $compromis->pourcentage_agent)/100  ) /Tva::coefficient_tva() ; ;
                $montant_ttc_externe =  ( $compromis->frais_agence  * (100 - $compromis->pourcentage_agent)/100  ) ;
                    $facture = Facture::create([
                        "numero"=> null,
                        "user_id"=> $compromis->user_id,
                        "compromis_id"=> $compromis->id,
                        "type"=> "partage_externe",
                        "encaissee"=> false,
                        "montant_ht"=>   round($montant_ht_externe,2),
                        "montant_ttc"=> round($montant_ttc_externe,2),
                        "formule" => null
                    ]);
                    
                    $compromis->facture_honoraire_partage_externe_cree = true;
                }
            
            }
            
            
            
            $compromis->update();
            // on incremente le chiffre d'affaire et on modifie s'il le faut le pourcentage
            $niveau = $this->calcul_niveau($paliers, $chiffre_affaire_styl );
    
            $mandataire->commission = $paliers[$niveau-1][1];
            $mandataire->update();
    
        
  
    
}
    
    
    

/**
 * Déduction de la pub sur la facture d'honoraire sans supprimer la note d'hono
 *
 * @return \Illuminate\Http\Response
 */

public  function deduire_pub(Request $request, $facture_id)
{
    // dd("iciiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii");
        
    
    $facture = Facture::where('id', Crypt::decrypt($facture_id))->first();
    $compromis = Compromis::where('id', $facture->compromis_id)->first();
    
    $mandataire = $compromis->user;
    $contrat = $mandataire->contrat;

    $deb_annee = date("Y")."-01-01";

    // On calcul le chiffre d'affaire encaissé du mandataire depuis le 1er janvier, pour voir s'il passe à la TVA
    $chiffre_affaire_encai = Facture::where('user_id',$mandataire->id)->whereIn('type',['honoraire','partage','parrainage','parrainage_partage'])->where('reglee',true)->where('date_reglement','>=',$deb_annee)->sum('montant_ht');
   
    //  VERIFIER S'IL Y'A TVA OU PAS
    $tva = Tva::coefficient_tva();


    if($mandataire->nb_mois_pub_restant >= 0 ){
      
    //   Si c'est la première fois que le mandataire deduis la pub
          if($facture->nb_mois_deduis === null){
          
            $montant_ht = $facture->montant_ht -  $request->nb_mois_deduire * $contrat->packpub->tarif ;       
            
            // Verifier si le mandataire est soumis à la tva   *************************************************************
            $montant_ttc = $facture->montant_ttc > 0 ?  $montant_ht * $tva : $facture->montant_ttc;
            
          }
      
      
        $facture->montant_ht = $montant_ht;
        $facture->montant_ttc = $montant_ttc;
        
        $facture->nb_mois_deduis =  $request->nb_mois_deduire;
      
    //   dd($request->nb_mois_deduire);

        $mandataire->nb_mois_pub_restant -= $request->nb_mois_deduire;
        $mandataire->update();
        $facture->update();
        
      
        if( session('is_switch') == true ){
            $action = "a déduit $request->nb_mois_deduire mois de pub sur la facture $facture->numero pour  ".Auth::user()->nom." ".Auth::user()->prenom;
            $user_id = session('admin_id');
        }else{
            $action = Auth::user()->nom." ".Auth::user()->prenom." a déduit $request->nb_mois_deduire mois de pub sur la facture  $facture->numero";
            $user_id = Auth::user()->id;
        }
      
        Historique::createHistorique( $user_id,$facture->id,"facture",$action );

    }

  

    if($facture->type == "honoraire"){
            return redirect()->route('facture.preparer_facture_honoraire', [ Crypt::encrypt( $compromis->id)]);
    }elseif($facture->type == "partage"){
            return redirect()->route('facture.preparer_facture_honoraire_partage', [ Crypt::encrypt( $compromis->id),$facture->user->id]);

    }        
}

   
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

/**
 * Déduction de la pub sur la facture d'honoraire
 *
 * @return \Illuminate\Http\Response
 */

public  function deduire_pub_facture_honoraire(Request $request, $compromis)
{
      
//  on doit verifier que facture_honoraire_cree est false avant les modifsxxxxxxxxxxxxxxxxxxxxxxxxxxx
// If faut creer la facture avec champs nb_mois_deduis en +

    $compromis = Compromis::where('id', Crypt::decrypt($compromis))->first();
    $mandataire = $compromis->user;
    $contrat = $mandataire->contrat;

    // On se positionne sur le pack actuel
    if($mandataire->pack_actuel == "starter"){
        $pourcent_dep =  $contrat->pourcentage_depart_starter;
        $paliers = $this->palier_unserialize( $contrat->palier_starter );
    }else{
        $pourcent_dep =  $contrat->pourcentage_depart_expert;
        $paliers = $this->palier_unserialize( $contrat->palier_expert );
    }

    // on modifie le palier pour ajouter le % de depart dans la colonne des % (palier[1])
    $p = $pourcent_dep ;
    for($i = 0 ; $i <count($paliers); $i++) {
        $p += $paliers[$i][1];
        $paliers[$i][1] = $p; 
    }

    $chiffre_affaire_styl = $mandataire->chiffre_affaire_styl( $mandataire->date_anniv(), $compromis->getFactureStylimmo()->date_encaissement->format('Y-m-d'));

    $deb_annee = date("Y")."-01-01";

    // On calcul le chiffre d'affaire encaissé du mandataire depuis le 1er janvier, pour voir s'il passe à la TVA
    $chiffre_affaire_encai = Facture::where('user_id',$mandataire->id)->whereIn('type',['honoraire','partage','parrainage','parrainage_partage'])->where('reglee',true)->where('date_reglement','>=',$deb_annee)->sum('montant_ht');
    
    //  VERIFIER S'IL Y'A TVA OU PAS
    $tva = Tva::coefficient_tva();
    if($contrat->est_soumis_tva == false ){

        if( $mandataire->statut == "auto-entrepeneur"){

            if($chiffre_affaire_encai < Parametre::montant_tva()){
                $tva = 0;
            }else{
                $contrat->est_soumis_tva = true;
                $contrat->update();
            }
        }else{
            $tva = 0;
        }
    }
    //PASSER LA COMMISSION DU MANDATAIRE EN PARAMETRE
    $montant_vnt_ht = ($compromis->frais_agence()/Tva::coefficient_tva()) ; 
    
    // Calcul de la commission, on retire l'encaissé actuel pour ne pas faire de doublon pendant le calcul de com
    $niveau_actuel = $this->calcul_niveau($paliers, ($chiffre_affaire_styl - $montant_vnt_ht ));


    // PASSER LE TYPE DE LA FACTYPE EN PARAMETRE


    if($compromis->facture_honoraire_cree == false && $mandataire->nb_mois_pub_restant >= 0 ){
      
      
        $formule = $this->calcul_com($paliers, $montant_vnt_ht, $chiffre_affaire_styl, $niveau_actuel-1, $mandataire);
        // on deduis maintenant le montant des nb mois de pub
        $montant_ht = round ( ($formule[1] - ($contrat->packpub->tarif * $request->nb_mois_deduire) ) ,2) ;
        $montant_ttc = round ($montant_ht*$tva,2);

        $facture = Facture::create([
            "numero"=> null,
            "user_id"=> $mandataire->id,
            "compromis_id"=> $compromis->id,
            "type"=> "honoraire",
            "encaissee"=> false,
            "montant_ht"=>  $montant_ht,  
            "montant_ttc"=> $montant_ttc,
            "formule" => serialize($formule),
            "nb_mois_deduis"=> $request->nb_mois_deduire,
        ]);

        $mandataire->nb_mois_pub_restant -= $request->nb_mois_deduire;
        $mandataire->update();
        
        $compromis->facture_honoraire_cree = true;
        $compromis->update();

        if( session('is_switch') == true ){
            $action = "a déduit $request->nb_mois_deduire mois de pub sur la facture $facture->numero pour  ".Auth::user()->nom." ".Auth::user()->prenom;
            $user_id = session('admin_id');
        }else{
            $action = Auth::user()->nom." ".Auth::user()->prenom." a déduit $request->nb_mois_deduire mois de pub sur la facture  $facture->numero";
            $user_id = Auth::user()->id;
        }
      
        Historique::createHistorique( $user_id,$facture->id,"facture",$action );

    }else{
        $facture = Facture::where([ ['type','honoraire'],['compromis_id',$compromis->id]])->first();
        $formule = unserialize( $facture->formule);


    }


    $compromis->facture_honoraire_cree = true;
    $compromis->update();
    // on incremente le chiffre d'affaire et on modifie s'il le faut le pourcentage

    $niveau = $this->calcul_niveau($paliers, $chiffre_affaire_styl );
    $mandataire->commission = $paliers[$niveau-1][1];
    $mandataire->update();


    $factureStylimmo = Facture::where([ ['type','stylimmo'],['compromis_id',$compromis->id]])->first();

    // $facture = Facture::where([ ['type','honoraire'],['compromis_id',$compromis->id]])->first();

    return view ('facture.preparer_honoraire',compact(['compromis','mandataire','facture','formule','factureStylimmo']));
        
}



/**
 * Déduction de la pub sur la facture d'honoraire partagée
 *
 * @return \Illuminate\Http\Response
 */

public  function deduire_pub_facture_honoraire_partage(Request $request, $compromis, $mandataire_id = null)
{
        
//  on doit verifier que facture_honoraire_cree est false avant les modifsxxxxxxxxxxxxxxxxxxxxxxxxxxx
// If faut creer la facture avec champs nb_mois_deduis en +


$compromis = Compromis::where('id', Crypt::decrypt($compromis))->first();

if($compromis->je_porte_affaire == 1 && $compromis->est_partage_agent == 1 && (Auth()->user()->id == $compromis->user_id || $mandataire_id == $compromis->user_id  )){

    $mandataire_partage = User::where('id',$compromis->agent_id)->first();
    $mandataire = $compromis->user;
    $pourcentage_partage = $compromis->pourcentage_agent;
 
}else{
// mandataire qui ne porte  pas l'affaire


    $mandataire_partage = $compromis->user;
    $mandataire = User::where('id',$compromis->agent_id)->first();
    $pourcentage_partage = 100 - $compromis->pourcentage_agent;   
   
}


$factureStylimmo = Facture::where([ ['type','stylimmo'],['compromis_id',$compromis->id],['a_avoir', false]])->first();

$contrat = $mandataire->contrat;

// On se positionne sur le pack actuel
if($mandataire->pack_actuel == "starter"){
    $pourcent_dep =  $contrat->pourcentage_depart_starter;
    $paliers = $this->palier_unserialize( $contrat->palier_starter );
}else{
    $pourcent_dep =  $contrat->pourcentage_depart_expert;
    $paliers = $this->palier_unserialize( $contrat->palier_expert );
}

// on modifie le palier pour ajouter le % de depart dans la colonne des % (palier[1])
$p = $pourcent_dep ;
for($i = 0 ; $i <count($paliers); $i++) {
    $p += $paliers[$i][1];
    $paliers[$i][1] = $p; 
}

$tva = Tva::coefficient_tva();
$deb_annee = date("Y")."-01-01";

// On calcul le chiffre d'affaire encaissé du mandataire depuis le 1er janvier, pour voir s'il passe à la TVA
$chiffre_affaire_encai = Facture::where('user_id',$mandataire->id)->whereIn('type',['honoraire','partage','parrainage','parrainage_partage'])->where('reglee',true)->where('date_reglement','>=',$deb_annee)->sum('montant_ht');

if($contrat->est_soumis_tva == false ){

    if( $mandataire->statut == "auto-entrepeneur"){

        if($chiffre_affaire_encai < Parametre::montant_tva()){
            $tva = 0;
        }else{
            $contrat->est_soumis_tva = true;
            $contrat->update();
        }
    }else{
        $tva = 0;
    }
}

// Calcul de la commission
// $chiffre_affaire_sty = getCAStylimmo($mandataire_id, $date_deb, $date_fin);

$chiffre_affaire_styl = $mandataire->chiffre_affaire_styl( $mandataire->date_anniv(), $compromis->getFactureStylimmo()->date_encaissement->format('Y-m-d'));

if($compromis->je_porte_affaire == 1 && $compromis->est_partage_agent == 1 && (Auth()->user()->id == $compromis->user_id || $mandataire_id == $compromis->user_id) ){
//  dd("poter");
// facture du mandataire qui porte l'affaire
    
        $montant_vnt_ht = (($compromis->frais_agence()*$pourcentage_partage/100)/Tva::coefficient_tva()) ;
        
        
        // Calcul de la commission, on retire l'encaissé actuel pour ne pas faire de doublon pendant le calcul de com
        $niveau_actuel = $this->calcul_niveau($paliers, ($chiffre_affaire_styl - $montant_vnt_ht ));

        $formule = $this->calcul_com($paliers, $montant_vnt_ht, $chiffre_affaire_styl, $niveau_actuel-1, $mandataire);
// dd($formule);
      
            $montant_ht = round ( ($formule[1] - ($contrat->packpub->tarif * $request->nb_mois_deduire) ) ,2) ;
            $montant_ttc = round ($montant_ht*$tva,2);
        
            $facture = Facture::create([
                "numero"=> null,
                "user_id"=> $mandataire->id,
                "compromis_id"=> $compromis->id,
                "type"=> "partage",
                "encaissee"=> false,
                "montant_ht"=>  $montant_ht,
                "montant_ttc"=> $montant_ttc,
                "nb_mois_deduis"=> $request->nb_mois_deduire,
                "formule" => serialize($formule)
            ]);   
        
          
    
            $mandataire->nb_mois_pub_restant -= $request->nb_mois_deduire;
           
        
        
        $compromis->facture_honoraire_partage_porteur_cree = true;
        $compromis->update();

        // on incremente le chiffre d'affaire et on modifie s'il le faut le pourcentage
        $niveau = $this->calcul_niveau($paliers, $chiffre_affaire_styl );
        $mandataire->commission = $paliers[$niveau-1][1];
        $mandataire->update();

        // Faire la facture du parrain de celui pas l'affaire s'il a un parrain 

        $filleul = Filleul::where('user_id',$mandataire->id)->first();
        
    

    
   
}
// facture du mandataire qui ne porte pas l'affaire
else{

  

        $montant_vnt_ht = (($compromis->frais_agence()*$pourcentage_partage/100)/Tva::coefficient_tva()) ;

        // Calcul de la commission, on retire l'encaissé actuel pour ne pas faire de doublon pendant le calcul de com
        $niveau_actuel = $this->calcul_niveau($paliers, ($chiffre_affaire_styl - $montant_vnt_ht ));

        $formule = $this->calcul_com($paliers, $montant_vnt_ht, $chiffre_affaire_styl, $niveau_actuel-1, $mandataire);

        
        $montant_ht = round ( ($formule[1] - ($contrat->packpub->tarif * $request->nb_mois_deduire) ) ,2) ;
        $montant_ttc = round ($montant_ht*$tva,2);
        $facture = Facture::create([
            "numero"=> null,
            "user_id"=> $mandataire->id,
            "compromis_id"=> $compromis->id,
            "type"=> "partage",
            "encaissee"=> false,
            "montant_ht"=>  $montant_ht,
            "montant_ttc"=> $montant_ttc,
            "nb_mois_deduis"=> $request->nb_mois_deduire,
            "formule" => serialize($formule)
        ]);   

        $mandataire->nb_mois_pub_restant -= $request->nb_mois_deduire;
       

        $compromis->facture_honoraire_partage_cree = true;
        $compromis->update();

        // on incremente le chiffre d'affaire et on modifie s'il le faut le pourcentage

        $niveau = $this->calcul_niveau($paliers, $chiffre_affaire_styl );
        $mandataire->commission = $paliers[$niveau-1][1];
        $mandataire->update();

        // // Faire la facture du parrain de celui qui ne porte pas l'affaire s'il a un parrain 

        $filleul =  ($mandataire_partage != null ) ? Filleul::where('user_id',$mandataire_partage->id)->first() : null;


}
//  dd($formule);

if( session('is_switch') == true ){
    $action = "a déduit $request->nb_mois_deduire mois de pub sur la facture $facture->type du mandat $compromis->numero_mandat pour  ".Auth::user()->nom." ".Auth::user()->prenom;
    $user_id = session('admin_id');
}else{
    $proprietaire = $facture->user->nom." ".$facture->user->prenom ;
    $action = Auth::user()->nom." ".Auth::user()->prenom." a déduit $request->nb_mois_deduire mois de pub sur la facture  $facture->type du mandat $compromis->numero_mandat appartenant à $proprietaire ";
    $user_id = Auth::user()->id;
}

Historique::createHistorique( $user_id,$facture->id,"facture",$action );

return view ('facture.preparer_honoraire_partage',compact(['compromis','factureStylimmo','mandataire','mandataire_partage','facture','pourcentage_partage','formule']));

        
}



     //    ######## FACTURE PAC PUB
 /**
 * Liste des factures de pack pub
 *
 * @return \Illuminate\Http\Response
 */
public  function packpub()
{
    return view ('facture.pack_pub');
}

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

    return $chunk;
}


/**
 *  Calcul de la commission en fonction du palier, de la vente, du chiffre d'affaire styl et du niveau actuel
 *
 * @param  double  $montant_vnt, $ca
 * @return \Illuminate\Http\Response
*/

public function calcul_com($palier, $montant_vnt_ht, $ca, $niveau)
{

    $commission = 0;
    $tab = array();
    
    // on retire l'encaissé actuel parcequ'il fait déjà partir du ca encaissé
    $ca -= $montant_vnt_ht;
    // dd($montant_vnt_ht);
        // à partir du niveau actuel, on avance sur le palier
       for ($i=$niveau; $i<count($palier);$i++){
           if ($ca + $montant_vnt_ht <= ($palier[$i])[3] || $i == count($palier) - 1){
               $commission += ($montant_vnt_ht / 100) * ($palier[$i])[1];
               $tab[] = array($montant_vnt_ht,($palier[$i])[1]);
               break;
           }
           else {
               $diff = ($palier[$i])[3] - $ca;
               $commission += ($diff / 100) * ($palier[$i])[1];
               $montant_vnt_ht -= $diff;

               $tab[] = array($diff,($palier[$i])[1]);
            
            //    echo("Ajout à la commission:". ($diff / 100) * ($palier[$i])[1]);
            //    echo("reste:". $montant_vnt_ht);
               $ca += $diff;
           }
       }

    $tabs = array($tab,$commission);
    return $tabs;
}


/**
 * Calcul du palier actuel du mandataire en fonction de son CA STYLIMMO encaissé
 *
 * @return \Illuminate\Http\Response
 */
public function calcul_niveau($paliers, $chiffre_affaire)
{
    $niveau = 1;
    $nb_niveau = sizeof($paliers) -1  ;
    // dd($chiffre_affaire);
    foreach ($paliers as $palier) {
       
        if($chiffre_affaire >= $palier[2] && $chiffre_affaire <= $palier[3] ){
            $niveau = $palier[0];
        }elseif($chiffre_affaire > $paliers[ $nb_niveau ][3]){
            $niveau = $paliers[ $nb_niveau ][0];
        }
    }

// dd($niveau);
    return $niveau;
}


/**
 * Vues pour générer les factures d'honoraires
 *
 * @return \Illuminate\Http\Response
 */
    public function generer_facture_honoraire_create($facture_id)
    {
        $facture = Facture::where('id',  Crypt::decrypt($facture_id))->first();
        return view('facture.generer_honoraire', compact('facture') );
    }

/**
 * Vues pour générer les factures d'honoraires
 *
 * @return \Illuminate\Http\Response
 */
public function generer_pdf_facture_honoraire(Request $request, $facture_id)
{

       // on force le format des dates à cause des vieux navigateurs
       $date = date_create($request->date);
       $date = $date->format('Y-m-d');


    $facture = Facture::where('id',  Crypt::decrypt($facture_id))->first();
    $formule = unserialize( $facture->formule);
// dd($facture->user);
    $check_numero = Facture::where([['user_id',$facture->user_id],['numero',$request->numero]])->first();
    
    // dd($request->numero);
    $request->validate([
        "numero" => "required",
        "date" => "required|date",
    ]);


    if($check_numero != null && $facture->numero != $request->numero ){
        return redirect()->route('facture.generer_honoraire_create',$facture_id)->with('ok',__("Le numéro de facture $request->numero existe déjà dans vos factures"));
    }




    $facture->numero = $request->numero ;
    $facture->date_facture = $date ;
    $facture->statut = "valide";

    // on sauvegarde la facture dans le repertoire du mandataire
    $path = storage_path('app/public/'.$facture->user->id.'/factures');

    if(!File::exists($path))
        File::makeDirectory($path, 0755, true);
 
    $path = $path.'/facture_honoraire_'.$request->numero.'.pdf';
 
    // dd($path);
    // $path = storage_path('app/public/factures/facture_honoraire_'.$facture->numero.'.pdf');

    $facture->url = $path ;


    $facture->update();
    
    if($request->modele == 1){
      
           $pdf = PDF::loadView('facture.modele.modele1',compact(['facture','formule']));
           
           $pdf->save($path);
           // $pdf->download($path);
        //   return $pdf->download("facture_honoraire_$facture->numero.pdf");
    }
    elseif($request->modele == 2){
        // return view('facture.modele.modele2', compact(['facture','formule']) );
        $pdf = PDF::loadView('facture.modele.modele2',compact(['facture','formule']));
        $pdf->save($path);
           // $pdf->download($path);
        //   return $pdf->download("facture_honoraire_$facture->numero.pdf");
    }
    elseif($request->modele == 3){
        // return view('facture.modele.modele3', compact(['facture','formule']) );
        $pdf = PDF::loadView('facture.modele.modele3',compact(['facture','formule']));
           $pdf->save($path);
           // $pdf->download($path);
        //   return $pdf->download("facture_honoraire_$facture->numero.pdf");
    }

    return redirect()->route('facture.index')->with('ok',__("Votre facture $request->numero a bien été générée "));
    
    
}


/**
 * Vues pour ajouter le pdf d'une facture d'honoraire
 *
 * @return \Illuminate\Http\Response
 */
public function create_upload_pdf_honoraire($facture_id)
{
    $facture = Facture::where('id',  Crypt::decrypt($facture_id))->first();
    
    // dd(Crypt::decrypt($facture_id));
    return view('facture.add_honoraire_pdf', compact('facture') );
    
}

/**
 * Sauvegarde du pdf d'une facture d'honoraire
 *
 * @return \Illuminate\Http\Response
 */
public function store_upload_pdf_honoraire(Request $request , $facture_id)
{
        // on force le format des dates à cause des vieux navigateurs
        $date = date_create($request->date_facture);
        $date_facture = $date->format('Y-m-d');
     

        $numero = str_replace(['/', '\\', '<','>',':','|','?','*','#'],"-",$request->numero_facture) ;

    $facture = Facture::where('id',  Crypt::decrypt($facture_id))->first();

    $check_numero = Facture::where([['user_id',$facture->user_id],['numero',$request->numero_facture]])->first();
    
    $request->validate([
        "numero_facture" => "required",
        "date_facture" => "required|date",
        "montant_ht" => "required|numeric",
        "file" => "required|mimes:jpeg,png,pdf,doc,docx'|max:5000",
    ]);


    if($check_numero != null && $facture->numero != $request->numero_facture ){
        return redirect()->route('facture.create_upload_pdf_honoraire',$facture_id)->with('ok',__("Le numéro de facture $request->numero_facture existe déjà dans vos factures"));
    }

dd(doubleval($request->montant_ht)."==".gettype(doubleval($request->montant_ht) )."----->".$facture->montant_ht."==".gettype($facture->montant_ht)."****** <br>".floatval($request->montant_ht) != floatval($facture->montant_ht));
    if(doubleval($request->montant_ht) != $facture->montant_ht ){
        return redirect()->route('facture.create_upload_pdf_honoraire',$facture_id)->with('ok',__("Votre montant HT ( $request->montant_ht € )  ne correspond pas au montant HT  ( $facture->montant_ht € ) de la note d'honoraire. Veuillez contacter l'administrateur."));
    }
  


//   dd($check_numero);
    if($file = $request->file('file')){

        $name = $file->getClientOriginalName();

        // on sauvegarde la facture dans le repertoire du mandataire
        $path = storage_path('app/public/'.$facture->user->id.'/factures');

        if(!File::exists($path))
            File::makeDirectory($path, 0755, true);

            $filename = strtoupper($facture->user->nom)." ".strtoupper(substr($facture->user->prenom,0,1))." F".$numero." ".$request->montant_ht."€ F".$facture->compromis->getFactureStylimmo()->numero ;
 
            $file->move($path,$filename.'.pdf');            
            $path = $path.'/'.$filename.'.pdf';
        
            $facture->url = $path;
            $facture->numero = $request->numero_facture;
            $facture->date_facture = $date_facture;
            $facture->statut = "en attente de validation";
            $facture->update();
    }
    
    
    // SI YA PARTAGE EXTERNE AVEC UNE AGENCE
    
    if($request->numero_facture_externe != null){
        
        $facture_externe  = Facture::where([['user_id',  $facture->user_id],['type','partage_externe']])->first(); 
        $numero_externe = str_replace(['/', '\\', '<','>',':','|','?','*','#'],"-",$request->numero_facture_externe) ;
        
        
        if($file_externe = $request->file('file_externe')){

            $name_externe = $file_externe->getClientOriginalName();
    
            // on sauvegarde la facture dans le repertoire du mandataire
            $path_externe = storage_path('app/public/'.$facture->user->id.'/factures');
    
            if(!File::exists($path_externe))
                File::makeDirectory($path_externe, 0755, true);
    
                $filename_externe = strtoupper($facture_externe->compromis->nom_agent)." F".$numero_externe." ".$request->montant_ht_externe."€ F".$facture_externe->compromis->getFactureStylimmo()->numero ;
     
                $file_externe->move($path_externe,$filename_externe.'.pdf');            
                $path_externe = $path_externe.'/'.$filename_externe.'.pdf';
            
                $facture_externe->url = $path_externe;
                $facture_externe->numero = $request->numero_facture;
                $facture_externe->date_facture = $request->date_facture_externe;
                $facture_externe->statut = "en attente de validation";
                $facture_externe->update();
        }
    
    }
    
    
    // SI ON AJOUTE LE RIB DE L'AGENCE EXTERNE
    if($rib = $request->file('rib')){

        $facture_externe  = Facture::where([['user_id',  $facture->user_id],['type','partage_externe']])->first(); 
        $name_externe = $rib->getClientOriginalName();

        // on sauvegarde la facture dans le repertoire du mandataire
        $path_rib = storage_path('app/public/'.$facture->user->id.'/rib');

        if(!File::exists($path_rib))
            File::makeDirectory($path_rib, 0755, true);

            $filename_rib = strtoupper($facture_externe->compromis->nom_agent)."_rib_".$facture_externe->compromis->getFactureStylimmo()->numero ;
 
            $rib->move($path_rib,$filename_rib.'.pdf');            
            $path_rib = $path_rib.'/'.$filename_rib.'.pdf';
        
            $facture_externe->rib = $path_rib;

            $facture_externe->update();
    }
    
    
    
    
    if( session('is_switch') == true ){
        $action = "a ajouté la facture $facture->numero pour  ".Auth::user()->nom." ".Auth::user()->prenom;
        $user_id = session('admin_id');
   }else{
        $action = Auth::user()->nom." ".Auth::user()->prenom." a ajouté la facture $facture->numero";
        $user_id = Auth::user()->id;
   }
  
    Historique::createHistorique( $user_id,$facture->id,"facture",$action );


    return redirect()->route('facture.index')->with('ok',__("Votre facture $facture->numero est attente de validation."));
    
}

/**
 * Liste des factures d'honoraire à valider
 *
 * @return \Illuminate\Http\Response
 */
public function honoraire_a_valider()
{
    $factures = Facture::where('statut',  "en attente de validation")->get();
    return view('facture.a_valider', compact('factures') );
    
}


/**
 * Télécharger les factures 
 *
 * @return \Illuminate\Http\Response
 */
public function download_pdf_facture($facture_id)
{
    $facture = Facture::where('id',  Crypt::decrypt($facture_id))->first();
    return response()->download($facture->url);
    
}


/**
 * Télécharger lerib de l'agence externe
 *
 * @return \Illuminate\Http\Response
 */
public function download_pdf_rib($facture_id)
{
    $facture = Facture::where('id',  Crypt::decrypt($facture_id))->first();
    return response()->download($facture->rib);
    
}


/**
 * Valider les factures 
 *
 * @return \Illuminate\Http\Response
 */
public function valider_honoraire($action, $facture_id)
{
    $facture = Facture::where('id',  Crypt::decrypt($facture_id))->first();
    if($action == 1){
        $facture->statut = "valide";
        // ##### Notifier le mandataire par mail
     
            $action = Auth::user()->nom." ".Auth::user()->prenom." a validé la facture $facture->numero";
            $user_id = Auth::user()->id;
       
            Mail::to($facture->user->email)->send(new NotifierValidationHonoraire($facture));
      
            Historique::createHistorique( $user_id,$facture->id,"facture",$action );
    }else{
        $facture->statut = "refuse";
        $facture->url = null;
        
            $action = Auth::user()->nom." ".Auth::user()->prenom." a réfusé la facture $facture->numero";
            $user_id = Auth::user()->id;
   
        Mail::to($facture->user->email)->send(new NotifierValidationHonoraire($facture));
      
        Historique::createHistorique( $user_id,$facture->id,"facture",$action );
       
       if(file_exists($facture->url)) unlink($facture->url);
        // ##### Notifier le mandataire par mail

    }
    $facture->update();
    // return response()->download($facture->url);
    return redirect()->back();
    
}


// ############## FIN FACTURES D'HONORAIRES 





// ############## FACTURES D'AVOIR ###############

    /**
     * Création de facture d'avoir
     *
     * @return \Illuminate\Http\Response
     */
    public function create_avoir($facture_id)
    {
        $facture = Facture::where('id',  Crypt::decrypt($facture_id))->first();
        $numero = Facture::whereIn('type', ['avoir','stylimmo','pack_pub','carte_visite','communication','autre'])->max('numero') + 1;

       return view('facture.avoir.add_avoir', compact(['facture','numero']) );
    }

    /**
     * sauvegarde de facture d'avoir
     *
     * @return \Illuminate\Http\Response
     */
    public function store_avoir(Request $request)
    {
        
        $request->validate([
            'numero' => 'required|numeric|unique:factures',

        ]);
        
       $avoir =  Facture::store_avoir($request->facture_id,$request->numero, $request->motif);
      
 
        $facture = Facture::where('id',$request->facture_id)->first();
        $compromis = $facture->compromis;
        $mandataire = $facture->user;
        $numero = $request->numero;
        
        if($compromis != null){
            $compromis->demande_facture = 0;
            $compromis->facture_stylimmo_valide = 0;
            $compromis->update();
        }
       
        
            // return redirect()->route('facture.index')->with('ok', __('Avoir crée')  );
        if($facture->type == "stylimmo"){
            return redirect()->route('facture.generer_avoir_stylimmo', Crypt::encrypt($avoir->id));
        }else{
        
            return redirect()->route('facture.index')->with('ok',"Un Avoir sur la facture $facture->numero a été crée");
        }

              
        // return view ('facture.avoir.generer_avoir_stylimmo',compact(['compromis','numero','mandataire','facture']));
      
    }

    /**
     * sauvegarde de facture d'avoir
     *
     * @return \Illuminate\Http\Response
     */
    public function show_avoir($facture_id)
    {
        
        $facture = Facture::where('id', Crypt::decrypt($facture_id))->first();
        $avoir = $facture->avoir;
        $compromis = $facture->compromis;
        $mandataire = $compromis->user;
        // dd($mandataire);

       return view('facture.show_avoir', compact('facture','avoir','compromis','mandataire') );
    }

    
    /**
     * Visualisation de la facture d'avoir
     *
     * @return \Illuminate\Http\Response
     */
    public function generer_avoir_stylimmo($avoir_id)
    {
        $avoir = Facture::where('id',Crypt::decrypt($avoir_id))->first();
        $facture = Facture::where('id',$avoir->facture_id)->first() ; 
        $compromis = $facture->compromis;
        $mandataire = $avoir->user;
        $filename = "FAVOIR ".$avoir->numero." ".$avoir->montant_ttc."€ ".strtoupper($mandataire->nom)." ".strtoupper(substr($mandataire->prenom,0,1)).".pdf" ;

        
          // on sauvegarde la facture dans le repertoire du mandataire
            $path = storage_path('app/public/'.$mandataire->id.'/avoirs');

            if(!File::exists($path))
                File::makeDirectory($path, 0755, true);
            
            $pdf = PDF::loadView('facture.avoir.pdf_avoir_stylimmo',compact(['compromis','mandataire','facture','avoir']));
            
            $path = $path.'/'.$filename;
            $pdf->save($path);
            
            $avoir->url = $path;
            
            $avoir->update();
      
        return view ('facture.avoir.generer_avoir_stylimmo',compact(['compromis','mandataire','facture','avoir']));
    }

    
    /**
     * construction de la vue pdf d'une facture d'avoir
     *
     * @return \Illuminate\Http\Response
     */
    public function generer_pdf_avoir($avoir_id)
    {
        $avoir = Facture::where('id',Crypt::decrypt($avoir_id))->first();
        $facture = Facture::where('id',$avoir->facture_id)->first() ; 
        $compromis = $facture->compromis;
        $mandataire = $facture->user;
        
      
        return view ('facture.avoir.pdf_avoir_stylimmo',compact(['compromis','mandataire','facture','avoir']));
    }

/**
 *  telecharger facture avoir
 *
 * @param  string  $avoir_id
 * @return \Illuminate\Http\Response
*/
 
    public  function download_pdf_avoir($avoir_id)
    {

        $avoir = Facture::where('id', Crypt::decrypt($avoir_id))->first();
        $facture = Facture::where('facture_id',$avoir->facture_id)->first();
        $compromis = $facture->compromis;
        $mandataire = $avoir->user;

    
       
        if($mandataire != null){
            $nom = $mandataire->nom;
            $prenom = $mandataire->prenom;
            $mandataire_id = $mandataire->id;
        }else {
        
            $nom = "";
            $prenom = "";
            $mandataire_id = 0;
            
        }
        
        
        
        $filename = "FAVOIR".$avoir->numero." ".$avoir->montant_ttc."€ ".strtoupper($nom)." ".strtoupper(substr($prenom,0,1)).".pdf" ;
      
        return response()->download($avoir->url,$filename);

    //     $pdf = PDF::loadView('facture.avoir.pdf_avoir_stylimmo',compact(['compromis','mandataire','facture','avoir']));
    //     $path = storage_path('app/public/avoirs/avoir.pdf');
    //     $pdf->save($path);
    // //    return  $pdf->download($path);
    //     // dd('ddd');
    //    return $pdf->download('facture.pdf');
      
    }

    
/**
 *  regler la note d'honoraire
 *
 * @param  string  $facture_id
 * @return \Illuminate\Http\Response
*/
    public  function regler_facture_honoraire(Request $request, $facture_id)
    {


        $facture = Facture::where('id', Crypt::decrypt($facture_id))->first();
    
        $facture->reglee = true;
        $facture->date_reglement = Auth::user()->role == "admin" ? $request->date_reglement : $request->date_reglement_pub;
        $facture->update();
        

    //    ************* Creer un mail pour notifier le mandataire
        // Mail::to("gestion@stylimmo.com")->send(new EncaissementFacture($facture));
       
            $action = Auth::user()->nom." ".Auth::user()->prenom." a réglé la facture $facture->numero";
            $user_id = Auth::user()->id;
     
      
        Historique::createHistorique( $user_id,$facture->id,"facture",$action );

return 4444;
        return redirect()->route('facture.index')->with('ok', __("Facture $facture->numero reglée")  );
        
    }


    /**
         * Recalculer une note d'honoraire
         *
         * @return \Illuminate\Http\Response
     */
    public function recalculer_honoraire($facture_id)
    {
        $facture = Facture::where('id',Crypt::decrypt($facture_id))->first();

// dd(Crypt::decrypt($facture_id));
        $compromis = $facture->compromis;
        
        $mandataire = $facture->user;
        $mandataire->nb_mois_pub_restant += $facture->nb_mois_deduis;
        $mandataire->update();
        
        
        
        // Pour recalculer il faut faire une remise à zéro dans le compromis, puis supprimer la facture et la recalculer
        // $mandataire->nb_mois_pub_restant -= $facture->nb_mois_deduis ; 
        // $mandataire->update();

        /* --- remise à zéro en fonction du type de facture
            honoraire 
                - facture_honoraire_cree
            partage 
                - facture_honoraire_partage_cree  
                - facture_honoraire_partage_porteur_cree

            parrainage 
                - facture_honoraire_parrainage_cree

            parrainage_partage
                - facture_honoraire_parrainage_partage_cree
        */
       
        $proprietaire = $facture->user->nom." ".$facture->user->prenom ;
        $action = Auth::user()->nom." ".Auth::user()->prenom." a récalculé la facture  $facture->type du mandat $compromis->numero_mandat appartenant à $proprietaire ";
        $user_id = Auth::user()->id;

        Historique::createHistorique( $user_id,$facture->id,"facture",$action );

        if($facture->type == "honoraire"){
        
        // On vérifie qu'il ne sagit pas de la première déduiction de jetons après encaissement de la facture styl
            if($facture->nb_mois_deduis !== null){
                $compromis->facture_honoraire_cree = 0 ;
                $compromis->update();
                // dd($facture);
                $facture->delete();
            
            }
       
                
                
                return redirect()->route('facture.preparer_facture_honoraire', [ Crypt::encrypt( $compromis->id)]);
        }elseif($facture->type == "partage"){
                // le mandataire qui porte l'affaire
                if($mandataire->id == $compromis->user_id){
                    $compromis->facture_honoraire_partage_porteur_cree = 0 ;
            // dd('partage 1 ');
            

                }
                // le mandataire qui ne porte pas l'affaire
                else{
                    $compromis->facture_honoraire_partage_cree = 0 ;
            // dd('partage 2');
                    
                }
                
                
                
                  // On vérifie qu'il ne sagit pas de la première déduiction de jetons après encaissement de la facture styl
            if($facture->nb_mois_deduis !== null){
                $compromis->update();
                $facture->delete();
            }
              
                return redirect()->route('facture.preparer_facture_honoraire_partage', [ Crypt::encrypt( $compromis->id),$mandataire->id]);

        }
        elseif($facture->type == "partage_externe"){
        
            $compromis->facture_honoraire_partage_externe_cree = 0 ;
            $compromis->update();
            // dd($facture);
            $facture->delete();

            return redirect()->route('facture.preparer_facture_honoraire_partage_externe', [ Crypt::encrypt( $compromis->id)]);
        }
        
        
        
        elseif($facture->type == "parrainage"){
            $compromis->facture_honoraire_parrainage_cree = 0 ;

            $compromis->update();
            $facture->delete();
            
            if($facture->filleul_id !=null){
                return redirect()->route('facture.preparer_facture_honoraire_parrainage', [ Crypt::encrypt( $compromis->id),$facture->filleul_id]);

            }else{
                return redirect()->route('facture.preparer_facture_honoraire_parrainage', [ Crypt::encrypt( $compromis->id)]);

            }




        }elseif($facture->type == "parrainage_partage"){
            $compromis->facture_honoraire_parrainage_partage_cree = 0 ;

            $compromis->update();
            $facture->delete();
            return redirect()->route('facture.preparer_facture_honoraire_parrainage', [ Crypt::encrypt( $compromis->id)]);

        }else{
            return  redirect()->back()->with("ok", "La note d'honoraire n'a pas été recalculée");
        }
        

        
        
        $compromis->update();
        $facture->delete();


        return redirect()->back()->with("ok", "La note d'honoraire a été recalculée");
    }

    /**
         * Recalculer pour chacun des mandataires les CA stylimmo
         *
         * @return \Illuminate\Http\Response
     */
    public function recalculer_les_ca_styl()
    {
       
        // On reccuperere tous les mandataires 

        $mandataires = User::where('role','mandataire')->get();
        $deb_annee = date("Y")."-01-01";

        // pour chaque mandataire on calcul le ca styl et on le met à jour  dans la table des mandataires 
        foreach ($mandataires as $mandataire ) {
             // CA encaissé non partagé

             $compro_encaisse_partage_pas_n = Compromis::where([['user_id',$mandataire->id],['est_partage_agent',false],['demande_facture',2],['archive',false]])->get();
             $ca_encaisse_partage_pas_n = 0;
             if($compro_encaisse_partage_pas_n != null){                
                 foreach ($compro_encaisse_partage_pas_n as $compros_encaisse) {
                     if($compros_encaisse->getFactureStylimmo()->a_voir = false && $compros_encaisse->getFactureStylimmo()->encaissee == 1 && $compros_encaisse->getFactureStylimmo()->date_encaissement->format("Y-m-d") >= $deb_annee){
                         $ca_encaisse_partage_pas_n +=  $compros_encaisse->getFactureStylimmo()->montant_ttc;
                        //  echo  $mandataire->id == 12 ?  "<br/>".$compros_encaisse->numero_mandat." np".$compros_encaisse->getFactureStylimmo()->montant_ttc : null ;
                     }
                }
                
            }
         
             // CA encaissé partagé et porte affaire
             $compro_encaisse_porte_n = Compromis::where([['user_id',$mandataire->id],['est_partage_agent',true],['demande_facture',2],['archive',false]])->get();
             $ca_encaisse_porte_n = 0;

                 if($compro_encaisse_porte_n != null){
                     foreach ($compro_encaisse_porte_n as $compros_encaisse) {
                         if($compros_encaisse->getFactureStylimmo()->a_voir = false && $compros_encaisse->getFactureStylimmo()->encaissee == 1 && $compros_encaisse->getFactureStylimmo()->date_encaissement->format("Y-m-d") >= $deb_annee){
                             $ca_encaisse_porte_n +=  $compros_encaisse->frais_agence * $compros_encaisse->pourcentage_agent/100;
                            //  echo  $mandataire->id == 12 ?  '<br/> pp  '.$compros_encaisse->numero_mandat.'--'.$compros_encaisse->getFactureStylimmo()->montant_ttc * $compros_encaisse->pourcentage_agent/100: null ;
                         }
                     }
                 }


             // CA encaissé partagé et ne porte pas affaire
  
             $compro_encaisse_porte_pas_n = Compromis::where([['agent_id',$mandataire->id],['est_partage_agent',true],['demande_facture',2],['archive',false]])->get();
             $ca_encaisse_porte_pas_n = 0;

                 if($compro_encaisse_porte_pas_n != null){
                     foreach ($compro_encaisse_porte_pas_n as $compros_encaisse) {
                         if($compros_encaisse->getFactureStylimmo()->a_voir = false && $compros_encaisse->getFactureStylimmo()->encaissee == 1 && $compros_encaisse->getFactureStylimmo()->date_encaissement->format("Y-m-d") >= $deb_annee){
                             $ca_encaisse_porte_pas_n +=  $compros_encaisse->frais_agence * (100-$compros_encaisse->pourcentage_agent)/100;
                            //  echo  $mandataire->id == 12 ?  '<br/>ppp  '.$compros_encaisse->numero_mandat.'--'.$compros_encaisse->getFactureStylimmo()->montant_ttc* (100-$compros_encaisse->pourcentage_agent)/100 : null ;
                         }
                     }
                 }

          
             
             $ca_encaisse_N = round(($ca_encaisse_partage_pas_n+$ca_encaisse_porte_n+$ca_encaisse_porte_pas_n)/Tva::coefficient_tva(),2);

             $mandataire->chiffre_affaire_sty = $ca_encaisse_N ;
             $mandataire->update();
       
       // $mandataire->id == 12 ?   dd($ca_encaisse_N) : null;
         
        }

        return "OK";
    }

    
    /**
         * export de données pour les factures
         *
         * @return \Illuminate\Http\Response
     */
    public function export_facture()
    {
       
        $factures = Facture::whereIn('type',['stylimmo'])->latest()->get();
            
       
        // dd($factureStylimmos);
        
        return view ('facture.export',compact(['factures']));
       
    }


    /**
     *  enaisser la facture stylimmo
     *
     * @param  int  $facture
     * @return \Illuminate\Http\Response
    */
        
    public  function reencaisser_facture_stylimmo()
    {

        $factures = Facture::where([['type','stylimmo'],['encaissee',1]])->get();

        foreach ($factures as $facture) {
            
            $this->encaisser_facture_stylimmo($facture->id,  $facture->date_encaissement);
        }
        // dd($factures);

        return "ok";
    }

    /**
     * etat financier
     *
     * @param  int  $compromis
     * @return \Illuminate\Http\Response
     */
    public function etat_financier($date_deb = null, $date_fin = null)
    {
        // ,['cloture_affaire','<',2]
        // etat financier
        ini_set('max_execution_time', 500);
        $compromis = Compromis::where([['archive','<', 1],['facture_stylimmo_valide', 1]])->get();
        $etats = array();
        $total_encaisse = 0;
        $total_reste_a_payer = 0 ;
        $total_tva_a_payer = 0 ;
        
        
        
        if($date_deb > $date_fin){
            $dt = $date_deb;
            $date_deb = $date_fin;
            $date_fin = $dt;
        }

                foreach ($compromis as $compro) {
                    if($compro->getFactureStylimmo()->encaissee == true ){

                        array_push($etats, $compro->etat_fin($date_deb,$date_fin)); 

                    //    if($compro->getFactureStylimmo()->numero == 16050)
                    //         dd($compro->etat_fin($date_deb,$date_fin));


                        if( ($compro->getFactureStylimmo()->date_encaissement->format('Y-m-d') >= $date_deb && $compro->getFactureStylimmo()->date_encaissement->format('Y-m-d') <= $date_fin) || ($date_deb == null || $date_fin== null) )
                            $total_encaisse +=$compro->getFactureStylimmo()->montant_ttc ;
                    }
                }
        
                foreach ($etats as $etat) {
                    if( ($etat['facture_styl']->date_encaissement->format('Y-m-d') >= $date_deb && $etat['facture_styl']->date_encaissement->format('Y-m-d') <= $date_fin) || ($date_deb == null || $date_fin== null) ){
                            $total_reste_a_payer += $etat['reste_a_regler'];
                            $total_tva_a_payer += $etat['tva_a_regler'];
                    }
                  
                }

       
        return view ('facture.etat_financier',compact('etats','date_deb','date_fin','total_encaisse','total_reste_a_payer','total_tva_a_payer') );  
        // return redirect()->route('compromis.index')->with('ok', __('compromis modifié')  );

    }


    
    /**
     *  Créer une facture stylimmo libre
     *
     * @return \Illuminate\Http\Response
    */
    public  function create_libre()
    {
        $mandataires = User::where('role', 'mandataire')->orderBy('nom')->get();
        $numero = Facture::whereIn('type',['avoir','stylimmo','pack_pub','carte_visite','communication','autre'])->max('numero') + 1;
        return view ('facture.add',compact('numero','mandataires'));
    }


    /**
     *  Ajouter une facture stylimmo libre
     *
     * @return \Illuminate\Http\Response
    */
    public  function store_libre(Request $request)
    {
       
       
       if($request->destinataire_est_mandataire ){
            $request->validate([
                'numero' => 'required|numeric|unique:factures',
                'type' => 'required',
                'description_produit' => 'required',
            ]);

            $destinataire_est_mandataire = true;

        $user_id = $request->mandataire_id;
       }else{

            $request->validate([
                'numero' => 'required|numeric|unique:factures',
                'type' => 'required',
                'destinataire' => 'required',
                'description_produit' => 'required',
            ]);
            
            $user_id = null;
            $destinataire_est_mandataire = false;

       }

       $facture = Facture::create([
            "numero"=> $request->numero,
            "user_id"=> $user_id,
           
            "type"=> $request->type,
            "encaissee"=> false,
            "montant_ht"=>  $request->montant_ht,
            "montant_ttc"=> $request->montant_ht * Tva::coefficient_tva(),
            "date_facture"=> $request->date_facture,
            "destinataire_est_mandataire"=> $destinataire_est_mandataire,
            "destinataire"=> $request->destinataire,
            "description_produit"=> $request->description_produit,
       ]);
       
       
        return view ('facture.generer_facture_autre',compact('facture'));
    }



    /**
     *  Modifier une facture stylimmo libre
     *
     * @return \Illuminate\Http\Response
    */
    public  function edit_libre($facture_id)
    {
       

        $facture = Facture::where('id', crypt::decrypt($facture_id))->first();
        $mandataires = User::where('role', 'mandataire')->orderBy('nom')->get();
       
        
        return view ('facture.edit',compact('mandataires','facture'));

    }

    /**
     *  Modifier une facture stylimmo libre
     *
     * @return \Illuminate\Http\Response
    */
    public  function update_libre(Request $request, $facture_id)
    {
       

        $facture = Facture::where('id', crypt::decrypt($facture_id))->first();
        

        if($request->numero != $facture->numero){
            $request->validate([
                'numero' => 'required|numeric|unique:factures',
            ]);
        }
      
        
        if($request->destinataire_est_mandataire ){


            $request->validate([
                'type' => 'required',
                'description_produit' => 'required',
            ]);

            $destinataire_est_mandataire = true;
            $user_id = $request->mandataire_id;


       }else{

            $request->validate([
                'type' => 'required',
                'destinataire' => 'required',
                'description_produit' => 'required',
            ]);
            
            $user_id = null;
            $destinataire_est_mandataire = false;

       }


            $facture->numero = $request->numero;
            $facture->user_id = $user_id;
           
            $facture->type = $request->type;

            $facture->montant_ht =  $request->montant_ht;
            $facture->montant_ttc = $request->montant_ht * Tva::coefficient_tva();
            $facture->date_facture = $request->date_facture;
            $facture->destinataire_est_mandataire = $destinataire_est_mandataire;
            $facture->destinataire = $request->destinataire;
            $facture->description_produit = $request->description_produit;


            $facture->update();
       
        
        return view ('facture.generer_facture_autre',compact('facture'));


    }
        
    /**
     *  telecharger facture autre
     *
     * @param  string  $compromis_id
     * @return \Illuminate\Http\Response
    */

    public  function download_pdf_facture_autre($facture_id)
    {

        // $compromis = Compromis::where('id', Crypt::decrypt($compromis_id))->first();
        // $mandataire = $compromis->user;

        $facture = Facture::where('id', crypt::decrypt($facture_id))->first();
        if($facture->destinataire_est_mandataire == true ){
            $filename = "F".$facture->numero." ".$facture->type." ".$facture->montant_ttc."€ ".strtoupper($facture->user->nom)." ".strtoupper(substr($facture->user->prenom,0,1)).".pdf" ;
        }else{
            $filename = "F".$facture->numero." ".$facture->type." ".$facture->montant_ttc."€.pdf" ;
        }

        $pdf = PDF::loadView('facture.pdf_autre',compact(['facture']));

        $path = storage_path('app/public/factures/'.$filename);
      
        // $pdf->save($path);
        // $pdf->download($path);
        return $pdf->download($filename);
    
    }


        
    /**
     *  générer facture autre y compris pack_pub
     *
     * @param  string  $compromis_id
     * @return \Illuminate\Http\Response
    */

    public  function generer_pdf_facture_autre($facture_id)
    {


        // on sauvegarde la facture dans le repertoire du mandataire
        $path = storage_path('app/public/factures/factures_autres');

        if(!File::exists($path))
            File::makeDirectory($path, 0755, true);
        
            $facture = Facture::where('id', crypt::decrypt($facture_id))->first();
          
            $pdf = PDF::loadView('facture.pdf_autre',compact(['facture']));


        if($facture->destinataire_est_mandataire == true ){
            $filename = "F".$facture->numero." ".$facture->type." ".$facture->montant_ttc."€ ".strtoupper($facture->user->nom)." ".strtoupper(substr($facture->user->prenom,0,1)).".pdf" ;
        }else{
            $filename = "F".$facture->numero." ".$facture->type." ".$facture->montant_ttc."€.pdf" ;
        }
        
        $path = $path.'/'.$filename;
        $pdf->save($path);
        
        $facture->url = $path;
        $facture->update();
  

        return   redirect()->route('facture.index')->with("ok", "Votre facture ". $facture->type." " .$facture->numero." a été crée");
 

    }
    
    
    /**
     *  Liste des factures d'honoraires a payer et non ajoutées
     *
     * @return \Illuminate\Http\Response
    */

    public  function honoraire_a_payer()
    {


        $facturesAPayer = Facture::whereIn('type',['honoraire','partage','partage_externe','parrainage','parrainage_partage'])->where([['reglee', false], ['statut','valide']])->latest()->get();
        $facturesNonAjou = Facture::whereIn('type',['honoraire','partage','partage_externe','parrainage','parrainage_partage'])->where([['reglee', false], ['statut','<>','valide']])->latest()->get();
        
        // Liste des affaires réitérée, encaissée mais dont les notes d'honoraires n'ont pas été générée
        $compromisR = Compromis::where([['facture_stylimmo_valide', true], ['cloture_affaire', 1]])->where(function ($query) {
        
            // $query->where([['est_partage_agent', false], ['facture_honoraire_cree', false], ['facture_honoraire_parrainage_cree', false]])
            $query->where([['est_partage_agent', false], ['facture_honoraire_cree', false]])
                ->orWhere([['est_partage_agent', true], ['facture_honoraire_partage_cree', false], ['facture_honoraire_partage_porteur_cree', false]])
                ->orWhere([['est_partage_agent', true], ['facture_honoraire_partage_cree', true], ['facture_honoraire_partage_porteur_cree', false]])
                ->orWhere([['est_partage_agent', true], ['facture_honoraire_partage_cree', false], ['facture_honoraire_partage_porteur_cree', true]]);
        
        })->get();

// dd($compromisR);


// On reccupere le total TTC
        $totalApayer1 = Facture::whereIn('type',['honoraire','partage','parrainage','parrainage_partage','partage_externe'])->where([['reglee', false], ['statut','valide'], ['montant_ttc', 0]])->sum('montant_ht');
        $totalApayer2 = Facture::whereIn('type',['honoraire','partage','parrainage','parrainage_partage','partage_externe'])->where([['reglee', false], ['statut','valide'], ['montant_ttc','<>', 0]])->sum('montant_ttc');
  
        $totalApayer = $totalApayer1 + $totalApayer2;
        
        $totalNonAjou1 = Facture::whereIn('type',['honoraire','partage','parrainage','parrainage_partage','partage_externe'])->where([['reglee', false], ['statut','<>','valide'], ['montant_ttc', 0]])->sum('montant_ht');
        $totalNonAjou2 = Facture::whereIn('type',['honoraire','partage','parrainage','parrainage_partage','partage_externe'])->where([['reglee', false], ['statut','<>','valide'], ['montant_ttc','<>', 0]])->sum('montant_ttc');
  
        $totalNonAjou = $totalNonAjou1 + $totalNonAjou2;
  
//   Calcul des montants TVA;
       
       $motantTvaFAPayer = 0;
       $motantTvaFNonAjou = 0;
       
       foreach ($facturesAPayer as $fact) {
            $motantTvaFAPayer += $fact->montant_ttc == 0 ? 0 : $fact->montant_ttc - $fact->montant_ht;
       }
       
        foreach ($facturesNonAjou as $fact) {
            $motantTvaFNonAjou += $fact->montant_ttc == 0 ? 0 : $fact->montant_ttc - $fact->montant_ht;
        }

//calcul des montant HT
            $totalNonAjou_HT = Facture::whereIn('type',['honoraire','partage','parrainage','parrainage_partage','partage_externe'])->where([['reglee', false], ['statut','<>','valide']])->sum('montant_ht');
            $totalApayer_HT = Facture::whereIn('type',['honoraire','partage','parrainage','parrainage_partage','partage_externe'])->where([['reglee', false], ['statut','valide']])->sum('montant_ht');


       return view('facture.a_payer.index', compact('facturesAPayer','facturesNonAjou','totalNonAjou','totalApayer','motantTvaFNonAjou','motantTvaFAPayer','totalApayer_HT','totalNonAjou_HT','compromisR'));
 

    }
    
    /**
     *  Liste des factures STYL'IMMO non encaissées hors délais ( dont la date de vente est dépassée de 60 jours )
     *
     * @return \Illuminate\Http\Response
    */

    public  function hors_delais()
    {


// dd(date('Y-m-d', strtotime(date('Y-m-d'). ' - 60 days')));



    $factures = Facture::where([['type','stylimmo'],['a_avoir',false],['encaissee',false]])->get();
    $today60 = date('Y-m-d', strtotime(date('Y-m-d'). ' - 60 days'));
    
    
       return view('facture.hors_delais', compact('factures','today60'));
 

    }





    
}
