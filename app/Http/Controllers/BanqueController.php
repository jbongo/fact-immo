<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BanqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Traitement des factures reçus en banque (marquer comme encaissées)
     *
     * @return \Illuminate\Http\Response
     */
    public function traiter_encaissement()
    {
        $datas = $this->lecture_fichier_banque();
        
        
        
        dd($datas);
        
    }

    /**
     * Lecture du fichier csv envoyé par la banque
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function lecture_fichier_banque()
    {
       
        $datas = array();
        
        
        $url_fichier = public_path('banque\banque.csv');
    
        if( ($handle = fopen($url_fichier, 'r')) !== false ) {
            $row = 1;
            while(($data = fgetcsv($handle,1000,';')) !== false){
            
                $data_assoc = array();
                
                $data_assoc["date"] = $data[0];
                $data_assoc["date_valeur"] = $data[1];
                $data_assoc["montant"] = $data[2];
                $data_assoc["libelle"] = $data[3];
                $data_assoc["numero_facture"] = $this->filtrer_numero_facture($data[3]);
                
                
                $datas[] = $data_assoc;
                
                // echo"<pre>";
                // print_r($data_assoc);
            
            }
            
           
        }
        
        
        
        dd($datas);
        
        fclose($handle);
        
        return $datas;
            
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function filtrer_numero_facture($libelle)
    {
        
        $numero = null ;
        
        // On decoupe le libelle en tableau de mots
        $tab = explode(" ",$libelle);
               
        foreach ($tab as $value) {
        
            $value = (int) filter_var($value, FILTER_SANITIZE_NUMBER_INT);
            
            if($value > 16000 && $value < 99000){
                $numero = $value;
            }
        }
        return $numero;
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
