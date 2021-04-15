<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facture;
use App\Factpub;
use App\Tva;
use Illuminate\Support\Facades\Crypt;


class FactpubController extends Controller
{
    
    
    
    /**
     *  Liste des factures pub à valider
     *
     * @return \Illuminate\Http\Response
    */
    
    public  function pub_a_valider()
    {
    
        $factures = Factpub::where([['validation',0]])->get();
       
        return view('facture.pub.pub_a_valider', compact('factures'));
    }
    
    
    /**
     *  Liste des factures pub à valider
     *
     * @return \Illuminate\Http\Response
    */
    
    public  function valider_fact_pub($fact_pub_id, $validation)
    {
    
   
        $factpub = Factpub::where('id',$fact_pub_id)->first();
  
        $factpub->validation = $validation;
        
        $montant_ttc = $factpub->user->contrat->packpub->tarif;
        $montant_ht = round($montant_ttc / Tva::coefficient_tva(), 2);
        $numero = Facture::whereIn('type',['avoir','stylimmo','pack_pub','carte_visite','communication','autre'])->max('numero') + 1;
        
        $facture = Facture::create([
            "numero"=> $numero,
            "user_id"=> $factpub->user_id,
            "type"=> "pack_pub",
            "encaissee"=> false,
            "montant_ht"=>  $montant_ht,
            "montant_ttc"=> $montant_ttc,
            "date_facture"=> date('Y-m-d'),
        
        ]);
        
           
        
        
        $factpub->update();
        
        return Crypt::encrypt($facture->id);
       
        
    }
    
    
    /**
     *  page de la facture de pub
     *
     * @return \Illuminate\Http\Response
    */
    
    public  function generer_fact_pub($facture_id)
    {
    
        $facture = Facture::where([['id',Crypt::decrypt($facture_id)],])->first();
       
        return view('facture.pub.generer_facture_pub', compact('facture'));
    }
    
    
    
    /**
     *  génère le pdf de la facture de pub
     *
     * @return \Illuminate\Http\Response
    */
    
    public  function generer_pdf_fact_pub($facture_id)
    {
    
        $facture = Facture::where([['id',Crypt::decrypt($facture_id)],])->first();
       
        return view('facture.pub.generer_facture_pub', compact('facture'));
    }
    
    
    /**
     *  génère le pdf de la facture de pub
     *
     * @return \Illuminate\Http\Response
    */
    
    public  function telecharger_pdf_fact_pub($facture_id)
    {
    
        $facture = Facture::where([['id',Crypt::decrypt($facture_id)],])->first();
       
        return view('facture.pub.generer_facture_pub', compact('facture'));
    }
    

}
