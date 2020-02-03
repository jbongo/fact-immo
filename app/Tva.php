<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tva extends Model
{
    protected $dates = ['date_debut_tva_actuelle','date_debut_tva_prochaine'];
    protected $guarded =[];

}
