<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Prospect;
use App\Parametre;
use App\Contrat;
use App\Packpub;
use App\User;
use App\Agenda;
use App\Bibliotheque;
use App\Document;
use App\Fichier;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File ;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendFicheProspect;
use App\Mail\SendModeleContrat;
use Illuminate\Support\Facades\DB;

use Auth;
use PDF;
use iio\libmergepdf\Merger;

class ProspectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prospects = Prospect::where([['archive', false], ['est_mandataire', false]])->get();
        // $prospects = Prospect::where('archive', false)->get();
        
        $agendas = Agenda::where('est_agenda_prospect', true)->get()->toJson();
              
        $mandataires = User::join('contrats','users.id','=','contrats.user_id' )
        ->select('*','contrats.id as contrat_id')
        ->where('contrats.a_demission', false)->get();
        
        $bibliotheques = Bibliotheque::all();
        
        //  Tableau contenant les ids et noms des prospects pour faciliter l'affichage dans le code js
        $tab_prospect = array();
        foreach ($prospects as $prospect) {
            $tab_prospect [$prospect->id]["nom"] = $prospect->nom." ". $prospect->prenom; 
            $tab_prospect [$prospect->id]["contact"] = $prospect->telephone_portable; 
        }
        
        $tab_prospect =  json_encode($tab_prospect);
   

        return view('prospect.index', compact('prospects','agendas', 'mandataires','bibliotheques','tab_prospect'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $parrains = User::where([['role','mandataire']])->get();
        
        $parrains = DB::table('users')
                        ->join('contrats', 'users.id', '=', 'contrats.user_id')
                        ->select('users.*', 'contrats.*')
                        ->where([['role','mandataire'], ['a_demission', false] ] )
                        ->get();
                        
        // dd($parrains);
    
        return view('prospect.add',compact('parrains') );
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
            "a_parrain" => $request->a_parrain == "on" ? true : false,
            // "type_parrain" => $request->type_parrain,
            "parrain_id" => $request->parrain_id,
            "source" => $request->source,
            "commentaire_pro" => $request->commentaire_pro,
            "commentaire_perso" => $request->commentaire_perso,
        ]);
        
        return  redirect()->route('prospect.index')->with('ok','prospect créé');
       
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
        
        $documents = Bibliotheque::all();
        
        $agendas = Agenda::where('prospect_id',Crypt::decrypt($id) )->get();
        
        return view('prospect.show', compact('prospect', 'documents', 'agendas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $parrains = User::where([['role','mandataire']])->get();
        
        $parrains = DB::table('users')
                        ->join('contrats', 'users.id', '=', 'contrats.user_id')
                        ->select('users.*', 'contrats.*')
                        ->where([['role','mandataire'], ['a_demission', false] ] )
                        ->get();
        $prospect = Prospect::where('id', Crypt::decrypt($id))->first();
        $parr = User::where('id',$prospect->parrain_id)->first();
        
        return view('prospect.edit', compact('prospect','parrains','parr'));
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
        $prospect->a_parrain = $request->a_parrain == "on" ? true : false;
        // $prospect->type_parrain = $request->type_parrain;
        $prospect->parrain_id = $request->parrain_id;
        $prospect->source = $request->source;
        $prospect->commentaire_pro = $request->commentaire_pro;
        $prospect->commentaire_perso = $request->commentaire_perso;
        
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
        
        
        $nom = str_replace(['/', '\\', '<','>',':','|','?','*','#'],"-",$prospect->nom) ;
        
        if($file = $request->file('piece_identite')){

            $request->validate([
                "piece_identite" => "required|mimes:jpeg,jpg,png,pdf|max:5000",
                "date_expiration_carteidentite" => "required",
                
            ]);
          


                $name = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                
        
                // on sauvegarde le fichier dans le repertoire du mandataire
                $path = storage_path('app/public/prospects');
        
                if(!File::exists($path))
                    File::makeDirectory($path, 0755, true);
        
                    $filename = strtoupper($nom)." piece_identite ".$prospect->id ;
         
                    $file->move($path,$filename.'.'.$extension);            
                    $path = $path.'/'.$filename.'.'.$extension;
                
                    $prospect->piece_identite = $path;
                    $prospect->date_expiration_carteidentite = $request->date_expiration_carteidentite;

        }
        
        if($file = $request->file('rib')){

            $request->validate([
                "rib" => "required|mimes:jpeg,jpg,png,pdf|max:5000",
            ]);
          


                $name = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                
        
                // on sauvegarde le fichier  dans le repertoire du mandataire
                $path = storage_path('app/public/prospects/');
        
                if(!File::exists($path))
                    File::makeDirectory($path, 0755, true);
        
                    $filename = strtoupper($nom)." rib ".$prospect->id ;
         
                    $file->move($path,$filename.'.'.$extension);            
                    $path = $path.'/'.$filename.'.'.$extension;
                
                    $prospect->rib = $path;

        }
        
        // if($file = $request->file('attestation_responsabilite')){

        //     $request->validate([
        //         "attestation_responsabilite" => "required|mimes:jpeg,png,pdf|max:5000",
        //     ]);
          


        //         $name = $file->getClientOriginalName();
        //         $extension = $file->getClientOriginalExtension();
                
        
        //         // on sauvegarde le fichier dans le repertoire du mandataire
        //         $path = storage_path('app/public/prospects/');
        
        //         if(!File::exists($path))
        //             File::makeDirectory($path, 0755, true);
        
        //             $filename = strtoupper($nom)." attestation_responsabilite ".$prospect->id ;
         
        //             $file->move($path,$filename.'.'.$extension);            
        //             $path = $path.'/'.$filename.'.'.$extension;
                
        //             $prospect->attestation_responsabilite = $path;

        // }
        
        if($file = $request->file('photo')){

            $request->validate([
                "photo" => "required|mimes:jpeg,jpg,png|max:5000",
            ]);
          


                $name = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                
        
                // on sauvegarde le fichier dans le repertoire du mandataire
                $path = storage_path('app/public/prospects/');
        
                if(!File::exists($path))
                    File::makeDirectory($path, 0755, true);
        
                    $filename = strtoupper($nom)." photo ".$prospect->id ;
         
                    $file->move($path,$filename.'.'.$extension);            
                    $path = $path.'/'.$filename.'.'.$extension;
                
                    $prospect->photo = $path;

        }
        
        
      
        
        $prospect->renseigne = true;
        $prospect->update();
        
        if(Auth::check() && $prospect->user_id != null ){
            return redirect()->route('mandataire.show', Crypt::encrypt($prospect->user_id))->with('ok', 'Vos modifications ont été prises en compte ');
        
        }
        
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
        $prospect->date_envoi_fiche = date('Y-m-d');
        
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
        $contrat  = Contrat::where("id", 80)->first();
        $modele  = Contrat::where('est_modele', true)->first();
        $packs = Packpub::all();
        
        $prospect = Prospect::where('id',1)->first();
        
        $palier_starter = Contrat::palier_unserialize($modele->palier_starter);
        $palier_expert = Contrat::palier_unserialize($modele->palier_expert);
        
        $comm_parrain = unserialize($parametre->comm_parrain);
       
        
        return view('contrat.modele_contrat_pdf', compact('parametre','prospect'));
        return view('contrat.annexe_pdf',compact('parametre','modele','palier_expert','palier_starter','packs','prospect','contrat','comm_parrain'));

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
        $contrat  = Contrat::where("id", 19)->first();
        
        $packs = Packpub::all();
        
        $palier_starter = Contrat::palier_unserialize($contrat->palier_starter);
        $palier_expert = Contrat::palier_unserialize($contrat->palier_expert);
        
        $prospect = Prospect::where('id',Crypt::decrypt($prospect_id))->first();
        
        $comm_parrain = unserialize($parametre->comm_parrain);
           
        $modele_contrat_pdf = PDF::loadView('contrat.modele_contrat_pdf',compact('parametre','prospect'));
        
        $modele_annexe_pdf = PDF::loadView('contrat.annexe_pdf',compact('parametre','contrat','palier_expert','palier_starter','packs','comm_parrain'));
        
       
        
        $contrat_path = $path.'modele_contrat.pdf';
        $annexe_path = $path.'modele_annexe.pdf';
        
        $modele_contrat_pdf->save($contrat_path);
        // dd($contrat_path);
        
        $modele_annexe_pdf->save($annexe_path);
   
   
        $prospect->modele_contrat_envoye = true ;
        $prospect->date_envoi_modele_contrat = date('Y-m-d') ;
   
        $prospect->update();
   
        $modele_contrat_pdf_path = storage_path('app/public/contrat/').'modele_contrat.pdf';
        $modele_annexe_pdf_path = storage_path('app/public/contrat/').'modele_annexe.pdf';
   
   
  
        Mail::to($prospect->email)->send(new SendModeleContrat($prospect,$modele_contrat_pdf_path, $modele_annexe_pdf_path));
        
        return  redirect()->route('prospect.agenda.show',  $prospect->id )->with('ok','Le modèle du contrat a été envoyé au prospect ');
        
        // return  redirect()->route('prospect.index')->with('ok','Le modèle de contrat a été envoyé au prospect ');


    }
    
    /**
     * télécharger un modele de contrat et les annexes
     *
     * @return \Illuminate\Http\Response
     */
    public function telecharger_modele_contrat($prospect_id)
    {
       // on sauvegarde la modele de contrat
       $path = storage_path('app/public/contrat/');

       if(!File::exists($path))
           File::makeDirectory($path, 0755, true);
       
        $parametre  = Parametre::first();
        $contrat  = Contrat::where('est_modele', true)->first();
        $contrat  = Contrat::where("id", 19)->first();
        
        $packs = Packpub::all();
        
        $palier_starter = Contrat::palier_unserialize($contrat->palier_starter);
        $palier_expert = Contrat::palier_unserialize($contrat->palier_expert);
        
        $prospect = Prospect::where('id',Crypt::decrypt($prospect_id))->first();
        
        $comm_parrain = unserialize($parametre->comm_parrain);
           
        $modele_contrat_pdf = PDF::loadView('contrat.modele_contrat_pdf',compact('parametre','prospect'));
        
        $modele_annexe_pdf = PDF::loadView('contrat.annexe_pdf',compact('parametre','contrat','palier_expert','palier_starter','packs','comm_parrain'));
        
       
        
        $contrat_path = $path.'modele_contrat.pdf';
        $annexe_path = $path.'modele_annexe.pdf';
        
        $modele_contrat_pdf->save($contrat_path);
        // dd($contrat_path);
        
        $modele_annexe_pdf->save($annexe_path);
   
   
        $prospect->modele_contrat_envoye = true ;
   
        $prospect->update();
   
        $modele_contrat_pdf_path = storage_path('app/public/contrat/').'modele_contrat.pdf';
        $modele_annexe_pdf_path = storage_path('app/public/contrat/').'modele_annexe.pdf';
   
        $merger = new Merger;     
        $merger->addFile($modele_contrat_pdf_path);
        $merger->addFile($modele_annexe_pdf_path);

        $createdPdf = $merger->merge();
      
        return new Response($createdPdf, 200, array('Content-Type' => 'application/pdf'));
   
        return response()->download($modele_contrat_pdf_path);
       

    }

    
    
     /**
     * Passer le prospect à mandataire
     *
     * @return \Illuminate\Http\Response
     */
    public function prospect_a_mandataire($prospect_id)
    {
      
        $prospect = Prospect::where('id',Crypt::decrypt($prospect_id))->first();        
        
        $mandataire = User::where('email_perso',$prospect->email)->first();

        
        if($mandataire != null){
            return  redirect()->route('prospect.index')->with('ok','Cette adresse email existe déjà');
        }
        
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
            
            // $user = User::where('id',92)->first();
        }
        else{
        
            return  redirect()->route('prospect.index')->with('ok','Ce prospect est déjà mandataire ');
        }
        
        $prospect->user_id = $user->id;
        $prospect->est_mandataire = true;
        $prospect->update();
        
        // Transfert des documents dans la liste des documents du mandataire
        
        $document = Document::where('reference', 'picedidentit')->first();        
        if($prospect->piece_identite != null && $document != null){
    

            // on sauvegarde le document
            $path = storage_path('app/public/'.$user->id.'/documents');
            $reference = $document->reference;
            
            $split = explode('.', $prospect->piece_identite);
            $extension = '.'.$split[sizeof($split)-1];
    
            if(!File::exists($path))
                File::makeDirectory($path, 0755, true);
    
                $filename = $reference . "_".$user->id;
               

                $fichier = $user->document($document->id);
            
               
                $path = $path.'/'.$filename.$extension;
              
                    // On copie le fichier dans le dossier document 
                    copy($prospect->piece_identite,$path );
               
                    
                    $fichier =   Fichier::create([                        
                        "user_id" => $user->id,
                        "document_id" => $document->id,
                        "url" => $path,
                        "extension" => $extension,
                        "date_expiration" => $prospect->date_expiration_carte_identite
                    ]);

        }
        
        $document = Document::where('reference', 'rib')->first();        
        if($prospect->rib != null && $document != null){
    

            // on sauvegarde le document
            $path = storage_path('app/public/'.$user->id.'/documents');
            $reference = $document->reference;
            
            $split = explode('.', $prospect->rib);
            $extension = '.'.$split[sizeof($split)-1];
    
            if(!File::exists($path))
                File::makeDirectory($path, 0755, true);
    
                $filename = $reference . "_".$user->id;
               

                $fichier = $user->document($document->id);
            
              
               // on enregistre le chemin complet du fichier déplacé dans la variable path
               $path = $path.'/'.$filename.$extension;
                    
                // On copie le fichier dans le dossier document en le renommant
                copy($prospect->rib,$path );
                

                    $fichier =   Fichier::create([                        
                        "user_id" => $user->id,
                        "document_id" => $document->id,
                        "url" => $path,
                        "extension" => $extension,
                    ]);

        }
        
        
        $document = Document::where('reference', 'photo')->first();        
        if($prospect->photo != null && $document != null){
    

            // on sauvegarde le document
            $path = storage_path('app/public/'.$user->id.'/documents');
            $reference = $document->reference;
            
            $split = explode('.', $prospect->photo);
            $extension = '.'.$split[sizeof($split)-1];
    
            if(!File::exists($path))
                File::makeDirectory($path, 0755, true);
    
                $filename = $reference . "_".$user->id;
               

                $fichier = $user->document($document->id);
            
                    // on enregistre le chemin complet du fichier déplacé dans la variable path
                    $path = $path.'/'.$filename.$extension;
              
                     // On copie le fichier dans le dossier document en le renommant
                     copy($prospect->photo,$path );

                    
                    $fichier =   Fichier::create([                        
                        "user_id" => $user->id,
                        "document_id" => $document->id,
                        "url" => $path,
                        "extension" => $extension,
                    ]);

        }

         return redirect()->route('mandataire.edit', ['user_id'=>Crypt::encrypt($user->id)]);
     

    }
    
    
    
    
    
    
        
     /**
     * Affiche l'agenda de tous les prospects
     *
     * @return \Illuminate\Http\Response
     */
    public function agenda_general()
    {
        
        $agendas = Agenda::where('est_agenda_prospect', true)->get()->toJson();
        // dd($agendas);
        return view('prospect.agenda_general',compact('agendas'));

    }
    
    
    /**
     * affichage de  l'agenda d'un prospect
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_agenda_prospect($prospect_id)
    {
        $agendas = Agenda::where('prospect_id', $prospect_id)->get()->toJson();
        $prospect = Prospect::where('id', $prospect_id)->first();
        // dd($agendas);
        return view('prospect.agenda',compact('agendas', 'prospect'));
           
    }
    
    
    /**
     *  création d'un agenda
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_agenda_prospect(Request $request)
    {
        
        $agenda = Agenda::create([
        
            'titre' => $request->titre, 
            'description' => $request->description, 
            'date_deb' => $request->date_deb, 
            'date_fin' => $request->date_fin, 
            'heure_deb' => $request->heure_deb, 
            'type_rappel' => $request->type_rappel, 
            // 'heure_fin' => $request->heure_fin, 
            // 'est_agenda_prospect' => $request->est_agenda_prospect,            
            'est_agenda_prospect' => true,
            // 'est_agenda_mandataire' => $request->est_agenda_mandataire,            
            'est_agenda_mandataire' => false,
            // 'est_agenda_prospect' => $request->est_agenda_prospect,            
            'est_agenda_general' => false,
            'liee_a' => "prospect",
            'prospect_id' => $request->prospect_id, 
            'user_id' => $request->user_id, 
        
        ]);
        
    return redirect()->back()->with('ok', 'tâche créée');
        
    }


    

    /**
     * Modification d'un agenda
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_agenda_prospect(Request $request)
    {
        //
        $agenda = Agenda::where('id',$request->id)->first();
        
        $agenda->titre =  $request->titre; 
        $agenda->description =  $request->description; 
        $agenda->date_deb =  $request->date_deb; 
        $agenda->date_fin =  $request->date_fin; 
        $agenda->heure_deb =  $request->heure_deb; 
        $agenda->type_rappel =  $request->type_rappel; 
        // $agenda->heure_fin =  $request->heure_fin; 
         $agenda->est_agenda_prospect = true;
        // $agenda->est_agenda_mandataire =  $request->est_agenda_mandataire;            
         $agenda->est_agenda_mandataire = false;
        // $agenda->est_agenda_prospect =  $request->est_agenda_prospect;            
        $agenda->est_agenda_general =  false;
        $agenda->liee_a =  "prospect"; 
        $agenda->prospect_id =  $request->prospect_id; 
        $agenda->user_id =  $request->user_id; 
        
        
        $agenda->est_terminee = $request->est_terminee == "true" ? true : false;             
        // dd($agenda->est_terminee);
        
        $agenda->update();
        
        return redirect()->back()->with('ok', 'tâche modifiée '.$agenda->titre);
        
    }
    
}