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
        return $this->hasOne(Mandat::class);
    }
    
    /**
     * Retourne les contacts du bien
     *
     */
    public function contacts()
    {
        return $this->belongsToMany(Contact::class);
    }
    
     /**
     * Retourne les visites du bien
     *
     */
    public function visites()
    {

        return $this->HasMany(Visite::class);
    }
    
    /**
     * Retourne les offres d'achats du bien
     *
     */
    public function offreachats()
    {

        return $this->hasMany(Offreachat::class);
    }
    
    /**
     * Retourne les offres d'achats du bien
     *
     */
    public function offreachataccepte()
    {   
        $offre = Offreachat::where('bien_id', $this->id)->first();
        
        return $offre;
        return $this->hasMany(Offreachat::class);
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
