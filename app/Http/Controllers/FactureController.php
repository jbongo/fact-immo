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
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Mail\DemandeFactureStylimmo;
use App\Mail\EnvoyerFactureStylimmoMandataire;
use App\Mail\EncaissementFacture;
use PDF;
use Illuminate\Support\Facades\File ;
use Illuminate\Support\Facades\Storage;



class FactureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //
     
        if(auth()->user()->role == "admin"){
            $factureStylimmos = Facture::whereIn('type',['stylimmo'])->latest()->get();
            $factureHonoraires = Facture::whereIn('type',['honoraire','partage','parrainage','parrainage_partage'])->latest()->get();
            $factureCommunications = Facture::where('type',['pack_pub','carte_visite'])->latest()->get();
            
        }else{
            $factureHonoraires = Facture::where('user_id',auth()->user()->id)->whereIn('type',['honoraire','partage','parrainage','parrainage_partage'])->latest()->get();
            $factureStylimmos = Facture::where('user_id',auth()->user()->id)->where('type','stylimmo')->latest()->get();
            $factureCommunications = Facture::where('user_id',auth()->user()->id)->whereIn('type',['pack_pub','carte_visite'])->latest()->get();

        }
        // dd($factureStylimmos);
        
        return view ('facture.index',compact(['factureHonoraires','factureStylimmos']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
     * demande de facture stylimmo par le mandataire
     *
     * @param  int  $compromis
     * @return \Illuminate\Http\Response
     */
    public function demander_facture($compromis_id)
    {
    
        $compromis = Compromis::where('id',Crypt::decrypt($compromis_id))->first();
        $mandataire = User::where('id',$compromis->user_id)->first();
        $numero = Facture::where([ ['type','stylimmo']])->max('numero') + 1;

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

    
        $compromis = Compromis::where('id',Crypt::decrypt($compromis_id))->first();
        $compromis->date_vente = $request->date_vente;

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
        $compromis->date_signature = $request->date_signature;

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




        // return view ('demande_facture.demande',compact('compromis'));    
        return redirect()->route('compromis.index')->with('ok', __('Demande de facture éffectuée')  );

    }



// ################
    public  function demandes_stylimmo()
    {
        
        $compromis = Compromis::where([['demande_facture', 1],['archive',0]])->get();
        // dd($compromis);
        return view ('demande_facture.index',compact('compromis'));
    }

    //################

    public  function show_demande_stylimmo($compromis)
    {
        
        $compromis = Compromis::where('id', Crypt::decrypt($compromis))->first();
        return view ('demande_facture.show',compact('compromis'));
    }


//############
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

   

    
    // dd($request->numero);
    $numero = $request->numero;
    $compromis = Compromis::where('id', Crypt::decrypt($compromis))->first();
    $mandataire = $compromis->user;
    // save la facture

    $tva = 1.2;
    // $numero = 1507;
    $facture = Facture::where([ ['type','stylimmo'],['compromis_id',$compromis->id]])->first();


    // Si la facture n'est pas déjà crée
    if ($facture == null) {
            $facture = Facture::create([
            "numero"=> $numero,
            "user_id"=> $compromis->user_id,
            "compromis_id"=> $compromis->id,
            "type"=> "stylimmo",
            "encaissee"=> false,
            "montant_ht"=>  round ($compromis->frais_agence/$tva ,2),
            "montant_ttc"=> $compromis->frais_agence,
            "date_facture"=> $request->date_facture,

        ]);
        // $compromis->facture_honoraire_cree = true;

    }else{
        $facture = Facture::where([ ['type','stylimmo'],['compromis_id',$compromis->id]])->first();
    }
    
    // fin save facture

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
    
    return view ('facture.generer_stylimmo',compact(['compromis','mandataire','facture']))->with('ok', __('Facture envoyée au mandataire') );
    
}

//############
    public  function generer_facture_stylimmo($compromis)
    {
        
        $compromis = Compromis::where('id', Crypt::decrypt($compromis))->first();
        $mandataire = $compromis->user;
        $facture = Facture::where([ ['type','stylimmo'],['compromis_id',$compromis->id]])->first();

        $numero = "";
        // $nb_numeros_facture = Facture::where([ ['type','stylimmo']])->select('numero')->count();
        
        // if($nb_numeros_facture > 0){
        //     $numeros_facture = Facture::where([ ['type','stylimmo']])->select('numero')->get()->toArray();
        //     $numeros = array();
    
        //     foreach ($numeros_facture as $num) {
        //         $numeros[] = $num["numero"];
        //     }
    
        //     $numero = max($numeros)+1;
        // }
        
        $numero = Facture::where([ ['type','stylimmo']])->max('numero') + 1;
        $lastdate = Facture::where('numero',$numero-1)->select('date_facture')->first();
            

        $lastdate= $lastdate['date_facture'];
      
        return view ('facture.generer_stylimmo',compact(['compromis','numero','mandataire','facture','lastdate']));
      
    }

  
    //###### telecharger facture stylimmo
    public  function download_pdf_facture_stylimmo($compromis_id)
    {

        $compromis = Compromis::where('id', Crypt::decrypt($compromis_id))->first();
        $mandataire = $compromis->user;
 
        $facture = Facture::where([ ['type','stylimmo'],['compromis_id',$compromis->id]])->first();
    
        // dd('ddd');
        $pdf = PDF::loadView('facture.pdf_stylimmo',compact(['compromis','mandataire','facture']));
        $path = storage_path('app/public/factures/facture.pdf');
        // $pdf->save($path);
        // $pdf->download($path);
       return $pdf->download('facture.pdf');
      
    }
    
    //###### envoyer facture stylimmo au mandataire
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

       //###### enaisser la facture stylimmo
       public  function encaisser_facture_stylimmo($facture_id, Request $request)
       {
   
   
           $facture = Facture::where('id', $facture_id)->first();
        
           $facture->encaissee = true;
           $facture->date_encaissement = $request->date_encaissement;
           $facture->update();
        //    dd($facture);
   
   
           // dd('ddd');
           Mail::to($facture->compromis->user->email)->send(new EncaissementFacture($facture));
        //    Mail::to("gestion@stylimmo.com")->send(new EncaissementFacture($facture));
           return $facture->numero ;
        //    return redirect()->route('facture.index')->with('ok', __("Facture ". $facture->numero ." encaissée, le mandataire a été notifié")  );
           
       }



//    ############ FACTURES D'HONORAIRES ############

// Préparation de la facture d'honoraire
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

    // Calcul de la commission
    $niveau_actuel = $this->calcul_niveau($paliers, $mandataire->chiffre_affaire_sty);

    if($compromis->facture_honoraire_cree == false && $compromis->user->statut !="auto-entrepreneur" ){
    
        $montant_vnt_ht = ($compromis->frais_agence/1.2) ; 
        $formule = $this->calcul_com($paliers, $montant_vnt_ht, $mandataire->chiffre_affaire_sty, $niveau_actuel-1, $mandataire);
        $deb_annee = date("Y")."-01-01";

        // On calcul le chiffre d'affaire encaissé du mandataire depuis le 1er janvier, pour voir s'il passe à la TVA
        $chiffre_affaire_encai = Facture::where('user_id',$mandataire->id)->whereIn('type',['honoraire','partage','parrainage','parrainage_partage'])->where('reglee',true)->where('date_reglement','>=',$deb_annee)->sum('montant_ht');

        $tva = 1.2;
        if($contrat->est_soumis_tva == false){
        
            if($chiffre_affaire_encai < 35200){
                $tva = 0;
            }else{
                $contrat->est_soumis_tva = true;
                $contrat->update();
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
        $mandataire->chiffre_affaire += $formule[1];
        $mandataire->chiffre_affaire_sty += $compromis->frais_agence/1.2;
        $niveau = $this->calcul_niveau($paliers, $mandataire->chiffre_affaire_sty );
        $mandataire->commission = $paliers[$niveau-1][1];
        $mandataire->update();

            // Faire la facture du parrain s'il y'a un parrain 

            $filleul = Filleul::where('user_id',$mandataire->id)->first();

            if($filleul != null ){
                $this->store_facture_honoraire_parrainage($compromis, $filleul);
            }
        }
        elseif($compromis->facture_honoraire_cree == false && $compromis->user->statut =="auto-entrepreneur"){
            $facture = null;
            $formule = null;
        }
        else{
            $facture = Facture::where([ ['type','honoraire'],['compromis_id',$compromis->id]])->first();
            $formule = unserialize( $facture->formule);
        }
        
        
    $factureStylimmo = Facture::where([ ['type','stylimmo'],['compromis_id',$compromis->id]])->first();
    return view ('facture.preparer_honoraire',compact(['compromis','mandataire','facture','factureStylimmo','formule']));
    
}

// Préparation de la facture d'honoraire du parrain  / *************revoir pour ajouter la formule de calcul par niveau***************
public  function preparer_facture_honoraire_parrainage($compromis)
{

    $compromis = Compromis::where('id', Crypt::decrypt($compromis))->first();

    $deux_filleuls = false;
    //  On détermine le filleul ou les filleuls s'il y'a partage entre les filleuls (même parrain)
    if($compromis->est_partage_agent == true){
        

        //on va comparer les parrains des filleuls (si les 2 en ont) pour voir si c'est le même
        $filleul1  = Filleul::where('user_id',$compromis->user_id)->first();
        $filleul2  = Filleul::where('user_id',$compromis->agent_id)->first();

        // Si les 2 filleuls ont un parrain
        if($filleul1 != null & $filleul2 != null){

            // si les 2 filleuls ont le même parrain
            if($filleul1->parrain_id == $filleul2->parrain_id  ){
                $deux_filleuls= true;
                dd("2 filleuls");

                // 


#######################################################




            } //Si les 2 n'ont pas le même parrain
            else{
                
                $filleul_id =  $filleul1->parrain_id == auth::id() ? $filleul1->user_id : $filleul2->user_id ;

                $filleul = User::where('id',$filleul_id)->first();
                $pourcentage_parrain =  Filleul::where('user_id',$filleul->id)->select('pourcentage')->first();
                $pourcentage_parrain = $pourcentage_parrain['pourcentage'];

                // lorsque le filleul porte l'affaire
                if($filleul->id == $compromis->user_id){
                    
                    $frais_agence = $compromis->frais_agence * $compromis->pourcentage_agent/100 ;
                }
                // lorsque le filleul ne porte pas l'affaire
                else{

                    $frais_agence = $compromis->frais_agence * (100 - $compromis->pourcentage_agent) /100 ;
                }
                

                 // On determine le parrain 
                $parrain_id =  Filleul::where('user_id',$filleul->id)->select('parrain_id')->first();    
                $parrain = User::where('id',$parrain_id['parrain_id'])->first();
                $deb_annee = date("Y")."-01-01";
            // on determine le chiffre d'affaire encaissé du parrain depuis le 1er janvier, pour voir s'il est soumis à la TVA
                $chiffre_affaire_parrain_encai = Facture::where('user_id',$parrain->id)->whereIn('type',['honoraire','partage','parrainage','parrainage_partage'])->where('reglee',true)->where('date_reglement','>=',$deb_annee)->sum('montant_ht');
            //    on reccupere le contrat du parrain
                $contrat = $parrain->contrat;
                $tva = 1.2;
                
                if($contrat->est_soumis_tva == false){
                
                    if($chiffre_affaire_encai < 35200){
                        $tva = 0;
                    }else{
                        $contrat->est_soumis_tva = true;
                        $contrat->update();
                    }

                }

                $montant_ht = round ( ($frais_agence * $pourcentage_parrain/100 )/$tva ,2);
                $montant_ttc = round( $frais_agence * $pourcentage_parrain/100,2);

                $result = Filleul::droitParrainage(Auth::id(), $filleul->id, $compromis->id);

            }
            

        }else{
            // on continue avec l'unique filleul
            if($filleul1 != null){
                // Lorsque le filleul porte l'affaire

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
                $tva = 1.2;
                
                if($contrat->est_soumis_tva == false){
                
                    if($chiffre_affaire_encai < 35200){
                        $tva = 0;
                    }else{
                        $contrat->est_soumis_tva = true;
                        $contrat->update();
                    }

                }

                $frais_agence = $compromis->frais_agence * $compromis->pourcentage_agent/100 ;
                $montant_ht = round ( ($frais_agence * $pourcentage_parrain/100 )/$tva ,2);
                $montant_ttc = round( $frais_agence * $pourcentage_parrain/100,2);
                // dd("unique filleul 1 ");

            }else{
                // Lorsque le filleul ne porte pas l'affaire
                $filleul = User::where('id',$filleul2->user_id)->first();
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
                $tva = 1.2;
                
                if($contrat->est_soumis_tva == false){
                
                    if($chiffre_affaire_encai < 35200){
                        $tva = 0;
                    }else{
                        $contrat->est_soumis_tva = true;
                        $contrat->update();
                    }

                }


                $frais_agence = $compromis->frais_agence * (100 - $compromis->pourcentage_agent) /100 ;
                $montant_ht = round ( ($frais_agence * $pourcentage_parrain/100 )/$tva ,2);
                $montant_ttc = round( $frais_agence * $pourcentage_parrain/100,2);
                // dd($montant_ttc);
                //  dd("unique filleul 2 ");
                

            }

            $result = Filleul::droitParrainage(Auth::id(), $filleul->id, $compromis->id);
          

        }
        



    }else{

        //  dd("un filleul sans partage");
        $filleul = User::where('id',$compromis->user_id)->first();
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
        $tva = 1.2;
        
        if($contrat->est_soumis_tva == false){
        
            if($chiffre_affaire_encai < 35200){
                $tva = 0;
            }else{
                $contrat->est_soumis_tva = true;
                $contrat->update();
            }

        }
        
        $montant_ht = round ( ($compromis->frais_agence*$pourcentage_parrain/100 )/$tva ,2);
        $montant_ttc = round( $compromis->frais_agence*$pourcentage_parrain/100,2);

        $result = Filleul::droitParrainage(Auth::id(), $filleul->id, $compromis->id);

    }


// 

    $parrain_id =  Filleul::where('user_id',$filleul->id)->select('parrain_id')->first();
    $pourcentage_parrain =  Filleul::where('user_id',$filleul->id)->select('pourcentage')->first();
    $pourcentage_parrain = $pourcentage_parrain['pourcentage'];
    $parrain = User::where('id',$parrain_id['parrain_id'])->first();
    
    // ########### On doit verifier si le parrain a droit à la comm ##########


    if($compromis->facture_honoraire_parrainage_cree == false ){
        // Si toutes les conditions pour toucher le parrainnage sont respectées
        if($result["respect_condition"] == true){

            // calcul du montant ht et ttc
            
            $facture = Facture::create([
                "numero"=> null,
                "user_id"=> $parrain_id['parrain_id'],
                "compromis_id"=> $compromis->id,
                "type"=> "parrainage",
                "encaissee"=> false,
                "montant_ht"=>  $montant_ht,
                "montant_ttc"=> $montant_ttc,
            ]);
            // on incremente le chiffre d'affaire du parrain
            // dd($parrain);
            $parrain->chiffre_affaire += $facture->montant_ttc ; 
            $parrain->update(); 
            
            $compromis->facture_honoraire_parrainage_cree = true;
            $compromis->update();
            }else{
            $facture = null;

            }
        }else{
            $facture = Facture::where([ ['type','parrainage'],['compromis_id',$compromis->id]])->first();

        }


   
// dd($facture );
    return view ('facture.preparer_honoraire_parrainage',compact(['compromis','parrain','filleul','facture','pourcentage_parrain','result']));
    
}



// Factures de parrainage dans le cas d'un partage entre deux mandataires
public  function preparer_facture_honoraire_parrainage_partage(Compromis $compromis )
{
    // if($compromis->parrain_partage_id != null){

        $filleul = Filleul::where([ ['parrain_id',$compromis->parrain_partage_id],['user_id', $compromis->agent_id] ])->first();
    // }

// xxxxxxxxxxxxxxxxxxxxxx

//     dd($compromis->user_id);
    $parrain_id = $filleul->parrain_id ; 
    $pourcentage_parrain = $filleul->pourcentage; 


    $parrain = User::where('id',$parrain_id)->first();

    // On vérifie si filleul est le porteur d'affaire
    if($compromis->user_id == $filleul->user_id){
        // On fait la facture du parrain de celui qui a crée l'affaire
        if($compromis->facture_honoraire_parrainage_cree == false ){
            $tva = 1.2;
            
            $facture = Facture::create([
                "numero"=> null,
                "user_id"=> $parrain->id,
                "compromis_id"=> $compromis->id,
                "type"=> "parrainage",
                "encaissee"=> false,
                "montant_ht"=>  round ( ( ($compromis->frais_agence * $compromis->pourcentage_agent/100) *$pourcentage_parrain/100 )/$tva ,2),
                "montant_ttc"=> round( ($compromis->frais_agence * $compromis->pourcentage_agent/100) *$pourcentage_parrain/100,2),
            ]);
            // dd($facture);
            // on incremente le chiffre d'affaire du parrain
            $parrain->chiffre_affaire += $facture->montant_ttc ; 
            $parrain->update(); 
            
            $compromis->facture_honoraire_parrainage_cree = true;
            $compromis->update();
        }else{
            $facture = Facture::where([ ['type','parrainage'],['compromis_id',$compromis->id]])->first();
        }
    // On vérifie si filleul est le partage
    }elseif($compromis->agent_id == $filleul->user_id){
        // On fait la facture du parrain du partage
        if($compromis->facture_honoraire_parrainage_partage_cree == false ){
            $tva = 1.2;
            
            $facture = Facture::create([
                "numero"=> null,
                "user_id"=> $parrain->id,
                "compromis_id"=> $compromis->id,
                "type"=> "parrainage_partage",
                "encaissee"=> false,
                "montant_ht"=>  round ( ( ($compromis->frais_agence * (100 - $compromis->pourcentage_agent)/100)*$pourcentage_parrain/100 )/$tva ,2),
                "montant_ttc"=> round( ($compromis->frais_agence * (100 - $compromis->pourcentage_agent)/100)*$pourcentage_parrain/100,2),
            ]);
            // dd($facture);
            // on incremente le chiffre d'affaire du parrain
            $parrain->chiffre_affaire += $facture->montant_ttc ; 
            $parrain->update(); 
            
            $compromis->facture_honoraire_parrainage_partage_cree = true;
            $compromis->update();
        }else{
            $facture = Facture::where([ ['type','parrainage_partage'],['compromis_id',$compromis->id]])->first();
        }
    }

    return view ('facture.preparer_honoraire_parrainage',compact(['compromis','parrain','filleul','facture','pourcentage_parrain']));

}

public  function store_facture_honoraire_parrainage(Compromis $compromis, Filleul $filleul)
{
    

//    dd("creation facture parrain du filleul ".$filleul->user_id);

    $parrain_id = $filleul->parrain_id ; 
    $pourcentage_parrain = $filleul->pourcentage; 

    $parrain = User::where('id',$parrain_id)->first();
    // On vérifie si filleul est le porteur d'affaire
    if($compromis->user_id == $filleul->user_id){
        // On fait la facture du parrain de celui qui a crée l'affaire
        if($compromis->facture_honoraire_parrainage_cree == false ){
            $tva = 1.2;

            $facture = Facture::create([
                "numero"=> null,
                "user_id"=> $parrain->id,
                "compromis_id"=> $compromis->id,
                "type"=> "parrainage",
                "encaissee"=> false,
                "montant_ht"=>  round ( ( ($compromis->frais_agence * $compromis->pourcentage_agent/100) *$pourcentage_parrain/100 )/$tva ,2),
                "montant_ttc"=> round( ($compromis->frais_agence * $compromis->pourcentage_agent/100) *$pourcentage_parrain/100,2),
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
            $tva = 1.2;
            
            $facture = Facture::create([
                "numero"=> null,
                "user_id"=> $parrain->id,
                "compromis_id"=> $compromis->id,
                "type"=> "parrainage_partage",
                "encaissee"=> false,
                "montant_ht"=>  round ( ( ($compromis->frais_agence * (100 - $compromis->pourcentage_agent)/100)*$pourcentage_parrain/100 )/$tva ,2),
                "montant_ttc"=> round( ($compromis->frais_agence * (100 - $compromis->pourcentage_agent)/100)*$pourcentage_parrain/100,2),
            ]);
            // dd($facture);
            // on incremente le chiffre d'affaire du parrain
            $parrain->chiffre_affaire += $facture->montant_ttc ; 
            $parrain->update(); 
            
            $compromis->facture_honoraire_parrainage_partage_cree = true;
            $compromis->update();
        }
    }

    

    //  On fait la facture du parrain de celui qui ne porte pas l'affaire (le partage)
    // facture_honoraire_parrainage_partage_cree
    
}


// Préparation de la facture d'honoraire pour le partage (le mandataire qui ne porte pas l'affaire)
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

    // Calcul de la commission
    $niveau_actuel = $this->calcul_niveau($paliers, $mandataire->chiffre_affaire_sty);
    if($compromis->je_porte_affaire == 1 && $compromis->est_partage_agent == 1 && (Auth()->user()->id == $compromis->user_id || $mandataire_id == $compromis->user_id) ){
        // facture du mandataire qui porte l'affaire
        if($compromis->facture_honoraire_partage_porteur_cree == false ){
            $montant_vnt_ht = ($compromis->frais_agence/1.2) ;
            
            $formule = $this->calcul_com($paliers, $montant_vnt_ht*$pourcentage_partage/100, $mandataire->chiffre_affaire_sty, $niveau_actuel-1, $mandataire);

            $tva = 1.2;
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
            $mandataire->chiffre_affaire += $formule[1];
            $mandataire->chiffre_affaire_sty += ($compromis->frais_agence/1.2)*$pourcentage_partage/100;
            $niveau = $this->calcul_niveau($paliers, $mandataire->chiffre_affaire_sty );
            $mandataire->commission = $paliers[$niveau-1][1];
            $mandataire->update();

            // Faire la facture du parrain de celui pas l'affaire s'il a un parrain 

            $filleul = Filleul::where('user_id',$mandataire->id)->first();
            if($filleul != null ){
                $this->store_facture_honoraire_parrainage($compromis, $filleul);
            }
        

        }else{
            // dd('stop');

                $facture = Facture::where([ ['type','partage'],['user_id',$mandataire->id],['compromis_id',$compromis->id]])->first();
        //  dd($mandataireid);
            $formule = unserialize( $facture->formule);
        }
    }
// facture du mandataire qui ne porte pas l'affaire
    else{

        if($compromis->facture_honoraire_partage_cree == false ){

            $montant_vnt_ht = ($compromis->frais_agence/1.2) ;
            $formule = $this->calcul_com($paliers, $montant_vnt_ht*$pourcentage_partage/100, $mandataire->chiffre_affaire_sty, $niveau_actuel-1, $mandataire);

            $tva = 1.2;
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
            $mandataire->chiffre_affaire += $formule[1];
            $mandataire->chiffre_affaire_sty += ($compromis->frais_agence/1.2)*$pourcentage_partage/100;
            $niveau = $this->calcul_niveau($paliers, $mandataire->chiffre_affaire_sty );
            $mandataire->commission = $paliers[$niveau-1][1];
            $mandataire->update();

            // // Faire la facture du parrain de celui qui ne porte pas l'affaire s'il a un parrain 

            $filleul = Filleul::where('user_id',$mandataire_partage->id)->first();

            if($filleul != null ){
                $this->store_facture_honoraire_parrainage($compromis, $filleul);
            }

        }else{
            if($mandataire_id == null){
                $facture = Facture::where([ ['type','partage'],['user_id',$mandataire->id],['compromis_id',$compromis->id]])->first();

            }else{
                
                $facture = Facture::where([ ['type','partage'],['user_id',$mandataire_id],['compromis_id',$compromis->id]])->first();
               
            }
            $formule = unserialize( $facture->formule);
        }

    }
// dd($formule);

    return view ('facture.preparer_honoraire_partage',compact(['compromis','factureStylimmo','mandataire','mandataire_partage','facture','pourcentage_partage','formule']));
    
}
    


// Déduction de la pub sur la facture d'honoraire
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

    // Calcul de la commission
    $niveau_actuel = $this->calcul_niveau($paliers, $mandataire->chiffre_affaire_sty);

    if($compromis->facture_honoraire_cree == false && $mandataire->nb_mois_pub_restant > 0 && $compromis->user->statut !="independant"){
        $tva = 1.2;
        $montant_vnt_ht = ($compromis->frais_agence/$tva) ; 
      
        $formule = $this->calcul_com($paliers, $montant_vnt_ht, $mandataire->chiffre_affaire_sty, $niveau_actuel-1, $mandataire);
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
    }else{
        $facture = Facture::where([ ['type','honoraire'],['compromis_id',$compromis->id]])->first();
        $formule = unserialize( $facture->formule);


    }


    $compromis->facture_honoraire_cree = true;
    $compromis->update();
    // on incremente le chiffre d'affaire et on modifie s'il le faut le pourcentage
    $mandataire->chiffre_affaire += $formule[1];
    $mandataire->chiffre_affaire_sty += $compromis->frais_agence/1.2; // revoir cette partie, faut t-il utiliser le ht ou ttc des frais agence ?
    $niveau = $this->calcul_niveau($paliers, $mandataire->chiffre_affaire_sty );
    $mandataire->commission = $paliers[$niveau-1][1];
    $mandataire->update();


    $factureStylimmo = Facture::where([ ['type','stylimmo'],['compromis_id',$compromis->id]])->first();

    // $facture = Facture::where([ ['type','honoraire'],['compromis_id',$compromis->id]])->first();

    return view ('facture.preparer_honoraire',compact(['compromis','mandataire','facture','formule','factureStylimmo']));
        
}


     //    ######## FACTURE PAC PUB
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
    // syupprime le premier tableau de notre tableau
    // dd($chunk);
    // array_shift($chunk);

    return $chunk;
}

// Calcul de la commission en fonction du palier, de la vente, du chiffre d'affaire styl et du niveau actuel
public function calcul_com($palier, $montant_vnt_ht, $ca, $niveau)
{

    $commission = 0;
    $tab = array();
        // à partir du niveau actuell, on avance sur le palier
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
            
               echo("Ajout à la commission:". ($diff / 100) * ($palier[$i])[1]);
               echo("reste:". $montant_vnt_ht);
               $ca += $diff;
           }
       }

    $tabs = array($tab,$commission);
    return $tabs;
}

