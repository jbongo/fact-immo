<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contratfournisseur extends Model
{
    protected $guarded =[];
    protected $dates = ['date_deb','date_fin'];    
    
    /**
     * Retourne tous les articles du contrat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
