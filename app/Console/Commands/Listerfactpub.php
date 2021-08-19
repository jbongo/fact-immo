<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User;
use App\Contrat;
use App\Factpub;
use App\Tva;

use App\Cronjob;

class Listerfactpub extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:listerfactpub';
    

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permet de lister chaque 28 du mois tous les mandataires qui sont soumis aux factures, pour validation et génération de facture de packpub';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        
        $today = date('Y-m-d');
        
        $contrats = Contrat::where([['a_demission',false],['deduis_jeton', false], ['est_modele', false],['est_soumis_fact_pub', true]])->orWhere([['a_demission',true],['date_fin_preavis', '>=' ,$today],['deduis_jeton', false], ['est_modele', false]])->get();
        
        foreach ($contrats as $contrat) {
            
          
            // On determine la date à laquelle le mandataire doit passer expert
            $date_passage_expert = strtotime($contrat->date_deb_activite->format('Y-m-d'). "+ $contrat->duree_max_starter month");
            $date_passage_expert = date('Y-m-d', $date_passage_expert);
            
            $today = date_create(date('Y-m-d'));
            $date_passage= date_create($date_passage_expert);
            
            // on determine le nombre de jours entre son passage à expert et aujourd'hui
            $duree_passage_expert = date_diff($today, $date_passage);
            

      
            
            
       
            
            
            
            // Date de fin de la gratuité totale pour le starter
            $date_fin_gratuite_totale_starter = strtotime($contrat->date_deb_activite->format('Y-m-d'). "+ $contrat->duree_gratuite_starter month");            
            $date_fin_pack_info_starter = strtotime( date('Y-m-d',$date_fin_gratuite_totale_starter)."+ $contrat->duree_pack_info_starter month");
            
            
            
             // Date de fin de la gratuité totale pour l'expert
             $date_fin_gratuite_totale_expert = strtotime($contrat->date_deb_activite->format('Y-m-d'). "+ $contrat->duree_gratuite_expert month");            
             $date_fin_pack_info_expert = strtotime( date('Y-m-d',$date_fin_gratuite_totale_expert)."+ $contrat->duree_pack_info_expert month");
             
            
            
            // dd( $contrat->user->pack_actuel);
            
            // Le Mandataire paye si 
            // son pack est starter et sa période de gratuitée est terminée 
            // son pack est expert et sa période de gratuitée est terminée et 28 jour après qu'il soit passé expert
            
            if($contrat->user->pack_actuel == "expert"  && ($contrat->est_demarrage_starter == false || $contrat->est_demarrage_starter == true && $duree_passage_expert->days > 28 ) ){
                
               
                // période pendant laquelle le mandataire ne paye que le pack info
                if( date('Y-m-d') > date('Y-m-d',$date_fin_gratuite_totale_expert) && date('Y-m-d') < date('Y-m-d',$date_fin_pack_info_expert) && $contrat->forfait_pack_info > 0 ){
                
                    Factpub::create([
                        'user_id' => $contrat->user_id,
                        'packpub' => $contrat->packpub->nom,
                        'montant_ht' => $contrat->forfait_pack_info ,
                        'montant_ttc' => $contrat->forfait_pack_info * Tva::coefficient_tva(),
                    
                    ]);
                
                
                // après la fin de la gratuité le mandataire paye des packs pub
                }elseif(date('Y-m-d') >= date('Y-m-d',$date_fin_pack_info_expert)){
                
                    Factpub::create([
                        'user_id' => $contrat->user_id,
                        'packpub' => $contrat->packpub->nom,
                        'montant_ht' => round($contrat->packpub->tarif / Tva::coefficient_tva(), 2),
                        'montant_ttc' => $contrat->packpub->tarif,
                    
                    ]);
                
                }

               
                
            }elseif($contrat->user->pack_actuel == "starter") {
            
                
                // période pendant laquelle le mandataire ne paye que le pack info
                if( date('Y-m-d') > date('Y-m-d',$date_fin_gratuite_totale_starter) && date('Y-m-d') < date('Y-m-d',$date_fin_pack_info_starter) && $contrat->forfait_pack_info > 0 ){
                
                    Factpub::create([
                        'user_id' => $contrat->user_id,
                        'packpub' => $contrat->packpub->nom,
                        'montant_ht' => $contrat->forfait_pack_info ,
                        'montant_ttc' => $contrat->forfait_pack_info * Tva::coefficient_tva(),
                    
                    ]);
                
                
                // après la fin de la gratuité le mandataire paye des packs pub
                }elseif(date('Y-m-d') >= date('Y-m-d',$date_fin_pack_info_starter)){
                
              
                    Factpub::create([
                        'user_id' => $contrat->user_id,
                        'packpub' => $contrat->packpub->nom,
                        'montant_ht' => round($contrat->packpub->tarif / Tva::coefficient_tva(), 2),
                        'montant_ttc' => $contrat->packpub->tarif,
                    
                    ]);
                
                }
                
                
                
              
            
            }
            
                
            
        }
        Cronjob::create([
            "nom" => "listerfactpub",
            ]);
    }
}
