<?php

namespace App\Http\Controllers;

use App\Tva;
use App\Mail\EncaissementFacture;
use App\Facture;
use App\User;
use App\Filleul;
use App\Fichier;
use App\Contrat;
// use Mail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Mail;
use App\Mail\NotifDocumentExpire;

use iio\libmergepdf\Merger;
use iio\libmergepdf\Pages;


class TvaController extends Controller
{
    /**
     * tests
     *
     * @return \Illuminate\Http\Response
     */
    public function test()
    {
    

      
        $contrats = Contrat::where([['a_demission', false],['user_id','<>', null]])->get();
        $today = date('Y-m-d');

    
        foreach ($contrats as $contrat) {
            
            $fichiers = Fichier::where([['user_id',$contrat->user_id],['date_expiration','<', $today]])->get();
            
            if(sizeof($fichiers)> 0){
                // dd($fichiers);

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


dd($fichiers);

    $filleuls = Filleul::all();
    
        foreach ($filleuls as $fill) {
            
            $expire = $fill->expire == 0 ? "": "expiré";
            
            echo " Parrain: {$fill->parrain()->nom} {$fill->parrain()->prenom} |  Filleul: {$fill->user->nom } {$fill->user->prenom} ===> $expire <br><br>";
            
        }

exit;
       
        $mandataires = User::where('role','mandataire')->orderBy('nom')->get();
        
        foreach ($mandataires as $mandataire) {
            if(($mandataire->contrat != null && $mandataire->contrat->a_demission == false && $mandataire->contrat->est_fin_droit_suite == false) ) {
            
                echo $mandataire->email.", $mandataire->email_perso,<br>";
            }
        }


dd("cc");

}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tva  $tva
     * @return \Illuminate\Http\Response
     */
    public function show(Tva $tva)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tva  $tva
     * @return \Illuminate\Http\Response
     */
    public function edit(Tva $tva)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tva  $tva
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tva $tva)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tva  $tva
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tva $tva)
    {
        //
    }
}
