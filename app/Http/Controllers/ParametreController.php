<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Parametre;
use App\Tva;
use Config;
class ParametreController extends Controller
{
    
     /**
     * Création et modification des paramètres généraux.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_parametre_generaux()
    {


        $parametre = Parametre::first();
        // $parametre = null;
        
        if($parametre == null){
            return view ('parametre.generaux.create');
        }else{
            return view ('parametre.generaux.edit', compact(['parametre']));
        }
    }


     /**
     * Création des paramètres généraux.
     *
     * @return \Illuminate\Http\Response
     */
    public function store_parametre_generaux(Request $request)
    {
    
    $tva = Tva::create([
        "tva_actuelle" => $request->tva_actuelle,
        "date_debut_tva_actuelle" => $request->date_debut_tva_actuelle,
        "date_fin_tva_actuelle" => $request->date_fin_tva_actuelle,
        "tva_prochaine" => $request->tva_prochaine,
        "date_debut_tva_prochaine" => $request->date_debut_tva_prochaine,
    ]);


    
    Parametre::create([
        "tva_id" => $tva->id,
        "raison_sociale" => $request->raison_sociale,
        "numero_siret" => $request->numero_siret,
        "numero_rcs" => $request->numero_rcs,
        "numero_tva" => $request->numero_tva,
        "adresse" => $request->adresse,
        "code_postal" => $request->code_postal,
        "ville" => $request->ville,
        "ca_imposable" => $request->ca_imposable,
    ]);


    }


    /**
     * Modification des paramètres généraux.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_parametre_generaux(Request $request)
    {
    

    $parametre = Parametre::first();

    $tva = Tva::where('tva_id',$parametre->tva_id)->first();
    $tva->tva_actuelle = $request->tva_actuelle;
    $tva->date_debut_tva_actuelle = $request->date_debut_tva_actuelle;
    $tva->date_fin_tva_actuelle = $request->date_fin_tva_actuelle;
    $tva->tva_prochaine = $request->tva_prochaine;
    $tva->date_debut_tva_prochaine = $request->date_debut_tva_prochaine;

    $tva->update();


    $parametre->raison_sociale = $request->raison_sociale;
    $parametre->numero_siret = $request->numero_siret;
    $parametre->numero_rcs = $request->numero_rcs;
    $parametre->numero_tva = $request->numero_tva;
    $parametre->adresse = $request->adresse;
    $parametre->code_postal = $request->code_postal;
    $parametre->ville = $request->ville;
    $parametre->ca_imposable = $request->ca_imposable;
   
    $parametre->update();

    }

}