public function calcul_niveau($paliers, $chiffre_affaire)
{
    $niveau = 1;
    $nb_niveau = sizeof($paliers) -1  ;
    // dd($paliers[4]);
    foreach ($paliers as $palier) {
       
        if($chiffre_affaire >= $palier[2] && $chiffre_affaire <= $palier[3] ){
            $niveau = $palier[0];
        }elseif($chiffre_affaire > $paliers[ $nb_niveau ][3]){
            $niveau = $paliers[ $nb_niveau ][0];
        }
    }

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
    $facture->date_facture = $request->date ;
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
    return view('facture.add_honoraire_pdf', compact('facture') );
    
}

/**
 * Sauvegarde du pdf d'une facture d'honoraire
 *
 * @return \Illuminate\Http\Response
 */
public function store_upload_pdf_honoraire(Request $request , $facture_id)
{
    
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

    if($request->montant_ht != $facture->montant_ht ){
        return redirect()->route('facture.create_upload_pdf_honoraire',$facture_id)->with('ok',__("Votre montant HT ( $request->montant_ht € )  ne correspond pas au montant HT  ( $facture->montant_ht € ) de la note d'honoraire. Veuillez contacter l'administrateur."));
    }
  


//   dd($check_numero);
    if($file = $request->file('file')){

        $name = $file->getClientOriginalName();

        // on sauvegarde la facture dans le repertoire du mandataire
        $path = storage_path('app/public/'.$facture->user->id.'/factures');

        if(!File::exists($path))
            File::makeDirectory($path, 0755, true);
 
            $file->move($path,'facture_honoraire_'.$facture->numero.'.pdf');            
            $path = $path.'/facture_honoraire_'.$facture->numero.'.pdf';
        
            $facture->url = $path;
            $facture->numero = $request->numero_facture;
            $facture->date_facture = $request->date_facture;
            $facture->statut = "en attente de validation";
            $facture->update();
    }
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
    }else{
        $facture->statut = "refuse";
        $facture->url = null;
       
       if(file_exists($facture->url)) unlink($facture->url);
        // ##### Notifier le mandataire par mail

    }
    $facture->update();
    // return response()->download($facture->url);
    
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
       return view('facture.add_avoir', compact('facture') );
    }

    /**
     * sauvegarde de facture d'avoir
     *
     * @return \Illuminate\Http\Response
     */
    public function store_avoir(Request $request)
    {
        
        $request->validate([
            'montant' => 'required|numeric',
            'date' => 'required|date',
            'motif' => 'required|string',
        ]);
        
        $facture = Facture::where('id',$request->facture_id)->first();
        $avoir = Avoir::create([
            "numero" => "av".$facture->numero,
            "facture_id"=> $facture->id,
            "montant"=> $request->montant,
            "date"=> $request->date,
            "motif"=> $request->motif,
        ]);

        if($avoir != null ){
            $facture->a_avoir = true;
            $facture->update();
            return redirect()->route('facture.index')->with('ok', __('Avoir crée')  );
        }else{
            return redirect()->route('facture.index')->with('ok', __('Avoir non crée')  );

        }
       
      
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
     * construction de la vue pdf d'une facture d'avoir
     *
     * @return \Illuminate\Http\Response
     */
    public function generer_pdf_avoir($facture_id)
    {
        $avoir = Avoir::where('id',Crypt::decrypt($avoir_id))->first();
        $facture = $avoir->facture ; 
        $compromis = $facture->compromis;
        $mandataire = $compromis->user;
        
      
        return view ('facture.generer_pdf_avoir',compact(['compromis','mandataire','facture','avoir']));
    }

    //###### telecharger facture avoir
    public  function download_pdf_avoir($avoir_id)
    {

        $avoir = Avoir::where('id', Crypt::decrypt($avoir_id))->first();
        $facture = $avoir->facture;
        $compromis = $facture->compromis;
        $mandataire = $compromis->user;
        $pdf = PDF::loadView('facture.pdf_avoir',compact(['compromis','mandataire','facture','avoir']));
        $path = storage_path('app/public/avoirs/avoir.pdf');
        $pdf->save($path);
    //    return  $pdf->download($path);
        // dd('ddd');
       return $pdf->download('facture.pdf');
      
    }

    //###### regler la note d'honoraire
    public  function regler_facture_honoraire(Request $request, $facture_id)
    {


        $facture = Facture::where('id', Crypt::decrypt($facture_id))->first();
    
        $facture->reglee = true;
        $facture->date_reglement = $request->date_reglement;
        $facture->update();
        

        // return $facture->reglee.'';
    //    ************* Creer un mail pour notifier le mandataire
        // Mail::to("gestion@stylimmo.com")->send(new EncaissementFacture($facture));

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
      
        $compromis = $facture->compromis;

        $mandataire = $facture->user;
        
        
        // Pour recalculer il faut faire une remise à zéro dans le compromis, puis supprimer la facture et la recalculer


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

        if($facture->type == "honoraire"){
            $compromis->facture_honoraire_cree = 0 ;

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
        }elseif($facture->type == "parrainage"){
            $compromis->facture_honoraire_parrainage_cree = 0 ;

        }elseif($facture->type == "parrainage_partage"){
            $compromis->facture_honoraire_parrainage_partage_cree = 0 ;

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
                     if($compros_encaisse->getFactureStylimmo()->encaissee == 1 && $compros_encaisse->getFactureStylimmo()->date_encaissement->format("Y-m-d") >= $deb_annee){
                         $ca_encaisse_partage_pas_n +=  $compros_encaisse->getFactureStylimmo()->montant_ttc;
                         echo  $mandataire->id == 12 ?  "<br/>".$compros_encaisse->numero_mandat." np".$compros_encaisse->getFactureStylimmo()->montant_ttc : null ;
                     }
                }
                
            }
         
             // CA encaissé partagé et porte affaire
             $compro_encaisse_porte_n = Compromis::where([['user_id',$mandataire->id],['est_partage_agent',true],['demande_facture',2],['archive',false]])->get();
             $ca_encaisse_porte_n = 0;

                 if($compro_encaisse_porte_n != null){
                     foreach ($compro_encaisse_porte_n as $compros_encaisse) {
                         if($compros_encaisse->getFactureStylimmo()->encaissee == 1 && $compros_encaisse->getFactureStylimmo()->date_encaissement->format("Y-m-d") >= $deb_annee){
                             $ca_encaisse_porte_n +=  $compros_encaisse->frais_agence * $compros_encaisse->pourcentage_agent/100;
                             echo  $mandataire->id == 12 ?  '<br/> pp  '.$compros_encaisse->numero_mandat.'--'.$compros_encaisse->getFactureStylimmo()->montant_ttc * $compros_encaisse->pourcentage_agent/100: null ;
                         }
                     }
                 }


             // CA encaissé partagé et ne porte pas affaire
  
             $compro_encaisse_porte_pas_n = Compromis::where([['agent_id',$mandataire->id],['est_partage_agent',true],['demande_facture',2],['archive',false]])->get();
             $ca_encaisse_porte_pas_n = 0;

                 if($compro_encaisse_porte_pas_n != null){
                     foreach ($compro_encaisse_porte_pas_n as $compros_encaisse) {
                         if($compros_encaisse->getFactureStylimmo()->encaissee == 1 && $compros_encaisse->getFactureStylimmo()->date_encaissement->format("Y-m-d") >= $deb_annee){
                             $ca_encaisse_porte_pas_n +=  $compros_encaisse->frais_agence * (100-$compros_encaisse->pourcentage_agent)/100;
                             echo  $mandataire->id == 12 ?  '<br/>ppp  '.$compros_encaisse->numero_mandat.'--'.$compros_encaisse->getFactureStylimmo()->montant_ttc* (100-$compros_encaisse->pourcentage_agent)/100 : null ;
                         }
                     }
                 }

          
             
             $ca_encaisse_N = round(($ca_encaisse_partage_pas_n+$ca_encaisse_porte_n+$ca_encaisse_porte_pas_n)/1.2,2);

             $mandataire->chiffre_affaire_sty = $ca_encaisse_N ;
             $mandataire->update();
       
       // $mandataire->id == 12 ?   dd($ca_encaisse_N) : null;
         
        }


        // dd($mandataires);

        





        return "OK";
    }

    
}
