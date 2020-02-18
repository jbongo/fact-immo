<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Filleul;
use App\User;
use App\Parametre;



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
    protected $description = 'Chaque jour on vérifie que chaque la durée d\'ancienneté du mandatire, si > 3 ans alors on passe le filleul a expire = 1,  
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

        $comm_parrain = unserialize($parametre->comm_parrain);

        // dd($comm_parrain);
        if($filleuls != null){

            foreach($filleuls as $filleul){
                $date_deb =  strtotime($filleul->user->contrat->date_deb_activite);
                $rang = $filleul->rang <= 3 ? $filleul->rang : 'n';

                $today = strtotime (date('Y-m-d'));
                $diff = $today - $date_deb;
                // echo $today; 

                // dd(strtotime("2020-01-02") - strtotime('2020-01-01'));
                $trois_ans = 86400*365*3;

                // Après 3ANS d'activités le filleul expire
                if($diff >= $trois_ans){

                   $filleul->expire = 1;
                   $filleul->update();
                   

                //    echo 'update '.$filleul->id;
                }else{
                   
                    // si ancienneté est inférieur à 1 ans
                    // if($diff <= 365*86400){
                    //     $filleul->pourcentage = $comm_parrain["p_1_$rang"];

                    // }
                    //si ancienneté est compris entre 1 et 2 ans
                    if($diff > 365*86400 && $diff <= 365*86400*2){
                        $filleul->pourcentage = $comm_parrain["p_2_$rang"];
                    }
                    //si ancienneté est compris entre 2 et 3 ans
                    elseif($diff > 365*86400*2 && $diff <= 365*86400*3){
                        $filleul->pourcentage = $comm_parrain["p_3_$rang"];
                    }
                    // ancienneté sup à 3 ans
                    else{
                        $filleul->pourcentage = $comm_parrain["p_3_$rang"];
                    }

                   $filleul->update();

                }


                
            }
        }
    }
}
