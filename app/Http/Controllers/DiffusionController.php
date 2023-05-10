<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Passerelle;
use App\Bien;
use App\Diffusion;
use App\Utilisateur;
use App\Annonce;
use Illuminate\Support\Facades\Crypt;


class DiffusionController extends Controller
{
    private $passerelles_path;
    private $photos_path;
    
    public function __construct()	{
		$this->passerelles_path = public_path('/images/passerelles_xml');
		$this->photos_path = public_path('/images/photos_bien');
    }
    

/** Liste des passerelles 
*
* @author jean-philippe
* @return \Illuminate\Http\Response
**/ 
    public function index_auto(){
        $passerelles = Passerelle::all();
        
        // les admins ont accès à tous les biens
        if(Auth()->user()->role== "admin"){
            $biens = Bien::all();
        }
        else{
            $biens = Bien::where('utilisateur_id',auth()->id())->get();            
        }
        
        return view('diffusion.diffusion_auto',compact(['passerelles','biens']));
    }


/** Obtenir les passerelles sur lesquelles un bien est diffusé
*
* @author jean-philippe
* @return \Illuminate\Http\Response
**/ 
public function getPasserelles(Bien $bien_id){
    
    
    $all_passerelles = Passerelle::where('statut',1)->get()->toArray();
    $passerelles = Passerelle::where('statut',1)->get();
    
    // on réccupère l'id des passerelles 
    $passerelles_bien = Diffusion::where([ ['bien_id',$bien_id->id], ['type','automatique'] ])->select('passerelle_id')->get();
    
    // tab_passerelles contient la liste de toutes les passerelles actives et celles cochées pour le bien
    $tab_passerelles =  array($all_passerelles,$passerelles_bien);
   
    return json_encode($tab_passerelles) ;
}



/** Ascocier une passerelle au bien
*
* @author jean-philippe
* @return \Illuminate\Http\Response
**/ 
public function attach_passerelle_bien( Request $request, $bien_id){
    
    $bien_passerelles = json_decode($request["pass_bien"], true);
// return $bien_passerelles;
// on parcour un tableau de [bien,passerelle]
    foreach ($bien_passerelles as $data ) {
        if(Diffusion::where([ ['bien_id',$bien_id], ['passerelle_id',$data[0]], ['type','automatique'] ])->count()<=0){
            if($data[1] == true){
                Diffusion::create([
                "bien_id"=>$bien_id,
                "type"=>"automatique",
                "passerelle_id"=>$data[0],
                ]);
            }
        }else{
            if($data[1] == false){
                $diffusion = Diffusion::where([ ['bien_id',$bien_id], ['passerelle_id',$data[0]], ['type','automatique'] ])->delete();
            }
        }

    }
  
   
    // return $bien_passerelles;
 }

 

