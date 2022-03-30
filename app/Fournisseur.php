<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    protected $guarded =[];

    //
    
    /**
     * Retourne tous les contrats du fournisseur
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contrats()
    {
        return $this->hasMany(Contratfournisseur::class);
    }
    
    /**
     * Retourne toutes les commandes du fournisseur
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function commandes()
    {
        return $this->hasMany(Commandefournisseur::class);
    }
}
