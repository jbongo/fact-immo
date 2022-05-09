<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    //
    
    protected $guarded =[];
    protected $dates = ['date_deb','date_fin'];
    
    public function  user(){
        return $this->belongsTo('App\User');
    }
    
    public function  prospect(){
        return $this->belongsTo('App\Prospect');
    }
    
    public static function nb_taches($type_tache = "a_faire"){
    
    
    if($type_tache =="a_faire"){
        $nb_taches = Agenda::where([['est_terminee', false], ['date_deb', '>=', date('Y-m-d')]])->count();
        
    }elseif($type_tache == "en_retard"){
        $nb_taches = Agenda::where([['est_terminee', false], ['date_deb', '<', date('Y-m-d')]])->count();
    
    }else{
    
        $nb_taches = "erreur de paramètre";
    }
        
        return $nb_taches;
       
    } 
}
