<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use SoapBox\Formatter\Formatter;

use App\Bien;
use App\Bienphoto;
use App\Annonce;
use Illuminate\Support\Facades\Crypt;

class AnnonceController extends Controller
{
    private $photos_path;

    public function __construct()
    {
        $this->photos_path = public_path('/images/photos_bien');
    }

/** Page d'ajout d'une annonce
* @author jean-philippe
* @return \Illuminate\Http\Response
**/ 
    public function create($bien_id ){
        
        $bien_id_crypt =  $bien_id;

       $bien_id =  Crypt::decrypt($bien_id); 
       
        // return $bien_id;
        $liste_photos = Bienphoto::where('bien_id',$bien_id)->orderBy('image_position','asc')->get();
        
        $bien = Bien::where('id',$bien_id)->firstOrFail();
        //  dd($liste_photos );
        return view('diffusion.prog.add_annonce',compact(['bien','liste_photos','bien_id_crypt']));
    }

    /** Page d'édition d'une annonce
* @author jean-philippe
* @return \Illuminate\Http\Response
**/ 
public function edit($annonce_id ){
        
    $annonce_id_crypt =  $annonce_id;
    $annonce_id =  Crypt::decrypt($annonce_id); 
   
    // return $bien_id;
    $liste_photos = Bienphoto::where('annonce_id',$annonce_id)->orderBy('image_position','asc')->get();
    $annonce = Annonce::where('id',$annonce_id)->firstOrFail();
    $bien_id_crypt = Crypt::encrypt($annonce->bien_id); 
  
    return view('diffusion.prog.edit_annonce',compact(['annonce','liste_photos','bien_id_crypt','annonce_id_crypt']));
}

/** Création d'une nouvelle annonce
*
* @author jean-philippe
* @return \Illuminate\Http\Response
**/ 
    public function update(Request $request, Annonce $annonce){
        //  dd($request);
        // return $annonce;
        if($annonce->identifiant_annonce == $request->identifiant_annonce){
            $request->validate([
                "titre" => 'required|string',
                "description" => 'required|string',
                "prix" => 'required|numeric',
            ]);
        }else{
            $request->validate([
                "identifiant_annonce" => 'required|unique:Annonce|string|max:255',
                "titre" => 'required|string',
                "description" => 'required|string',
                "prix" => 'required|numeric',
            ]);
        }

        $annonce->identifiant_annonce = $request->identifiant_annonce;
        $annonce->titre = $request->titre;
        $annonce->description = $request->description;
        $annonce->prix = $request->prix;

        
       $annonce->update();

        $bien_id_crypt = Crypt::encrypt($annonce->bien_id);
      
        return redirect()->route('annonce.index',$bien_id_crypt)->with('ok',__("Annonce modifiée"));
       
    }
        

/**Liste des annonces d'un bien
* @author jean-philippe
* @return \Illuminate\Http\Response
**/ 
public function index($bien_id){
        
    $bien_id_crypt =  $bien_id;

   $bien_id =  Crypt::decrypt($bien_id); 
   
    // return $bien_id;
    $liste_photos = Bienphoto::where('bien_id',$bien_id)->orderBy('image_position','asc')->get();
    $annonces = Annonce::where('bien_id',$bien_id)->get();
    
    $bien = Bien::where('id',$bien_id)->firstOrFail();
    
    return view('diffusion.prog.index_annonce',compact(['bien','annonces', 'bien_id_crypt']));
}



/** Création d'une nouvelle annonce
*
* @author jean-philippe
* @return \Illuminate\Http\Response
**/ 
    public function store(Request $request ){
//   dd($request);
        $request->validate([
            "identifiant_annonce" => 'required|unique:annonces|string|max:255',
            "titre" => 'required|string',
            "description" => 'required|string',
            "prix" => 'required|numeric',
        ]);
        
      
        $annonce = Annonce::create([
            "identifiant_annonce" => $request->identifiant_annonce ,
            "titre"=> $request->titre,
            "description"=> $request->description,
            "prix"=> $request->prix,
            "bien_id"=> $request->bien_id,
        ]);

        $annonce_id_crypt = Crypt::encrypt($annonce->id);
        $bien_id_crypt = Crypt::encrypt($request->bien_id);
        
        // dd($request->bien_id);
        return redirect()->route('annonce.add_photo',[$bien_id_crypt,$annonce->id]);
        // return view('diffusion.prog.add_annonce',compact('bien_id'));
    }
    
///////// ########## GESTION DES PHOTOS DE L'ANNONCE

    // affichage du formulaire d'ajout des photos dE l'annonce
    public function uploadPhoto($bien_id, $annonce_id){
    
        return view('diffusion.prog.add_photos_annonce',compact(['bien_id','annonce_id']));
    }

/** Ajout des photos de l'annonce
*
* @author jean-philippe
* @return \Illuminate\Http\Response
**/ 
    public function storePhotos(Request $request, $bien_id, $annonce_id ){

        $photos = $request->file('file');
         
        
        // on converti la variable $photo en tableau s'il y'a une seule photo 
        if (!is_array($photos)) {
            $photos = [$photos];
        }
        
        if (!is_dir($this->photos_path)) {
            mkdir($this->photos_path, 0777);
            $this->photos_path .= '/'.auth()->id();
            mkdir($this->photos_path, 0777);
        }else{
            $this->photos_path .= '/'.auth()->id();
            if (!is_dir($this->photos_path)) {

                mkdir($this->photos_path, 0777);
            }
        }

        // dd($photos);
       
            for ($i = 0; $i < count($photos); $i++) {
                $photo = $photos[$i];
                $name = sha1(date('YmdHis') .str_random(30));
                $save_name = auth()->id().'/'.$name. '.' .$photo->getClientOriginalExtension();
                $resize_name = $name. str_random(2). '.' .$photo->getClientOriginalExtension();
                
                $img = Image::make($photo)
                    ->resize(750, 550)
                     ->save($this->photos_path .'/' .$resize_name);
    
              
                $photo->move($this->photos_path, $save_name);
                
                $bienid = Crypt::decrypt($bien_id);
                
                // dans ce bloc, on réccupère la plus grande position enrégistrée et on l'incremente pour la position de l'image suivante
                $image_position = 0;
                $image_position =  Bienphoto::where([
                    ['annonce_id',$annonce_id],
                 
                    ])->pluck('image_position')->toArray();

                if(sizeof($image_position) ==0){
                    $image_position = 1;
                }else{
                      $image_position = max($image_position ) + 1;
                }
              
                

                Bienphoto::create([
                    "bien_id" => $bienid,
                    "visibilite"=> "visible",
                    "is_annonce" => true,
                    "annonce_id" => $annonce_id,
                    "filename"=> $save_name,
                    "resized_name"=>auth()->id().'/'.$resize_name,
                    "original_name"=> basename($photo->getClientOriginalName()),
                    "image_position" => $image_position,

                ]);
                     //dd($photos);
                     
            }
            
        // return Response::json([
        //     'message' => 'Images sauvegardées'
        // ], 200);
    
    }
}
