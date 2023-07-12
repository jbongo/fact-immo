<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use App\Individu;
use App\Offreachat;
use App\Entite;
use App\Typecontact;
use Auth;
use Crypt;
use File;
use Storage;

class OffreachatController extends Controller
{
    public function make_directory(){
        $path = storage_path('app/public/offres');
        if(!File::exists($path))
            File::makeDirectory($path, 0644, true);
        return $path;
    }


    public function storexx(Request $data, $id){
        $data['entite_id'] = DecryptId($data['entite_id']);
        $data['suiviaffaire_id'] = DecryptId($id);
        $data->validate([
            'montant' => 'required|numeric',
            'frais_agence' => 'required|numeric',
            'date_debut'=>'required|date|before:tomorrow',
            'date_expiration' => 'required|date|after:date_debut'
        ]);
        $offre = Offreachat::create($data->all());
        if($offre->suiviaffaire->statut = "debut")
            $offre->suiviaffaire->statut = "offre";
        $offre->suiviaffaire->update();
        $this->print($offre);
        return redirect()->back()->with('ok', 'Offre ajoutée !');
    }


    /**
    * Accepter ou réfuser une offre
    */
    public function accepter($offre_id, $statut){

        $offre = Offreachat::findOrFail(Crypt::decrypt($offre_id));
       
        $offre->statut = $statut;
        if ($statut == 1){
            
            $bien = $offre->bien;
            $bien->statut = "offre";
          
            $listoffres = $offre->bien->offreachats->where('id', '!=', $offre->id);
            foreach ($listoffres as $one){
                $one->statut = 2 ;
                $one->update();
            }
            $bien->update();
        }
        $offre->update();
        
        return "true";
    }


