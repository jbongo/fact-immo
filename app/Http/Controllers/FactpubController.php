<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facture;
use App\Factpub;
use App\Tva;
use App\Mail\EnvoyerFactPub;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Crypt;

use PDF;
use Illuminate\Support\Facades\File ;
use Illuminate\Support\Facades\Storage;


class FactpubController extends Controller
{
    
    
    
    /**
     *  Liste des factures pub à valider
     *
     * @return \Illuminate\Http\Response
    */
    
    public  function pub_a_valider()
    {
    
        $factures = Factpub::where([['validation',0]])->orderBy('id','desc')->get();
       
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
        
        if($factpub->validation == 1)
            return redirect()->route('facture.pub_a_valider')->with('ok', "Facture déjà validée");
        $factpub->validation = $validation;
        
        // Si la facture a été validé
        if($validation == 1){
           
            $numero = Facture::whereIn('type',['avoir','stylimmo','pack_pub','carte_visite','communication','autre','forfait_entree','cci'])->max('numero') + 1;
            
            $facture = Facture::create([
                "numero"=> $numero,
                "user_id"=> $factpub->user_id,
                "type"=> "pack_pub",
                "encaissee"=> false,
                "montant_ht"=>   $factpub->montant_ht,
                "montant_ttc"=>  $factpub->montant_ttc,
                "date_facture"=> date('Y-m-d'),
            
            ]);
            
            $factpub->facture_id = $facture->id;
            $factpub->update();
            
            
            return Crypt::encrypt($facture->id);
        }else{
            $factpub->update();
            
            return redirect()->route('facture.pub_a_valider');
            
        }
     
       
        
    }
    
    
    
    /**
     *  Liste des factures pub à valider
     *
     * @return \Illuminate\Http\Response
    */
    
    public  function valider_fact_pub_plusieurs(Request $request, $validation)
    {
    
    
// dd($request->list_id);
        
        
        $fact_pub_id = $request->list_id;
        
        // return $fact_pub_id;
        
        $factpubs = Factpub::whereIn('id',$fact_pub_id)->get();
        
        
        foreach ($factpubs as $factpub) {
            
             
            //  On passe à la prochaine facture si la facture à déjà été validée
             if($factpub->validation == 1)
                continue;
      
            $factpub->validation = $validation;
            
            // Si la facture a été validé
            if($validation == 1){
               
                $numero = Facture::whereIn('type',['avoir','stylimmo','pack_pub','carte_visite','communication','autre','forfait_entree','cci'])->max('numero') + 1;
                
              
                
                
                $facture = Facture::create([
                    "numero"=> $numero,
                    "user_id"=> $factpub->user_id,
                    "type"=> "pack_pub",
                    "encaissee"=> false,
                    "montant_ht"=>   $factpub->montant_ht,
                    "montant_ttc"=>  $factpub->montant_ttc,
                    "date_facture"=> date('Y-m-d'),
                
                ]);
                
                $factpub->facture_id = $facture->id;
                $factpub->update();
                
                // 
        
                $tabmois = ['','Janvier','Février','Mars','Avril', 'Mai','Juin','Juillet','Aôut', 'Septembre','Octobre','Novembre','Décembre'];
                
                if($facture->factpublist() != null){
                    $mois = $tabmois[$facture->factpublist()->created_at->format('m')*1];
                } else{
                    $mois = $tabmois[$facture->created_at->format('m')*1];
                }
                
                $this->generer_pdf_fact_pub(Crypt::encrypt($facture->id));
                
                
                // return Crypt::encrypt($facture->id);
            }else{
                $factpub->update();
                
                // return redirect()->route('facture.pub_a_valider');
            }
     
        }
        
        return "ok";
    }
    
    /**
     *  page de la facture de pub
     *
     * @return \Illuminate\Http\Response
    */
    
    public  function generer_fact_pub($facture_id)
    {
    
        $facture = Facture::where([['id',Crypt::decrypt($facture_id)],])->first();  
        
        $tabmois = ['','Janvier','Février','Mars','Avril', 'Mai','Juin','Juillet','Aôut', 'Septembre','Octobre','Novembre','Décembre'];
        
        if($facture->factpublist() != null){
            $mois = $tabmois[$facture->factpublist()->created_at->format('m')*1];
        } else{
            $mois = $tabmois[$facture->created_at->format('m')*1];
        }
        
        $this->generer_pdf_fact_pub($facture_id);
       
        return view('facture.pub.generer_facture_pub', compact(['facture','mois']));
    }
    
    
    
    /**
     *  génère le pdf de la facture de pub
     *
     * @return \Illuminate\Http\Response
    */
    
