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
    
 
        return view('test');



        $classmap = array('MyWSDLStructure' => 'MyComplexDataType');
        $client = new \SoapClient("https://production.protexa.fr/WSPROTEXA_WEB/awws/wsprotexa.awws?wsdl",array("trace" => 1, "exception" => 0));
           
        //   $xml = $client->wsajoutacces(
        //     "075137@dimora.fr",
        //     "Vjp57pro@",
        //     "Test jean",
        //     "support@stylimmo.com",
        //     "ATMXEH",
        //     "Agence Bagnols",
        //     4,
        //     "0769191053",
        //     "0160",
        //     true,
        //     true,
        //   );
  
  $params = new \stdClass();
  
  $params->Login_connexion = "075137@dimora.fr";
  $params->MotdePasse = "KRHGYP";
  $params->NumMandat = "10000";
//   $params->Registre = "T";
//   $params->AvecLien = 1;
//   $res = $client->__soapCall("wsd6info", array($params));
  $res = $client->__soapCall("wslistenumsuperieurs", array($params));
  echo "<pre>";
//   dd($res);
// var_dump($client->wsplistereservation("pontaud.l@stylimmo.com","SPDl44461@@", "T", 1));
file_put_contents("protexa.xml", $res->wslistenumsuperieursResult);
$xml = simplexml_load_string($res->wslistenumsuperieursResult);
dd($xml);
// echo($res->wsplistereservationResult);
  
//   var_dump($xml);


return "yes";
      
     



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
