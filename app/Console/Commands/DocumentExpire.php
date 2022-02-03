<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Fichier;

class DocumentExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:documentexpire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoi une notification quand la date de validité du document arrive à expiration ';

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
        $fichiers = Fichier::where('expire',0)->get();

      
        if($fichiers != null){

            foreach($fichiers as $fichier){

                $today = strtotime (date('Y-m-d'));
                $diff = $today - $date_entree;

                   
                //    ENVOI MAIL
                Mail::to($mandataire->email)->send(new NotifEvolutionfichier($mandataire,$mandataire_fichier));

                
            }
        }
        Cronjob::create([
            "nom" => "documentexpire",
            ]);
    
    }
}
