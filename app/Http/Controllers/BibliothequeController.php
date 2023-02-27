<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Bibliotheque;
use App\Historique;
use App\User;
use App\Prospect;
use App\UserBibliotheque;


use File;
use Auth;

use App\Mail\SendDocument;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Crypt;


class BibliothequeController extends Controller
{
    /**
     *Liste des documents de la bibliothèque
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = Bibliotheque::orderBy('nom')->get();
        
        
        return view('bibliotheque.index', compact('documents'));
    }

    /**
     *Ajout d'un document 
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bibliotheque.add');
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
            "nom"=> "required|unique:bibliotheques",
            "fichier"=> "required"
        
        ]);
        
        $reference = strtolower( str_replace(['/', '\\', '<','>',':','|','?','*','#',' ',"'"],"",$request->nom) );
        
        
        
        
        if($file = $request->file("fichier")){


     
            // on sauvegarde le document
            // $path = storage_path('app/public/bibliotheque');
            $path = public_path('bibliotheques');
               
            if(!File::exists($path))
                File::makeDirectory($path, 0755, true);
    
                $filename = $reference . "_".rand(1,10000);
                $extension = '.'.$file->getClientOriginalExtension();


                
                // On déplace le fichier dans le dossier bibliotheque 
                $file->move($path,$filename.$extension);  
                // on enregistre le chemin complet du fichier déplacé dans la variable path
                $path = $path.'/'.$filename.$extension;
                
                
                $fichier =   Bibliotheque::create([                        
                    "nom" =>  $request["nom"],
                    "reference" =>  $reference,
                    "description" =>  $request["description"],
                    "url" => $path,
                    "extension" => $extension,
                    "date_expiration" => $request["date_expiration"]
                ]);
                
                
                
                $action = Auth::user()->nom." ".Auth::user()->prenom." a ajouté le fichier $fichier->nom dans la bibliothèque";
                $user_id = Auth::user()->id;
          
                Historique::createHistorique( $user_id,$fichier->id,"autre",$action );
       
                
    
            
                
             
        }//SI LE MANDATAIRE N'A PAS RENSEIGNE DE FICHIER         
        else{
        
            return redirect()->route('bibliotheque.index')->with('ok', "Document non ajouté");
        
        
        
        }
        
        return redirect()->route('bibliotheque.index')->with('ok', "Document ajouté");
        
        
    }


    /**
     * Page de modif d'un document de la bibliothèque
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $document = Bibliotheque::where('id', $id)->first();        
        return view('bibliotheque.edit', compact('document'));
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
         // dd($request->all());
        
        $document = Bibliotheque::where('id', $id)->first();        
        
        if($request->nom != $document->nom){
            $request->validate([
                "nom"=> "required|unique:bibliotheques",    
            ]);
        }
        
        
        $reference = strtolower( str_replace(['/', '\\', '<','>',':','|','?','*','#',' ',"'"],"",$request->nom) );
        
        
        // dd($document);
        
        if($file = $request->file("fichier")){


     
            // on sauvegarde le document
            // $path = storage_path('app/public/bibliotheque');
            $path = public_path('bibliotheques');
               
            if(!File::exists($path))
                File::makeDirectory($path, 0755, true);
    
                $filename = $reference . "_".rand(1,10000);
                $extension = '.'.$file->getClientOriginalExtension();

                // On supprime le premier document
                if(File::exists($document->url))
                unlink($document->url);
                
                
                // On déplace le fichier dans le dossier bibliotheque 
                $file->move($path,$filename.$extension);  
                // on enregistre le chemin complet du fichier déplacé dans la variable path
                $path = $path.'/'.$filename.$extension;
                // dd($path);
                
                
                                 
                $document->nom =  $request["nom"];  
                $document->reference =  $reference;
                $document->description =  $request["description"];  
                $document->url = $path;
                $document->extension = $extension;
                $document->date_expiration = $request["date_expiration"]; 
                
                $document->update();
                
                
                
                $action = Auth::user()->nom." ".Auth::user()->prenom." a modifié le fichier $document->nom dans la bibliothèque";
                $user_id = Auth::user()->id;
          
                Historique::createHistorique( $user_id,$document->id,"autre",$action );
       
                
    
            
                
             
        }//SI LE MANDATAIRE N'A PAS RENSEIGNE DE FICHIER         
        else{
        
                $document->nom =  $request["nom"]; 
                $document->description =  $request["description"]; 
                $document->reference =  $reference;
                
                $document->date_expiration = $request["date_expiration"]; 
                
                $document->update();
        
        
        
        }
        
        return redirect()->route('bibliotheque.index')->with('ok', "Document Modifié");
        
    }




    /**
     * Télécharger un document
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download_bibliotheque ($id)
    {
      
        
       
        $document = Bibliotheque::where('id', $id)->first();

        $filename = $document->reference.$document->extension ;
        
        // dd($fichier->url);
      
        return response()->download($document->url,$filename);
    }
    
    
    /**
     * Envoyer un document
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function envoyer_document ($id, $user_id, $type_user = "mandataire")
    {
      
        
       
        $document = Bibliotheque::where('id', $id)->first();
        
        if($type_user == "prospect"){
            $user = Prospect::where('id', $user_id)->first();
           
        }else{
            $user = User::where('id', $user_id)->first();              
        }
    
    // dd($user);
        Mail::to($user->email)->send(new SendDocument($document,$user, $type_user));
        
        $user->bibliotheques()->attach($id, ['est_fichier_vu'=> false, 'created_at' => date('Y-m-d'), 'updated_at' => date('Y-m-d')]);
        
        return redirect()->back()->with('ok', "Document : $document->nom envoyé au mandataire");

    }
    
    
    
    /**
     *Affiche le document envoyé par mail avec le formulaire de confirmation
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id, $user_id, $type_user = "mandataire")
    {
    
    
        $document = Bibliotheque::where('id',$id)->first();
        
        if($type_user == "prospect"){
            // $user = Prospect::where('id',  Crypt::decrypt($user_id))->first();
            // dd($user_id);
           
        }else{
            // $user = User::where('id',  Crypt::decrypt($user_id))->first(); 
            
        }
        $user = Prospect::where('id', $user_id)->first();
        
        // on vérifie si le user a déjà ouvert au document
        
        $user_biblio = $user->bibliotheques()->wherePivot('bibliotheque_id', $id)->first() ;
        
        if($user_biblio != null ){
            $user->bibliotheques()->updateExistingPivot($id, ['est_fichier_vu'=> true, 'updated_at' => date('Y-m-d')]) ;       
        } 
 
        
        // $user->bibliotheques()->attach($id);
  
  
        
        
        $pdf = explode('/',  $document->url)[sizeof(explode('/',  $document->url)) -1];
        
        // dd($pdf);
      
        return view('bibliotheque.show', compact('document', 'pdf', 'user_id','type_user'));
    }
    
    
    /**
     *Affiche le document envoyé par mail avec le formulaire de confirmation
     *
     * @return \Illuminate\Http\Response
     */
    public function reponseUser(Request $request, $id, $user_id, $type_user = "mandataire")
    {
    
    
        $document = Bibliotheque::where('id',$id)->first();
        
        if($type_user == "prospect"){
            // $user = Prospect::where('id',  Crypt::decrypt($user_id))->first();
            // dd($user_id);
        }else{
            // $user = User::where('id',  Crypt::decrypt($user_id))->first(); 
            
        }
        $user = Prospect::where('id', $user_id)->first();
        
        
        $user_biblio = $user->bibliotheques()->wherePivot('bibliotheque_id', $id)->first() ;
        
        if($user_biblio != null ){        
            $user->bibliotheques()->updateExistingPivot($id, ['question1' => $request->question1, 'updated_at' => date('Y-m-d')]) ;
        }
                

        
        $pdf = explode('/',  $document->url)[sizeof(explode('/',  $document->url)) -1];
        
        // dd($pdf);
        
        return redirect()->back()->with('ok', 'Merci pour votre réponse ');
      
        // return view('bibliotheque.show', compact('document', 'pdf'));
    }


    /**
     * Suppression d'un document
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    
        $document = Bibliotheque::where('id', $id)->first();
        
        if(file_exists($document->url)) unlink($document->url);
        
        $document->users()->detach();
        
        Bibliotheque::destroy($document->id);
       
        
        return redirect()->route('bibliotheque.index')->with('ok', "Document Supprimé");
        
    }
    
}
