<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Baremehonoraire;
use Illuminate\Support\Facades\Crypt;

class BaremehonoraireController extends Controller
{
    /**
    * Affiche la page de barème d'honoraire
    */
    
    public function index(){
        
        $baremes = Baremehonoraire::all();
        return view('parametre.bareme_honoraire.index', compact('baremes'));
    
    }
    
    /**
    * Page d'ajout de barème d'honoraire
    */
    
    public function create(){     
       
        return view('parametre.bareme_honoraire.add');
    }
    
    /**
    * Ajout de barème d'honoraire
    */
    
    public function store(Request $request){     
       
      
       $request->validate([
            "prix_min" => "required",
            "prix_max" => "required",
        ]);
        
       if($request->est_forfait == "false"){
            $request->validate([
                "pourcentage" => "required",
            ]);
       
       }else{
           if($request->forfait_max == "null"){
                $request->validate([
                    "forfait_min" => "required",
                ]);
           }elseif($request->forfait_min == "null"){
                $request->validate([
                    "forfait_max" => "required",
                ]);
           }
        
       }
       
    
        Baremehonoraire::create([
            "prix_min" => $request->prix_min,
            "prix_max" => $request->prix_max,
            "forfait_min" => $request->forfait_min,
            "forfait_max" => $request->forfait_max,
            "pourcentage" => $request->pourcentage,
            "est_forfait" => $request->est_forfait == "true" ? true: false,        
        ]);
        return redirect()->route('bareme_honoraire.index')->with('ok', ("Barème créé"));
    }
    
    
    /**
    * Page de modification de barème d'honoraire
    */
    
    public function edit($bareme_id){     
       
       $bareme = Baremehonoraire::where('id', Crypt::decrypt($bareme_id))->first();
        return view('parametre.bareme_honoraire.edit', compact('bareme'));
    }
    
    
 
    
    /**
    * Modification de barème d'honoraire
    */
    
    public function update(Request $request, $bareme_id){     
       
      
       $request->validate([
            "prix_min" => "required",
            "prix_max" => "required",
        ]);
        
       if($request->est_forfait == "false"){
            $request->validate([
                "pourcentage" => "required",
            ]);
       
       }else{
           if($request->forfait_max == "null"){
                $request->validate([
                    "forfait_min" => "required",
                ]);
           }elseif($request->forfait_min == "null"){
                $request->validate([
                    "forfait_max" => "required",
                ]);
           }
        
       }
       
        $bareme = Baremehonoraire::where('id', $bareme_id)->first();

        $bareme->prix_min = $request->prix_min;
        $bareme->prix_max = $request->prix_max;
        $bareme->forfait_min = $request->forfait_min;
        $bareme->forfait_max = $request->forfait_max;
        $bareme->pourcentage = $request->pourcentage;
        $bareme->est_forfait = $request->est_forfait == "true" ? true: false;        
        
        $bareme->update();
    
        return redirect()->route('bareme_honoraire.index')->with('ok', ("Barème modifié"));
    }
    
    /**
    *  Supprimer un barème
    */    
    public function delete($bareme_id){     
       
        $bareme = Baremehonoraire::where('id', Crypt::decrypt($bareme_id))->first();
        $bareme->delete();
        
        return "delete";
    }
    
}
