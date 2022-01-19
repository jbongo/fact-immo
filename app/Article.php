<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded =[];
    protected $dates = ['date_achat','date_expiration'];

    public function  fournisseur(){
        return $this->belongsTo('App\Fournisseur');
    }
    
    public function  contratfournisseur(){
        return $this->belongsTo('App\Contratfournisseur');
    }
}
