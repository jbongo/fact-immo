<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banque extends Model
{
    //
    protected $guarded =[];
    protected $dates = ['date_encaissement'];
}
