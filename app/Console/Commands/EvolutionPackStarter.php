<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Mail\NotifEvolutionStarter;
use Illuminate\Support\Facades\Mail;


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
    protected $description = ' Vérifie si les mandataires qui ont le pack starter, ont dépassé la durée du pack starter pour les passer au pack expert';

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
           
            $nb_mois_starter = $mandataire->contrat->duree_max_starter;
           

            if(date('Y-m-d',strtotime($mandataire->contrat->date_deb_activite->format('Y-m-d')."+ $nb_mois_starter month")) <= date('Y-m-d') ){

                $mandataire->pack_actuel = "expert";
                $ancienne_comm = $mandataire->commission;
                $nouvelle_comm = $mandataire->contrat->pourcentage_depart_expert;
                $mandataire->commission = $nouvelle_comm;

                $mandataire->update();

                Mail::to($mandataire->email)->send(new NotifEvolutionStarter($mandataire,$nb_mois_starter,$mandataire->contrat->date_deb_activite,$ancienne_comm,$nouvelle_comm));
                Mail::to("support@stylimmo.com")->send(new NotifEvolutionStarter($mandataire,$nb_mois_starter,$mandataire->contrat->date_deb_activite,$ancienne_comm,$nouvelle_comm));

               
                // echo $mandataire->nom." -->".date('Y-m-d',strtotime($mandataire->contrat->date_deb_activite->format("Y-m-d")."+ $nb_mois_starter month"))." \n";
            }
            
           }

        }


    }
}
