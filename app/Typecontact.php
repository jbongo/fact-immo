<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Typecontact extends Model
{
    protected $guarded =[];
    
    /**
     * The contacts that belong to the Typecontact
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function contacts()
    {
        return $this->belongsToMany(Contact::class);
    }
    
}
