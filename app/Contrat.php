<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    //
    protected $guarded =[];
    protected $dates = ['date_entree','date_deb_activite'];
    public function  user(){

        return $this->belongsTo(User::class);
    }
    public function packpub()
    {
        return $this->belongsto(Packpub::class);
    }
}
