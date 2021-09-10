<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use Auth;
use App\Notifications\ReitererAffaire;


class Compromis extends Model
{
    //
    protected $guarded =[];
    protected $dates = ['date_vente','date_mandat','date_signature'];


    public function  user(){
        return $this->belongsTo('App\User');
    }

    public function getPartage(){

        $partage = User::where('id',$this->agent_id)->first();
        return $partage;
    }

    public function getParrainPartage(){

        $partage = User::where('id',$this->parrain_partage_id)->first();
        return $partage;
    }

    public function getFactureStylimmo(){

        $facture = Facture::where([['compromis_id',$this->id],['type','stylimmo'],['a_avoir', false]])->first();
        return $facture;
    }
    public function getHonoPorteur(){

        $facture = Facture::where([['compromis_id',$this->id],['user_id',$this->user_id]])->whereIn('type',['honoraire','partage'])->first();
        return $facture;
    }

    public function getHonoPartage(){

        $facture = Facture::where([['compromis_id',$this->id],['user_id',$this->agent_id]])->whereIn('type',['partage'])->first();
        return $facture;
    }

    public function getFactureParrainPorteur(){

        $facture = Facture::where([['compromis_id',$this->id]])->whereIn('type',['parrainage'])->first();
        return $facture;
    }

    public function getFactureParrainPartage(){

        $facture = Facture::where([['compromis_id',$this->id]])->whereIn('type',['parrainage_partage'])->first();
        return $facture;
    }


    //###### Factures provisoire

    public function getFactureHonoProvi(){

        $compromis = $this;
        $mandataire = $compromis->user;
        
        $contrat = $mandataire->contrat;
        $montant_ht = null;
        $montant_tva = 0;
      
        // On va determiner la dernière date d'anniv de sa date d'entree
        $m_d_entree = $mandataire->contrat->date_entree->format('m-d');
        $m_d_entree_fr = $mandataire->contrat->date_entree->format('d/m');
        $y_encaiss = $compromis->getFactureStylimmo()->date_encaissement->format('Y');

        // dd($y_encaiss.'-'.$m_d_entree);
        if( $compromis->getFactureStylimmo()->date_encaissement->format('Y-m-d') > $y_encaiss.'-'.$m_d_entree  ){
            $date_deb = $y_encaiss.'-'.$m_d_entree ;
            $date_fin = $compromis->getFactureStylimmo()->date_encaissement->format('Y-m-d');
            $date_anniv = $m_d_entree_fr.'/'.$y_encaiss;
        }else{
            $date_deb =  ($y_encaiss-1).'-'.$m_d_entree ;
            $date_fin = $compromis->getFactureStylimmo()->date_encaissement->format('Y-m-d'); 
            $date_anniv = $m_d_entree_fr.'/'.($y_encaiss-1);
        }

        $chiffre_affaire_sty = Compromis::getCAStylimmo($mandataire->id, $date_deb, $date_fin); 

        
        
        // On se positionne sur le pack actuel
        if($mandataire->pack_actuel == "starter"){
            $pourcent_dep =  $contrat->pourcentage_depart_starter;
            $paliers = $this->palier_unserialize( $contrat->palier_starter );
        }else{
            $pourcent_dep =  $contrat->pourcentage_depart_expert;
            $paliers = $this->palier_unserialize( $contrat->palier_expert );
        }

        // on modifie le palier pour ajouter le % de depart dans la colonne des % (palier[1])
        $p = $pourcent_dep ;
        for($i = 0 ; $i <count($paliers); $i++) {
            $p += $paliers[$i][1];
            $paliers[$i][1] = $p; 
        }

        // Calcul de la commission
        $niveau_actuel = $this->calcul_niveau($paliers, $chiffre_affaire_sty);


        $tva = Tva::coefficient_tva();
        // dd($chiffre_affaire_encai);
        if($contrat->est_soumis_tva == false ){

            if( $mandataire->statut == "auto-entrepreneur"){

                if($chiffre_affaire_encai < Parametre::montant_tva()){
                    $tva = 0;
                }
            }else{
                $tva = 0;
            }
        }

        // SI LE MANDATAIRE PORTEUR NE PARTAGE PAS
        if($compromis->est_partage_agent == false ){

        
            $montant_vnt_ht = ($compromis->frais_agence()/Tva::coefficient_tva()) ; 
            $formule = $this->calcul_com($paliers, $montant_vnt_ht, $chiffre_affaire_sty, $niveau_actuel-1, $mandataire);
        

            
            $montant_ht = round ( $formule[1] ,2) ;


            // SI LE MANDATAIRE PORTEUR PARTAGE 
            }else{

                $montant_vnt_ht = ($compromis->frais_agence()/Tva::coefficient_tva()) ; 
                $pourcentage_partage = $compromis->pourcentage_agent/100;

                $formule = $this->calcul_com($paliers, $montant_vnt_ht*$pourcentage_partage , $chiffre_affaire_sty, $niveau_actuel-1, $mandataire);

                    $montant_ht = round ( $formule[1] ,2) ;
                    $montant_ttc = round ($montant_ht*$tva,2);

            }
            
            if($contrat->est_soumis_tva == true ){
                $montant_tva =  round ($montant_ht*Tva::tva(),2);
            }else{
                $montant_tva =  0;
            }
            
            return array("montant_ht"=> $montant_ht, "montant_tva"=> $montant_tva) ;
    }




