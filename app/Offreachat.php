<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offreachat extends Model
{
    protected $guarded = [];
    protected $dates = ['date_debut','date_expiration'];

    public function bien(){
        return $this->belongsTo(Bien::class);
    }

    public function acquereur(){
        return $this->belongsTo(Contact::class);
    }
    
    public function notaire(){
        return $this->belongsTo(Contact::class);
    }
    
        /**
     * Get the contact that owns the Offre
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
