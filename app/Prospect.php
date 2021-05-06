<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prospect extends Model
{
    //
    protected $guarded =[];
    protected $dates = ['date_ouverture_fiche','date_naissance'];
}
