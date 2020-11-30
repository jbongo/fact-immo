<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tva extends Model
{
    protected $dates = ['date_debut_tva_actuelle','date_debut_tva_prochaine'];
    protected $guarded =[];
    
    public static function tva(){
    
        $tva = Tva::where('actif',true)->first();
    
        return $tva->tva_actuelle;
    }
    
    public static function tva100(){
    
        $tva = Tva::where('actif',true)->first();
    
        return $tva->tva_actuelle; 
    }

}
