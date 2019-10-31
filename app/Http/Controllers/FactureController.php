<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facture;
use App\User;
use App\Compromis;
use App\Filleul;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Mail\DemandeFactureStylimmo;
use App\Mail\EnvoyerFactureStylimmoMandataire;
use App\Mail\EncaissementFacture;
use PDF;
use Illuminate\Support\Facades\File ;


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
            $factureEmises = Facture::whereIn('type',['pack_pub','carte_visite','stylimmo'])->get();
            $factureRecues = Facture::whereIn('type',['honoraire'])->get();

        }else{
            $factureEmises = Facture::where('user_id',auth()->user()->id)->whereIn('type',['honoraire'])->get();
            $factureRecues = Facture::where('user_id',auth()->user()->id)->whereIn('type',['pack_pub','carte_visite','stylimmo'])->get();
        }
   
        
        return view ('facture.index',compact(['factureEmises','factureRecues']));
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
        return view ('demande_facture.demande',compact('compromis'));  
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
        // 0 = facture non demandée, 1= facture demandée en attente de validation, 2 = demande traitée par stylimmo
        $compromis->demande_facture = 1;

        $compromis->update();

        $nb_demande_facture =  Compromis::where('demande_facture',1)->count();


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
        
        $compromis = Compromis::where('demande_facture', 1)->get();
        return view ('demande_facture.index',compact('compromis'));
    }

    //################

    public  function show_demande_stylimmo($compromis)
    {
        
        $compromis = Compromis::where('id', Crypt::decrypt($compromis))->first();
        return view ('demande_facture.show',compact('compromis'));
    }


//############
public  function valider_facture_stylimmo($compromis)
{
    
    $compromis = Compromis::where('id', Crypt::decrypt($compromis))->first();
    $mandataire = $compromis->user;
    // save la facture

    $tva = 1.2;
    $numero = 1507;
    $facture = Facture::where([ ['type','stylimmo'],['compromis_id',$compromis->id]])->first();
    $nb_numeros_facture = Facture::where([ ['type','stylimmo']])->select('numero')->count();
    
    if($nb_numeros_facture > 0){
        $numeros_facture = Facture::where([ ['type','stylimmo']])->select('numero')->get()->toArray();
        $numeros = array();

        foreach ($numeros_facture as $num) {
            $numeros[] = $num["numero"];
        }

        $numero = max($numeros)+1;
    }

    // dd($numeros_facture);
    
    // dd($numero);

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

    $nb_demande_facture =  Compromis::where('demande_facture',1)->count();
    $admins = User::where('role','admin')->get();

    foreach ($admins as $admin) {
        $admin->demande_facture = $nb_demande_facture;
        $admin->update();
    }
    
    Mail::to($mandataire->email)->send(new EnvoyerFactureStylimmoMandataire($mandataire,$facture));
    
    return view ('facture.generer_stylimmo',compact(['compromis','mandataire','facture']))->with('ok', __('Facture envoyée au mandataire') );
    
}

//############
    public  function generer_facture_stylimmo($compromis)
    {
        
        $compromis = Compromis::where('id', Crypt::decrypt($compromis))->first();
        $mandataire = $compromis->user;
        $facture = Facture::where([ ['type','stylimmo'],['compromis_id',$compromis->id]])->first();
        
      
        return view ('facture.generer_stylimmo',compact(['compromis','mandataire','facture']));
      
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

        return redirect()->route('facture.demande_stylimmo')->with('ok', __('Facture envoyée au mandataire')  );
        
    }

       //###### envoyer facture stylimmo au mandataire
       public  function encaisser_facture_stylimmo($facture_id)
       {
   
   
           $facture = Facture::where('id', Crypt::decrypt($facture_id))->first();
        
           $facture->encaissee = true;
           $facture->update();
           // dd($facture);
   
   
           // dd('ddd');
           Mail::to($facture->compromis->user->email)->send(new EncaissementFacture($facture));
   
           return redirect()->route('facture.index')->with('ok', __('Facture encaissée, le mandataire a été notifié')  );
           
       }


    //    ######## FACTURE D'HONORAIRES

