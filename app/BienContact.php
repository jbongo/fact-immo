<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BienContact extends Model
{
    //
    protected $guarded =[];
    
    /**
     * Retourne le contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
    
    /**
     * Retourne le bien
     *
     */
    public function bien()
    {
        return $this->belongsTo(User::class);
    }
}
