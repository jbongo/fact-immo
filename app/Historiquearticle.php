<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historiquearticle extends Model
{
    
    protected $guarded =[];
    protected $dates = ['date_achat','date_expiration'];
}
