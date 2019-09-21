<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facture;
use App\User;
use App\Compromis;
use Illuminate\Support\Facades\Crypt;
use PDF;

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
        $factures = Facture::all();
        return view ('facture.index',compact('factures'));
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

        // return view ('demande_facture.demande',compact('compromis'));    
        return redirect()->route('compromis.index')->with('ok', __('Demande de facture éffectuée')  );

    }


    public  function demandes_stylimmo()
    {
        
        $compromis = Compromis::where('demande_facture', 1)->get();
        return view ('demande_facture.index',compact('compromis'));
    }

    public  function show_demande_stylimmo($compromis)
    {
        
        $compromis = Compromis::where('id', Crypt::decrypt($compromis))->first();
        return view ('demande_facture.show',compact('compromis'));
    }

    public  function generer_facture_stylimmo($compromis)
    {
        
        $compromis = Compromis::where('id', Crypt::decrypt($compromis))->first();
        $mandataire = $compromis->user;
        // save la facture

        $tva = 0.2;
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
                "compromis_id"=> $compromis->id,
                "type"=> "stylimmo",
                "encaissee"=> false,
                "montant_ht"=>  round ($compromis->frais_agence*$tva ,2),
                "montant_ttc"=> $compromis->frais_agence,

            ]);

        }else{
            $facture = Facture::where([ ['type','stylimmo'],['compromis_id',$compromis->id]])->first();
        }
       
        // fin save facture
      
        return view ('facture.generer_stylimmo',compact(['compromis','mandataire','facture']));
      
    }


    public  function generer_pdf_facture_stylimmo()
    {
        
        $pdf = PDF::loadView('facture.generer_stylimmo');
        $path = storage_path('app/public/factures/test.pdf');
        $pdf->save($path);
       return $pdf->download('facture.pdf');
      
    }

    // telecharger facture stylimmo
    public  function download_pdf_facture_stylimmo($compromis_id)
    {

        $compromis = Compromis::where('id', Crypt::decrypt($compromis_id))->first();
        $mandataire = $compromis->user;
 
        $facture = Facture::where([ ['type','stylimmo'],['compromis_id',$compromis->id]])->first();
    
        // dd('ddd');
        $pdf = PDF::loadView('facture.pdf_stylimmo',compact(['compromis','mandataire','facture']));
        $path = storage_path('app/public/factures/facture.pdf');
        $pdf->save($path);
        // $pdf->download($path);
       return $pdf->download('facture.pdf');

  
       
      
    }
    

    
    
}
