<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Document;
use App\Fichier;
use App\Historiquefichier;
use App\Historique;
use Auth;
use App\Mail\ValidationFichier;
use Illuminate\Support\Facades\File ;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;


use Illuminate\Support\Facades\Crypt;
class DocumentController extends Controller
{
    /**
     * Page listant tous les mandataires avec leurs documents
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mandataires = User::where('role','mandataire')->orderBy('nom')->get();
        $documents = Document::where('archive', false)->orderBy('nom')->get();

        
        return view('documents.index', compact('mandataires','documents'));

    }



  /**
     * Liste des documents à fournir
     *
     * @return \Illuminate\Http\Response
     */
    public function liste()
    {
       $documents = Document::where('archive', false)->orderBy('nom','asc')->get();
        
        return view('documents.liste', compact('documents'));

    }
    
    
    
    /**
     * Création d'un document à renseigner par les mandataires
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('documents.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "nom"=> "required|unique:documents"
        
        ]);
        
        $reference = strtolower( str_replace(['/', '\\', '<','>',':','|','?','*','#',' ',"'"],"",$request->nom) );
        
        Document::create([
            "nom"=> $request->nom,
            "description"=> $request->description,
            "reference"=> $reference,
            "a_date_expiration"=> $request->a_date_expiration == "Oui" ? true : false,
            "supprime_si_demission"=> $request->supprime_si_demission == "Oui" ? true : false,
            "a_historique"=> $request->a_historique == "Oui" ? true : false,
        
        ]);
        
        return redirect()->route('document.liste')->with('ok', "Document ajouté");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($mandataire_id)
    {
        
        $mandataire = User::where('id', Crypt::decrypt($mandataire_id))->first();
        
        $documents = Document::where('archive', false)->get();
        
        
        return view('documents.show', compact('mandataire', 'documents'));
        
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $document = Document::where('id', Crypt::decrypt($id))->first();
        
        
        return view('documents.edit', compact('document'));
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
    
    
        $document = Document::where('id', $id)->first();
        

        if($document->nom != $request->nom){
        
            $request->validate([
                "nom"=> "required|unique:documents"
            ]);
        }
     
        
        $reference = strtolower(preg_replace('/[^A-Za-z0-9]/', '', $request->nom));
        // $reference = strtolower( str_replace(['/', '\\', '<','>',':','|','?','*','#',' ',"'"],"",$reference) );
        
    
    
        
        $document->a_date_expiration = $request->a_date_expiration == "Oui" ? true : false;
        $document->supprime_si_demission = $request->supprime_si_demission == "Oui" ? true : false;
        $document->a_historique = $request->a_historique == "Oui" ? true : false;
        $document->nom = $request->nom;
        $document->description = $request->description;
        $document->reference = $reference;
        
        $document->update();
        
        return redirect()->route('document.liste')->with('ok', 'document modifié');
        
    }

    /**
     *Archiver les documents
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function archiver($id)
    {
        
        Document::where('id', $id)->update(['archive' => true]);
        
        return "archivé";
    }
    
    
    
    
    /**
     * Sauvegarde des documents
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function save_doc( Request $request, $mandataire_id)
    {
        
        $mandataire = User::where('id', $mandataire_id)->first();
        
        $documents = Document::where('archive', false)->get();
        
       foreach ($documents as $document) {
  
           
            if($file = $request->file($document->reference)){


                if($document->a_date_expiration == true ){
                                
                    $request->validate([
                        "date_expiration_".$document->reference => "required"
                    ]);
                }
                
                // on sauvegarde le document
                $path = storage_path('app/public/'.$mandataire->id.'/documents');
                $reference = $document->reference;
        
                if(!File::exists($path))
                    File::makeDirectory($path, 0755, true);
        
                    $filename = $reference . "_".$mandataire->id;
                    $extension = '.'.$file->getClientOriginalExtension();
                    
               
         
                  
                
                    $fichier = $mandataire->document($document->id);
                
                    // On vérifie si le fichier n'existe pas
                    if( $fichier == null){
                    
                        // On déplace le fichier dans le dossier document 
                        $file->move($path,$filename.$extension);  
                        // on enregistre le chemin complet du fichier déplacé dans la variable path
                        $path = $path.'/'.$filename.$extension;                        
                       
                        
                        $fichier =   Fichier::create([                        
                            "user_id" => $mandataire->id,
                            "document_id" => $document->id,
                            "url" => $path,
                            "extension" => $extension,
                            "date_expiration" => $request["date_expiration_$reference"]
                        ]);
                        
                        
                        
                        $action = Auth::user()->nom." ".Auth::user()->prenom." a ajouté le fichier $document->nom de $mandataire->prenom $mandataire->nom";
                        $user_id = Auth::user()->id;
                  
                        Historique::createHistorique( $user_id,$fichier->id,"autre",$action );
               
                    }else {
                    
                        
                        // Si le fichier doit être gardé en historique
                        if($document->a_historique == true){
                        
                        
                            
                            $path_historique = $fichier->url;
                      
                             // Sauvegarde de l'ancien fichier dans le dossier historique
                            if(file_exists($fichier->url)){
                            
                                $path_historique = storage_path('app/public/'.$mandataire->id.'/documents/historique/');
                                
                                if(!File::exists($path_historique))
                                File::makeDirectory($path_historique, 0755, true);
                                
                                
                                
                                // On réccupère l'extension du fichier
                                $extension_historique = explode(".",$fichier->url);
                                
                                $extension_historique = '.'.$extension_historique[sizeof($extension_historique) - 1];
                                
                                $filename_historique = $document->reference . "_".$mandataire->id."_".random_int(1, 10000).$extension_historique;
                                
                   
                                
                                // Chemin complet du fichier
                                
                                $path_historique = $path_historique.$filename_historique;
                                
                               
                            
                                // On renomme le fichier et on le deplace dans le repertoire des historiques
                                rename($fichier->url, $path_historique );
                              
                                // dd($mandataire->nom."".$mandataire->id);
                            }
         
                            
                            Historiquefichier::create([
                                "user_id" => $mandataire->id,
                                "document_id" => $document->id,
                                "url" => $path_historique,
                                "modif_url" => $fichier->url == $path ? false : true,
                                "extension" => $fichier->extension,
                                "modif_extension" => $fichier->extension == $extension_historique ? false : true,
                                "date_expiration" => $fichier->date_expiration,
                                "modif_date_expiration" =>$fichier->date_expiration == $request["date_expiration_$reference"] ? false : true
                            ]);
                            
                            
                           
                        }
                        
                         // On déplace le fichier dans le dossier document 
                         $file->move($path,$filename.$extension);  
                         // on enregistre le chemin complet du fichier déplacé dans la variable path
                         $path = $path.'/'.$filename.$extension;
                         
                         $fichier->valide = 0 ;
                        
                        $today = date('Y-m-d');
                        
                        $fichier->url = $path;
                        $fichier->extension = $extension;
                        $fichier->expire = $request["date_expiration_$reference"] < $today ? true : false;
                        $fichier->date_expiration = $request["date_expiration_$reference"] ;
                        
                      
                        
                        $fichier->update();
                        
                        $action = Auth::user()->nom." ".Auth::user()->prenom." a modifié le fichier $document->nom de $mandataire->prenom $mandataire->nom";
                        $user_id = Auth::user()->id;
                  
                //   dd($fichier->id);
                        Historique::createHistorique( $user_id,$fichier->id,"autre",$action );
                    
                    }
                
                    
                 
            }//SI LE MANDATAIRE N'A PAS RENSEIGNE DE FICHIER 
            else {
               
                // si le fichier existe déjà, on modifie juste la date d'expiration
                $fichier = $mandataire->document($document->id);
                if( $fichier != null){
                
                    $reference = $document->reference;
                    $fichier->date_expiration = $request["date_expiration_$reference"] ;
                    $today = date('Y-m-d');
                    $fichier->expire = $request["date_expiration_$reference"] < $today ? true : false;
                    
                    $fichier->update();
                    
                    $action = Auth::user()->nom." ".Auth::user()->prenom." a modifié la date d'expiration du fichier $document->nom de $mandataire->prenom $mandataire->nom";
                    $user_id = Auth::user()->id;

                    Historique::createHistorique( $user_id,$fichier->id,"autre",$action );
                }
            }
           
           
           
       }
        
        return redirect()->route('document.show', Crypt::encrypt($mandataire->id))->with('ok', 'Document(s) modifié(s)') ;
        
        
    }
    
    
    /**
     *  telecharger documents
     *
     * @param  string  $avoir_id
     * @return \Illuminate\Http\Response
    */
     