    public function getFactureHonoPartageProvi(){

        $compromis = $this;
        $mandataire = $compromis->getPartage();

        // si le partage existe
        if($mandataire != null){

       
        
                $contrat = $mandataire->contrat;
                $montant_ht = null;

                // On va determiner la dernière date d'anniv de sa date d'entree
                $m_d_entree = $mandataire->contrat->date_entree->format('m-d');
                $m_d_entree_fr = $mandataire->contrat->date_entree->format('d/m');
                $y_encaiss = $compromis->getFactureStylimmo()->date_encaissement->format('Y');

                // dd($y_encaiss.'-'.$m_d_entree);
                if( $compromis->getFactureStylimmo()->date_encaissement->format('Y-m-d') > $y_encaiss.'-'.$m_d_entree  ){
                    $date_deb = $y_encaiss.'-'.$m_d_entree ;
                    $date_fin = $compromis->getFactureStylimmo()->date_encaissement->format('Y-m-d');
                    $date_anniv = $m_d_entree_fr.'/'.$y_encaiss;
                }else{
                    $date_deb =  ($y_encaiss-1).'-'.$m_d_entree ;
                    $date_fin = $compromis->getFactureStylimmo()->date_encaissement->format('Y-m-d'); 
                    $date_anniv = $m_d_entree_fr.'/'.($y_encaiss-1);
                }

                $chiffre_affaire_sty = Compromis::getCAStylimmo($mandataire->id, $date_deb, $date_fin); 

                
                
                // On se positionne sur le pack actuel
                if($mandataire->pack_actuel == "starter"){
                    $pourcent_dep =  $contrat->pourcentage_depart_starter;
                    $paliers = $this->palier_unserialize( $contrat->palier_starter );
                }else{
                    $pourcent_dep =  $contrat->pourcentage_depart_expert;
                    $paliers = $this->palier_unserialize( $contrat->palier_expert );
                }

                // on modifie le palier pour ajouter le % de depart dans la colonne des % (palier[1])
                $p = $pourcent_dep ;
                for($i = 0 ; $i <count($paliers); $i++) {
                    $p += $paliers[$i][1];
                    $paliers[$i][1] = $p; 
                }

                // Calcul de la commission
                $niveau_actuel = $this->calcul_niveau($paliers, $chiffre_affaire_sty);


                $tva = Tva::coefficient_tva();
                // dd($chiffre_affaire_encai);
                if($contrat->est_soumis_tva == false ){

                    if( $mandataire->statut == "auto-entrepreneur"){

                        if($chiffre_affaire_encai < Parametre::montant_tva()){
                            $tva = 0;
                        }
                    }else{
                        $tva = 0;
                    }
                }

                    // SI LE MANDATAIRE PORTEUR NE PARTAGE PAS
                    if($compromis->est_partage_agent == true ){

                
                        $montant_vnt_ht = ($compromis->frais_agence()/Tva::coefficient_tva()) ; 
                        $pourcentage_partage = (100 - $compromis->pourcentage_agent)/100;

                        $formule = $this->calcul_com($paliers, $montant_vnt_ht*$pourcentage_partage , $chiffre_affaire_sty, $niveau_actuel-1, $mandataire);

                            $montant_ht = round ( $formule[1] ,2) ;
                            $montant_ttc = round ($montant_ht*$tva,2);

                    }
                }
                else{
                    return 0 ;
                }



                if($contrat->est_soumis_tva == true ){
                    $montant_tva =  round ($montant_ht*Tva::tva(),2);
                }else{
                    $montant_tva =  0;
                }
                
                return array("montant_ht"=> $montant_ht, "montant_tva"=> $montant_tva) ;
    }





