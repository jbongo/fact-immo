<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    //
    protected $guarded =[];

    public function  mandataire(){

        return $this->belongsTo(Mandataire::class);
    }
    public function packpub()
    {
        return $this->belongsto(Packpub::class);
    }
}
