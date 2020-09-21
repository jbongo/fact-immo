<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Compromis;
use App\Filleul;

class CloturerCompromis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:cloturercompromis';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permet de clôturer les compromis dont toutes les factures ont été réglées';

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

        $compromis = Compromis::where('archive',0)->get();

        foreach ($compromis as $compro) {
           
            $hono_porteur_regle = 1;
            $hono_partage_regle = 1;
            $hono_parrain_porteur_regle = 1;
            $hono_parrain_partage_regle = 1;



        // #### FACTURES DU PORTEUR

            // On verifié si la facture hono du porteur d'affaire est reglée
            if($compro->getHonoPorteur() != null ){

                if($compro->getHonoPorteur()->reglee == false ){
                    $hono_porteur_regle = 0;
                }

            }else{
                $hono_porteur_regle = 0;
            }

            // Si le partage d'affaire est un filleul

           if($compro->user->filleul !=null){

                 // On verifié si la facture parrainage du porteur d'affaire est reglée
                if($compro->getFactureParrainPorteur() != null ){

                    if($compro->getFactureParrainPorteur()->reglee == false ){
                        $hono_parrain_porteur_regle = 0;
                    }

                }else{
                    $hono_parrain_porteur_regle = 0;
                }

           }


        // #### FACTURES DU PARTAGE

        // On vérifie s'il y'a partage

        if($compro->parrain_partage_id != null){

             // On verifié si la facture hono du partage d'affaire est reglée
             if($compro->getHonoPartage() != null ){

                if($compro->getHonoPartage()->reglee == false ){
                    $hono_partage_regle = 0;
                }

            }else{
                $hono_partage_regle = 0;
            }

            // Si le partage d'affaire est un filleul

           if($compro->user->filleul !=null){

                 // On verifié si la facture parrainage du partage d'affaire est reglée
                if($compro->getFactureParrainPartage() != null ){

                    if($compro->getFactureParrainPartage()->reglee == false ){
                        $hono_parrain_partage_regle = 0;
                    }

                }else{
                    $hono_parrain_partage_regle = 0;
                }

           }

        }


        // On vérifie si l'affaire peut être archivée

            if($hono_porteur_regle == 1 &&  $hono_partage_regle ==1 && $hono_parrain_porteur_regle ==1 && $hono_parrain_partage_regle ==1  ){
                $compro->cloture_affaire = 2;
                $compro->update();
            }

        }
    }
}
