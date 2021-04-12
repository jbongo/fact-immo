<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facture;
use App\Factpub;

class FactpubController extends Controller
{
    
    
    
/**
 *  Liste des factures pub à valider
 *
 * @return \Illuminate\Http\Response
*/

public  function pub_a_valider()
{



    $factures = Factpub::where([['validation',0],])->get();
   
    
       return view('facture.pub.pub_a_valider', compact('factures'));
 

}



}
