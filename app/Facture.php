<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PDF;
use Illuminate\Support\Facades\File ;
use App\Facture;

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

        $compromis = $facture->compromis;
        $mandataire = $facture->user;

        $filename = "FAVOIR ".$numero." ".$facture->montant_ttc."€ ".strtoupper($mandataire->nom)." ".strtoupper(substr($mandataire->prenom,0,1)).".pdf" ;

        
          // on sauvegarde la facture dans le repertoire du mandataire
            $path = storage_path('app/public/'.$mandataire->id.'/avoirs');

            if(!File::exists($path))
                File::makeDirectory($path, 0755, true);


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
            
            $pdf = PDF::loadView('facture.avoir.pdf_avoir_stylimmo',compact(['compromis','mandataire','facture','avoir']));
            
            $path = $path.'/'.$filename;
            $pdf->save($path);
            $avoir->url = $path;

            $avoir->update();

  

        $facture->a_avoir = true;
        $facture->update();




        return $avoir;
        

    }
    public function avoir(){
        $avoir = Facture::where([['facture_id',$this->id,['type','avoir']]])->first();
      
      
        return $avoir;
    }
}
