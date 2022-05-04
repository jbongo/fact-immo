<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Outilfiche extends Model
{
    protected $guarded =[];
    
        
    /**
     * Reccupérer la fiche info
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ficheinfo()
    {
        return $this->belongsTo(Ficheinfo::class);
    }
}
