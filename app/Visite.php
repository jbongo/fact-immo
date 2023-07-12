<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visite extends Model
{
    protected $guarded =[];
    
    
    /**
     * Get the contact that owns the Visite
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