    /**
    * Télécharger d'une offre d'achat
    */
    public function download($id){
    
        $offre = Offreachat::findOrFail(Crypt::decrypt($id));
        $file = storage_path('app/public/offres/').$offre->fichier_pdf;
        /*if(!File::exists($file))
            abort(404);*/
        $filename = "offre_achat".$offre->id.".pdf" ;
        return response()->download($file,$filename);
        return $file; 
        return Storage::get($file);
    }
    
    
    /**
    * Ajout d'une offre d'achat
    */
    public function store(Request $request){
    

    
        $request->validate([
            "bien_id" => "required",
            "contact_id" => "required",
            "montant" => "required",
            "frais_agence" => "required",
            "date_debut" => "required",

        ]);
        
        
        if($request->ajouter_offreur == "on"){
           
        
            if($request->nature_offreur == "Personne seule"){
                
                $request->validate([
                    "email_offreur"=>"required|email",
                    "nom_offreur"=>"required|string",
                    "prenom_offreur"=>"required|string",
                    "civilite_offreur"=>"required|string"
                ]);
               
            }elseif($request->nature_offreur == "Personne morale"){
                $request->validate([
                    "email_offreur"=>"required|email",
                    "raison_sociale_offreur"=>"required|string"
                ]);
            }elseif($request->nature_offreur == "Couple"){
                $request->validate([
                    "email1_offreur"=>"required|email",
                    "email2_offreur"=>"email",
                    "nom1_offreur"=>"required|string",
                    "nom2_offreur"=>"required|string",
                    "civilite1_offreur"=>"required|string",
                    "civilite2_offreur"=>"required|string",
                ]);
            }elseif($request->nature_offreur == "Groupe"){
                $request->validate([
                    "email_offreur"=>"required|email",
                    "nom_groupe_offreur"=>"required|string",
                ]);
            }
            
            $contact = Contact::create([
                "user_id"=> Auth::user()->id,
                "nature"=> $request->nature_offreur,
                "type"=> $request->type_offreur,
                "note" => $request->note_offreur,
                         
            ]);
            $typeContact = Typecontact::where('type', 'Acquereur')->first();
            
            $contact->typeContacts()->attach($typeContact->id);
      
            if($request->type == "individu"){
            
                $individu = Individu::create([
                    "user_id"=> Auth::user()->id,     
                    "contact_id" => $contact->id,
                    
                    "civilite" => $request->civilite_offreur,
                    "nom" => $request->nom_offreur,
                    "prenom" => $request->prenom_offreur,    
                    "nationalite" => $request->nationalite_offreur,        
                    "adresse" => $request->adresse_offreur,
                    "code_postal" => $request->code_postal_offreur,
                    "ville" => $request->ville_offreur,
                    "telephone_fixe" => $request->telephone_fixe_offreur,
                    "telephone_mobile" => $request->telephone_mobile_offreur,
                    "email" => $request->email_offreur,
                    
                    "civilite1" => $request->civilite1_offreur,
                    "nom1" => $request->nom1_offreur,
                    "prenom1" => $request->prenom1_offreur,
                    "adresse1" => $request->adresse1_offreur,
                    "code_postal1" => $request->code_postal1_offreur,
                    "ville1" => $request->ville1_offreur,
                    "telephone_fixe1" => $request->telephone_fixe1_offreur,
                    "telephone_mobile1" => $request->telephone_mobile1_offreur,
                    "email1" => $request->email1_offreur,
                    
                    "civilite2" => $request->civilite2_offreur,
                    "nom2" => $request->nom2_offreur,
                    "prenom2" => $request->prenom2_offreur,
                    "adresse2" => $request->adresse2_offreur,
                    "code_postal2" => $request->code_postal2_offreur,
                    "ville2" => $request->ville2_offreur,
                    "telephone_fixe2" => $request->telephone_fixe2_offreur,
                    "telephone_mobile2" => $request->telephone_mobile2_offreur,
                    "email2" => $request->email2_offreur,                
                 
                ]);
                
            }else{
                
                $entite = Entite::create([
                    "user_id"=> Auth::user()->id,                
                    "contact_id" => $contact->id,
                    "forme_juridique" => $request->forme_juridique_offreur,
                    "nom" => $request->nom_groupe_offreur,
                    "type" => $request->type_groupe_offreur,
                    "raison_sociale" => $request->raison_sociale_offreur,
                    "adresse" => $request->adresse_offreur,
                    "code_postal" => $request->code_postal_offreur,
                    "ville" => $request->ville_offreur,
                    "telephone_fixe" => $request->telephone_fixe_offreur,
                    "telephone_mobile" => $request->telephone_mobile_offreur,
                    "email" => $request->email_offreur,
                    "numero_siret" => $request->numero_siret_offreur,                        
                 
                ]);
            }
            
            
        } // SI ON CHOISI UN CONTACT EXISTANT
        else{
        
            $contact = Contact::where('id', $request->contact_id)->first();
        }
           
    
    
        $path = storage_path('app/public/offres');
        
    
        if(!File::exists($path))
            File::makeDirectory($path, 0644, true);
            
        $filename = $request->fichier_pdf->getClientOriginalName();
        $request->fichier_pdf->move($path, $filename);
            
            $offreachat = Offreachat::create([
                "bien_id" => $request->bien_id,                     
                "contact_id" => $contact->id,                     
                "date_debut" => $request->date_debut,                     
                "date_expiration" => $request->date_expiration,                     
                "montant" => $request->montant,             
                "frais_agence" => $request->frais_agence,             
                "fichier_pdf" => $filename,             
            ]);
            
        
            
            
            return redirect()->back()->with('ok', "Offre d'achat ajoutée");
            
        }
        
        
        /**
        * Modification d'une offre d'achat
        */
        
        public function update(Request $request, $offreachat_id){
        
    
    
        
            $request->validate([
                "date_visite" => "required"
            ]);       
            
            
            $contact = Contact::where('id', $request->contact_id)->first();
            $offreachat = Offreachat::where('id', Crypt::decrypt($offreachat_id))->first();    
            
                  
            $offreachat->contact_id = $contact->id;                     
            $offreachat->date = $request->date_visite;                     
            $offreachat->heure = $request->heure_visite;                     
            $offreachat->compte_rendu = $request->notes;             
            $offreachat->update();
            
            return redirect()->back()->with('ok', "Offre d'achat ajoutée");
                
        }
        
         /**
        * Suppression d'une offre d'achat
        */
        
        public function delete($offreachat_id){
    
       
            $offreachat = Offreachat::where('id', Crypt::decrypt($offreachat_id))->first();    
           
         
            return $offreachat->delete() == true ? "true" : "false";        
            return redirect()->back()->with('ok', "Offre d'achat supprimée");
                
        }
}
