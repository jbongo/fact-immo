<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


use App\Contrat;
use App\Mail\NotifFinDroitSuite;


use Illuminate\Support\Facades\Mail;

class FinDroitSuite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:findroitsuite';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Coupe l\'accès aux mandataires apère la fin de droit de suite';

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
        
        $today = date("Y-m-d") ;
        
        $contrats = Contrat::where([['a_demission',true],['est_fin_droit_suite',false]])->get();
        foreach ($contrats as $contrat) {
            
            if($contrat->date_fin_droit_suite->format('Y-m-d') <= $today ) {
                
                $mandataire = $contrat->user ;
                
                $mandataire->password = $mandataire->password."_demission";
                $contrat->est_fin_droit_suite = true ;
                
                             
                $contrat->update();
                $mandataire->update();
                
                echo $contrat->user->nom."---". $contrat->date_fin_droit_suite->format('Y-m-d'). "\n";
            
                if($contrat->date_fin_droit_suite->format('Y-m-d') == $today )
                    Mail::to($mandataire->email)->send(new NotifFinDroitSuite($contrat));
                
                
                Mail::to("gestion@stylimmo.com")->send(new NotifFinDroitSuite($contrat));
            }
            
        }
        
        
    }
}
