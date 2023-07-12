<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use App\Individu;
use App\Visite;
use App\Entite;
use App\Typecontact;
use Auth;

use Crypt;

class VisiteController extends Controller
{
  
    /**
    * Ajout d'une visite
    */
    
    public function store(Request $request){
    


    
    $request->validate([
        "date_visite" => "required"
    ]);
    
    if($request->ajouter_visiteur == "on"){
       
    
        if($request->nature_visiteur == "Personne seule"){
            
            $request->validate([
                "email_visiteur"=>"required|email",
                "nom_visiteur"=>"required|string",
                "prenom_visiteur"=>"required|string",
                "civilite_visiteur"=>"required|string"
            ]);
           
        }elseif($request->nature_visiteur == "Personne morale"){
            $request->validate([
                "email_visiteur"=>"required|email",
                "raison_sociale_visiteur"=>"required|string"
            ]);
        }elseif($request->nature_visiteur == "Couple"){
            $request->validate([
                "email1_visiteur"=>"required|email",
                "email2_visiteur"=>"email",
                "nom1_visiteur"=>"required|string",
                "nom2_visiteur"=>"required|string",
                "civilite1_visiteur"=>"required|string",
                "civilite2_visiteur"=>"required|string",
            ]);
        }elseif($request->nature_visiteur == "Groupe"){
            $request->validate([
                "email_visiteur"=>"required|email",
                "nom_groupe_visiteur"=>"required|string",
            ]);
        }
        
        $contact = Contact::create([
            "user_id"=> Auth::user()->id,
            "nature"=> $request->nature_visiteur,
            "type"=> $request->type_visiteur,
            "note" => $request->note_visiteur,
                     
        ]);
        $typeContact = Typecontact::where('type', 'Acquereur')->first();
        
        $contact->typeContacts()->attach($typeContact->id);
  
        if($request->type == "individu"){
        
            $individu = Individu::create([
                "user_id"=> Auth::user()->id,     
                "contact_id" => $contact->id,
                
                "civilite" => $request->civilite_visiteur,
                "nom" => $request->nom_visiteur,
                "prenom" => $request->prenom_visiteur,    
                "nationalite" => $request->nationalite_visiteur,        
                "adresse" => $request->adresse_visiteur,
                "code_postal" => $request->code_postal_visiteur,
                "ville" => $request->ville_visiteur,
                "telephone_fixe" => $request->telephone_fixe_visiteur,
                "telephone_mobile" => $request->telephone_mobile_visiteur,
                "email" => $request->email_visiteur,
                
                "civilite1" => $request->civilite1_visiteur,
                "nom1" => $request->nom1_visiteur,
                "prenom1" => $request->prenom1_visiteur,
                "adresse1" => $request->adresse1_visiteur,
                "code_postal1" => $request->code_postal1_visiteur,
                "ville1" => $request->ville1_visiteur,
                "telephone_fixe1" => $request->telephone_fixe1_visiteur,
                "telephone_mobile1" => $request->telephone_mobile1_visiteur,
                "email1" => $request->email1_visiteur,
                
                "civilite2" => $request->civilite2_visiteur,
                "nom2" => $request->nom2_visiteur,
                "prenom2" => $request->prenom2_visiteur,
                "adresse2" => $request->adresse2_visiteur,
                "code_postal2" => $request->code_postal2_visiteur,
                "ville2" => $request->ville2_visiteur,
                "telephone_fixe2" => $request->telephone_fixe2_visiteur,
                "telephone_mobile2" => $request->telephone_mobile2_visiteur,
                "email2" => $request->email2_visiteur,                
             
            ]);
            
        }else{
            
            $entite = Entite::create([
                "user_id"=> Auth::user()->id,                
                "contact_id" => $contact->id,
                "forme_juridique" => $request->forme_juridique_visiteur,
                "nom" => $request->nom_groupe_visiteur,
                "type" => $request->type_groupe_visiteur,
                "raison_sociale" => $request->raison_sociale_visiteur,
                "adresse" => $request->adresse_visiteur,
                "code_postal" => $request->code_postal_visiteur,
                "ville" => $request->ville_visiteur,
                "telephone_fixe" => $request->telephone_fixe_visiteur,
                "telephone_mobile" => $request->telephone_mobile_visiteur,
                "email" => $request->email_visiteur,
                "numero_siret" => $request->numero_siret_visiteur,                        
             
            ]);
        }
        
        
    } // SI ON CHOISI UN CONTACT EXISTANT
    else{
    
        $contact = Contact::where('id', $request->visiteur_id)->first();
    }
       

        
        $visite = Visite::create([
            "bien_id" => $request->bien_id,                     
            "contact_id" => $contact->id,                     
            "date" => $request->date_visite,                     
            "heure" => $request->heure_visite,                     
            "compte_rendu" => $request->notes,             
        ]);
        return redirect()->back()->with('ok', "Visite ajoutée");
        
    }
    
    
    /**
    * Modification d'une visite
    */
    
    public function update(Request $request, $visite_id){
    


    
        $request->validate([
            "date_visite" => "required"
        ]);       
        
        
        $contact = Contact::where('id', $request->visiteur_id)->first();
        $visite = Visite::where('id', Crypt::decrypt($visite_id))->first();    
        
              
        $visite->contact_id = $contact->id;                     
        $visite->date = $request->date_visite;                     
        $visite->heure = $request->heure_visite;                     
        $visite->compte_rendu = $request->notes;             
        $visite->update();
        
        return redirect()->back()->with('ok', "Visite ajoutée");
            
    }
    
     /**
    * Suppression d'une visite
    */
    
    public function delete($visite_id){

   
        $visite = Visite::where('id', Crypt::decrypt($visite_id))->first();    
       
     
        return $visite->delete() == true ? "true" : "false";        
        return redirect()->back()->with('ok', "Visite supprimée");
            
    }
}
