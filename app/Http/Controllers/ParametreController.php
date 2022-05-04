<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Parametre;
use App\Tva;
use App\Historique;
use Auth;

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
            $comm_parrain = unserialize($parametre['comm_parrain']);
            
            $tva_prochaine = Tva::where('est_tva_prochaine', true)->first(); 
            return view ('parametre.generaux.edit', compact(['parametre','comm_parrain','tva_prochaine']));
        }
    }


     /**
     * Création des paramètres généraux.
     *
     * @return \Illuminate\Http\Response
     */
    public function store_parametre_generaux(Request $request)
    {

        // dd($request->all());
    
        $comm_parrain = array();

        $comm_parrain["p_1_1"] = $request->p_1_1;
        $comm_parrain["p_1_2"] = $request->p_1_2;
        $comm_parrain["p_1_3"] = $request->p_1_3;
        $comm_parrain["p_1_n"] = $request->p_1_n;
        $comm_parrain["p_2_1"] = $request->p_2_1;
        $comm_parrain["p_2_2"] = $request->p_2_2;
        $comm_parrain["p_2_3"] = $request->p_2_3;
        $comm_parrain["p_2_n"] = $request->p_2_n;
        $comm_parrain["p_3_1"] = $request->p_3_1;
        $comm_parrain["p_3_2"] = $request->p_3_2;
        $comm_parrain["p_3_3"] = $request->p_3_3;
        $comm_parrain["p_3_n"] = $request->p_3_n;
        $comm_parrain["seuil_parr_1"] = $request->seuil_parr_1;
        $comm_parrain["seuil_fill_1"] = $request->seuil_fill_1;
        $comm_parrain["seuil_parr_2"] = $request->seuil_parr_2;
        $comm_parrain["seuil_fill_2"] = $request->seuil_fill_2;
        $comm_parrain["seuil_parr_3"] = $request->seuil_parr_3;
        $comm_parrain["seuil_fill_3"] = $request->seuil_fill_3;

        $comm_parrain = serialize($comm_parrain);

        // dd($comm_parrain);

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
        "comm_parrain" => $comm_parrain,
        "nb_jour_max_demande" => $request->nb_jour_max_demande,
        
        "num_carte_pro" => $request->num_carte_pro,
        "carte_pro_delivre_le" => $request->carte_pro_delivre_le,
        "carte_pro_delivre_par" => $request->carte_pro_delivre_par,
        "adresse_organisme_de_garantie" => $request->adresse_organisme_de_garantie,
        "gerant" => $request->gerant,
        "capital" => $request->capital,
    ]);
    

    
     return redirect('parametre/generaux/create');

    }


    /**
     * Modification des paramètres généraux.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_parametre_generaux(Request $request)
    {
    
        $parametre = Parametre::first();
    
    
    
        // dd($request->all());
    
        $tva = Tva::where('id',$parametre->tva_id)->first();
        $tva_prochaine = Tva::where('est_tva_prochaine',true)->first();
        
        $tva->tva_actuelle = $request->tva_actuelle;
        $tva->date_debut_tva_actuelle = $request->date_debut_tva_actuelle;
        
        
        if($request->tva_prochaine != null && $tva_prochaine == null){
        
            Tva::create([
                "tva_actuelle" => $request->tva_prochaine,
                "date_debut_tva_actuelle" => $request->date_debut_tva_prochaine,
                
                "est_tva_prochaine" => true,
                "actif" => false,
            ]);
            
    
    
        }elseif($request->tva_prochaine != null && $tva_prochaine != null){
        
            $tva_prochaine->tva_actuelle = $request->tva_prochaine;
            $tva_prochaine->date_debut_tva_actuelle = $request->date_debut_tva_prochaine;
            
            $tva_prochaine->update();
        
        }
        
      
    
        $tva->update();
    
    
        $comm_parrain = array();

        $comm_parrain["p_1_1"] = $request->p_1_1;
        $comm_parrain["p_1_2"] = $request->p_1_2;
        $comm_parrain["p_1_3"] = $request->p_1_3;
        $comm_parrain["p_1_n"] = $request->p_1_n;
        $comm_parrain["p_2_1"] = $request->p_2_1;
        $comm_parrain["p_2_2"] = $request->p_2_2;
        $comm_parrain["p_2_3"] = $request->p_2_3;
        $comm_parrain["p_2_n"] = $request->p_2_n;
        $comm_parrain["p_3_1"] = $request->p_3_1;
        $comm_parrain["p_3_2"] = $request->p_3_2;
        $comm_parrain["p_3_3"] = $request->p_3_3;
        $comm_parrain["p_3_n"] = $request->p_3_n;
        $comm_parrain["seuil_parr_1"] = $request->seuil_parr_1;
        $comm_parrain["seuil_fill_1"] = $request->seuil_fill_1;
        $comm_parrain["seuil_parr_2"] = $request->seuil_parr_2;
        $comm_parrain["seuil_fill_2"] = $request->seuil_fill_2;
        $comm_parrain["seuil_parr_3"] = $request->seuil_parr_3;
        $comm_parrain["seuil_fill_3"] = $request->seuil_fill_3;
        
        $comm_parrain = serialize($comm_parrain);
    
    
        $parametre->raison_sociale = $request->raison_sociale;
        $parametre->numero_siret = $request->numero_siret;
        $parametre->numero_rcs = $request->numero_rcs;
        $parametre->numero_tva = $request->numero_tva;
        $parametre->adresse = $request->adresse;
        $parametre->code_postal = $request->code_postal;
        $parametre->ville = $request->ville;
        $parametre->ca_imposable = $request->ca_imposable;
        $parametre->comm_parrain = $comm_parrain;
        $parametre->nb_jour_max_demande = $request->nb_jour_max_demande;
       
        $parametre->num_carte_pro  = $request->num_carte_pro;
        $parametre->carte_pro_delivre_le  = $request->carte_pro_delivre_le;
        $parametre->carte_pro_delivre_par  = $request->carte_pro_delivre_par;
        $parametre->adresse_organisme_de_garantie  = $request->adresse_organisme_de_garantie;
        $parametre->gerant  = $request->gerant;
        $parametre->capital  = $request->capital;
        
        $parametre->update();
        
        Historique::create([
            "user_id"=> Auth::user()->id,
            "ressource_id"=> $parametre->id,
            "ressource"=> "parametre",
            "action"=> "a modifié les paramètres généraux",
        ]);
        
        return redirect('parametre/generaux/create');

    }

}
