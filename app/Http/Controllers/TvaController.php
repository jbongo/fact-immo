<?php

namespace App\Http\Controllers;

use App\Tva;
use Illuminate\Http\Request;

class TvaController extends Controller
{
    /**
     * tests
     *
     * @return \Illuminate\Http\Response
     */
    public function test()
    {

        
        echo "<br>";

        $libelle = "VIR OFFICE NOTARIAL DES BARO 0260670009996 FACTURE 16368 STYLIMMO VENTE SCHNEEEBAUER / DIMIE";
        
        $tab = explode(" ",$libelle);
        echo "<pre>";
        var_dump($tab);
        echo "<pre>";
        
        $num_mandat = null;
        
        foreach ($tab as $value) {
        
        $value = (int) filter_var($value, FILTER_SANITIZE_NUMBER_INT);
        
        echo $value."<br>";
          
            
        }
        if(preg_match('([0-9]{5})', $libelle) ){
        
            echo "num facture OK";
        }else{
        
             echo "num facture NOT OK";
        }
        
        
      

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
