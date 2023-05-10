<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Individu extends Model
{
    //
    protected $guarded =[];
    
    /**
     * The entites that belong to the Individu
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function entites()
    {
        return $this->belongsToMany(Entite::class);
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
