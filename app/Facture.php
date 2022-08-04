<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PDF;
use Illuminate\Support\Facades\File ;
use App\Facture;
use App\User;
use App\Factpub;
use App\Fournisseur;

class Facture extends Model
{
    //
    protected $guarded =[];
    protected $dates =['date_facture','date_reglement','date_encaissement','date_relance_paiement','date_ajout_facture','date_export'];

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
    // retourne l'avoir d'une facture
    public function avoir(){
        $avoir = Facture::where([['facture_id',$this->id,['type','avoir']]])->first();
        return $avoir;
    }

    // Retourne la facture liée à un avoir
    public function facture_avoir(){
        $avoir = Facture::where([['id',$this->facture_id]])->first();
        return $avoir;
    }
    
    public static function nb_facture_a_payer(){
        $nb =  Facture::whereIn('type',['honoraire','partage','parrainage','parrainage_partage','partage_externe'])->where([['reglee', false], ['statut','valide']])->count();
        return $nb;
    }
    
    
    
    
    // Retourne le max à deduire et le reste à déduire
    public static function etat_jeton($user_id){
        
        $mandataire = User::where('id', $user_id)->first();
        $tab = array();
        
        if($mandataire->contrat->deduis_jeton == true) {
        
            $jeton_restant = $mandataire->nb_mois_pub_restant ;
            $tab["jeton_restant"] = $jeton_restant;
            
            $today = date_create(date('Y-m-d'));
            $date_anniv = date_create($mandataire->date_anniv());
            
            // nombre de mois entre la date d'anniv et aujourd'hui == nombre de jeton minimum à deduire pour être à jour
            $interval = date_diff($today, $date_anniv);
            
            // Nombre de jeton qui doit rester à deduire
            $nb_mois_max  = 12 - $interval->m;
            $tab["jeton_max"] = $nb_mois_max ;
            
            
            $tab["retard"] =  ($jeton_restant - $nb_mois_max) > 0 ? ($jeton_restant - $nb_mois_max) : 0 ;
            
            $tab["jeton_min_a_deduire"] = $tab["retard"] > 3 ?  $tab["retard"]  - 3 : 0 ;
            
            $tab['date_anniv'] = $mandataire->date_anniv("fr");
        
        }else{
            return null; 
        }
        
        
        return $tab;
    }
    
    // Pourcentage actuel 
    public  function pourcentage_actuel(){
        
        $formule = unserialize($this->formule);
        
        
        return $formule != null ?  $formule[0][0][1] : null;
    }
    
    
    // Retourne la pré-facture de pub liée à cette facture de pub
    public  function factpublist(){
        
        $factpub = Factpub::where('facture_id', $this->id)->first();
        
        // dd($factpub);
        return $factpub;
        
    }
    
    // Retournisseur si la facture est une facture fournisseur
    
    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }
    
    /**
    *   Retourne l'utilsateur lié à la facture (quand le destinataire n'est pas un mandataire)
    */
    public function userliee(){
    
        return User::where('id', $this->est_liee_mandataire_id)->first();
    }
   
}