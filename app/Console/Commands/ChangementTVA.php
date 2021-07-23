<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Tva;
use App\Parametre;
use App\Mail\ChangementTVA as ChangementTVAMail ;
use Illuminate\Support\Facades\Mail;

use App\Cronjob;

class ChangementTVA extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:changementtva';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permet de modifier la TVA en cours si une TVa est déjà planifiée';

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
        
        $tva_encour = Tva::where('actif', true)->first();
        $tva_prochaine = Tva::where('est_tva_prochaine', true)->first();
        
        
      
        if ($tva_prochaine != null){
        
            if($tva_prochaine->date_debut_tva_actuelle->format('Y-m-d') == Date('Y-m-d')){
                
                $tva_prochaine->actif = true;
                $tva_encour->actif = false;
                $tva_prochaine->est_tva_prochaine = false;
               
                $parametre = Parametre::first();
                $parametre->tva_id = $tva_prochaine->id;
                
                $parametre->update();
               
                $tva_prochaine->update();
                $tva_encour->update();
                
            // Mail::to("gestion@stylimmo.com")->send(new ChangementTVAMail($tva_encour->tva_actuelle ,$tva_prochaine->tva_actuelle));
                
            }
        
        
        }
        // echo $tva_encour
        Cronjob::create([
            "nom" => "changementtva",
            ]);
    }
}
