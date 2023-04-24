<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Utilisateur;
use App\Entite;
use App\Individu;
use App\Contact;
use App\EntiteIndividu;
use App\Http\Requests\ContactsValidator;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * CRUD display list entite.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role === "admin"){
            $contacts = Contact::all();
        }else{
            $contacts = Contact::where("user_id", $user->id)->get();
        
        }
       
        return view('contact.index', compact('contacts')); 
    }
    
    
    /**
     * Page de création d'un contact
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
        return view('contact.add'); 
    }
    
    /**
     * Affichage un contact
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function show($contact_id)
    {
        $contact = Contact::where('id', Crypt::decrypt($contact_id))->first();
        
        if($contact->type == "entité"){
            return view('contact.show_entite', compact('contact')); 
            
        }else{     
            return view('contact.show_individu', compact('contact')); 
            
        }
    }
    
    /**
     * Page modification contact
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function edit($contact_id)
    {
        $contact = Contact::where('id', Crypt::decrypt($contact_id))->first();
        
        if($contact->type == "entité"){
            $infosContact = $contact->entite;
        }else{
            $infosContact = $contact->individu;
      
        }
        

        return view('contact.edit', compact('contact', 'infosContact')); 
    }
    
    
    /**
     * Enregistrer les contacts
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
          
        
        if($request->type_contact == "Personne seule"){
            
            $request->validate([
                "email"=>"required|email",
                "nom"=>"required|string",
                "prenom"=>"required|string",
                "civilite"=>"required|string"
            ]);
           
        }elseif($request->type_contact == "Personne morale"){
            $request->validate([
                "email"=>"required|email",
                "raison_sociale"=>"required|string"
            ]);
        }elseif($request->type_contact == "Couple"){
            $request->validate([
                "email1"=>"required|email",
                "email2"=>"email",
                "nom1"=>"required|string",
                "nom2"=>"required|string",
                "prenom1"=>"required|string",
                "prenom2"=>"required|string",
                "civilite1"=>"required|string",
                "civilite2"=>"required|string",
            ]);
        }elseif($request->type_contact == "Groupe"){
            $request->validate([
                "email"=>"required|email",
                "nom_groupe"=>"required|string",
            ]);
        }
        
        $contact = Contact::create([
            "user_id"=> Auth::user()->id,
            "nature"=> $request->nature,
            "type"=> $request->type,
            "est_partenaire" => $request->statut == "Partenaire" ? true : false,
            "est_acquereur" => $request->statut == "Acquereur" ? true : false,
            "est_proprietaire" => $request->statut == "Propriétaire" ? true : false,
            "est_locataire" => $request->statut == "Locataire" ? true : false,
            "est_notaire" => $request->metier == "Notaire" ? true : false,
            "est_prospect" => $request->metier == "Prospect" ? true : false,
            "est_fournisseur" => $request->metier == "Fournisseur" ? true : false,
            "note" => $request->note,
                     
        ]);
        
  
        if($request->type == "individu"){
        
            $individu = Individu::create([
                "user_id"=> Auth::user()->id,     
                "contact_id" => $contact->id,
                
                "civilite" => $request->civilite,
                "nom" => $request->nom,
                "prenom" => $request->prenom,
                "date_naissance" => $request->date_naissance,
                "lieu_naissance" => $request->lieu_naissance,
                "nationalite" => $request->nationalite,
                "prenom_pere" => $request->prenom_pere,
                "nom_prenom_mere" => $request->nom_prenom_mere,
                "situation_matrimoniale" => $request->situation_matrimoniale,
                "nom_jeune_fille" => $request->nom_jeune_fille,
                "adresse" => $request->adresse,
                "code_postal" => $request->code_postal,
                "ville" => $request->ville,
                "telephone_fixe" => $request->telephone_fixe,
                "telephone_mobile" => $request->telephone_mobile,
                "email" => $request->email,
                
                "civilite1" => $request->civilite1,
                "nom1" => $request->nom1,
                "prenom1" => $request->prenom1,
                "adresse1" => $request->adresse1,
                "code_postal1" => $request->code_postal1,
                "ville1" => $request->ville1,
                "telephone_fixe1" => $request->telephone_fixe1,
                "telephone_mobile1" => $request->telephone_mobile1,
                "email1" => $request->email1,
                
                "civilite2" => $request->civilite2,
                "nom2" => $request->nom2,
                "prenom2" => $request->prenom2,
                "adresse2" => $request->adresse2,
                "code_postal2" => $request->code_postal2,
                "ville2" => $request->ville2,
                "telephone_fixe2" => $request->telephone_fixe2,
                "telephone_mobile2" => $request->telephone_mobile2,
                "email2" => $request->email2,                
             
            ]);
            
        }else{
            
            $entite = Entite::create([
                "user_id"=> Auth::user()->id,                
                "contact_id" => $contact->id,
                "forme_juridique" => $request->forme_juridique,
                "raison_sociale" => $request->raison_sociale,
                "adresse" => $request->adresse,
                "code_postal" => $request->code_postal,
                "ville" => $request->ville,
                "telephone" => $request->telephone,
                "email" => $request->email,
                "numero_siret" => $request->numero_siret,
                "code_naf" => $request->code_naf,
                "date_immatriculation" => $request->date_immatriculation,
                "numero_rsac" => $request->numero_rsac,
                "numero_assurance" => $request->numero_assurance,
                "numero_tva" => $request->numero_tva,
                "numero_rcs" => $request->numero_rcs,
                "rib_bancaire" => $request->rib_bancaire,
                "iban" => $request->iban,
                "bic" => $request->bic,                             
             
            ]);
        }
       

        return redirect()->route('contact.index')->with('ok', 'Contact ajouté');
   
    }
    
    
    
    /**
     * CRUD display list entite.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function index_entite()
    {
        $user = Auth::user();
        if ($user->role === "admin" || $user->role === "salarie")
            $query = Entite::all();
        else if($user->role === "commercial")
            $query = Entite::where("utilisateur_id", $user->id)->get();
        else
            abort(404);
        return view('contact.index_entite', compact('query')); 
    }

    /**
     * CRUD display list individu.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function index_individu()
    {
        $user = Auth::user();
        if ($user->role === "admin" || $user->role === "salarie")
            $query = Individu::all();
        else if($user->role === "commercial")
            $query = Individu::where("utilisateur_id", $user->id)->get();
        else
            abort(404);
        return view('contact.index_individu', compact('query')); 
    }

}
