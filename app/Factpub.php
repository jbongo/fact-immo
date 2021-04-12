<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factpub extends Model
{
    //
    protected $guarded =[];
    protected $dates =['date_validation'];
    
    public function  user(){

        // return $this->belongsTo(User::class);
        return $this->belongsTo(User::class);
    }
}
