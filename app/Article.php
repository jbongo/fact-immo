<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded =[];
    protected $dates = ['date_achat'];

    public function  fournisseur(){
        return $this->belongsTo('App\Fournisseur');
    }
}
