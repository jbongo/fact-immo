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

        if($facture->type == "stylimmo"){
    
    
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
    
            }else{
            
            
                $mandataire = $facture->user;
                if($mandataire != null){
                    $nom = $mandataire->nom;
                    $prenom = $mandataire->prenom;
                    $mandataire_id = $mandataire->id;
                }else {
                
                    $nom = "";
                    $prenom = "";
                    $mandataire_id = 0;
                    
                }
        
                $filename = "FAVOIR ".$numero." ".$facture->montant_ttc."€ ".strtoupper($nom)." ".strtoupper(substr($prenom,0,1)).".pdf" ;
                
                // dd($filename);
              
    
            
              // on sauvegarde la facture dans le repertoire du mandataire
                $path = storage_path('app/public/'.$mandataire_id.'/avoirs');
    
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
                    "url"=> null,
                    
                    "destinataire_est_mandataire"=> $facture->destinataire_est_mandataire,
                    "destinataire"=> $facture->destinataire,
                    "description_produit"=> $facture->description_produit,
                    
        
                ]);
                
                $pdf = PDF::loadView('facture.avoir.pdf_avoir_autre',compact(['facture','avoir']));
                
                $path = $path.'/'.$filename;
                $pdf->save($path);
                
              
                $avoir->url = $path;
                $avoir->update();
    
            
            }
    
            $facture->a_avoir = true;
            $facture->update();




        return $avoir;
        

    }
    public function avoir(){
        $avoir = Facture::where([['facture_id',$this->id,['type','avoir']]])->first();
        return $avoir;
    }

    public function facture_avoir(){
        $avoir = Facture::where([['id',$this->facture_id,['type','stylimmo']]])->first();
        return $avoir;
    }
    
    public static function nb_facture_a_payer(){
        $nb =  Facture::whereIn('type',['honoraire','partage','parrainage','parrainage_partage'])->where([['reglee', false], ['statut','valide']])->count();
        return $nb;
    }
   
}
