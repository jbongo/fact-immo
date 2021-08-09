<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Mail\NotifEvolutionStarter;
use Illuminate\Support\Facades\Mail;
use App\Cronjob;


class EvolutionPackStarter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:evolutionpackstarter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = ' Vérifie si les mandataires qui ont le pack starter, ont dépassé la durée du pack starter ou s\'ils ont dépassé le nombre de vente requis pour les passer au pack expert';

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

        $mandataires = User::where('pack_actuel','starter')->get();

        foreach ($mandataires as $mandataire) {
           
           
           if($mandataire->contrat != null && $mandataire->contrat->a_demission == false){
           
                $passage_expert = false;
                $nb_mois_starter = $mandataire->contrat->duree_max_starter;
                
           
                // le parametre nb_vente est prioritaire pour le passage à expert s'il est renseigné dans le contrat du mandataire
                if($mandataire->contrat->nb_vente_passage_expert > 0){

                    // Si le mandataire dépasse le nombre vente requis, on le passe expert  
                    $date_deb = $mandataire->contrat->date_deb_activite->format('Y-m-d').
                    $date_fin = date('Y-m-d');
                    $passage_expert =  $mandataire->nombre_vente($date_deb, $date_fin) >= $mandataire->contrat->nb_vente_passage_expert   ? true : false ;
                                   
                }else{
                
                    // On tient compte seulement du nombre de mois max durée stater si le nombre de vente pour passage à expert n'est pas renseigné ou égale à 0 
                    if(date('Y-m-d',strtotime($mandataire->contrat->date_deb_activite->format('Y-m-d')."+ $nb_mois_starter month")) <= date('Y-m-d') ){
                        $passage_expert = true;
                    }
                
                }
                
                
                
                if($passage_expert == true){
                
                    $mandataire->pack_actuel = "expert";
                    $ancienne_comm = $mandataire->commission;
                    $nouvelle_comm = $mandataire->contrat->pourcentage_depart_expert;
                    $mandataire->commission = $nouvelle_comm;
    
                    $mandataire->update();
    
                    Mail::to($mandataire->email)->send(new NotifEvolutionStarter($mandataire,$nb_mois_starter,$mandataire->contrat->date_deb_activite,$ancienne_comm,$nouvelle_comm));
                    Mail::to("support@stylimmo.com")->send(new NotifEvolutionStarter($mandataire,$nb_mois_starter,$mandataire->contrat->date_deb_activite,$ancienne_comm,$nouvelle_comm));
                }
            
           
            
           }

        }

        Cronjob::create([
            "nom" => "evolutionpackstarter",
            ]);
    }
}