   /************************************************************/
  /*             DIFFUSION PLANIFIE                           */
 /* **********************************************************/


 
/** 
 * Renvoie la page de plannification de diffusions
 *
 * @author jean-philippe
 * @param App\Models\Biens $bien
 * @return \Illuminate\Http\Response
*/ 
public function create($bien_id){
       
    $bien_id_decrypt = Crypt::decrypt($bien_id);
    $bien = Bien::where('id',$bien_id_decrypt)->first();   
    $passerelles_ = Passerelle::where('type',"Avec abonnement")->get();
    
    $passerelles_size = sizeof($passerelles_);
    $passerelles = $passerelles_->toJson() ;
    $annonces = Annonce::where('bien_id',$bien_id_decrypt)->get();
    
    $diffusions = Diffusion::where('type','planifie')->get();
    // on reccupere toutes les dates de diffusion par passerelle pour ce bien 
    $dates_de_diff = Diffusion::select('date','passerelle_id')->where([['type','planifie'],['bien_id',$bien_id_decrypt]])->get()->toArray();
    // on construis un tableau de dates par passerelles
    $dates_de_diffusion = array();
// dd($dates_de_diff);
    foreach ($passerelles_ as $passerelle) {
        $days = array();
        foreach ($dates_de_diff as $date) {
            if($passerelle->id === $date['passerelle_id']){
                $day = $date['date']; 
                // $day = $day['mday'].'/'.$day['mon'].'/'.$day['year'];
                array_push ($days, $day);
            }
           
        }
        $dates_de_diffusion[$passerelle->id] = $days;
    }
// dd($dates_de_diffusion);
    
    $dates_de_diffusion = json_encode($dates_de_diffusion);
    return view('diffusion.prog.add_diffusion',compact(['passerelles','bien','passerelles_size','annonces','bien_id','diffusions','dates_de_diffusion']));
}

public function create_suiv_prec($bien_id){
       
    $bien_id_decrypt = Crypt::decrypt($bien_id);
    $passerelles_ = Passerelle::where('type',"Avec abonnement")->get();
    
    $passerelles_size = sizeof($passerelles_);
    $passerelles = $passerelles_->toJson() ;
    
    // on reccupere toutes les dates de diffusion par passerelle pour ce bien 
    $dates_de_diff = Diffusion::select('date','passerelle_id')->where([['type','planifie'],['bien_id',$bien_id_decrypt]])->get()->toArray();
    // on construis un tableau de dates par passerelles
    $dates_de_diffusion = array();
    foreach ($passerelles_ as $passerelle) {
        $days = array();
        foreach ($dates_de_diff as $date) {
            if($passerelle->id === $date['passerelle_id']){
                $day = $date['date']; 
                array_push ($days, $day);
            }
           
        }
        $dates_de_diffusion[$passerelle->id] = $days;
    }
    
    $dates_de_diffusion = json_encode($dates_de_diffusion);
    return $dates_de_diffusion;
}
/** 
* Liste des passerelles 
*
* @author jean-philippe
* @return \Illuminate\Http\Response
*/ 
public function index_prog(){
    $passerelles = Passerelle::all();
    
    // les admins ont accès à tous les biens
    if(Auth()->user()->role== "admin"){
        $biens = Bien::all();
    }
    else{
        $biens = Bien::where('utilisateur_id',auth()->id())->get();            
    }
    
    return view('diffusion.diffusion_prog',compact(['passerelles','biens']));
}


/** Affiche la page sur laquelle on choisit les date de diffusion et les annonces 
*
* @author jean-philippe
* @return \Illuminate\Http\Response
**/ 
public function date_annonce( $passerelles, $bien_id){
    
    // return json_decode($passerelles, true);
    $passerelles_id = array();
    foreach( json_decode($passerelles, true) as $id){          
        array_push($passerelles_id, (int)$id );
    }
    
    $passerelles_id = json_encode($passerelles_id);



    $passerelles = Passerelle::whereIn('id',json_decode($passerelles, true))->get();
    $bien = Bien::where('id',$bien_id)->firstOrFail();
//  dd($passerelles_id);

    return view('diffusion.prog.date_annonce',compact(['passerelles','bien','passerelles_id']));
}

/** Sauvegarder la planification de la Diffusion
*
* @author jean-philippe
* @return \Illuminate\Http\Response
**/ 
public function planifier(Request $request, $bien_id ){
    
    // return json_encode($request->passerelle_id."---".$request->datepicker1."---".$request->datepicker2."---".$request->choose_annonce."---".$request->annonce_id);

    $passerelle_id = $request->passerelle_id;
    $date_debut = $request->datepicker1;
    $date_fin = $request->datepicker2;
    $choose_annonce = $request->choose_annonce;
    $annonce_id = $request->annonce_id;

    $bien_id = Crypt::decrypt($bien_id);

    if($date_debut > $date_fin){
        $tmp = $date_debut;
        $date_debut = $date_fin;
        $date_fin = $tmp;
    }

    for ($i = $date_debut; $i<=$date_fin; $i+=86400){
        Diffusion::create([
            "bien_id"=>$bien_id,
            "type"=>"planifie",
            "passerelle_id"=>$passerelle_id,
            "annonce_id"=>$annonce_id,
            "date"=>$i,
            "date_debut"=>$date_debut,
            "date_fin"=>$date_fin,
        ]); 
      
    }
    return $date_fin.$i;

    
    

}

/** Liste des diffusions pour un bien 
*
* @author jean-philippe
* @return \Illuminate\Http\Response
**/ 
public function listeDiffusion($type, $bien_id){
   
    if($type =="next"){
        $diffusions = Diffusion::where([ ['bien_id',$bien_id],['date','>',now()] ])->get();
    }elseif($type=="now"){

        $diffusions = Diffusion::where([ ['bien_id',$bien_id],['date','<=',now()],['date','>=', now()] ])->get();
    }else{
        $diffusions = Diffusion::where('bien_id',$bien_id)->get();
    }
    $bien = Bien::where('id',$bien_id)->firstOrFail();
    
    $nb_next = Diffusion::where([ ['bien_id',$bien_id],['date','>',now()] ])->count();
    $nb_now =  Diffusion::where([ ['bien_id',$bien_id],['date','<=',now()],['date','>=', now()] ])->count();
    $nb_all = Diffusion::where('bien_id',$bien_id)->count();
    return view('diffusion.prog.liste_diffusion',compact(['diffusions','bien','type','nb_next','nb_now','nb_all']));
}

/** Supprimer une diffusion
*
* @author jean-philippe
* @return \Illuminate\Http\Response
**/ 
public function delete(Request $request, $bien_id){

    $date_deb = $request->date_deb; 
    $date_fin = $request->date_fin ;

    if($date_deb > $date_fin){
        $tmp = $date_deb;
        $date_deb = $date_fin;
        $date_fin = $tmp;
    }
    $bien_id = Crypt::decrypt($bien_id);
    

   for ($date = $date_deb; $date <= $date_fin ; $date+= 86400) { 
       $diffusion = Diffusion::where([ ['bien_id',$bien_id],['passerelle_id',$request->passerelle_id],['date',$date]])->first();
       if($diffusion != null)
       $diffusion->delete();
   }
//    $diffusion = Diffusion::where([ ['bien_id',$bien_id],['passerelle_id',$request->passerelle_id],['date',$date_deb]])->first();

   return $request;
} 
}
