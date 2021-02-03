<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Contrat;

class UpdateJeton extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updatejeton';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permet de mettre à jour les jetons à la date d\'anniversaire (date deb activité + gratuité des mandataires';

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
        $contrats = Contrat::where('deduis_jeton',true)->get();
        
    
        foreach ($contrats as $contrat) {
            
            if($contrat->user != null ){
                
                // calcul de la date anniv (date deb activite + gratuite expert)
                $date_anniv = $contrat->est_demarrage_starter ? date('m-d', strtotime($contrat->duree_gratuite_starter."months", strtotime($contrat->date_deb_activite)))  : $contrat->date_deb_activite->format('m-d') ;
                
                // echo $date_anniv."<br>";
                if(date('m-d')  == $date_anniv ){
                    $contrat->user->nb_mois_pub_restant += 12;
                    $contrat->user->update();
                    
                    // dd($contrat); 
                }
                
            }
        }
 
        
        
        
        
        
        // dd($contrats[1]);
        
    }
}
