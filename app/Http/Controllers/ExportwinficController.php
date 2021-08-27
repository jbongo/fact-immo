<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facture;
class ExportwinficController extends Controller
{
    /**
     * Afficher de la liste des factures à exporter
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
       
        return view ('winfic.index',compact(['factureStylimmos','date_deb','date_fin']));
        
    }

    /**
     *exporter les fichiers ECRITURE.WIN 
     *
     * @return \Illuminate\Http\Response
     */
    public function exporter_ecriture($date_deb = null, $date_fin = null)
    {
        
        
    
    
        if($date_deb == null || $date_fin == null || $date_fin < $date_deb){        
            $date_deb = date("Y-m")."-01";
            $date_fin = date("Y-m-d");        
        }     
        
        $factureStylimmos = Facture::whereIn('type',['stylimmo','avoir','pack_pub','carte_visite','communication','autre','forfait_entree','cci'])->whereBetween('date_facture',[$date_deb,$date_fin])->orderBy('numero','asc')->get();  
        
        $data = "";
        $num_folio = 1;
        $num_ecriture = 1;
        
        if(file_exists("ECRITURE.WIN")){
            unlink("ECRITURE.WIN");
        }
        
        
        foreach ($factureStylimmos as $facture) {
           
            $code_journal = "VE";
            $date_operation = $facture->date_facture->format('dmY');
            // $num_folio = "";
            // $num_ecriture = "";
            $jour_ecriture =  $this->formatage_colonne(6,$facture->date_facture->format('d'), "droite");;
            
            
            
            $compte_tva = $this->formatage_colonne(6, 445716);
            
            
            // SI VENTE = 708229, si LOCATION = 708239, si PACK pub, frais entrée etc = 708800
            
            if($facture->compromis != null){
                
                $compte_ht = $facture->compromis->type == "vente" ? 708229 : 708239;
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
        
        return response()->download("ECRITURE.WIN");
        
    }





/**
     *exporter les fichiers ECRITURE.WIN 
     *
     * @return \Illuminate\Http\Response
     */
    public function exporter_ecrana($date_deb = null, $date_fin = null)
    {
        
        
    
    
        if($date_deb == null || $date_fin == null || $date_fin < $date_deb){        
            $date_deb = date("Y-m")."-01";
            $date_fin = date("Y-m-d");        
        }     
        
        $factureStylimmos = Facture::whereIn('type',['stylimmo','avoir','pack_pub','carte_visite','communication','autre','forfait_entree','cci'])->whereBetween('date_facture',[$date_deb,$date_fin])->orderBy('numero','asc')->get();    
        
        $data = "";
        $num_folio = 1;
        $num_ecriture = 1;
        
        if(file_exists("ECRANA.WIN")){
            unlink("ECRANA.WIN");
        }
        
     
        
        foreach ($factureStylimmos as $facture) {
        
            
            
                $code_journal = "VE";
                $date_operation = $facture->date_facture->format('dmY');
                // $num_folio = "";
                // $num_ecriture = "";
                
                // $jour_ecriture =  $this->formatage_colonne(6,$facture->date_facture->format('d'), "droite");;
                
                
                
                $compte_tva = $this->formatage_colonne(6, 445716);
                
                
                
                // *************** VERIFIER QUE LE COMPRO N'EST PAS NULL
                
                if($facture->compromis != null){
                
                    $compte_ht = $facture->compromis->type == "vente" ? 708229 : 708239;
                }else{
                    $compte_ht = 708800;
                }
                
                $code_section = $facture->user->code_analytic;
               
                  // Pour les factures Stylimmo et leurs avoirs, utiliser le le compte 9CLIEN sinon reccuperer directement le code client du mandataire
            
                if($facture->type == "stylimmo" || ($facture->type == "avoir" && $facture->facture_avoir()->type == "stylimmo")){
                    $compte_ttc = "9CLIEN";                
                }else {
                    $compte_ttc = $this->formatage_colonne(6,$facture->user->code_client);            
                }
            
               
            
                $filler1 = "      0,000";
                $filler2 = " ";
              
                
                
                //  On vérifie si y'a partage ou pas..  Quand y'a partage, créer les lignes pour chaque mandataire              
                
                if($facture->compromis != null && $facture->compromis->est_partage_agent == true){
                
                    $compromis = $facture->compromis; 
                    $taux_porteur = $facture->compromis->pourcentage_agent;
                    $taux_partage = 100 - $facture->compromis->pourcentage_agent;
                    
                    
                    $stylimmo_facture_tout = true;
                
                    // on determine les montants en fonction du partage de l'affaire
                    // qui_porte_externe :::  // 1 = Styl et l'agence-- 2= L'agence -- 3= Styl
                    
                    // Qaund STYLIMMO n'a pas tout facturé au notaire
                    if($compromis->partage_reseau == false && ( $compromis->qui_porte_externe == 1 || $compromis->qui_porte_externe == 2 ) ){
                    
                        // STYL a déjà facturé une seule partie des frais agence, donc plus besoin de consider le pourcentage 
                        $montant_tva_porteur = $facture->montant_ttc - $facture->montant_ht ;
                        $montant_ht_porteur = $facture->montant_ht ;
                        $montant_ttc_porteur =  $facture->montant_ttc ;
                        
                        $stylimmo_facture_tout = false;
                        
                        $taux_porteur = 100 ;
                        
                    
                    // Qaund STYLIMMO a tout facturé au notaire
                    }else{
                    
                        $taux_porteur = $compromis->pourcentage_agent;
                    
                        $montant_tva_porteur = ($facture->montant_ttc - $facture->montant_ht) * $taux_porteur/100;
                        $montant_ht_porteur =  $facture->montant_ht * $taux_porteur/100;
                        $montant_ttc_porteur =  $facture->montant_ttc * $taux_porteur/100;
                        
                        
                        $taux_partage = 100 - $compromis->pourcentage_agent;
                        
                        $montant_tva_partage = ($facture->montant_ttc - $facture->montant_ht) * $taux_partage/100  ;
                        $montant_ht_partage =  $facture->montant_ht * $taux_partage/100;
                        $montant_ttc_partage = $facture->montant_ttc * $taux_partage/100 ;
                        
                        
                    }
                    
                  
                
                    if($facture->type == "avoir"){
                    
                    
                     // POUR LE mandataire qui porte l'affaire, USER_ID
                
                         $montant_debit_tva_porteur = $this->formatage_colonne(13, number_format( $montant_tva_porteur  ,2, ",",""), "droite");
                         $montant_credit_tva_porteur = $this->formatage_colonne(13, "0,00", "droite");
                         
                         
                         $montant_debit_ht_porteur = $this->formatage_colonne(13, number_format(  $montant_ht_porteur ,2, ",",""), "droite");
                         $montant_credit_ht_porteur = $this->formatage_colonne(13, "0,00", "droite");
                         
                         $montant_debit_ttc_porteur = $this->formatage_colonne(13, "0,00", "droite");
                         $montant_credit_ttc_porteur = $this->formatage_colonne(13, number_format( $montant_ttc_porteur ,2, ",",""), "droite");
                
                
                
                
                
                    // POUR LE mandataire qui ne porte pas l'affaire, AGENT_ID OU l'AGENCE OU AGENT EXTERNE ( si c'est STYLIMMO qui porte l'affaire chez le notaire ==> si STYLIMMO facture tout )
                    
                        if($stylimmo_facture_tout = true){
                    
                   
                        $montant_debit_tva_partage = $this->formatage_colonne(13, number_format( $montant_tva_partage ,2, ",",""), "droite");
                        $montant_credit_tva_partage = $this->formatage_colonne(13, "0,00", "droite");
                        
                        
                        $montant_debit_ht_partage = $this->formatage_colonne(13, number_format($montant_ht_partage ,2, ",",""), "droite");
                        $montant_credit_ht_partage = $this->formatage_colonne(13, "0,00", "droite");
                        
                        $montant_debit_ttc_partage =$this->formatage_colonne(13, "0,00", "droite");
                        $montant_credit_ttc_partage = $this->formatage_colonne(13, number_format($montant_ttc_partage ,2, ",",""), "droite");
                        
                        }
                    
                    
                    }else{
                    
                    
                     // POUR LE mandataire qui porte l'affaire, USER_ID
                
                        
                         $montant_debit_tva_porteur = $this->formatage_colonne(13, "0,00", "droite");
                         $montant_credit_tva_porteur = $this->formatage_colonne(13, number_format($montant_tva_porteur  ,2, ",",""), "droite");
                         
                        
                         $montant_debit_ht_porteur = $this->formatage_colonne(13, "0,00", "droite");
                         $montant_credit_ht_porteur = $this->formatage_colonne(13, number_format($montant_ht_porteur  ,2, ",",""), "droite");
                         
                        
                         $montant_debit_ttc_porteur = $this->formatage_colonne(13, number_format($montant_ttc_porteur  ,2, ",",""), "droite");
                
                
                
                
                    // POUR LE mandataire qui ne porte pas l'affaire, AGENT_ID OU l'AGENCE OU AGENT EXTERNE ( si c'est STYLIMMO qui porte l'affaire chez le notaire ==> si STYLIMMO facture tout )
                        
                        if($stylimmo_facture_tout = true){
                    
                        $montant_debit_tva_partage = $this->formatage_colonne(13, "0,00", "droite");
                        $montant_credit_tva_partage = $this->formatage_colonne(13, number_format($montant_tva_partage ,2, ",",""), "droite");
                        
                       
                        $montant_debit_ht_partage = $this->formatage_colonne(13, "0,00", "droite");
                        $montant_credit_ht_partage = $this->formatage_colonne(13, number_format($montant_ht_partage ,2, ",",""), "droite");
                        
                       
                        $montant_debit_ttc_partage = $this->formatage_colonne(13, number_format($montant_ttc_partage ,2, ",",""), "droite");
                        $montant_credit_ttc_partage = $this->formatage_colonne(13, "0,00", "droite");
                    
                        }
                    }
                    
                    
                    
                    $ligne1_porteur = $code_journal."|".$date_operation."|".$this->formatage_colonne(6,$num_folio,'droite')."|".$this->formatage_colonne(6,$num_ecriture,'droite')."|".$compte_tva."|".$montant_debit_tva_porteur."|".$montant_credit_tva_porteur."|".$filler1."|".$filler2."|\r\n";
                    $num_ecriture++;
                
                    
                    $ligne2_porteur = $code_journal."|".$date_operation."|".$this->formatage_colonne(6,$num_folio,'droite')."|".$this->formatage_colonne(6,$num_ecriture,'droite')."|".$compte_ht."|".$montant_debit_ht_porteur."|".$montant_credit_ht_porteur."|".$filler1."|".$filler2."|\r\n";
                    $num_ecriture++;
                
                    $ligne3_porteur = $code_journal."|".$date_operation."|".$this->formatage_colonne(6,$num_folio,'droite')."|".$this->formatage_colonne(6,$num_ecriture,'droite')."|".$compte_ttc."|".$montant_debit_ttc_porteur."|".$montant_credit_ttc_porteur."|".$filler1."|".$filler2."|\r\n";
                    $num_ecriture++;
                         
                    
                    $data.=$ligne1_porteur.$ligne2_porteur.$ligne3_porteur ;
                    
                    if($num_ecriture > 47 ){
                        $num_folio ++;
                        $num_ecriture = 1;
                    }
                    
                    
                    
                    if($stylimmo_facture_tout = true){
                    
                        $ligne1_partage = $code_journal."|".$date_operation."|".$this->formatage_colonne(6,$num_folio,'droite')."|".$this->formatage_colonne(6,$num_ecriture,'droite')."|".$compte_tva."|".$montant_debit_tva_partage."|".$montant_credit_tva_partage."|".$filler1."|".$filler2."|\r\n";
                        $num_ecriture++;
                    
                        
                        $ligne2_partage = $code_journal."|".$date_operation."|".$this->formatage_colonne(6,$num_folio,'droite')."|".$this->formatage_colonne(6,$num_ecriture,'droite')."|".$compte_ht."|".$montant_debit_ht_partage."|".$montant_credit_ht_partage."|".$filler1."|".$filler2."|\r\n";
                        $num_ecriture++;
                    
                        $ligne3_partage = $code_journal."|".$date_operation."|".$this->formatage_colonne(6,$num_folio,'droite')."|".$this->formatage_colonne(6,$num_ecriture,'droite')."|".$compte_ttc."|".$montant_debit_ttc_partage."|".$montant_credit_ttc_partage."|".$filler1."|".$filler2."|\r\n";
                        $num_ecriture++;
                             
                        
                        $data.=$ligne1_partage.$ligne2_partage.$ligne3_partage ;
                        
                        if($num_ecriture > 47 ){
                            $num_folio ++;
                            $num_ecriture = 1;
                        }
                    }
                    
                    
                    
                }
                
                // SI y'a pas de partage
                
                else{
                
                    $taux_porteur = 100;
                
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
                
  
        }
 
 
        file_put_contents("ECRANA.WIN", $data);
        
        return response()->download("ECRANA.WIN");
        
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