    public function getFactureParrainPorteurProvi(){

        $compromis = $this;
        
        $filleul1  = Filleul::where('user_id',$compromis->user_id)->first();
        // on vérifie que le porteur d'affaire a un filleul
        if($filleul1 != null) {
        
                //  lorsque les filleuls partagent 
                if($compromis->est_partage_agent == true){
                    
                            
                            $filleul = User::where('id',$filleul1->user_id)->first();
                            $pourcentage_parrain =  Filleul::where('user_id',$filleul->id)->select('pourcentage')->first();
                            $pourcentage_parrain = $pourcentage_parrain['pourcentage'];
            
            
                            // On determine le parrain 
                            $parrain_id =  Filleul::where('user_id',$filleul->id)->select('parrain_id')->first();    
                            $parrain = User::where('id',$parrain_id['parrain_id'])->first();
                            $deb_annee = date("Y")."-01-01";


                             // On vérifie que le parrain a les droits de parrainage n'a pas dépassé le plafond de comm sur son filleul 
                                        
                                $result = Filleul::droitParrainage($parrain->id, $filleul->id, $compromis->id);

                                if($result['respect_condition'] == false ) 
                                    return array("montant_ht"=> 0, "montant_tva"=> 0) ;

                                    
                        // on determine le chiffre d'affaire encaissé du parrain depuis le 1er janvier, pour voir s'il est soumis à la TVA
                            $chiffre_affaire_parrain_encai = Facture::where('user_id',$parrain->id)->whereIn('type',['honoraire','partage','parrainage','parrainage_partage'])->where('reglee',true)->where('date_reglement','>=',$deb_annee)->sum('montant_ht');
                        //    on reccupere le contrat du parrain
                            $contrat = $parrain->contrat;
                            $tva = Tva::coefficient_tva();
                            
                            if($contrat->est_soumis_tva == false){
                            
                                if($chiffre_affaire_parrain_encai < Parametre::montant_tva()){
                                    $tva = 0;
                                }else{
                                    $contrat->est_soumis_tva = true;
                                    $contrat->update();
                                }
            
                            }
            
                            $frais_agence = $compromis->frais_agence() * $compromis->pourcentage_agent/100 ;
                            $montant_ht = round ( ($frais_agence * $pourcentage_parrain/100 )/Tva::coefficient_tva() ,2);
                            $montant_ttc = round( $montant_ht*$tva,2);
                            // dd("unique filleul 1 ");
            
                    
            
                        
                    
            
                        if($result['ca_comm_parr'] >= $filleul->contrat->seuil_comm ){
                            $montant_ht = 0;
                            $montant_ttc = 0;
                        }
                        else{
                            if( $result['ca_comm_parr'] + $montant_ht  > $filleul->contrat->seuil_comm ){
                                $montant_ht = $filleul->contrat->seuil_comm - $result['ca_comm_parr'];
                                $montant_ttc = $montant_ht*Tva::coefficient_tva();
                            }
                        }
                    
            
            
            // filleul sans partage
                }else{ 
            

                    //   dd("un filleul sans partage");
                    $filleul = User::where('id',$compromis->user_id)->first();
                    $pourcentage_parrain =  Filleul::where('user_id',$filleul->id)->select('pourcentage')->first();
                    $pourcentage_parrain = $pourcentage_parrain['pourcentage'];
            
                    // On determine le parrain 
                    $parrain_id =  Filleul::where('user_id',$filleul->id)->select('parrain_id')->first();    
                    $parrain = User::where('id',$parrain_id['parrain_id'])->first();
                    $deb_annee = date("Y")."-01-01";

                    // On vérifie que le parrain a les droits de parrainage n'a pas dépassé le plafond de comm sur son filleul 
                                        
                    $result = Filleul::droitParrainage($parrain->id, $filleul->id, $compromis->id);

                    if($result['respect_condition'] == false ) 
                        return array("montant_ht"=> 0, "montant_tva"=> 0) ;
                
                // on determine le chiffre d'affaire ht encaissé du parrain depuis le 1er janvier, pour voir s'il est soumis à la TVA
                    $chiffre_affaire_parrain_encai = Facture::where('user_id',$parrain->id)->whereIn('type',['honoraire','partage','parrainage','parrainage_partage'])->where('reglee',true)->where('date_reglement','>=',$deb_annee)->sum('montant_ht');
                //    on reccupere le contrat du parrain
                    $contrat = $parrain->contrat;
                    $tva = Tva::coefficient_tva();
                    
                    if($contrat->est_soumis_tva == false){
                    
                        if($chiffre_affaire_parrain_encai < Parametre::montant_tva()){
                            $tva = 0;
                        }else{
                            $contrat->est_soumis_tva = true;
                            $contrat->update();
                        }
            
                    }
            
                
                     // On determine les montants ttc et ht du parrain 
                     $frais_agence =  $compromis->frais_agence();
                    $montant_ht = round ( ($frais_agence * $pourcentage_parrain/100 )/Tva::coefficient_tva(),2);
                    $montant_ttc = round($montant_ht*$tva,2);
                
            
                    if($result['ca_comm_parr'] >= $filleul->contrat->seuil_comm ){
                        $montant_ht = 0;
                        $montant_ttc = 0;
                    }
                    else{
                        if( $result['ca_comm_parr'] + $montant_ht  > $filleul->contrat->seuil_comm ){
                            $montant_ht = $filleul->contrat->seuil_comm - $result['ca_comm_parr'];
                            $montant_ttc = $montant_ht*$tva;
            
                        }
                    }
            
            
            
                }
    
        }
        else{

            return array("montant_ht"=> 0, "montant_tva"=> 0) ;
        }

    
         if($contrat->est_soumis_tva == true ){
                $montant_tva =  round ($montant_ht*Tva::tva(),2);
        }else{
            $montant_tva =  0;
        }


            
            return array("montant_ht"=> $montant_ht, "montant_tva"=> $montant_tva) ;
    }

    
    public function getFactureParrainPartageProvi(){

        $compromis = $this;
        
        $filleul1  = Filleul::where('user_id',$compromis->agent_id)->first();

        // on vérifie que le partage de l'affaire a un filleul
        if($filleul1 != null) {
        
                //  lorsque les filleuls partagent 
                if($compromis->est_partage_agent == true){
                    
            
                            $filleul = User::where('id',$filleul1->user_id)->first();
                            $pourcentage_parrain =  Filleul::where('user_id',$filleul->id)->select('pourcentage')->first();
                            $pourcentage_parrain = $pourcentage_parrain['pourcentage'];
            
            
                            // On determine le parrain 
                            $parrain_id =  Filleul::where('user_id',$filleul->id)->select('parrain_id')->first();    
                            $parrain = User::where('id',$parrain_id['parrain_id'])->first();
                            $deb_annee = date("Y")."-01-01";

                             // On vérifie que le parrain a les droits de parrainage n'a pas dépassé le plafond de comm sur son filleul 
                                        
                            $result = Filleul::droitParrainage($parrain->id, $filleul->id, $compromis->id);

                            if($result['respect_condition'] == false ) 
                                return array("montant_ht"=> 0, "montant_tva"=> 0) ;


                        // on determine le chiffre d'affaire encaissé du parrain depuis le 1er janvier, pour voir s'il est soumis à la TVA
                            $chiffre_affaire_parrain_encai = Facture::where('user_id',$parrain->id)->whereIn('type',['honoraire','partage','parrainage','parrainage_partage'])->where('reglee',true)->where('date_reglement','>=',$deb_annee)->sum('montant_ht');
                        //    on reccupere le contrat du parrain
                            $contrat = $parrain->contrat;
                            $tva = Tva::coefficient_tva();
                            
                            if($contrat->est_soumis_tva == false){
                            
                                if($chiffre_affaire_parrain_encai < Parametre::montant_tva()){
                                    $tva = 0;
                                }else{
                                    $contrat->est_soumis_tva = true;
                                    $contrat->update();
                                }
            
                            }
            
                            $frais_agence = $compromis->frais_agence() * (100- $compromis->pourcentage_agent)/100 ;
                            $montant_ht = round ( ($frais_agence * $pourcentage_parrain/100 )/Tva::coefficient_tva() ,2);
                            $montant_ttc = round( $montant_ht*$tva,2);
                            // dd("unique filleul 1 ");

            
                      
                    
            
                        if($result['ca_comm_parr'] >= $filleul->contrat->seuil_comm ){
                            $montant_ht = 0;
                            $montant_ttc = 0;
                        }
                        else{
                            if( $result['ca_comm_parr'] + $montant_ht  > $filleul->contrat->seuil_comm ){
                                $montant_ht = $filleul->contrat->seuil_comm - $result['ca_comm_parr'];
                                $montant_ttc = $montant_ht*Tva::coefficient_tva();
                            }
                        }
            
                    
                }
        }
        else{
                 return array("montant_ht"=> 0, "montant_tva"=> 0) ;
        }
    
          if($contrat->est_soumis_tva == true ){
                $montant_tva =  round ($montant_ht*Tva::tva(),2);
            }else{
                $montant_tva =  0;
            }
            
            return array("montant_ht"=> $montant_ht, "montant_tva"=> $montant_tva) ;
    }
      

// CALCUL DES TOTAUX DUS ET RESTE A REGLER


public function total_du(){

    $compromis = $this;

    $total_ht = 0 ;
    $total_tva = 0 ;

    if($compromis->getHonoPorteur() != null){
        $total_ht += $compromis->getHonoPorteur()->montant_ht;
        $total_tva += $compromis->getHonoPorteur()->montant_ttc > 0 ? $compromis->getHonoPorteur()->montant_ht * Tva::tva() : 0 ;

    }else{
        $total_ht += $compromis->getFactureHonoProvi()['montant_ht'];
        $total_tva += $compromis->getFactureHonoProvi()['montant_tva'];
    }

    if($compromis->getHonoPartage() != null){
        $total_ht += $compromis->getHonoPartage()->montant_ht;
        $total_tva += $compromis->getHonoPartage()->montant_ttc > 0 ? $compromis->getHonoPartage()->montant_ht * Tva::tva() : 0 ;
    }else{
        $total_ht += $compromis->getFactureHonoPartageProvi()['montant_ht'];
        $total_tva += $compromis->getFactureHonoPartageProvi()['montant_tva'];
    }

    if($compromis->getFactureParrainPorteur() != null){

        $total_ht += $compromis->getFactureParrainPorteur()->montant_ht;
        $total_tva += $compromis->getFactureParrainPorteur()->montant_ttc > 0 ? $compromis->getFactureParrainPorteur()->montant_ht * Tva::tva() : 0 ;
    }else{
        $total_ht += $compromis->getFactureParrainPorteurProvi()['montant_ht'];
        $total_tva += $compromis->getFactureParrainPorteurProvi()['montant_tva'];
    }

    if($compromis->getFactureParrainPartage() != null){
        $total_ht += $compromis->getFactureParrainPartage()->montant_ht;
        $total_tva += $compromis->getFactureParrainPartage()->montant_ttc > 0 ? $compromis->getFactureParrainPartage()->montant_ht * Tva::tva() : 0 ;
    }else{
        $total_ht += $compromis->getFactureParrainPartageProvi()['montant_ht'];
        $total_tva += $compromis->getFactureParrainPartageProvi()['montant_tva'];
    }


    return array("total_ht"=> $total_ht, "total_tva"=> $total_tva) ;
}



public function reste_a_regler($date_deb =null, $date_fin = null){

    $compromis = $this;
    $porteur = $this->user;
    $partage = $this->getPartage();

    $tva_a_payer = $this->total_du()['total_tva'];


    $nodate = ($date_deb == null || $date_fin == null) ? true : false ;

    $reste = $this->total_du()['total_ht'] + $this->total_du()['total_tva'] ;

    if($compromis->getHonoPorteur() != null){
        if($compromis->getHonoPorteur()->reglee == true  ){

            $mtn_a_deduire = $compromis->getHonoPorteur()->montant_ttc > 0 ?  $compromis->getHonoPorteur()->montant_ttc :  $compromis->getHonoPorteur()->montant_ht; 

            if($nodate == false){
                if(($compromis->getHonoPorteur()->date_reglement->format('yy-m-d') <= $date_fin)){

                    $reste -= $mtn_a_deduire;
                    $tva_a_payer -=  $compromis->getHonoPorteur()->montant_ttc > 0 ?  $compromis->getHonoPorteur()->montant_ht *Tva::tva()  : 0; 
                }
            }else{
                $reste -= $mtn_a_deduire;
                $tva_a_payer -= $compromis->getHonoPorteur()->montant_ttc > 0 ? $compromis->getHonoPorteur()->montant_ht *Tva::tva()  : 0; 

            }
        }
    }

    if($compromis->getHonoPartage() != null ){
        if($compromis->getHonoPartage()->reglee == true  ){

            $mtn_a_deduire = $compromis->getHonoPartage()->montant_ttc > 0 ?  $compromis->getHonoPartage()->montant_ttc :  $compromis->getHonoPartage()->montant_ht; 

            if($nodate == false){
                if(($compromis->getHonoPartage()->date_reglement->format('yy-m-d') <= $date_fin)){

                    $reste -= $mtn_a_deduire; 
                    $tva_a_payer -=  $compromis->getHonoPartage()->montant_ttc > 0 ? $compromis->getHonoPartage()->montant_ht *Tva::tva() : 0 ; 

                }
            }else{
                $reste -= $mtn_a_deduire;
                $tva_a_payer -=  $compromis->getHonoPartage()->montant_ttc > 0 ? $compromis->getHonoPartage()->montant_ht *Tva::tva() : 0 ; 

            }
        }
    }

    if($compromis->getFactureParrainPorteur() != null ){
        if($compromis->getFactureParrainPorteur()->reglee == true ){

            $mtn_a_deduire = $compromis->getFactureParrainPorteur()->montant_ttc > 0 ?  $compromis->getFactureParrainPorteur()->montant_ttc :  $compromis->getFactureParrainPorteur()->montant_ht; 

            if($nodate == false){
                if((  $compromis->getFactureParrainPorteur()->date_reglement->format('yy-m-d') <= $date_fin)){

                    $reste -= $mtn_a_deduire;
                    $tva_a_payer -= $compromis->getFactureParrainPorteur()->montant_ttc > 0 ? $compromis->getFactureParrainPorteur()->montant_ht *Tva::tva() : 0 ; 

                }
            }else{
                $reste -= $mtn_a_deduire;
                $tva_a_payer -= $compromis->getFactureParrainPorteur()->montant_ttc > 0 ? $compromis->getFactureParrainPorteur()->montant_ht *Tva::tva() : 0 ; 

            }
        }
    }

    if($compromis->getFactureParrainPartage() != null ){
        if($compromis->getFactureParrainPartage()->reglee == true ){
            $mtn_a_deduire = $compromis->getFactureParrainPartage()->montant_ttc > 0 ?  $compromis->getFactureParrainPartage()->montant_ttc :  $compromis->getFactureParrainPartage()->montant_ht; 

            if($nodate == false){
                if(( $compromis->getFactureParrainPartage()->date_reglement->format('yy-m-d') <= $date_fin)){

                    $reste -= $mtn_a_deduire;
                    $tva_a_payer -= $compromis->getFactureParrainPartage()->montant_ttc > 0 ? $compromis->getFactureParrainPartage()->montant_ht *Tva::tva() : 0 ; 

                }
            }else{
                $reste -= $mtn_a_deduire;
                $tva_a_payer -= $compromis->getFactureParrainPartage()->montant_ttc > 0 ? $compromis->getFactureParrainPartage()->montant_ht *Tva::tva() : 0 ; 

            }
        }
    }

    return array('reste_a_payer'=> $reste, 'tva_a_payer'=> $tva_a_payer) ;
}


// etat financier d'une affaire


public function etat_fin($date_deb=null, $date_fin=null){


    $etat = array();

    $mandat = $this->numero_mandat;
    $numero_styl = $this->getFactureStylimmo()->numero;

    $montant_styl_ht = $this->getFactureStylimmo()->montant_ht;
    $montant_styl_ttc = $this->getFactureStylimmo()->montant_ttc;

    $total_du_ht = $this->total_du()['total_ht'];
    $total_du_tva = $this->total_du()['total_tva'];
    $reste_a_regler = $this->reste_a_regler($date_deb, $date_fin)['reste_a_payer'];
    $tva_a_regler = $this->reste_a_regler($date_deb, $date_fin)['tva_a_payer'];
    // $reste_a_regler_ttc = $this->reste_a_regler()*Tva::coefficient_tva();

    $etat = array(
        "numero_mandat" => $mandat,
        "numero_styl" => $numero_styl,
        "montant_styl_ht" => $montant_styl_ht,
        "montant_styl_ttc" => $montant_styl_ttc,
        "montant_styl_tva" =>  $montant_styl_ht*Tva::tva(),
        "facture_styl" => $this->getFactureStylimmo(),

        "total_du_ht" => $total_du_ht,
        "total_du_tva" => $total_du_tva,
        
        "reste_a_regler" => $reste_a_regler,
        "tva_a_regler" => $tva_a_regler,
        // "reste_a_regler_ttc" => $reste_a_regler_ttc,
       
    );

    // dd($etat);
    return $etat;

}



