<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{
    protected $guarded = [];

    public function mandat()
    {
        return $this->hasMany(Mandat::class);
    }
}
