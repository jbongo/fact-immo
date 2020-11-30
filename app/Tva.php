<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tva extends Model
{
    protected $dates = ['date_debut_tva_actuelle','date_debut_tva_prochaine'];
    protected $guarded =[];
    
    public static function tva(){
    
        $tva = Tva::where('actif',true)->first();
    
        return $tva->tva_actuelle/100;
    }
    
    public static function coefficient_tva(){
    
        $tva = Tva::where('actif',true)->first();
    
        $coeff = $tva->tva_actuelle/100 + 1 ;
        return $coeff; 
    }

}
