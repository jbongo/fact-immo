<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commandefournisseur extends Model
{
    protected $guarded =[];
    protected $dates = ['date_commande'];    
    
    /**
     * Retourne tous les articles de la commande
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
