<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compromis extends Model
{
    //
    protected $guarded =[];
    protected $dates = ['date_vente'];


    public function  user(){
        return $this->belongsTo('App\User');
    }
}
