<?php

namespace App;

use App\Bibliotheque;
use Illuminate\Database\Eloquent\Model;

class Prospect extends Model
{
    //
    protected $guarded =[];
    protected $dates = ['date_ouverture_fiche','date_naissance','date_expiration_carteidentite'];
    
      // Retourne tous les documents qui lui ont étés envoyés
    public function bibliotheques(){

        return $this->belongsToMany(Bibliotheque::class, 'prospect_bibliotheque', 'prospect_id', 'bibliotheque_id');
    
    }
    
    
    // Retourne tous les documents qui lui ont étés envoyés
      public function getBibliotheque($bibliotheque_id){

        return $this->bibliotheques()->wherePivot('bibliotheque_id', $bibliotheque_id)->withPivot('est_fichier_vu','question1','created_at','updated_at')->first();
    
    }
    
    
}
