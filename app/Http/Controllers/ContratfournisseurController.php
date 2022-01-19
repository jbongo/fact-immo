<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use App\Contratfournisseur;
use App\Fournisseur;

class ContratfournisseurController extends Controller
{
   

    /**
     *Afficher le formulaire de création de contrat d'un fournisseur
     *
     * @return \Illuminate\Http\Response
     */
    public function create($fournisseur_id)
    {
        //
        
        $fournisseur = Fournisseur::where('id', Crypt::decrypt($fournisseur_id) )->first();
        
        return view('fournisseur.contrat.add', compact('fournisseur'));
    }

    /**
     * Enregistrer le contrat du fournisseur
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        Contratfournisseur::create([
            "fournisseur_id" => $request->fournisseur_id, 
            "libelle" => $request->libelle,              
            "numero_contrat" => $request->numero_contrat, 
            "numero_client" => $request->numero_client, 
            "description" => $request->description,             
            "date_deb" => $request->date_deb, 
            "date_fin" => $request->date_fin, 
        ]);

        return redirect()->back()->with('ok', __("Nouveau contrat fournisseur ajouté ")  );
    }

   

    /**
     * Afficher le formulaire de modification de contrat d'un fournisseur
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($fournisseur_id)
    {
        $contratfournisseur = Contratfournisseur::where('id', Crypt::decrypt($fournisseur_id) )->first();
        return view('fournisseur.contrat.edit', compact('contratfournisseur'));
        
    }

    /**
     *  Enregistrer le contrat du fournisseur
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $fournisseur_id)
    {
    
        $contratfournisseur = Contratfournisseur::where('id', Crypt::decrypt($fournisseur_id) )->first();
    
        $contratfournisseur->fournisseur_id = $request->fournisseur_id; 
        $contratfournisseur->libelle = $request->libelle;              
        $contratfournisseur->numero_contrat = $request->numero_contrat; 
        $contratfournisseur->numero_client = $request->numero_client; 
        $contratfournisseur->description = $request->description;             
        $contratfournisseur->date_deb = $request->date_deb; 
        $contratfournisseur->date_fin = $request->date_fin; 
        
        $contratfournisseur->update();
        return redirect()->back()->with('ok', __("Contrat fournisseur modifié ")  );
        
        
    }
    
    /**
     *  Archiver le contrat du fournisseur
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function archiver($fournisseur_id)
    {
    
        $contratfournisseur = Contratfournisseur::where('id', $fournisseur_id )->first();
    
        $contratfournisseur->archive = true;       
        
        $contratfournisseur->update();
        
        return redirect()->route('fournisseur.show', Crypt::encrypt($fournisseur_id))->with('ok', __("Contrat  <<$$contratfournisseur->libelle>> archivé")  );

        
        
    }

}
