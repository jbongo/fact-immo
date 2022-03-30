<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Commandefournisseur;
use App\Fournisseur;
use Illuminate\Support\Facades\Crypt;


class CommandefournisseurController extends Controller
{
   
    /**
     *Afficher le formulaire de création de commande d'un fournisseur
     *
     * @return \Illuminate\Http\Response
     */
    public function create($fournisseur_id)
    {
        //
        
        $fournisseur = Fournisseur::where('id', Crypt::decrypt($fournisseur_id) )->first();
        
        return view('fournisseur.commande.add', compact('fournisseur'));
    }

    /**
     * Enregistrer le commande du fournisseur
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        Commandefournisseur::create([
            "fournisseur_id" => $request->fournisseur_id,          
            "numero_commande" => $request->numero_commande, 
            "description" => $request->description,             
            "date_commande" => $request->date_commande, 
           
        ]);

        return redirect()->route('fournisseur.show', Crypt::encrypt($request->fournisseur_id))->with('ok', __("Nouvelle commande ajoutée:  << $request->numero_commande >> ")  );

        // return redirect()->back()->with('ok', __("Nouvelle commande fournisseur ajoutée ")  );
    }

   

    /**
     * Afficher le formulaire de modification de commande d'un fournisseur
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($fournisseur_id)
    {
        $commandefournisseur = Commandefournisseur::where('id', Crypt::decrypt($fournisseur_id) )->first();
        return view('fournisseur.commande.edit', compact('commandefournisseur'));
        
    }

    /**
     *  Enregistrer le commande du fournisseur
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $fournisseur_id)
    {
    
        $commandefournisseur = Commandefournisseur::where('id', Crypt::decrypt($fournisseur_id) )->first();
    
        $commandefournisseur->fournisseur_id = $request->fournisseur_id; 
        $commandefournisseur->libelle = $request->libelle;              
        $commandefournisseur->numero_commande = $request->numero_commande; 
        $commandefournisseur->numero_client = $request->numero_client; 
        $commandefournisseur->description = $request->description;             
        $commandefournisseur->date_deb = $request->date_deb; 
        $commandefournisseur->date_fin = $request->date_fin; 
        
        $commandefournisseur->update();
        return redirect()->back()->with('ok', __("commande fournisseur modifié ")  );
        
        
    }
    
    /**
     *  Archiver le commande du fournisseur
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function archiver($fournisseur_id)
    {
    
        $commandefournisseur = Commandefournisseur::where('id', $fournisseur_id )->first();
    
        $commandefournisseur->archive = true;       
        
        $commandefournisseur->update();
        
        return redirect()->route('fournisseur.show', Crypt::encrypt($fournisseur_id))->with('ok', __("commande  <<$$commandefournisseur->libelle>> archivé")  );

        
        
    }

}
