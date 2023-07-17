<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Contrat;

class CalculCAStylMandataire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:calculcastyl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculer les CA STYL de tous les mandataires actifs';

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
    
        
        $contrats = Contrat::where([['a_demission', false], ['est_fin_droit_suite', false], ['user_id', '<>', null]])->get();
        
        foreach ($contrats as $contrat) {            
                $contrat->user->sauvegarder_chiffre_affaire_styl(date('Y') . '-01-01', date('Y-m-d'));
        }
    }
}
