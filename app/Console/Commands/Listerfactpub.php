<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User;
use App\Contrat;
use App\Factpub;
use App\Tva;
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
        
        $contrats = Contrat::where([['a_demission',false],['deduis_jeton', false], ['est_modele', false]])->orWhere([['a_demission',true],['date_fin_preavis', '>=' ,$today],['deduis_jeton', false], ['est_modele', false]])->get();
        
        foreach ($contrats as $contrat) {
            
          
            
            $date_passage_expert = strtotime($contrat->date_deb_activite->format('Y-m-d'). "+ $contrat->duree_max_starter month");
            $date_passage_expert = date('Y-m-d', $date_passage_expert);
            
            $today = date_create(date('Y-m-d'));
            $date_passage= date_create($date_passage_expert);
            
            
            $duree_passage_expert = date_diff($today, $date_passage);
            
            // dd($duree_passage_expert);
           
            
            
            if($contrat->user->pack_actuel == "expert" && ($contrat->est_demarrage_starter == false || $contrat->est_demarrage_starter == true && $duree_passage_expert->days > 28 ) ){
                
                
                Factpub::create([
                'user_id' => $contrat->user_id,
                'packpub' => $contrat->packpub->nom,
                'montant_ht' => round($contrat->packpub->tarif / Tva::coefficient_tva(), 2),
                'montant_ttc' => $contrat->packpub->tarif,
                
                ]);
                
                
               
                
            }
            
        }

    }
}