    public  function generer_pdf_fact_pub($facture_id)
    {
    
       // on sauvegarde la facture dans le repertoire du mandataire
       $path = storage_path('app/public/factures/factures_autres');
    
       if(!File::exists($path))
           File::makeDirectory($path, 0755, true);
       
           $facture = Facture::where('id', crypt::decrypt($facture_id))->first();
           
        $tabmois = ['','Janvier','Février','Mars','Avril', 'Mai','Juin','Juillet','Aôut', 'Septembre','Octobre','Novembre','Décembre'];        
        if($facture->factpublist() != null){
            $mois = $tabmois[$facture->factpublist()->created_at->format('m')*1];
        } else{
            $mois = $tabmois[$facture->created_at->format('m')*1];
        }
       
       $pdf = PDF::loadView('facture.pub.pdf_facture_pub',compact(['facture','mois']));
          

       $filename = "F".$facture->numero." ".$facture->type." ".$facture->montant_ttc."€ ".strtoupper($facture->user->nom)." ".strtoupper(substr($facture->user->prenom,0,1)).".pdf" ;
       
       
       $path = $path.'/'.$filename;
       $pdf->save($path);
       
       $facture->url = $path;
       $facture->update();
       Mail::to($facture->user->email)->send(new EnvoyerFactPub($facture));
       

    }
    
    /**
     *  telecharger facture pack pub
     *
     * @return \Illuminate\Http\Response
    */

    public  function download_pdf_facture_fact_pub($facture_id)
    {

 
        $facture = Facture::where('id', crypt::decrypt($facture_id))->first();
        
        
            $filename = "F".$facture->numero." ".$facture->type." ".$facture->montant_ttc."€ ".strtoupper($facture->user->nom)." ".strtoupper(substr($facture->user->prenom,0,1)).".pdf" ;
       
 
        
            $tabmois = ['','Janvier','Février','Mars','Avril', 'Mai','Juin','Juillet','Aôut', 'Septembre','Octobre','Novembre','Décembre'];        
            
            if($facture->factpublist() != null){
                $mois = $tabmois[$facture->factpublist()->created_at->format('m')*1];
            } else{
                $mois = $tabmois[$facture->created_at->format('m')*1];
            }
               
            
            $pdf = PDF::loadView('facture.pub.pdf_facture_pub',compact(['facture','mois']));
           
       
        // $path = storage_path('app/public/factures/'.$filename);
 
        return $pdf->download($filename);
    
    }
    
    
     
    /**
     *  Recalculer la fact pub
     *
     * @return \Illuminate\Http\Response
    */
    
    public  function recalculer_fact_pub($fact_pub_id)
    {
    
   
        $factpub = Factpub::where('id',$fact_pub_id)->first();
        
        $contrat = $factpub->user->contrat ;
        
        
                    // On determine la date à laquelle le mandataire doit passer expert
                    $date_passage_expert = strtotime($contrat->date_deb_activite->format('Y-m-d'). "+ $contrat->duree_max_starter month");
                    $date_passage_expert = date('Y-m-d', $date_passage_expert);
                    
                    $today = date_create(date('Y-m-d'));
                    $date_passage= date_create($date_passage_expert);
                    
                    // on determine le nombre de jours entre son passage à expert et aujourd'hui
                    $duree_passage_expert = date_diff($today, $date_passage);
                    
        
                   
                    $duree_starter = date_diff($today, date_create($contrat->date_deb_activite->format('Y-m-d')));
                    $duree_starter = floor($duree_starter->days / 30);
                    
                    
                    
                    if($contrat->user->pack_actuel == "expert" && ($contrat->est_demarrage_starter == false || $contrat->est_demarrage_starter == true && $duree_passage_expert->days > 28 ) ){
                        
                        
                       
                            $factpub->packpub = $contrat->packpub->nom;
                            $factpub->montant_ht = round($contrat->packpub->tarif / Tva::coefficient_tva(), 2);
                            $factpub->montant_ttc = $contrat->packpub->tarif;
                        
                     
                        
                       
                        
                    }elseif($contrat->user->pack_actuel == "starter" && $contrat->duree_gratuite_starter >= $duree_starter ){
                    
                            $factpub->packpub = $contrat->packpub->nom;
                            $factpub->montant_ht = $contrat->forfait_pack_info ;
                            $factpub->montant_ttc = $contrat->forfait_pack_info * Tva::coefficient_tva();
                      
                    
                    }
                    
                    $factpub->update();
       
                    return redirect()->route('facture.pub_a_valider');

        
    }
    

}
