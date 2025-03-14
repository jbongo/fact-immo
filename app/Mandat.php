<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mandat extends Model
{
    protected $guarded = [];
    protected $dates = ['date_debut','date_fin', 'date_cloture', 'date_retour'];


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
    /**
     * Retourne le nombre de mandats non retournés.
     * 
     * @return int
     */
    public function nonRetournes($query)
    {
        return $query->where('statut', 'mandat')->where('est_retourne', false);
    }

    /**
     * Retourne le nombre de mandats non retorunés d'un utilisateur.
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function nonRetournesParUser($user_id)
    {
            return Mandat::where('user_id', $user_id)
                        ->where('statut', 'mandat')
                     ->where('est_retourne', false)
                     ;
    }

    /**
     * Retourne le nombre de réservations.
     * 
     * @return int
     */
    public function reservations()
    {
        return $this->where('statut', 'réservation');
    }

    /**
     * Retourne le nombre de réservations d'un utilisateur.
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function reservationsParUser($user_id)
    {
        return static::where('user_id', $user_id)->where('statut', 'réservation');
    }
}

