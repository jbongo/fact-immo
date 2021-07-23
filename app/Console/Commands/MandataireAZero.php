<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Contrat;
use App\Mail\NotifMandataireAZero;
use Illuminate\Support\Facades\Mail;
use App\Cronjob;

class MandataireAZero extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:mandataireazero';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A chaque anniversaire du mandataire, on reinitialise sa commission et on notifie par mail';

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

$contrats = Contrat::where([["user_id", '<>',null],["user_id", '>',4]])->get();


$today = date("Y-m-d") ;

        foreach ($contrats as $contrat) {

            // $date_anniversaire = $contrat->date_anniversaire->format("Y-m-d");

            // On va determiner la dernière date d'anniv de sa date d'anniversaire
            // $m_d_entree = $contrat->date_anniversaire->format('m-d');

            // $y_en_cour = date('Y');

        
            // if($today > $y_en_cour.'-'.$m_d_entree  ){
            //     $date_deb = $y_en_cour.'-'.$m_d_entree ;
                
            // }else{
            //     $date_deb =  ($y_en_cour-1).'-'.$m_d_entree ;
    
            // }

              // date_12 est la date exacte 1 ans avant today
            $date_12 =  strtotime( $today. " -1 year"); 
            $date_12 = date('Y-m-d',$date_12);
            $date_12_fr = date('d/m/Y',strtotime($date_12));




                $mandataire = $contrat->user;

                $nb_min_vente = $mandataire->nombre_vente($date_12, $today) ;
                $nb_min_filleul =  $mandataire->nombre_filleul($date_12, $today);

    
                $chiffre_affaire = $mandataire->chiffre_affaire($date_12, $today)  ;


                // Si on atteint la date d'anniv
                if($contrat->date_deb_activite->format('m-d') ==  date("m-d")){

                    $ancienne_comm= $mandataire->commission ;

                    // Si les conditions de mise à zero sont activées
                    if($contrat->a_condition_expert == true){

                        // Si toutes les conditions sont respectées 
                        if( $nb_min_vente >= $contrat->nombre_vente_min && $nb_min_filleul >=  $contrat->nombre_mini_filleul && $chiffre_affaire >= $contrat->chiffre_affaire_mini){
                            
                            $mandataire->commission = $contrat->pourcentage_depart_expert; 

                        }
                        else{

                            $mandataire->commission = $contrat->pourcentage_depart_expert - $contrat->a_soustraire; 

                        }

                    }else{

                        $mandataire->commission = $contrat->pourcentage_depart_expert; 
                    }

                    $date_deb_activite = $contrat->date_deb_activite;
                    $nouvelle_comm = $mandataire->commission ;
                    $date_deb= $date_12_fr;
                    $date_fin= date("d/m/Y") ;
                    $nb_vente= $nb_min_vente;
                    $nb_filleul= $nb_min_filleul;
                    
                    $mandataire->update();

                    

                    // Envoir de mail
                    Mail::to($mandataire->email)->send(new NotifMandataireAZero($mandataire, $date_deb_activite, $ancienne_comm, $nouvelle_comm, $date_deb, $date_fin, $chiffre_affaire, $nb_vente, $nb_filleul));
                    // Mail::to("gestion@stylimmo.com")->send(new NotifMandataireAZero($mandataire, $date_deb_activite, $ancienne_comm, $nouvelle_comm, $date_deb, $date_fin, $chiffre_affaire, $nb_vente, $nb_filleul));

                    //
                    echo "\nyes" ;
                }

// echo $contrat->date_deb_activite ." \n";

            }



            Cronjob::create([
                "nom" => "mandataireazero",
                ]);
    }
}
