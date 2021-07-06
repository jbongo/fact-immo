<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Prospect;
use App\Parametre;
use App\Contrat;
use App\Packpub;
use App\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File ;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendFicheProspect;
use App\Mail\SendModeleContrat;


use PDF;

class ProspectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prospects = Prospect::where('archive', false)->get();
        
        return view('prospect.index', compact('prospects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('prospect.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        
        $request->validate([
            "nom" => "required|string",
            "prenom" => "required|string",
            "civilite" => "required|string",
            "email" => "required|email|unique:prospects"
        ]);
        
        
        Prospect::create([
            "nom" => $request->nom,
            "nom_usage" => $request->nom_usage,
            "prenom" => $request->prenom,
            "civilite" => $request->civilite,
            "adresse" => $request->adresse,
            "code_postal" => $request->code_postal,
            "ville" => $request->ville,
            "telephone_fixe" => $request->telephone_fixe,
            "telephone_portable" => $request->telephone_portable,
            "email" => $request->email,
        ]);
        
        return  redirect()->route('prospect.index')->with('ok','prospect crée');
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $prospect = Prospect::where('id', Crypt::decrypt($id))->first();
        
        return view('prospect.show', compact('prospect'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $prospect = Prospect::where('id', Crypt::decrypt($id))->first();
        
        return view('prospect.edit', compact('prospect'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $prospect = Prospect::where('id', Crypt::decrypt($id))->first();
        
        $request->validate([
            "nom" => "required|string",
            "prenom" => "required|string",
            "civilite" => "required|string",
            "email" => "required|email"
        ]);
        
        
 
        $prospect->nom = $request->nom;
        $prospect->nom_usage = $request->nom_usage;
        $prospect->prenom = $request->prenom;
        $prospect->civilite = $request->civilite;
        $prospect->adresse = $request->adresse;
        $prospect->code_postal = $request->code_postal;
        $prospect->ville = $request->ville;
        $prospect->telephone_fixe = $request->telephone_fixe;
        $prospect->telephone_portable = $request->telephone_portable;
        $prospect->email = $request->email;
        
        $prospect->update();
        return redirect()->route('prospect.index')->with('ok','prospect modifié');

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    
    
    /**
     * Archiver les prospects
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function archiver($id, $action)
    {
        $prospect = Prospect::where('id', Crypt::decrypt($id))->first();
        
        
        $prospect->archive = $action == 1 ? true : false;
        $prospect->update();
        
        return $prospect;
    }
    
    /**
     * Consulter les archives
     *
     * @return \Illuminate\Http\Response
     */
    public function archives()
    {
        $prospects = Prospect::where('archive', true)->get();
        
        return view('prospect.archive', compact('prospects'));
    }
    
    
    /**
     *Afficher le formulaire de remseignement
     *
     * @return \Illuminate\Http\Response
     */
    public function create_fiche($id)
    {
    
        $prospect = Prospect::where('id', Crypt::decrypt($id))->first();
        // $prospect = Prospect::where('id', 1)->first();
        $prospect->a_ouvert_fiche = true;
        $prospect->date_ouverture_fiche = date("Y-m-d");
        
        $prospect->update();

        
        return view('prospect.fiche', compact('prospect'));
    }
    
    
    
    /**
     *Sauvegarder les infos de la fiche prospect
     *
     * @return \Illuminate\Http\Response
     */
    public function sauvegarder_fiche(Request $request, $id)
    {
    
    
    $request->validate([
        "civilite" => "required|string",
        "nom" => "required|string",
        "prenom" => "required|string",
        "adresse" => "required|string",
        "code_postal" => "required|string",
        "ville" => "required|string",
        "telephone_portable" => "required|string",
        "email" => "required|email"
    ]);
    

    // "carte_identite" => UploadedFile {#404 ▶}
    // "rib" => UploadedFile {#407 ▶}
    // "attestation_responsabilite" => UploadedFile {#406 ▶}
    // "photo" => UploadedFile {#153 ▶}
    
        $prospect = Prospect::where('id', Crypt::decrypt($id))->first();

    
        $prospect->civilite = $request->civilite;
        $prospect->nom = $request->nom;
        $prospect->nom_usage = $request->nom_usage;
        $prospect->prenom = $request->prenom;
        $prospect->adresse = $request->adresse;
        $prospect->code_postal = $request->code_postal;
        $prospect->ville = $request->ville;
        $prospect->telephone_fixe = $request->telephone_fixe;
        $prospect->telephone_portable = $request->telephone_portable;
        $prospect->email = $request->email;
        $prospect->date_naissance = $request->date_naissance;
        $prospect->lieu_naissance = $request->lieu_naissance;
        $prospect->situation_familliale = $request->situation_familliale;
        $prospect->nationalite = $request->nationalite;
        $prospect->nom_pere = $request->nom_pere;
        $prospect->nom_mere = $request->nom_mere;
        $prospect->statut_souhaite = $request->statut_souhaite;
        $prospect->numero_rsac = $request->numero_rsac;
        $prospect->numero_siret = $request->numero_siret;
        $prospect->code_postaux = $request->code_postaux;
        
        if($file = $request->file('piece_identite')){

            $request->validate([
                "piece_identite" => "required|mimes:jpeg,png,pdf|max:5000",
            ]);
          


                $name = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                
        
                // on sauvegarde la facture dans le repertoire du mandataire
                $path = storage_path('app/public/prospects/');
        
                if(!File::exists($path))
                    File::makeDirectory($path, 0755, true);
        
                    $filename = strtoupper($prospect->nom)." piece_identite ".$prospect->id ;
         
                    $file->move($path,$filename.'.'.$extension);            
                    $path = $path.'/'.$filename.'.'.$extension;
                
                    $prospect->piece_identite = $path;

        }
        
        if($file = $request->file('rib')){

            $request->validate([
                "rib" => "required|mimes:jpeg,png,pdf|max:5000",
            ]);
          


                $name = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                
        
                // on sauvegarde la facture dans le repertoire du mandataire
                $path = storage_path('app/public/prospects/');
        
                if(!File::exists($path))
                    File::makeDirectory($path, 0755, true);
        
                    $filename = strtoupper($prospect->nom)." rib ".$prospect->id ;
         
                    $file->move($path,$filename.'.'.$extension);            
                    $path = $path.'/'.$filename.'.'.$extension;
                
                    $prospect->rib = $path;

        }
        
        if($file = $request->file('attestation_responsabilite')){

            $request->validate([
                "attestation_responsabilite" => "required|mimes:jpeg,png,pdf|max:5000",
            ]);
          


                $name = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                
        
                // on sauvegarde la facture dans le repertoire du mandataire
                $path = storage_path('app/public/prospects/');
        
                if(!File::exists($path))
                    File::makeDirectory($path, 0755, true);
        
                    $filename = strtoupper($prospect->nom)." attestation_responsabilite ".$prospect->id ;
         
                    $file->move($path,$filename.'.'.$extension);            
                    $path = $path.'/'.$filename.'.'.$extension;
                
                    $prospect->attestation_responsabilite = $path;

        }
        
        if($file = $request->file('photo')){

            $request->validate([
                "photo" => "required|mimes:jpeg,png|max:5000",
            ]);
          


                $name = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                
        
                // on sauvegarde la facture dans le repertoire du mandataire
                $path = storage_path('app/public/prospects/');
        
                if(!File::exists($path))
                    File::makeDirectory($path, 0755, true);
        
                    $filename = strtoupper($prospect->nom)." photo ".$prospect->id ;
         
                    $file->move($path,$filename.'.'.$extension);            
                    $path = $path.'/'.$filename.'.'.$extension;
                
                    $prospect->photo = $path;

        }
        
        
      
        
        $prospect->renseigne = true;
        $prospect->update();
        
        
        return redirect()->route('prospect.fiche', Crypt::encrypt($prospect->id))->with('ok', 'Vos modifications ont été prises en compte ');
        
        // return view('prospect.fiche', compact('prospect'));
    }
    


    /**
     *Télecharger doc prospect
     *
     * @return \Illuminate\Http\Response
     */
    public function telecharger_doc($prospect_id, $type)
    {
        $prospect = Prospect::where('id', Crypt::decrypt($prospect_id))->first();
        // $prospect = Prospect::where('id', 1)->first();
        if($type=="photo"){
            return response()->download($prospect->photo);
        
        }elseif($type=="piece_identite"){
            return response()->download($prospect->piece_identite);
        
        }
        elseif($type=="attestation_responsabilite"){
            return response()->download($prospect->attestation_responsabilite);
        
        }elseif($type=="rib"){
            return response()->download($prospect->rib);

        
        }else{
        
        return  redirect()->back();
        
        }

    }
    
    
     /**
     *Envoi du mail au prospect pour renseigner sa fiche 
     *
     * @return \Illuminate\Http\Response
     */
    public function envoi_mail_fiche($prospect_id)
    {
        
        $prospect = Prospect::where('id', Crypt::decrypt($prospect_id))->first();
     
        $url = route('prospect.fiche', $prospect_id);
        Mail::to($prospect->email)->send(new SendFicheProspect($prospect, $url));
        
        $prospect->fiche_envoyee = true;
        $prospect->update();
     
        return  redirect()->route('prospect.index')->with('ok','Mail envoyé au prospect');
        


    }
    
    /**
     *Envoi du mail de modèle de contrat au prospect 
     *
     * @return \Illuminate\Http\Response
     */
    public function envoi_mail_modele_contrat($prospect_id)
    {
        
        $prospect = Prospect::where('id', Crypt::decrypt($prospect_id))->first();
     

        Mail::to($prospect->email)->send(new SendModeleContrat($prospect, $url));
        
        $prospect->modele_contrat_envoye = true;
        $prospect->update();
     
        return  redirect()->route('prospect.index')->with('ok','Le modèle du contrat a été envoyé au prospect ');
        


    }
    
    
    /**
     *Envoi du mail de contrat au prospect 
     *
     * @return \Illuminate\Http\Response
     */
    public function envoi_mail_contrat($prospect_id)
    {
        
        $prospect = Prospect::where('id', Crypt::decrypt($prospect_id))->first();
     

        Mail::to($prospect->email)->send(new SendContrat($prospect, $url));
        
        $prospect->contrat_envoye = true;
        $prospect->update();
     
        return  redirect()->route('prospect.index')->with('ok','Le contrat a été envoyé au prospect ');
        


    }
    
    
     /**
     * Affiche un modele de contrat
     *
     * @return \Illuminate\Http\Response
     */
    public function modele_contrat()
    {
        $parametre  = Parametre::first();
        $modele  = Contrat::where('est_modele', true)->first();
        $packs = Packpub::all();
        
        $prospect = Prospect::where('id',1)->first();
        
        $palier_starter = Contrat::palier_unserialize($modele->palier_starter);
        $palier_expert = Contrat::palier_unserialize($modele->palier_expert);
        
        // dd($parametre);
        
        return view('contrat.modele_contrat_pdf', compact('parametre','prospect'));
        return view('contrat.annexe_pdf',compact('parametre','modele','palier_expert','palier_starter','packs','prospect'));

    }
    
    
    /**
     * Affiche un modele de contrat et les annexes
     *
     * @return \Illuminate\Http\Response
     */
    public function envoyer_modele_contrat($prospect_id)
    {
       // on sauvegarde la modele de contrat
       $path = storage_path('app/public/contrat/');

       if(!File::exists($path))
           File::makeDirectory($path, 0755, true);
       
        $parametre  = Parametre::first();
        $contrat  = Contrat::where('est_modele', true)->first();
        $packs = Packpub::all();
        
        $palier_starter = Contrat::palier_unserialize($contrat->palier_starter);
        $palier_expert = Contrat::palier_unserialize($contrat->palier_expert);
        
        $prospect = Prospect::where('id',Crypt::decrypt($prospect_id))->first();
        
           
        $modele_contrat_pdf = PDF::loadView('contrat.modele_contrat_pdf',compact('parametre','prospect'));
        
        $modele_annexe_pdf = PDF::loadView('contrat.annexe_pdf',compact('parametre','contrat','palier_expert','palier_starter','packs'));
        
        
        $contrat_path = $path.'modele_contrat.pdf';
        $annexe_path = $path.'modele_annexe.pdf';
        
        $modele_contrat_pdf->save($contrat_path);
        $modele_annexe_pdf->save($annexe_path);
   
   
        $prospect->modele_contrat_envoye = true ;
   
        $prospect->update();
   
        $modele_contrat_pdf_path = storage_path('app/public/contrat/').'modele_contrat.pdf';
        $modele_annexe_pdf_path = storage_path('app/public/contrat/').'modele_annexe.pdf';
   
  
        Mail::to($prospect->email)->send(new SendModeleContrat($prospect,$modele_contrat_pdf_path, $modele_annexe_pdf_path));
        return  redirect()->route('prospect.index')->with('ok','Le modèle de contrat a été envoyé au prospect ');


    }
    
    
    
     /**
     * Passer le prospect à mandataire
     *
     * @return \Illuminate\Http\Response
     */
    public function prospect_a_mandataire($prospect_id)
    {
      
        $prospect = Prospect::where('id',Crypt::decrypt($prospect_id))->first();
        
        
        if($prospect->est_mandataire == false){
            
            $user = User::create([
                'statut'=>$prospect->statut_souhaite,
                'civilite' => $prospect->civilite,
                'nom' => $prospect->nom,
                'prenom'=>$prospect->prenom,
                'telephone1'=>$prospect->telephone_portable,
                'telephone2'=>$prospect->telephone_fixe,
                'ville'=>$prospect->ville,
                'code_postal'=>$prospect->code_postal,
                'pays'=>$prospect->pays,
                'email_perso'=>$prospect->email,
                'email'=>$prospect->id."",
                'role'=>"mandataire",
                'adresse'=>$prospect->adresse,
                'siret'=>$prospect->numero_siret,
              
                
               
            
            ]);
        }
        else{
        
            return  redirect()->route('prospect.index')->with('ok','Ce prospect est déjà mandataire ');
        }
        
        $prospect->user_id = $user->id;
        $prospect->est_mandataire = true;
        $prospect->update();

         return redirect()->route('mandataire.edit', ['user_id'=>Crypt::encrypt($user->id)]);
     

    }
    
    
    
    
    
    
        
     /**
     * Affiche l'agenda
     *
     * @return \Illuminate\Http\Response
     */
    public function agenda()
    {
        
        return view('prospect.agenda');

    }
    
}
