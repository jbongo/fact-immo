<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ficheinfo;
use App\Outilinfo;
use App\Outilfiche;
use App\User;
use App\Historique;
use Auth;

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
            array_push($tab_valeur, $pal);
        }
        $tab_valeur = array_chunk( $tab_valeur, 6);
        

        $new_fiche =  Ficheinfo::create([
            "user_id"=> $request->user_id,           
        ]);
        
        foreach ($tab_valeur as $tab) {
            
            Outilfiche::create([
                "ficheinfo_id" => $new_fiche->id,
                "outilinfo_id" => $tab[0],
                "nom" => $tab[1],
                "identifiant" => $tab[3],
                "password" => $tab[4],
                "site_web" => $tab[2],
                "autre_champ" => $tab[5],
            ]);
        }
        
        $user = $new_fiche->user;
        
        Historique::create([
            "user_id"=> Auth::user()->id,
            "ressource_id"=> $new_fiche->id,
            "ressource"=> "ficheinfo",
            "action"=> "a créé la fiche info de $user->nom  $user->prenom",
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
        $champs = $fiche->outilfiche;
        
      
        $mandataire = $fiche->user;
        $outils = Outilinfo::where('archive', false)->get();
     
        return view('fiche_info.edit',compact('fiche', 'champs','outils','mandataire') );
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
        

        $tab_valeur = array_chunk( $tab_valeur, 6);

       
        $fiche = Ficheinfo::where('user_id', $mandataire_id)->first();

        foreach ($tab_valeur as $tab) {
            
          
            $outilfiche = Outilfiche::where('id', $tab[0])->first();
            
            $outilfiche->nom = $tab[1];
            $outilfiche->identifiant = $tab[3];
            $outilfiche->password = $tab[4];
            $outilfiche->site_web = $tab[2];
            $outilfiche->autre_champ = $tab[5];
            
            $outilfiche->update();
            
         }
     
         $user = $fiche->user;
        
         Historique::create([
             "user_id"=> Auth::user()->id,
             "ressource_id"=> $fiche->id,
             "ressource"=> "ficheinfo",
             "action"=> "a modifié la fiche info de $user->nom  $user->prenom",
         ]);
        
   
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
        $champs =$fiche->outilfiche;
    
        // on sauvegarde la fiche dans le repertoire du mandataire
        $path = storage_path('app/public/'.$mandataire->id.'/fiche');
    
        if(!File::exists($path))
            File::makeDirectory($path, 0755, true);
     
        $path = $path.'/fiche_outil.pdf';
     
        // dd($path);
        // $path = storage_path('app/public/factures/facture_honoraire_'.$facture->numero.'.pdf');
    
        $fiche->url = $path ;
    
    
        $fiche->update();
        
        // dd($champs);
     
          
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
