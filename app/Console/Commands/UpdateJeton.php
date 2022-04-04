<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Contrat;
use App\Cronjob;
use App\Updatejeton as Jeton;
use App\Mail\NotifUpdateJeton;
use Illuminate\Support\Facades\Mail;


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
        $contrats = Contrat::where([['deduis_jeton',true], ['a_demission', false] ])->get();
        
    
        foreach ($contrats as $contrat) {
            
            if($contrat->user != null ){
              
                // calcul de la date anniv (date deb activite + gratuite expert)
                // $date_anniv = $contrat->est_demarrage_starter ? date('m-d', strtotime($contrat->duree_gratuite_starter."months", strtotime($contrat->date_deb_activite)))  : $contrat->date_deb_activite->format('m-d') ;
                $date_anniv = $contrat->date_deb_activite->format('m-d') ;
                
                // echo $date_anniv."<br>";
                if(date('m-d')  == $date_anniv ){
                   
                    $contrat->user->nb_mois_pub_restant += 12;
                    $contrat->user->update();
                    
                    // dd($contrat); 
                    Jeton::create([
                        "user_id" => $contrat->user->id,
                        "admin_id" => 0,
                        "jetons_deduis" => 12,
                        "jetons_avant_deduction" => $contrat->user->nb_mois_pub_restant,
                        "est_ajout_cronjob" => true,
                    
                    ]);
                    
                    Mail::to($contrat->user->email)->send(new NotifUpdateJeton($contrat->user));
                    Mail::to("support@stylimmo.com")->send(new NotifUpdateJeton($contrat->user));

                    
                }
                
            }
        }
 
        
        
        
        Cronjob::create([
            "nom" => "updatejeton",
            ]);
        
        // dd($contrats[1]);
        
    }
}
