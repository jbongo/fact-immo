<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    //
    
    protected $guarded =[];
    // protected $dates = ['date_deb','date_fin'];
    
    public function  user(){
        return $this->belongsTo('App\User');
    }
    
    public function  prospect(){
        return $this->belongsTo('App\Prospect');
    }
}
