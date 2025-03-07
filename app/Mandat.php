<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mandat extends Model
{
    protected $guarded = [];
    protected $dates = ['date_debut','date_fin'];


/**
 * Retourne le mandataire qui a saisie le mandat.
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */

    public function user(){
        return $this->belongsTo('App\User');
    }
    /**
     * Retourne le mandataire qui suit l'affaire.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function suiviPar(){
        
        return $this->belongsTo('App\User', 'suivi_par_id');
    }

    /**
     * Retourne le contact qui a signé le mandat.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function contact(){
        return $this->belongsTo('App\Contact');
    }

    /**
     * Retourne le bien concerné par le mandat.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bien(){
        return $this->belongsTo('App\Bien');
    }
}