    public  function download_document($mandataire_id, $document_id)
    {
    
        
        $mandataire = User::where('id', $mandataire_id)->first();
        
        if(intval($document_id)){
            $document = Document::where('id', $document_id)->first();
        
        }else{
        
            $document = Document::where('reference', $document_id)->first();
        
        }
       
        
        $fichier = $mandataire->document($document_id);
        
        // dd($fichier);
        
        $nom = strtolower(preg_replace('/[^A-Za-z0-9]/', '', $mandataire->nom));

        $filename = $document->reference.'_'.$nom.$fichier->extension ;
        
        // dd($fichier->url);
      
        return response()->download($fichier->url,$filename);
    
      
    }
    
    
    
    
    /**
     *  telecharger historique des documents
     *
     * @param  string  $avoir_id
     * @return \Illuminate\Http\Response
    */
     
    public  function download_historique_document($historique_id)
    {
    
        
        
        $historiquefichier = Historiquefichier::where('id', $historique_id)->first(); 
        $mandataire = $historiquefichier->user;
        
        
        
     
        // On réccupère l'extension du fichier
        // $extension = '.'.explode(".",$historiquefichier->url)[1];
        
        
         
        $extension = explode(".",$historiquefichier->url);
                                
        $extension = '.'.$extension[sizeof($extension) - 1];
        
        
        $document = $historiquefichier->document();
        
        $nom = strtolower(preg_replace('/[^A-Za-z0-9]/', '', $mandataire->nom));

        $filename = $document->reference.'_'.$nom.'_historique'.$extension ;
        
     
      
        return response()->download($historiquefichier->url,$filename);
    
      
    }
    
    
    
