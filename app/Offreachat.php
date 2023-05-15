<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offreachat extends Model
{
    protected $guarded = [];

    public function bien(){
        return $this->belongsTo(Bien::class);
    }

    public function acquereur(){
        return $this->belongsTo(Contact::class);
    }
    
    public function notaire(){
        return $this->belongsTo(Contact::class);
    }
}
