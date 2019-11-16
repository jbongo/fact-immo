<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    //
    protected $guarded =[];
    protected $dates =['date_facture'];

    public function compromis()
    {
        return $this->belongsTo(Compromis::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function avoir(){
        return $this->hasOne(Avoir::class);
    }
}