    /**
     * Afficher l'historique des documents
     *
     * @return \Illuminate\Http\Response
     */
    public function historique($mandataire_id)
    {
        $historiqueDocuments = Historiquefichier::where('user_id',  Crypt::decrypt($mandataire_id))->get();
       
        $mandataire = User::where('id', Crypt::decrypt($mandataire_id))->first();
        // $mandataire = User::where('id', $mandataire_id)->first();

        return view('documents.historique', compact('historiqueDocuments','mandataire'));

    }
    
    
    /**
     * Afficher la liste des documents à valider
     *
     * @return \Illuminate\Http\Response
    */
    public function a_valider()
    {
        $fichiers = Fichier::where('valide', false)->get();      

        return view('documents.a_valider', compact('fichiers'));

    }
    
    
    /**
     * Validation d'un document
     *
     * @return \Illuminate\Http\Response
     */
    public function valider(Request $request, $validation, $fichier_id)
    {
      
        $fichier = Fichier::where('id', $fichier_id)->first();
       
        if($fichier->valide == 2 ) return 0;
        
        $fichier->valide = $validation;
        $fichier->motif_refu = $request->motif;
        if($fichier->date_expiration != null && $fichier->date_expiration > date('Y-m-d')){
            $fichier->expire = false;
        }
        $fichier->update();
       
        // Si le fichié est refusé
        $fichier->valide == 2 ?  Mail::to($fichier->user->email)->send(new ValidationFichier($fichier)) : "";
       
        return 0;

    }
}
