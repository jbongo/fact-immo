<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    //
    protected $guarded =[];
    protected $dates = ['date_entree','date_deb_activite','date_demission','date_fin_preavis','date_fin_droit_suite','date_anniversaire'];         
    
    public function  user(){

        // return $this->belongsTo(User::class);
        return $this->belongsTo(User::class);
    }
    public function packpub()
    {
        return $this->belongsto(Packpub::class);
    }
    
    // Le montant pub que le mandataire doit payer
    
    // public function tarifpub()
    // {
    //     $contrat = $this;
        
        
              
    //     if($contrat->user->pack_actuel == "expert") ){
          
    //         $montant_ht = round($contrat->packpub->tarif / Tva::coefficient_tva(), 2);
    //         $montant_ttc = $contrat->packpub->tarif;
            
    //         ]);
            
            
           
            
    //     }else{
        
        
        
    //     }
    //     return $this->belongsto(Packpub::class);
    // }
}
