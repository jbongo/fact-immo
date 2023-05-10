<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{
    protected $guarded =[];
    
    public function photosbiens(){

        return $this->hasMany(Bienphoto::class);
    }




    public function biendetail(){

        return $this->hasOne(Biendetail::class);
    }

    public function annonces(){

        return $this->hasMany(Annonce::class);
    }

    public function diffusions(){

        return $this->hasMany(Diffusion::class);
    }

    public function user(){

        return $this->belongsTo(User::class);
    }

    public function mandat(){

        return $this->hasMany(Mandat::class);
    }
    
    /**
     * Retourne les contacts du biens
     *
     */
    public function contacts()
    {
        return $this->belongsToMany(Contact::class);
    }
    
    /**
     * Retourne le proprietaire du Bien
     *
     */
    public function proprietaire()
    {
    
        return $this->belongsTo(Contact::class, 'proprietaire_id', 'id');
    }
}