// Préparation de la facture d'honoraire
public  function preparer_facture_honoraire($compromis)
{
    
    $compromis = Compromis::where('id', Crypt::decrypt($compromis))->first();
    $mandataire = $compromis->user;
    
    $contrat = $mandataire->contrat;

    // On se positionne sur le pac actuel
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
    
    if($compromis->facture_honoraire_cree == false && $compromis->user->statut !="auto-entrepeneur" ){
    $formule = $this->calcul_com($paliers, $compromis->frais_agence, $mandataire->chiffre_affaire_sty, $niveau_actuel-1, $mandataire);

        $tva = 1.2;
        $facture = Facture::create([
            "numero"=> null,
            "user_id"=> $mandataire->id,
            "compromis_id"=> $compromis->id,
            "type"=> "honoraire",
            "encaissee"=> false,
            "montant_ht"=>  round ( ($formule[1])/$tva ,2),
            "montant_ttc"=> round( $formule[1],2),
            "formule" => serialize($formule)
        ]);
        
        
        $compromis->facture_honoraire_cree = true;
        $compromis->update();
        // on incremente le chiffre d'affaire et on modifie s'il le faut le pourcentage
        $mandataire->chiffre_affaire += $formule[1];
        $mandataire->chiffre_affaire_sty += $compromis->frais_agence;
        $niveau = $this->calcul_niveau($paliers, $mandataire->chiffre_affaire_sty );
        $mandataire->commission = $paliers[$niveau-1][1];
        $mandataire->update();

        }else{
            $facture = Facture::where([ ['type','honoraire'],['compromis_id',$compromis->id]])->first();
            $formule = unserialize( $facture->formule);
        }
 

    $factureStylimmo = Facture::where([ ['type','stylimmo'],['compromis_id',$compromis->id]])->first();


    return view ('facture.preparer_honoraire',compact(['compromis','mandataire','facture','factureStylimmo','formule']));
    
}

// Préparation de la facture d'honoraire du parrain
public  function preparer_facture_honoraire_parrainage($compromis)
{
    
    $compromis = Compromis::where('id', Crypt::decrypt($compromis))->first();
    $filleul = $compromis->user;
    $parrain_id =  Filleul::where('user_id',$filleul->id)->select('parrain_id')->first();
    $pourcentage_parrain =  Filleul::where('user_id',$filleul->id)->select('pourcentage')->first();
    $pourcentage_parrain = $pourcentage_parrain['pourcentage'];
    $parrain = User::where('id',$parrain_id['parrain_id'])->first();
    
    if($compromis->facture_honoraire_parrainage_cree == false ){
        $tva = 1.2;
        $facture = Facture::create([
            "numero"=> null,
            "user_id"=> $parrain_id['parrain_id'],
            "compromis_id"=> $compromis->id,
            "type"=> "parrainage",
            "encaissee"=> false,
            "montant_ht"=>  round ( ($compromis->frais_agence*$pourcentage_parrain/100 )/$tva ,2),
            "montant_ttc"=> round( $compromis->frais_agence*$pourcentage_parrain/100,2),
        ]);
        
        // on incremente le chiffre d'affaire du parrain
        $parrain->chiffre_affaire += $facture->montant_ttc ; 
        $parrain->update(); 
        
        $compromis->facture_honoraire_parrainage_cree = true;
        $compromis->update();
        }else{
            $facture = Facture::where([ ['type','parrainage'],['compromis_id',$compromis->id]])->first();
        }

    return view ('facture.preparer_honoraire_parrainage',compact(['compromis','parrain','filleul','facture','pourcentage_parrain']));
    
}


