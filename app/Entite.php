<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entite extends Model
{
    //
    protected $guarded =[];
    
    /**
     * The individus that belong to the Entite
     *
     */
    public function individus()
    {
        return $this->belongsToMany(Individu::class);
    }
    /**
     * Get the contact that owns the Entite
     *
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
    
}
