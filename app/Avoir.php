<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avoir extends Model
{
    //
    protected $guarded =[];
    protected $dates = ['date'];


    public function  facture(){
        return $this->belongsTo('App\Facture');
    }
}
