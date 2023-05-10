<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diffusion extends Model
{

    protected $guarded = [];    

    public function passerelle(){

        return $this->belongsTo('App\Passerelle');
    }

    public function bien(){
        return $this->belongsTo('App\Bien');
    }

    public function annonce(){
        return $this->belongsTo('App\Annonce');
    }
}
