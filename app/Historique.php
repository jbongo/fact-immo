<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historique extends Model
{
    protected $guarded =[];

    //

    public static function createHistorique($user_id,$ressource_id,$ressource,$action ){
        
        Historique::create([
            "user_id"=> $user_id,
            "ressource_id"=> $ressource_id,
            "ressource"=> $ressource,
            "action"=> $action,
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
