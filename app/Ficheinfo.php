<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Ficheinfo extends Model
{
    //
    protected $guarded =[];
    
    
    /**
     * Get the user that owns the Ficheinfo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
        
    /**
     * Liste des outils de la fiche info
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function outilfiche()
    {
        return $this->hasMany(Outilfiche::class);
    }
 
}
