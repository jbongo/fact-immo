<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //
    protected $guarded =[];
    
    
     /**
     * Get the individu that owns the Contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function individu()
    {
        return $this->hasOne(Individu::class);
    }
    
    
    /**
     * Get the entite associated with the Contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function entite()
    {
        return $this->hasOne(Entite::class);
    }
    
    /**
     * Retourne les biesn du contacts
     *
     */
    public function biens()
    {
        return $this->belongsToMany(Bien::class);
    }
}