    // CALCULS DES CHIFFRES D'AFFAIRES

    // Retourne le chiffre d'affaire stylimmo d'un mandataire sur une période
    public static function getCAStylimmo($mandataire_id, $date_deb, $date_fin){

    

            $compro_encaisse_partage_pas_n = Compromis::where([['user_id',$mandataire_id],['est_partage_agent',false],['demande_facture',2],['archive',false]])->get();
            $ca_encaisse_partage_pas_n = 0;
            if($compro_encaisse_partage_pas_n != null){                
                foreach ($compro_encaisse_partage_pas_n as $compros_encaisse) {
                    if($compros_encaisse->getFactureStylimmo()->encaissee == 1 && $compros_encaisse->getFactureStylimmo()->date_encaissement->format("Y-m-d") >= $date_deb && $compros_encaisse->getFactureStylimmo()->date_encaissement->format("Y-m-d") <= $date_fin){
                        $ca_encaisse_partage_pas_n +=  $compros_encaisse->getFactureStylimmo()->montant_ttc;
                    
                    }
               }
               
           }
        
            // CA encaissé partagé et porte affaire
            $compro_encaisse_porte_n = Compromis::where([['user_id',$mandataire_id],['est_partage_agent',true],['demande_facture',2],['archive',false]])->get();
            $ca_encaisse_porte_n = 0;

                if($compro_encaisse_porte_n != null){
                    foreach ($compro_encaisse_porte_n as $compros_encaisse) {
                        if($compros_encaisse->getFactureStylimmo()->encaissee == 1 && $compros_encaisse->getFactureStylimmo()->date_encaissement->format("Y-m-d") >= $date_deb && $compros_encaisse->getFactureStylimmo()->date_encaissement->format("Y-m-d") <= $date_fin){
                            $ca_encaisse_porte_n +=  $compros_encaisse->frais_agence * $compros_encaisse->pourcentage_agent/100;
                        }
                    }
                }


            // CA encaissé partagé et ne porte pas affaire
 
            $compro_encaisse_porte_pas_n = Compromis::where([['agent_id',$mandataire_id],['est_partage_agent',true],['demande_facture',2],['archive',false]])->get();
            $ca_encaisse_porte_pas_n = 0;

                if($compro_encaisse_porte_pas_n != null){
                    foreach ($compro_encaisse_porte_pas_n as $compros_encaisse) {
                        if($compros_encaisse->getFactureStylimmo()->encaissee == 1 && $compros_encaisse->getFactureStylimmo()->date_encaissement->format("Y-m-d") >= $date_deb && $compros_encaisse->getFactureStylimmo()->date_encaissement->format("Y-m-d") <= $date_fin){
                            $ca_encaisse_porte_pas_n +=  $compros_encaisse->frais_agence * (100-$compros_encaisse->pourcentage_agent)/100;
                        }
                    }
                }

         
            
            $ca_encaisse_N = round(($ca_encaisse_partage_pas_n+$ca_encaisse_porte_n+$ca_encaisse_porte_pas_n)/Tva::coefficient_tva(),2);


return $ca_encaisse_N ;    
       
    }


    
 /**
 * Déserialiser le palier
 *
 * @return \Illuminate\Http\Response
 */
public function palier_unserialize($param)
{
    // on construit un tableau sans les &
    $palier = explode("&", $param);
    $array = array();
    foreach($palier as $pal)
    {
        // pour chaque element du tableau, on extrait la valeur
        $tmp = substr($pal , strpos($pal, "=") + 1, strlen($pal));
        array_push($array, $tmp);
    }
    // on divise le nouveau tableau de valeur en 4 tableau de même taille
    $chunk = array_chunk($array, 4);

    return $chunk;
}


/**
 *  Calcul de la commission en fonction du palier, de la vente, du chiffre d'affaire styl et du niveau actuel
 *
 * @param  double  $montant_vnt, $ca
 * @return \Illuminate\Http\Response
*/

public function calcul_com($palier, $montant_vnt_ht, $ca, $niveau)
{

    $commission = 0;
    $tab = array();
        // à partir du niveau actuell, on avance sur le palier
       for ($i=$niveau; $i<count($palier);$i++){
           if ($ca + $montant_vnt_ht <= ($palier[$i])[3] || $i == count($palier) - 1){
               $commission += ($montant_vnt_ht / 100) * ($palier[$i])[1];
               $tab[] = array($montant_vnt_ht,($palier[$i])[1]);
               break;
           }
           else {
               $diff = ($palier[$i])[3] - $ca;
               $commission += ($diff / 100) * ($palier[$i])[1];
               $montant_vnt_ht -= $diff;

               $tab[] = array($diff,($palier[$i])[1]);
            
            //    echo("Ajout à la commission:". ($diff / 100) * ($palier[$i])[1]);
            //    echo("reste:". $montant_vnt_ht);
               $ca += $diff;
           }
       }

    $tabs = array($tab,$commission);
    return $tabs;
}


/**
 * Calcul du palier actuel du mandataire en fonction de son CA STYLIMMO encaissé
 *
 * @return \Illuminate\Http\Response
 */
public function calcul_niveau($paliers, $chiffre_affaire)
{
    $niveau = 1;
    $nb_niveau = sizeof($paliers) -1  ;
    // dd($paliers[4]);
    foreach ($paliers as $palier) {
       
        if($chiffre_affaire >= $palier[2] && $chiffre_affaire <= $palier[3] ){
            $niveau = $palier[0];
        }elseif($chiffre_affaire > $paliers[ $nb_niveau ][3]){
            $niveau = $paliers[ $nb_niveau ][0];
        }
    }

    return $niveau;
}

// ############### NOTIFICATIONS 


/**
 * Notification après avois réitéré 
 *
 * @return \Illuminate\Http\Response
 */
public function notif_reiterer_affaire()
{
      
     
    $notif = array("id"=>Auth::user()->id, "nom"=> Auth::user()->nom, "numero_mandat"=> $this->numero_mandat );    
    
 
    Notification::send(Auth::user(),  new ReitererAffaire($notif));
    

    return true;
}





/**
 * Retourne les frais d'agence, en vérifiant que sil y'a partage externe 
 *
 * @return \Illuminate\Http\Response
 */
public function frais_agence()
{
      
     
    $montant_ttc = $this->frais_agence;
    
    // Si on partage avec une agence externe
    if($this->est_partage_agent == true && $this->partage_reseau == false){
    // Si Styl et l'agence  OU  l'agence porte l'affaire chez le notaire, on ne facture facture pas la totalité des frais d'agence
        if($this->qui_porte_externe == 1 || $this->qui_porte_externe == 2){
        
            $montant_ttc = $montant_ttc * $this->pourcentage_agent / 100;
        }
    }
    
    // dd($montant_ttc);
    

    return $montant_ttc;
}

}
