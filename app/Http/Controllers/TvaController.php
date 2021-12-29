<?php

namespace App\Http\Controllers;

use App\Tva;
use App\Mail\EncaissementFacture;
use App\Facture;
use App\User;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
    
       
        $fact_jeton = Facture::where('nb_mois_deduis', '<>', null)->get();
        
             
        foreach ($fact_jeton as $fact) {
            
            $fact->montant_ttc_deduis = $fact->nb_mois_deduis * $fact->user->contrat->packpub->tarif  ;
            $fact->date_deduction = $fact->created_at ;
            
            echo "<br>".  $fact->user->contrat->packpub->tarif; 
            
            $fact->update();
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
