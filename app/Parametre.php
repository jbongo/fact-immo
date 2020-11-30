<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parametre extends Model
{
    protected $guarded =[];
    
    public function tva (){
       
        return $this->belongsTo(Tva::class);
       
    }
    
    public static function montant_tva(){
    
    $parametre = Parametre::first();
    return $parametre->ca_imposable;
    }
}
