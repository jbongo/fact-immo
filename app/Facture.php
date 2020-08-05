<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    //
    protected $guarded =[];
    protected $dates =['date_facture','date_reglement','date_encaissement'];

    public function compromis()
    {
        return $this->belongsTo(Compromis::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


  /**
     * sauvegarde de facture d'avoir
     *
     * @return \Illuminate\Http\Response
     */
    public static function store_avoir ($facture_id, $numero, $motif){
     

        $facture = Facture::where('id',$facture_id)->first();

        $avoir = Facture::create([
            "numero"=> $numero,
            "user_id"=> $facture->user_id,
            "facture_id"=> $facture->id,
            "compromis_id"=> $facture->compromis_id,
            "type"=> "avoir",
            "motif"=> $motif,
            "encaissee"=> false,
            "montant_ht"=>  $facture->montant_ht,
            "montant_ttc"=> $facture->montant_ttc,
            "date_facture"=> date('Y-m-d H:i:s'),

        ]);

        $facture->a_avoir = true;
        $facture->update();

        return $avoir;
        

    }
    public function avoir(){
        // $avoir = Facture::
        return $this->hasOne(Fac::class);
    }
}
