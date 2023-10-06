<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Facture;
use App\User;
use App\Historique;


use iio\libmergepdf\Merger;
use iio\libmergepdf\Pages;
use iio\libmergepdf\Driver\Fpdi2Driver;
use iio\libmergepdf\Source\FileSource;

use Illuminate\Support\Facades\Crypt;
use Auth;
use PDF;
use Illuminate\Support\Facades\File ;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ExportwinficController extends Controller
{
    /**
     * Afficher de la liste des factures ventes à exporter
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    
        $date_deb = $request->date_deb;
        $date_fin = $request->date_fin;
        
        if($date_deb == null || $date_fin == null || $date_fin < $date_deb){        
            $date_deb = date("Y-m")."-01";
            $date_fin = date("Y-m-d");        
        }     
        
        $factureStylimmos = Facture::whereIn('type',['stylimmo','avoir','pack_pub','carte_visite','communication','autre','forfait_entree','cci'])->whereBetween('date_facture',[$date_deb,$date_fin])->orderBy('numero','asc')->get();  
        $montant_credit_debit = Facture::whereIn('type',['stylimmo','avoir','pack_pub','carte_visite','communication','autre','forfait_entree','cci'])->whereBetween('date_facture',[$date_deb,$date_fin])->where('user_id','<>',77)->sum('montant_ttc');
        
        // dd($factureStylimmos);
      
        $this->generer_pdf_facture($date_deb, $date_fin);
       
        return view ('winfic.index',compact(['factureStylimmos','date_deb','date_fin','montant_credit_debit']));
        
    }
    
    
     /**
     * Afficher de la liste des factures fournisseurs à exporter
     *
     * @return \Illuminate\Http\Response
     */
    public function index_fournisseur(Request $request)
    {
    
        $date_deb = $request->date_deb;
        $date_fin = $request->date_fin;
        
        if($date_deb == null || $date_fin == null || $date_fin < $date_deb){        
            $date_deb = date("Y-m")."-01";
            $date_fin = date("Y-m-d");        
        }     
        
        $factureFournisseurs = Facture::whereIn('type',['honoraire','partage','partage_externe','parrainage','parrainage_partage'])->whereBetween('date_reglement',[$date_deb,$date_fin])->where([['user_id','<>',77], ['reglee', true]])->orderBy('numero','asc')->get();  
        $nbFacturesExporte = Facture::whereIn('type',['honoraire','partage','partage_externe','parrainage','parrainage_partage'])->whereBetween('date_reglement',[$date_deb,$date_fin])->where([['exporte', true],['user_id','<>',77], ['reglee', true]])->count();  
        $montant_credit_debit = Facture::whereIn('type',['honoraire','partage','partage_externe','parrainage','parrainage_partage'])->whereBetween('date_reglement',[$date_deb,$date_fin])->where([['user_id','<>',77], ['reglee', true]])->sum('montant_ttc');
        
        $date_factures = Facture::whereIn('type',['honoraire','partage','partage_externe','parrainage','parrainage_partage'])->whereBetween('date_reglement',[$date_deb,$date_fin])->where([['user_id','<>',77], ['reglee', true]])->orderBy('date_facture','asc')->select('date_facture')->distinct()->get();  
        
        
        // On réccupère les mois de dates de facture utiles pour saisir les numéros de code pièce
        $mois_factures = array();
        foreach ($date_factures as $date) {
           $mois_factures[] = $date['date_facture']->format('m/Y');
 
        }
        
        $mois_factures = array_unique($mois_factures);
      
       
        return view ('winfic.index_fournisseur',compact(['factureFournisseurs','date_deb','date_fin','montant_credit_debit','mois_factures','nbFacturesExporte']));
        
    }
    
    
    
    

    /**
     *exporter les fichiers ECRITURE.WIN transfert des ventes
     *
     * @return \Illuminate\Http\Response
     */
    public function exporter_ecriture1($date_deb = null, $date_fin = null)
    {
        
        
    
    
        if($date_deb == null || $date_fin == null || $date_fin < $date_deb){        
            $date_deb = date("Y-m")."-01";
            $date_fin = date("Y-m-d");        
        }     
        
        $factureStylimmos = Facture::whereIn('type',['stylimmo','avoir','pack_pub','carte_visite','communication','autre','forfait_entree','cci'])->whereBetween('date_facture',[$date_deb,$date_fin])->where('user_id','<>',77)->orderBy('numero','asc')->get();  
        
        $data = "";
        $num_folio = 1;
        $num_ecriture = 1;
        
        if(file_exists("ECRITURE.WIN")){
            unlink("ECRITURE.WIN");
        }
        
        // ########### TRANSFERT DES VENTES
        
        foreach ($factureStylimmos as $facture) {
           
            $code_journal = "VE";
            $date_operation = $facture->date_facture->format('dmY');
            // $num_folio = "";
            // $num_ecriture = "";
            $jour_ecriture =  $this->formatage_colonne(6,$facture->date_facture->format('d'), "droite");;
            
            
            
            $compte_tva = $this->formatage_colonne(6, 445716);
            
            
            // SI VENTE = 708229, si LOCATION = 708239, si PACK pub, frais entrée etc = 708800
            
            if($facture->compromis != null){
     
                $compte_ht = $facture->compromis->type_affaire == "Vente" ? 708229 : 708239;
            }else{
                $compte_ht = 708800;
            }
            
            
            
            // Pour les factures Stylimmo et leurs avoirs, utiliser le le compte 9CLIEN sinon reccuperer directement le code client du mandataire
            
            if($facture->type == "stylimmo" || ($facture->type == "avoir" && $facture->facture_avoir()->type == "stylimmo")){
                $compte_ttc = "9CLIEN";
                
                $libelle = $facture->compromis->charge == "vendeur" ? $this->formatage_colonne(30, $facture->compromis->nom_vendeur." ".$facture->compromis->prenon_vendeur) : $this->formatage_colonne(30, $facture->compromis->nom_acquereur." ".$facture->compromis->prenon_acquereur);
                
            }else {
                $compte_ttc = $this->formatage_colonne(6,$facture->user->code_client);
                $libelle = $this->formatage_colonne(30, $facture->user->nom." ".$facture->user->prenom);
            
            }
            
            
            if($facture->type == "avoir"){
            
                $montant_debit_tva = $this->formatage_colonne(13, number_format($facture->montant_ttc - $facture->montant_ht,2, ",",""), "droite");
                $montant_credit_tva = $this->formatage_colonne(13, "0,00", "droite");
                
                
                $montant_debit_ht = $this->formatage_colonne(13, number_format($facture->montant_ht,2, ",",""), "droite");
                $montant_credit_ht = $this->formatage_colonne(13, "0,00", "droite");
                
                $montant_debit_ttc =$this->formatage_colonne(13, "0,00", "droite");
                $montant_credit_ttc = $this->formatage_colonne(13, number_format($facture->montant_ttc,2, ",",""), "droite");
            
            }else{
            
                $montant_debit_tva = $this->formatage_colonne(13, "0,00", "droite");
                $montant_credit_tva = $this->formatage_colonne(13, number_format($facture->montant_ttc - $facture->montant_ht,2, ",",""), "droite");
                
               
                $montant_debit_ht = $this->formatage_colonne(13, "0,00", "droite");
                $montant_credit_ht = $this->formatage_colonne(13, number_format($facture->montant_ht,2, ",",""), "droite");
                
               
                $montant_debit_ttc = $this->formatage_colonne(13, number_format($facture->montant_ttc,2, ",",""), "droite");
                $montant_credit_ttc = $this->formatage_colonne(13, "0,00", "droite");
            
            
            }
            

            $lettrage = "  ";
            $code_piece = $this->formatage_colonne(5, $facture->numero);
            $code_stat = "    ";
            $date_echeance =  $facture->date_facture->format('dmY');
            $monnaie = 1;
            $filler = " ";
            $ind_compteur = " ";
            $quantite = "      0,000";
            $code_pointage = "  ";
            
            

            $ligne1 = $code_journal."|".$date_operation."|".$this->formatage_colonne(6,$num_folio,'droite')."|".$this->formatage_colonne(6,$num_ecriture,'droite')."|".$jour_ecriture."|".$compte_tva."|".$montant_debit_tva."|".$montant_credit_tva."|".$libelle."|".$lettrage."|".$code_piece."|".$code_stat."|".$date_echeance."|".$monnaie."|".$filler."|".$ind_compteur."|".$quantite."|".$code_pointage."|\r\n";
            $num_ecriture++;
        
            
            $ligne2 = $code_journal."|".$date_operation."|".$this->formatage_colonne(6,$num_folio,'droite')."|".$this->formatage_colonne(6,$num_ecriture,'droite')."|".$jour_ecriture."|".$compte_ht."|".$montant_debit_ht."|".$montant_credit_ht."|".$libelle."|".$lettrage."|".$code_piece."|".$code_stat."|".$date_echeance."|".$monnaie."|".$filler."|".$ind_compteur."|".$quantite."|".$code_pointage."|\r\n";
            $num_ecriture++;
        
            $ligne3 = $code_journal."|".$date_operation."|".$this->formatage_colonne(6,$num_folio,'droite')."|".$this->formatage_colonne(6,$num_ecriture,'droite')."|".$jour_ecriture."|".$compte_ttc."|".$montant_debit_ttc."|".$montant_credit_ttc."|".$libelle."|".$lettrage."|".$code_piece."|".$code_stat."|".$date_echeance."|".$monnaie."|".$filler."|".$ind_compteur."|".$quantite."|".$code_pointage."|\r\n";
            $num_ecriture++;
                 
            
            $data.=$ligne1.$ligne2.$ligne3 ;

            if($num_ecriture > 47 ){
                $num_folio ++;
                $num_ecriture = 1;
            }
            
        }
 
        file_put_contents("ECRITURE.WIN", $data);
        
        
        Historique::create([
            "user_id"=> Auth::user()->id,
            "ressource_id"=> null,
            "ressource"=> "export",
            "action"=> "a exporté les ventes dans winfic",
        ]);
        
        return response()->download("ECRITURE.WIN");
        
    }
    
    
    
    
    /**
     *exporter les fichiers ECRITURE.WIN transfert des encaissements et décaissements
     *
     * @return \Illuminate\Http\Response
     */
    public function exporter_ecriture2($date_deb = null, $date_fin = null)
    {
        

        if($date_deb == null || $date_fin == null || $date_fin < $date_deb){        
            $date_deb = date("Y-m")."-01";
            $date_fin = date("Y-m-d");        
        }    
        
        
        // TRANSFERT DES ENCAISSEMENTS
        
        
        $factureEncaissees = Facture::whereIn('type',['stylimmo','pack_pub','carte_visite','communication','autre','forfait_entree','cci'])->where('user_id','<>',null)->whereBetween('date_encaissement',[$date_deb,$date_fin])->orderBy('numero','asc')->get();  
        
        
        $data_encai = "";
        $data_encai_B1 = "";
        $data_encai_B2 = "";
        
        $total_transac_ttc = 0;
        $total_autre_ttc = 0;
        
        $num_folio_encai_B1 = 1;
        $num_ecriture_encai_B1 = 1;
        
        $num_folio_encai_B2 = 1;
        $num_ecriture_encai_B2 = 1;
        
        foreach ($factureEncaissees as $facture) {
        
            $code_journal_encai = $facture->type == "stylimmo" ?  "B2" : "B1";
            $date_operation_encai = $facture->date_encaissement->format('dmY');
        
            $jour_ecriture_encai =  $this->formatage_colonne(6,$facture->date_encaissement->format('d'), "droite");;
            
            
            
            // SI VENTE ET LOCATION = 9CLIEN, SI PACK pub, frais entrée etc = 9NON_CLIENT  si mandataire ou xxxxx   si client externe
          
            
            if($facture->type == "stylimmo"){
            
                $compte_ttc_encai = "9CLIEN";
                
                $libelle = $facture->compromis->charge == "vendeur" ?  $facture->compromis->nom_vendeur." ".$facture->compromis->prenon_vendeur : $facture->compromis->nom_acquereur." ".$facture->compromis->prenon_acquereur;                
                $libelle_encai = $this->formatage_colonne(30, $facture->compromis->scp_notaire." / ". $libelle);
            
                $libelle_contrepartie_transac_encai = $libelle_encai;
                $libelle_contrepartie_autre_encai = $libelle_encai;
                
            }else{
                
                if(!$facture->user) dd("Erreur: Facture liée à aucun mandataire du réseau");
                $compte_ttc_encai = $facture->user->code_client;
                
                $libelle_encai =  $this->formatage_colonne(30, $facture->user->nom." ".$facture->user->prenom);
                $libelle_contrepartie_transac_encai = $this->formatage_colonne(30, $facture->user->nom." ".$facture->user->prenom);
                $libelle_contrepartie_autre_encai = $this->formatage_colonne(30, $facture->user->nom." ".$facture->user->prenom);

            }
            
  
            
            $montant_debit_ttc_encai = $this->formatage_colonne(13, " ", "droite");
            $montant_credit_ttc_encai = $this->formatage_colonne(13, number_format($facture->montant_ttc,2, ",",""), "droite");
            
            
            // Pour la contraprtie, Sur chaque ligne
              
            if($facture->type == "stylimmo"){
                $total_transac_ttc = number_format($facture->montant_ttc,2, ".","");            
            }else{            
                $total_autre_ttc = number_format($facture->montant_ttc,2, ".","");            
            }
            
            
            // ######### CONTREPARTIE ENCAISSEMENT
             // Pour la contraprtie, faire une seule ligne ------------> sortie de la boucleb  somme des ttc
         
            // Factures transaction
            $code_journal_contrepartie_transac_encai = "B2";
            $compte_contrepartie_transac_encai = "512003";
            
            $montant_debit_contrepartie_transac_encai = $this->formatage_colonne(13, number_format($total_transac_ttc,2, ",",""), "droite") ;
            $montant_credit_contrepartie_transac_encai = $this->formatage_colonne(13, " ", "droite");
            
            
            
            
            
            //  Factures autres
            
            $code_journal_contrepartie_autre_encai = "B1";
            $compte_contrepartie_autre_encai = "512002";
            
            $montant_debit_contrepartie_autre_encai = $this->formatage_colonne(13, number_format($total_autre_ttc,2, ",",""), "droite") ;
            $montant_credit_contrepartie_autre_encai = $this->formatage_colonne(13, " ", "droite");
            
            
            
            $date_operation_contrepartie_encai = date('dmY',strtotime($date_fin));
            $jour_ecriture_contrepartie_encai=  $this->formatage_colonne(6, date('d',strtotime($date_fin)), "droite");
            $lettrage_contrepartie_encai = "  ";
            $code_piece_contrepartie_encai = $this->formatage_colonne(5, " ");
            $code_stat_contrepartie_encai = "    ";
            $date_echeance_contrepartie_encai =   date('dmY',strtotime($date_fin));
            $monnaie_contrepartie_encai = 1;
            $filler_contrepartie_encai = " ";
            $ind_compteur_contrepartie_encai = " ";
            $quantite_contrepartie_encai = "      0,000";
            $code_pointage_contrepartie_encai = "  ";
            
            
            $ligne2_contrepartie_transac_encai = "B2"."|".$date_operation_contrepartie_encai."|".$this->formatage_colonne(6,$num_folio_encai_B2,'droite')."|".$this->formatage_colonne(6,$num_ecriture_encai_B2,'droite')."|".$jour_ecriture_contrepartie_encai."|".$compte_contrepartie_transac_encai."|".$montant_debit_contrepartie_transac_encai."|".$montant_credit_contrepartie_transac_encai."|".$libelle_contrepartie_transac_encai."|".$lettrage_contrepartie_encai."|".$code_piece_contrepartie_encai."|".$code_stat_contrepartie_encai."|".$date_echeance_contrepartie_encai."|".$monnaie_contrepartie_encai."|".$filler_contrepartie_encai."|".$ind_compteur_contrepartie_encai."|".$quantite_contrepartie_encai."|".$code_pointage_contrepartie_encai."|\r\n";
            $num_ecriture_encai_B2++;
            
            $ligne2_contrepartie_autre_encai = "B1"."|".$date_operation_contrepartie_encai."|".$this->formatage_colonne(6,$num_folio_encai_B1,'droite')."|".$this->formatage_colonne(6,$num_ecriture_encai_B1,'droite')."|".$jour_ecriture_contrepartie_encai."|".$compte_contrepartie_autre_encai."|".$montant_debit_contrepartie_autre_encai."|".$montant_credit_contrepartie_autre_encai."|".$libelle_contrepartie_autre_encai."|".$lettrage_contrepartie_encai."|".$code_piece_contrepartie_encai."|".$code_stat_contrepartie_encai."|".$date_echeance_contrepartie_encai."|".$monnaie_contrepartie_encai."|".$filler_contrepartie_encai."|".$ind_compteur_contrepartie_encai."|".$quantite_contrepartie_encai."|".$code_pointage_contrepartie_encai."|\r\n";
            $num_ecriture_encai_B1++;
            
   
            
            
            $lettrage_encai = "  ";
            $code_piece_encai = $this->formatage_colonne(5, $facture->numero);
            $code_stat_encai = "    ";
            $date_echeance_encai =  $facture->date_facture->format('dmY');
            $monnaie_encai = 1;
            $filler_encai = " ";
            $ind_compteur_encai = " ";
            $quantite_encai = "      0,000";
            $code_pointage_encai = "  ";
                    
            
            
            if($code_journal_encai == "B2"){
                $data_encai_B2 .= $code_journal_encai."|".$date_operation_encai."|".$this->formatage_colonne(6,$num_folio_encai_B2,'droite')."|".$this->formatage_colonne(6,$num_ecriture_encai_B2,'droite')."|".$jour_ecriture_encai."|".$compte_ttc_encai."|".$montant_debit_ttc_encai."|".$montant_credit_ttc_encai."|".$libelle_encai."|".$lettrage_encai."|".$code_piece_encai."|".$code_stat_encai."|".$date_echeance_encai."|".$monnaie_encai."|".$filler_encai."|".$ind_compteur_encai."|".$quantite_encai."|".$code_pointage_encai."|\r\n";
                $data_encai_B2 .= $ligne2_contrepartie_transac_encai;
                
                $num_ecriture_encai_B2++;
                
            
            }else{
                $data_encai_B1 .= $code_journal_encai."|".$date_operation_encai."|".$this->formatage_colonne(6,$num_folio_encai_B1,'droite')."|".$this->formatage_colonne(6,$num_ecriture_encai_B1,'droite')."|".$jour_ecriture_encai."|".$compte_ttc_encai."|".$montant_debit_ttc_encai."|".$montant_credit_ttc_encai."|".$libelle_encai."|".$lettrage_encai."|".$code_piece_encai."|".$code_stat_encai."|".$date_echeance_encai."|".$monnaie_encai."|".$filler_encai."|".$ind_compteur_encai."|".$quantite_encai."|".$code_pointage_encai."|\r\n";
                $data_encai_B1 .= $ligne2_contrepartie_autre_encai;
                
                $num_ecriture_encai_B1++;
                
            }
            
            
           
            
            // $data_encai_B1 .= $ligne1_encai_B1;
            // $data_encai_B2 .= $ligne1_encai_B2;
            
            if($num_ecriture_encai_B1 > 50 ){
                $num_folio_encai_B1 ++;
                $num_ecriture_encai_B1 = 1;
            }
            
            if($num_ecriture_encai_B2 > 50 ){
                $num_folio_encai_B2 ++;
                $num_ecriture_encai_B2 = 1;
            }
            
        }
        
        
        
   
        // 
        $data_encai .= $data_encai_B1.$data_encai_B2;
        // $data_encai .= $data_encai_B1.$ligne2_contrepartie_autre_encai.$data_encai_B2.$ligne2_contrepartie_transac_encai;
        
        
        
       // TRANSFERT DES DECAISSEMENTS
        
   
       $factureDecaissees = Facture::whereIn('type',['honoraire','partage','parrainage','parrainage_partage','partage_externe'])->whereBetween('date_reglement',[$date_deb,$date_fin])->orderBy('numero','asc')->get();  
        
   
       $data_decai = "";

       $num_folio_decai = $num_folio_encai_B2;
       $num_ecriture_decai = $num_ecriture_encai_B2;
       
       foreach ($factureDecaissees as $facture) {
       
           $code_journal_decai = "B2" ;
           $date_operation_decai = $facture->date_reglement->format('dmY');
          
           $jour_ecriture_decai =  $this->formatage_colonne(6,$facture->date_reglement->format('d'), "droite");;
           
           
           
           // SI VENTE ET LOCATION = 9CLIEN, SI PACK pub, frais entrée etc = 9NON_CLIENT  si mandataire ou xxxxx   si client externe
         
               $compte_ttc_decai = str_replace('9','0',$facture->user->code_client);
               
               $libelle_decai =  $this->formatage_colonne(30, $facture->user->nom." VTE ".$facture->compromis->getFactureStylimmo()->numero);

      
           
    
            $ttc = $facture->montant_ttc > 0 ? $facture->montant_ttc : $facture->montant_ht;
            $montant_debit_ttc_decai = $this->formatage_colonne(13, number_format($ttc,2, ",",""), "droite");
            $montant_credit_ttc_decai = $this->formatage_colonne(13, " ", "droite");
           
           
           // Pour la contraprtie, faire une seule ligne ------------> sortie de la boucleb  somme des ttc
              
  
           
           
           $lettrage_decai = "  ";
           $code_piece_decai = $this->formatage_colonne(5, substr($facture->numero, -4));
           $code_stat_decai = "    ";
           $date_echeance_decai =  $facture->date_facture->format('dmY');
           $monnaie_decai = 1;
           $filler_decai = " ";
           $ind_compteur_decai = " ";
           $quantite_decai = "      0,000";
           $code_pointage_decai = "  ";
                   
           $ligne1_decai = $code_journal_decai."|".$date_operation_decai."|".$this->formatage_colonne(6,$num_folio_decai,'droite')."|".$this->formatage_colonne(6,$num_ecriture_decai,'droite')."|".$jour_ecriture_decai."|".$compte_ttc_decai."|".$montant_debit_ttc_decai."|".$montant_credit_ttc_decai."|".$libelle_decai."|".$lettrage_decai."|".$code_piece_decai."|".$code_stat_decai."|".$date_echeance_decai."|".$monnaie_decai."|".$filler_decai."|".$ind_compteur_decai."|".$quantite_decai."|".$code_pointage_decai."|\r\n";
           $num_ecriture_decai++;
           
          
           
           $data_decai .= $ligne1_decai;
          
           if($num_ecriture_decai > 50 ){
                $num_folio_decai ++;
                $num_ecriture_decai = 1;
            }
            
            
            
           // ######### CONTREPARTIE deCAISSEMENT
            // Pour la contraprtie, faire une seule ligne ------------> sortie de la boucleb  somme des ttc
        
           // Factures transaction
           $code_journal_contrepartie_decai = "B2";
           $compte_contrepartie_decai = "512003";
           $libelle_contrepartie_decai = $libelle_decai;
           
           $montant_debit_contrepartie_decai = $this->formatage_colonne(13, " ", "droite");
           $montant_credit_contrepartie_decai = $this->formatage_colonne(13, number_format($ttc,2, ",",""), "droite") ;
           
           
           
           $date_operation_contrepartie_decai = date('dmY',strtotime($date_fin));
           $jour_ecriture_contrepartie_decai=  $this->formatage_colonne(6, date('d',strtotime($date_fin)), "droite");
           $lettrage_contrepartie_decai = "  ";
           $code_piece_contrepartie_decai = $this->formatage_colonne(5, " ");
           $code_stat_contrepartie_decai = "    ";
           $date_echeance_contrepartie_decai =   date('dmY',strtotime($date_fin));
           $monnaie_contrepartie_decai = 1;
           $filler_contrepartie_decai = " ";
           $ind_compteur_contrepartie_decai = " ";
           $quantite_contrepartie_decai = "      0,000";
           $code_pointage_contrepartie_decai = "  ";
           
           
           $ligne2_contrepartie_transac_decai = "B2"."|".$date_operation_contrepartie_decai."|".$this->formatage_colonne(6,$num_folio_decai,'droite')."|".$this->formatage_colonne(6,$num_ecriture_decai,'droite')."|".$jour_ecriture_contrepartie_decai."|".$compte_contrepartie_decai."|".$montant_debit_contrepartie_decai."|".$montant_credit_contrepartie_decai."|".$libelle_contrepartie_decai."|".$lettrage_contrepartie_decai."|".$code_piece_contrepartie_decai."|".$code_stat_contrepartie_decai."|".$date_echeance_contrepartie_decai."|".$monnaie_contrepartie_decai."|".$filler_contrepartie_decai."|".$ind_compteur_contrepartie_decai."|".$quantite_contrepartie_decai."|".$code_pointage_contrepartie_decai."|\r\n";
           $num_ecriture_decai++;
           

           $data_decai .= $ligne2_contrepartie_transac_decai;
            

       }
       
        
        $data = $data_encai.$data_decai;
       

 
        file_put_contents("ECRITURE.WIN", $data);
        
        
        Historique::create([
            "user_id"=> Auth::user()->id,
            "ressource_id"=> null,
            "ressource"=> "export",
            "action"=> "a exporté les encaissements et décaissements dans winfic",
        ]);
        
        return response()->download("ECRITURE.WIN");
        
    }





    /**
     *exporter les fichiers ECRITURE.WIN / transferts des factures des indépendants et fournisseurs externes
     *
     * @return \Illuminate\Http\Response
     */
    public function exporter_ecriture3(Request $request, $date_deb = null, $date_fin = null)
    {
        
        
        
        // Si aucune facture selectionnée retourner null
        
        if($request->list_id == null ) return null;
    
        // periodes
        if($date_deb == null || $date_fin == null || $date_fin < $date_deb){        
            $date_deb = date("Y-m")."-01";
            $date_fin = date("Y-m-d");        
        }     
        
        
        $factureFournisseurs = Facture::whereIn('id', $request->list_id)->orderBy('date_facture','asc')->get();  
        
        DB::table('factures')->whereIn('id', $request->list_id)
                            ->update(['exporte' => true, 'date_export' => date('Y-m-d')]);

         
        $data = "";
        $num_folio = 1;
        $num_ecriture = 1;
        
        if(file_exists("ECRITURE.WIN")){
            unlink("ECRITURE.WIN");
        }
        
     
        
        $code_journal = "AC";
        $jour_ecriture =  $this->formatage_colonne(6,date('dmY'), "droite");
        $compte_tva = $this->formatage_colonne(6, 445666);
        $compte_ht = $this->formatage_colonne(6, 622219);
        $filler1 = "      0,000";
        $filler2 = "0";
        
        
        //   
        
        
        $periodes = explode('&', $request->periodes)  ;
        $tab = Array();
        // Création d'un tableau clé:valeur avec les dates de deb et date de fin + les champs periodes/numero pieces
        foreach ($periodes as $key => $periode) {
            
            $val = explode('=', $periode);            
            $tab[$val[0]] = $val[1];
            
        }
        
        $mois_numero_pieces = array_slice($tab, 2,sizeof($periodes));
        $mois_numero_ecritures = $mois_numero_pieces;
        
        // return "".str_contains("10/10/2022", '10/2021');
        // return $mois_numero_pieces;
        
        $data = "";
        foreach ($factureFournisseurs as $facture) {
        
            
            
            $date_operation = $facture->date_facture->format('dmY');
            // Date utilisée pour générer le code pièce
            $date_fact = $facture->date_facture->format('m/Y');
            
           
              // Pour les factures fournisseur utiliser le compte 0FOURN sinon sinon si facture indep, utiliser le 0Nom independant
        
            if($facture->type =="fournisseur"){
                $compte_ttc = "0FOURN";                
            }else {
                $compte_ttc = $this->formatage_colonne(6, str_replace('9','0',$facture->user->code_client) );            
            }
        
          
            $montant_ht = $facture->montant_ht;
            $montant_ttc = $facture->montant_ttc > $montant_ht ? $facture->montant_ttc :  $montant_ht ; 
            $montant_tva = $montant_ttc > $montant_ht ? ($montant_ttc - $montant_ht) : 0 ;
            
            $montant_credit_ht = $this->formatage_colonne(13, "0,00", "droite"); 
            $montant_debit_ht = $this->formatage_colonne(13, number_format(  $montant_ht ,2, ",",""), "droite");
            
            $montant_debit_ttc = $this->formatage_colonne(13, "0,00", "droite"); 
            $montant_credit_ttc = $this->formatage_colonne(13, number_format(  $montant_ttc ,2, ",",""), "droite");
            
            if($montant_tva > 0){
                
                $montant_debit_tva = $this->formatage_colonne(13, number_format(  $montant_tva ,2, ",",""), "droite");
                $montant_credit_tva = $this->formatage_colonne(13, "0,00", "droite"); 
            
            }
                
            //  $facture = Facture::where('fournisseur_id', 3)->first();
             
            if($facture->fournisseur != null){
                $libelle = $this->formatage_colonne(30, substr($facture->fournisseur->nom, 0, 15)." / ".substr($facture->numero, -4) , "gauche") ; 

            }else{
                $libelle = $this->formatage_colonne(30, substr($facture->user->nom, 0, 15)." / ".substr($facture->numero, -4)." / ".$facture->compromis->getFactureStylimmo()->numero , "gauche") ; ; 
            }
            
         
            $lettrage = "  ";
            
          
            
            $num_ecriture = intval($mois_numero_pieces[$date_fact]);
            
            // return $factureFournisseurs;
            
            
            $code_stat = "    ";
            $date_echeance =  $facture->date_facture->format('dmY');
            $monnaie = 1;
            $filler = " ";
            $ind_compteur = " ";
            $quantite = "      0,000";
            $code_pointage = "  ";
               
              
            $code_piece = intval($mois_numero_pieces[$date_fact]);
            
            $code_piece = $code_piece < 10 ? "0$code_piece": $code_piece;
            
            
            $num_ecriture = $mois_numero_ecritures[$date_fact];
            
            $num_folio = ceil($num_ecriture / 50) ;

            // Ligne TTC
            
            $code_piece = $this->formatage_colonne(5, $code_piece);
            
            $data .= $code_journal."|".$date_operation."|".$this->formatage_colonne(6,$num_folio,'droite')."|".$this->formatage_colonne(6,$num_ecriture,'droite')."|".$jour_ecriture."|".$compte_ttc."|".$montant_debit_ttc."|".$montant_credit_ttc."|".$libelle."|".$lettrage."|".$code_piece."|".$code_stat."|".$date_echeance."|".$monnaie."|".$filler."|".$ind_compteur."|".$quantite."|".$code_pointage."|\r\n";
            $num_ecriture++;
            $mois_numero_ecritures[$date_fact]++;
            
            if($num_ecriture > 50 ){
                $num_folio ++;
                $num_ecriture = 1;
                $mois_numero_ecritures[$date_fact] = 1;
            }
            
            // Ligne  HT
       
            $data .= $code_journal."|".$date_operation."|".$this->formatage_colonne(6,$num_folio,'droite')."|".$this->formatage_colonne(6,$num_ecriture,'droite')."|".$jour_ecriture."|".$compte_ht."|".$montant_debit_ht."|".$montant_credit_ht."|".$libelle."|".$lettrage."|".$code_piece."|".$code_stat."|".$date_echeance."|".$monnaie."|".$filler."|".$ind_compteur."|".$quantite."|".$code_pointage."|\r\n";
            
            $mois_numero_ecritures[$date_fact]++;
            $num_ecriture++;
            
            if($num_ecriture > 50 ){
                $num_folio ++;
                $num_ecriture = 1;
                $mois_numero_ecritures[$date_fact] = 1;
            }
            // Ligne TVA si y'a la TVA
            if($montant_tva > 0){
                // $code_piece = $this->formatage_colonne(5, $mois_numero_pieces[$date_fact]);
              
                $data .= $code_journal."|".$date_operation."|".$this->formatage_colonne(6,$num_folio,'droite')."|".$this->formatage_colonne(6,$num_ecriture,'droite')."|".$jour_ecriture."|".$compte_tva."|".$montant_debit_tva."|".$montant_credit_tva."|".$libelle."|".$lettrage."|".$code_piece."|".$code_stat."|".$date_echeance."|".$monnaie."|".$filler."|".$ind_compteur."|".$quantite."|".$code_pointage."|\r\n";
                $mois_numero_ecritures[$date_fact]++;
                $num_ecriture++;  
                
                if($num_ecriture > 50 ){
                    $num_folio ++;
                    $num_ecriture = 1;
                    $mois_numero_ecritures[$date_fact] = 1;
                }
            }
           
            
            $mois_numero_pieces[$date_fact]++;
            
  
  
        }
        // return $data;
 
 
        file_put_contents("ECRITURE.WIN", $data);
        
        
        Historique::create([
            "user_id"=> Auth::user()->id,
            "ressource_id"=> null,
            "ressource"=> "export",
            "action"=> "a exporté les fournisseurs dans winfic",
        ]);
        
        return response()->download("ECRITURE.WIN");
        
    }




    

    /**
     * Telecharger les exports
     */
    public function download_export($fichier="ECRITURE.WIN")
    {
        
        return response()->download($fichier);
        
    }




    /**
     * format un champ du fichier d'export en respectant le nombre de caractère requis
     */
    public function formatage_colonne($nb_caractere, $champ, $position = "gauche")
    {
        //si la taille de la chaine est supérieur au nombre de caractère max requis, il faut retirer des caractères dans la chaine        
        
            $champ = str_replace(["mr","mme","mlle","monsieur","madame","Mr","Mme","Mlle","Monsieur","Madame","Mademoisselle","MR","MME","MLLE","MADAME","MONSIEUR","MADEMOISELLE","M."],'', $champ);
        
            if(substr($champ, 0, 1) == " "){
                $champ = substr($champ, 1, strlen($champ));
            }
            $champ = str_replace('  ', ' ',$champ );
        
            $champ = htmlentities($champ, ENT_NOQUOTES, "utf-8");
        
            $champ = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $champ);
            $champ = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $champ); // pour les ligatures e.g. '&oelig;'
            $champ = preg_replace('#&[^;]+;#', '', $champ); // supprime les autres caractères
            
            
        if($nb_caractere < strlen($champ)){
        
            
            $champ = substr($champ,0, $nb_caractere);
        
        }else{
            
            // opn compte le nombre de caractere restant pour completer le champ            
            $nb_car_rest = $nb_caractere - strlen($champ);            
            
            $espacce = "";
            
            for ($i = 0; $i< $nb_car_rest; $i++){
               $espacce.= " ";
            }
            
        
            if($position == "gauche"){                    
                $champ = $champ.$espacce;
            
            }else {
                $champ = $espacce.$champ;
            
            }

        }

            return $champ;

    }

    /**
     * liste des codes analytiques et clients
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function code_analytic_client()
    {
        $mandataires = User::where('role','mandataire')->orderBy('nom')->get();
        
        return view ('winfic.code_analytic_client',compact('mandataires'));
    }
    
    
    
    /**
     *Concatener toutes les factures selectionnées dans un seul pdf
     *
     * @return \Illuminate\Http\Response
     */
    public function merge_factures($date_deb = null, $date_fin = null)
    {
       
        if($date_deb == null || $date_fin == null || $date_fin < $date_deb){        
            $date_deb = date("Y-m")."-01";
            $date_fin = date("Y-m-d");        
        }     
        
        $factureStylimmos = Facture::whereIn('type',['stylimmo','avoir','pack_pub','carte_visite','communication','autre','forfait_entree','cci'])->whereBetween('date_facture',[$date_deb,$date_fin])->where('user_id','<>',77)->orderBy('numero','asc')->get();
        
        $merger = new Merger;

        foreach ($factureStylimmos as $facture) {
        
        if($facture->url != null && file_exists($facture->url))
            $merger->addFile($facture->url);

            
        }
        $createdPdf = $merger->merge();
 
        return new Response($createdPdf, 200, array('Content-Type' => 'application/pdf'));
        
    
    
    }

        
    /**
     *Concatener toutes les factures fournisseurs selectionnées dans un seul pdf
     *
     * @return \Illuminate\Http\Response
     */
    public function merge_factures_fournisseur(Request $request)
    {
       
        if($request->list_id == null ) return null;   
        
        
        $factureFournisseurs = Facture::whereIn('id', $request->list_id)->orderBy('date_facture','asc')->get();  
        
                // $facture  = Facture::where('numero', '202202' )->first();
                // $filecontent = file_get_contents($facture->url);
                
                // if (preg_match("/^%PDF-1.5/", $filecontent)) {
                //     return "Valid pdf";
                // } else {
                //     return "In Valid pdf";
                // }
                
                
        $merger2 = new Merger;
        $createdPdf = "";
        $facture_non_merge = array();
        // $merger->addFile("test.jpg");
        foreach ($factureFournisseurs as $facture) {
        
            if($facture->url != null && file_exists($facture->url)){
                
                $continue = 0;
                $merger = new Merger;
                
                try {
                    
                    $merger->addFile($facture->url);
                    $createdPdf = $merger->merge();

                } catch (\Throwable $th) {
                   $continue = 1 ;
                   $facture_non_merge [] = array(Crypt::encrypt($facture->id), $facture->numero);
                }
                
                if($continue == 0){
                    $merger2->addFile($facture->url);
                    $createdPdf2 = $merger2->merge();
                }
                
            
            }

            
        }
        
        
        // $createdPdf = $merger->merge();
        
            // $merger->Output('I', 'generated.pdf');
            if($createdPdf2)
                file_put_contents('factures_fournisseur.pdf', $createdPdf2);
                
                return $facture_non_merge;
        // return new Response($createdPdf, 200, array('Content-Type' => 'application/pdf'));
        
    
    
    }

    
    
    
        
    /**
     *  générer les factures qui n'ont pas étés générées
     *
     * @param  string  $compromis_id
     * @return \Illuminate\Http\Response
    */

    public  function generer_pdf_facture($date_deb = null, $date_fin = null)
    {


        if($date_deb == null || $date_fin == null || $date_fin < $date_deb){        
            $date_deb = date("Y-m")."-01";
            $date_fin = date("Y-m-d");        
        }   
        
        
        $factures = Facture::whereIn('type',['pack_pub','carte_visite','communication','autre','forfait_entree','cci'])->where('url',null)->whereBetween('date_facture',[$date_deb,$date_fin])->where('user_id','<>',77)->orderBy('numero','asc')->get();
        
        
   
        // on sauvegarde la facture dans le repertoire du mandataire
        $chemin = storage_path('app/public/factures/factures_autres');

        if(!File::exists($chemin))
            File::makeDirectory($chemin, 0755, true);
        
            
            foreach ($factures as $facture) {
                
                $path = $chemin;
         
          
                if($facture->type == "cci" || $facture->type=="forfait_entree"){
                    $pdf = PDF::loadView('facture.pdf_cci_forfait',compact(['facture']));
                        
                }else{
                    $pdf = PDF::loadView('facture.pdf_autre',compact(['facture']));
                    
                }          
    
    
                if($facture->destinataire_est_mandataire == true ){
                    $filename = "F".$facture->numero." ".$facture->type." ".$facture->montant_ttc."€ ".strtoupper($facture->user->nom)." ".strtoupper(substr($facture->user->prenom,0,1)).".pdf" ;
                }else{
                    $filename = "F".$facture->numero." ".$facture->type." ".$facture->montant_ttc."€.pdf" ;
                }
                
                $path = $path.'/'.$filename;
                
                $pdf->save($path);
                
                $facture->url = $path;
                $facture->update();
                
            }

    }

    
    
    
    
    
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
