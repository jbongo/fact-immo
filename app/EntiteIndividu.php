<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntiteIndividu extends Model
{
    //
    protected $guarded =[];
    
    /**
     * Get the individu that owns the EntiteIndividu
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function individu()
    {
        return $this->belongsTo(Individu::class);
    }
    
    /**
     * Get the entite that owns the EntiteIndividu
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entite()
    {
        return $this->belongsTo(Entite::class);
    }
    
}
