<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bibliotheque extends Model
{
    //
    protected $guarded =[];
    protected $dates = ['date_expiration'];
    
   // Retourne tous les users qui ot reçus le document
    public function users(){
        return $this->belongsToMany(User::class, 'user_bibliotheque', 'user_id', 'bibliotheque_id');

    }
        
    // Retourne le document si l'utilisateur passé en paramètre l'a reçu
    public function getUser($user_id ){

        return $this->users()->wherePivot('user_id', $user_id)->withPivot('est_fichier_vu','question1','created_at','updated_at')->first();
    
    }
    
    // Retourne tous les prospects qui ot reçus le document
    public function prospects(){
        return $this->belongsToMany(Prospect::class, 'prospect_bibliotheque',  'bibliotheque_id','prospect_id');

    }
        
    // Retourne le document si le prospect passé en paramètre l'a reçu
    public function getProspect($prospect_id ){

        return $this->prospects()->wherePivot('prospect_id', $prospect_id)->withPivot('est_fichier_vu','question1','created_at','updated_at')->first();
    
    }
    
}
