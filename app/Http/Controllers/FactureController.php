<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facture;
use App\User;
use App\Compromis;
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

    // ###########
    // public  function generer_pdf_facture_stylimmo()
    // {
        
    //     $pdf = PDF::loadView('facture.generer_stylimmo');
    //     $path = storage_path('app/public/factures/test.pdf');
    //     $pdf->save($path);
    //    return $pdf->download('facture.pdf');
      
    // }

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

    
    $facture = Facture::where([ ['type','honoraire'],['compromis_id',$compromis->id]])->first();
    $factureStylimmo = Facture::where([ ['type','stylimmo'],['compromis_id',$compromis->id]])->first();

    return view ('facture.preparer_honoraire',compact(['compromis','mandataire','facture','factureStylimmo']));
    
}

    
// Préparation de la facture d'honoraire du parrain
public  function preparer_facture_honoraire_parrainage($compromis)
{
    
    $compromis = Compromis::where('id', Crypt::decrypt($compromis))->first();
    $mandataire = $compromis->user;

   
    $facture = Facture::where([ ['type','honoraire'],['compromis_id',$compromis->id]])->first();
    $factureStylimmo = Facture::where([ ['type','stylimmo'],['compromis_id',$compromis->id]])->first();


    return view ('facture.preparer_honoraire_parrainage',compact(['compromis','mandataire','facture','factureStylimmo']));
    
}
    
    // Déduction de la pub sur la facture d'honoraire
    public  function deduire_pub_facture_honoraire(Request $request, $compromis)
    {
        
//  on doit verifier que facture_honoraire_cree est false avant les modifsxxxxxxxxxxxxxxxxxxxxxxxxxxx
// If faut creer la facture avec champs nb_mois_deduis en +
       
        $compromis = Compromis::where('id', Crypt::decrypt($compromis))->first();
        $mandataire = $compromis->user;
        if($compromis->facture_honoraire_cree == false && $mandataire->nb_mois_pub_restant > 0 ){
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

    
}
