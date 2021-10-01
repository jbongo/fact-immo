<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Document;
use App\Fichier;

use Illuminate\Support\Facades\File ;


use Illuminate\Support\facades\Crypt;
class DocumentController extends Controller
{
    /**
     * Page listant tous les mandataires
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mandataires = User::where('role','mandataire')->orderBy('nom')->get();
        
        return view('documents.index', compact('mandataires'));

    }



  /**
     * Liste des documents à fournir
     *
     * @return \Illuminate\Http\Response
     */
    public function liste()
    {
       $documents = Document::where('archive', false)->get();
        
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
    

                
                
                // on sauvegarde le document
                $path = storage_path('app/public/'.$mandataire->id.'/documents');
                $reference = $document->reference;
        
                if(!File::exists($path))
                    File::makeDirectory($path, 0755, true);
        
                    $filename = $reference . "_".$mandataire->id;
                    $extension = '.'.$file->getClientOriginalExtension();
                    
               
         
                    $file->move($path,$filename.$extension);            
                    $path = $path.'/'.$filename.$extension;
                
                    $fichier = $mandataire->document($document->id);
                 
                    if( $fichier == null){
                    
                    // dd($extension);
                        Fichier::create([                        
                            "user_id" => $mandataire->id,
                            "document_id" => $document->id,
                            "url" => $path,
                            "extension" => $extension,
                            "date_expiration" => $request["date_expiration_$reference"]
                        ]);
               
                    }else {
                    
                        $fichier->url = $path;
                        $fichier->extension = $extension;
                        $fichier->date_expiration = $request["date_expiration_$reference"] ;
                        
                        $fichier->update();
                    
                    }
                
                    
                 
            }
           
           
           
       }
        
        return redirect()->route('document.show', Crypt::encrypt($mandataire->id))->with('ok', 'Document(s) modifié(s)') ;
        
        
    }
    
    
    /**
     *  telecharger facture avoir
     *
     * @param  string  $avoir_id
     * @return \Illuminate\Http\Response
    */
     
    public  function download_document($mandataire_id, $document_id)
    {
    
    
        $mandataire = User::where('id', $mandataire_id)->first();
        $document = Document::where('id', $document_id)->first();
        
        $fichier = $mandataire->document($document_id);
        
        $nom = strtolower(preg_replace('/[^A-Za-z0-9]/', '', $mandataire->nom));

        $filename = $document->reference.'_'.$nom.$fichier->extension ;
      
        return response()->download($fichier->url,$filename);
    
      
    }
}