// Préparation de la facture d'honoraire pour le partage (le mandataire qui ne porte pas l'affaire)
public  function preparer_facture_honoraire_partage($compromis)
{
    
    $compromis = Compromis::where('id', Crypt::decrypt($compromis))->first();

    if($compromis->je_porte_affaire == 1 && $compromis->est_partage_agent == 1 && Auth()->user()->id == $compromis->user_id){

        $mandataire_partage = User::where('id',$compromis->agent_id)->first();
        $mandataire = $compromis->user;
        $pourcentage_partage = $compromis->pourcentage_agent;    
    }else{

        $mandataire_partage = $compromis->user;
        $mandataire = User::where('id',$compromis->agent_id)->first();
        $pourcentage_partage = 100 - $compromis->pourcentage_agent;    
    }

   
    // $factureHonoraire = Facture::where([ ['type','honoraire'],['compromis_id',$compromis->id]])->first();   
    $factureStylimmo = Facture::where([ ['type','stylimmo'],['compromis_id',$compromis->id]])->first();
    // dd($factureHonoraire);

    $contrat = $mandataire->contrat;

    // On se positionne sur le pac actuel
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
    if($compromis->je_porte_affaire == 1 && $compromis->est_partage_agent == 1 && Auth()->user()->id == $compromis->user_id){
        // facture du mandataire qui porte l'affaire
        if($compromis->facture_honoraire_partage_porteur_cree == false ){
        $formule = $this->calcul_com($paliers, $compromis->frais_agence*$pourcentage_partage/100, $mandataire->chiffre_affaire_sty, $niveau_actuel-1, $mandataire);

            $tva = 1.2;
        
            $facture = Facture::create([
                "numero"=> null,
                "user_id"=> $mandataire->id,
                "compromis_id"=> $compromis->id,
                "type"=> "partage",
                "encaissee"=> false,
                "montant_ht"=>  round ( $formule[1]/$tva,2),
                "montant_ttc"=> round ( $formule[1],2),
                "formule" => serialize($formule)
            ]);   
            
            
            $compromis->facture_honoraire_partage_porteur_cree = true;
            $compromis->update();

            // on incremente le chiffre d'affaire et on modifie s'il le faut le pourcentage
            $mandataire->chiffre_affaire += $formule[1];
            $mandataire->chiffre_affaire_sty += $compromis->frais_agence*$pourcentage_partage/100;
            $niveau = $this->calcul_niveau($paliers, $mandataire->chiffre_affaire_sty );
            $mandataire->commission = $paliers[$niveau-1][1];
            $mandataire->update();
        }else{
            $facture = Facture::where([ ['type','partage'],['user_id',$mandataire->id],['compromis_id',$compromis->id]])->first();
            $formule = unserialize( $facture->formule);
        }
    }
// facture du mandataire qui ne porte pas l'affaire
    else{
        if($compromis->facture_honoraire_partage_cree == false ){
            $formule = $this->calcul_com($paliers, $compromis->frais_agence*$pourcentage_partage/100, $mandataire->chiffre_affaire_sty, $niveau_actuel-1, $mandataire);

            $tva = 1.2;
        
            $facture = Facture::create([
                "numero"=> null,
                "user_id"=> $mandataire->id,
                "compromis_id"=> $compromis->id,
                "type"=> "partage",
                "encaissee"=> false,
                "montant_ht"=>  round ( $formule[1]/$tva,2),
                "montant_ttc"=> round ( $formule[1],2),
                "formule" => serialize($formule)
            ]);   
            
            
            $compromis->facture_honoraire_partage_cree = true;
            $compromis->update();

            // on incremente le chiffre d'affaire et on modifie s'il le faut le pourcentage
            $mandataire->chiffre_affaire += $formule[1];
            $mandataire->chiffre_affaire_sty += $compromis->frais_agence*$pourcentage_partage/100;
            $niveau = $this->calcul_niveau($paliers, $mandataire->chiffre_affaire_sty );
            $mandataire->commission = $paliers[$niveau-1][1];
            $mandataire->update();
        }else{
            $facture = Facture::where([ ['type','partage'],['user_id',$mandataire->id],['compromis_id',$compromis->id]])->first();
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
        if($compromis->facture_honoraire_cree == false && $mandataire->nb_mois_pub_restant > 0 && $compromis->user->statut !="independant"){
            $tva = 1.2;
            $facture = Facture::create([
                "numero"=> null,
                "user_id"=> $mandataire->id,
                "compromis_id"=> $compromis->id,
                "type"=> "honoraire",
                "encaissee"=> false,
                "montant_ht"=>  round ( ($compromis->frais_agence*$mandataire->commission/100 )/$tva ,2),
                "montant_ttc"=> round( $compromis->frais_agence*$mandataire->commission/100,2),
                "nb_mois_deduis"=> $request->nb_mois_deduire,
            ]);
            $mandataire->nb_mois_pub_restant -= $request->nb_mois_deduire;
            $mandataire->update();
            
            $compromis->facture_honoraire_cree = true;
            $compromis->update();
        }else{
            $facture = Facture::where([ ['type','honoraire'],['compromis_id',$compromis->id]])->first();
        }
        
        $factureStylimmo = Facture::where([ ['type','stylimmo'],['compromis_id',$compromis->id]])->first();

        

        // $facture = Facture::where([ ['type','honoraire'],['compromis_id',$compromis->id]])->first();
  
        return view ('facture.preparer_honoraire',compact(['compromis','mandataire','facture','factureStylimmo']));
        
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


public function calcul_com($palier, $montant_vnt, $ca, $niveau)
{

    $commission = 0;
    $tab = array();

       for ($i=$niveau; $i<count($palier);$i++){
           if ($ca + $montant_vnt <= ($palier[$i])[3] || $i == count($palier) - 1){
               $commission += ($montant_vnt / 100) * ($palier[$i])[1];
               $tab[] = array($montant_vnt,($palier[$i])[1]);
               break;
           }
           else {
               $diff = ($palier[$i])[3] - $ca;
               $commission += ($diff / 100) * ($palier[$i])[1];
               $montant_vnt -= $diff;

               $tab[] = array($diff,($palier[$i])[1]);
            
               echo("Ajout à la commission:". ($diff / 100) * ($palier[$i])[1]);
               echo("reste:". $montant_vnt);
               $ca += $diff;
           }
       }
    //    dd($commission);

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



    
}
