<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cronjob extends Model
{
    //
    protected $guarded =[];
    protected $dates =['execute_le'];
}
