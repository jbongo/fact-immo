<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Filleul;
use App\User;
use App\Parametre;

use App\Cronjob;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifEvolutionFilleul;

class EvolutionFilleul extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:evolutionfilleul';

    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Chaque jour on vérifie la durée d\'ancienneté de chaque mandatire filleul, si > 3 ans alors on passe le filleul a expire = 1,  
    si la durée d\'ancienneté est < 3 ans alors on adapte le pourcentage du filleul en fonction de l\'année et de son rang
    ';

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
        $filleuls = Filleul::where('expire',0)->get();

        // dd($filleuls);
        // dd ($filleuls[1]->user->id);
        $parametre = Parametre::first();

        // $comm_parrain = unserialize($parametre->comm_parrain);

        // dd($comm_parrain);
        if($filleuls != null){

            foreach($filleuls as $filleul){
            // dd($filleul->user_id);

                $date_ent =  $filleul->user->contrat->date_entree->format('Y-m-d') >= "2019-01-01" ?  $filleul->user->contrat->date_entree : "2019-01-01";
                $date_entree =  strtotime($date_ent);
                $rang = $filleul->rang <= 3 ? $filleul->rang : 'n';

        
                $today = strtotime (date('Y-m-d'));
                $diff = $today - $date_entree;

                // On determine la commission de parrainnage du parrain
                // $parrain = User::where('id',$filleul->parrain_id)->first();
                $comm_parrain = unserialize($filleul->user->contrat->comm_parrain);

                

                // echo $parrain->nom."\n";
                $trois_ans = 86400*365*3;

                // Après 3ANS d'activités le filleul expire
                if($diff >= $trois_ans){

                   $filleul->expire = 1;
                   $filleul->update();

                   $mandataire = User::where('id', $filleul->parrain_id)->first(); 
                   $mandataire_filleul = $filleul->user;
                   
                //    ENVOI MAIL
                Mail::to($mandataire->email)->send(new NotifEvolutionFilleul($mandataire,$mandataire_filleul));


                //    echo 'update '.$filleul->id;
                }else{
                   
          
                     // si ancienneté est inférieur à 1 ans
                     if($diff <= 365*86400){
                        $filleul->pourcentage = $comm_parrain["p_1_$rang"];
                    }

                    //si ancienneté est compris entre 1 et 2 ans
                    if($diff > 365*86400 && $diff <= 365*86400*2){
                        $filleul->pourcentage = $comm_parrain["p_2_$rang"];
                    }
                    //si ancienneté est compris entre 2 et 3 ans
                    elseif($diff > 365*86400*2 && $diff <= 365*86400*3){
                        $filleul->pourcentage = $comm_parrain["p_3_$rang"];
                    }

                   $filleul->update();

                }


                
            }
        }
        Cronjob::create([
            "nom" => "evolutionfilleul",
            ]);
    }
}
