<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    //
    protected $guarded =[];
    protected $dates =['date_facture','date_reglement','date_encaissement'];

    public function compromis()
    {
        return $this->belongsTo(Compromis::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function create_avoir ($facture_id){
        
    }
    public function avoir(){
        return $this->hasOne(Avoir::class);
    }
}
