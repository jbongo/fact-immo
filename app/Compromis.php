<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compromis extends Model
{
    //
    protected $guarded =[];
    protected $dates = ['date_vente','date_mandat'];


    public function  user(){
        return $this->belongsTo('App\User');
    }

    public function getPartage(){

        $partage = User::where('id',$this->agent_id)->first();
        return $partage;
    }

    public function getParrainPartage(){

        $partage = User::where('id',$this->parrain_partage_id)->first();
        return $partage;
    }
}
