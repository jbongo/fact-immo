<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ficheinfo;
use App\Outilinfo;
use App\User;

use PDF;
use Illuminate\Support\Facades\File ;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

class FicheinfoController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fiches = Ficheinfo::all();
        return view('fiche_info.index',compact('fiches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($mandataire_id)
    {
        $mandataire = User::where('id', $mandataire_id)->first();
        $outils = Outilinfo::where('archive', false)->get();
        
        if($mandataire != null){        
            return view('fiche_info.add', compact('mandataire', 'outils'));
        }else{
            return  redirect()->back();
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        
        $fiche = Ficheinfo::where('user_id', $request->user_id)->first();
        if($fiche != null){
            return redirect()->route('fiche_info.edit', $request->user_id)->with('ok', "Fiche existante");
        }
        
        $champs = $request->all();
        // Suppression du premier champs token_
        array_shift($champs);
        
        // Suppression du champ user_id en dernière position
        array_pop($champs);

        $tab_valeur = array();
        foreach($champs as $key => $pal)
        {
            // pour chaque element du tableau, on extrait la valeur
            // $tmp = substr($pal , strpos($pal, " => ") + 1, strlen($pal));
            array_push($tab_valeur, $pal);
        }
        $tab_valeur = array_chunk( $tab_valeur, 5);

        Ficheinfo::create([
            "user_id"=> $request->user_id,           
            "champs_valeurs"=> json_encode($tab_valeur),
        ]);
        
        return redirect()->route('fiche_info.edit', $request->user_id)->with('ok', "Nouvelle fiche ajoutée");
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
    public function edit($mandataire_id)
    {
        
        $fiche = Ficheinfo::where('user_id', $mandataire_id)->first();
        $champs = json_decode($fiche->champs_valeurs);
        
      
        $mandataire = $fiche->user;
     
        return view('fiche_info.edit',compact('fiche', 'champs','mandataire') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $mandataire_id)
    {
      
        $champs = $request->all();

        // Suppression du premier champs token_
        array_shift($champs);
        
        $tab_valeur = array();
        foreach($champs as $key => $pal)
        {
            array_push($tab_valeur, $pal);
        }
        

        $tab_valeur = array_chunk( $tab_valeur, 5);

       
        $fiche = Ficheinfo::where('user_id', $mandataire_id)->first();
     
        $fiche->champs_valeurs = json_encode($tab_valeur);
        
        $fiche->update();
        return redirect()->route('fiche_info.edit', $mandataire_id)->with('ok', "Fiche modifiée");

    }
    
    
    /**
     * Génération Fiche outil pdf
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fiche_pdf($mandataire_id)
    {
      

        $fiche = Ficheinfo::where('user_id', Crypt::decrypt($mandataire_id) )->first();
        
        $mandataire = $fiche->user;
        $champs = json_decode($fiche->champs_valeurs);
    
        // on sauvegarde la fiche dans le repertoire du mandataire
        $path = storage_path('app/public/'.$mandataire->id.'/fiche');
    
        if(!File::exists($path))
            File::makeDirectory($path, 0755, true);
     
        $path = $path.'/fiche_outil.pdf';
     
        // dd($path);
        // $path = storage_path('app/public/factures/facture_honoraire_'.$facture->numero.'.pdf');
    
        $fiche->url = $path ;
    
    
        $fiche->update();
        
     
          
        $pdf = PDF::loadView('fiche_info.fiche_pdf',compact(['fiche','mandataire', 'champs']));
           
        $pdf->save($path);
        // $pdf->download($path);
        return $pdf->download("fiche_outil.pdf");
      
    
        return view('fiche_info.fiche_pdf', compact('fiche', 'mandataire', 'champs') );
        
    }
        
    /**
     * Réinitialiser la fiche outil
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reiniatiliser( $mandataire_id)
    {
      
       
        $fiche = Ficheinfo::where('user_id', Crypt::decrypt($mandataire_id) )->first();

        
        $fiche->delete();
        return redirect()->route('fiche_info.create', Crypt::decrypt($mandataire_id) )->with('ok', "Fiche réinitialisée");

    }

}
