<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Fichier;
use App\Contrat;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifDocumentExpire;

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
        
        $contrats = Contrat::where([['a_demission', false],['user_id','<>', null]])->get();
        $today = date('Y-m-d');

        foreach ($contrats as $contrat) {
            
            $fichiers = Fichier::where([['user_id',$contrat->user_id],['date_expiration','<', $today]])->get();
            
            if(sizeof($fichiers) > 0){
            
                foreach($fichiers as $fichier){  
                 
                    if($fichier->expire == false){
                        $fichier->expire = true;
                        $fichier->update();
                    }
                }

                //    ENVOI MAIL
                if($contrat->user != null)
                Mail::to($contrat->user->email)->send(new NotifDocumentExpire($contrat->user, $fichiers));
            }
        }
      
  
        Cronjob::create([
            "nom" => "documentexpire",
            ]);
    
    }
}
