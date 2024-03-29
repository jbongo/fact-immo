<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agenda;
use App\User;
use App\Prospect;

class AgendaController extends Controller
{
    /**
     * Agenda général
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $agendas = Agenda::all()->toJson();
       
        $mandataires = User::join('contrats','users.id','=','contrats.user_id' )
        ->select('*','users.id as id','contrats.id as contrat_id')
        ->where('contrats.a_demission', false)->get();
        
        $prospects = Prospect::where([['archive',false], ['est_mandataire', false]])->get();
        
        // dd($mandataires);
        $liste_prosprects = Prospect::all();
        $liste_mandataires = User::all();
        
        
        $tab_prospects  = array();
        $tab_mandataires = array();
        
        foreach ($liste_prosprects as $value) {
        
            $tab_prospects [$value->id]["nom"] = $value->nom; 
            $tab_prospects [$value->id]["nom_prenom"] = $value->nom." ". $value->prenom; 
            $tab_prospects [$value->id]["contact"] = $value->telephone_portable; 
        }
        
        
        foreach ($liste_mandataires as $value) {
        
            $tab_mandataires[$value->id]["nom"] = $value->nom; 
            $tab_mandataires[$value->id]["nom_prenom"] = $value->nom." ". $value->prenom; 
            $tab_mandataires[$value->id]["contact"] = $value->telephone1; 
        }
        
        $tab_prospects  = json_encode($tab_prospects ) ;
        $tab_mandataires = json_encode($tab_mandataires) ;
 
        
        return view('agenda.index',compact('agendas','mandataires', 'prospects','tab_prospects','tab_mandataires'));
    }


    /**
     * Agenda général
     * en listing
     * @return \Illuminate\Http\Response
     */
    public function listing()
    {
        
        $agendas = Agenda::all();
       
        $mandataires = User::join('contrats','users.id','=','contrats.user_id' )
        ->select('*','users.id as id','contrats.id as contrat_id')
        ->where('contrats.a_demission', false)->get();
        
        $prospects = Prospect::where([['archive',false], ['est_mandataire', false]])->get();
        
        // dd($agendas);
  
        return view('agenda.listing',compact('agendas','mandataires', 'prospects'));
    }
    
      /**
     * Liste des tâches en retard
     * 
     * @return \Illuminate\Http\Response
     */
    public function listing_en_retard()
    {
        
        $agendas = Agenda::where([['est_terminee', false], ['date_deb', '<', date('Y-m-d')]])->get();

       
        $mandataires = User::join('contrats','users.id','=','contrats.user_id' )
        ->select('*','users.id as id','contrats.id as contrat_id')
        ->where('contrats.a_demission', false)->get();
        
        $prospects = Prospect::where([['archive',false], ['est_mandataire', false]])->get();
        
        // dd($agendas);
  
        return view('agenda.taches_en_retard',compact('agendas','mandataires', 'prospects'));
    }
    
      /**
     * Liste des tâches à faire
     * en listing
     * @return \Illuminate\Http\Response
     */
    public function listing_a_faire()
    {
        
        $agendas = Agenda::where([['est_terminee', false], ['date_deb', '>=', date('Y-m-d')]])->get();
       
        $mandataires = User::join('contrats','users.id','=','contrats.user_id' )
        ->select('*','users.id as id','contrats.id as contrat_id')
        ->where('contrats.a_demission', false)->get();
        
        $prospects = Prospect::where([['archive',false], ['est_mandataire', false]])->get();
        
        // dd($agendas);
  
        return view('agenda.taches_a_faire',compact('agendas','mandataires', 'prospects'));
    }

   

    /**
     *  création d'un agenda
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $agenda = Agenda::create([
        
            'titre' => $request->titre, 
            'type_rappel' => $request->type_rappel, 
            'description' => $request->description, 
            'date_deb' => $request->date_deb, 
            'date_fin' => $request->date_fin, 
            'heure_deb' => $request->heure_deb, 
            'heure_fin' => $request->heure_fin, 
            // 'est_agenda_prospect' => $request->est_agenda_prospect,            
            'est_agenda_prospect' => false,
            // 'est_agenda_mandataire' => $request->est_agenda_mandataire,            
            'est_agenda_mandataire' => false,
            // 'est_agenda_prospect' => $request->est_agenda_prospect,            
            'est_agenda_general' => true,
            'liee_a' => $request->liee_a,
            'prospect_id' => $request->prospect_id, 
            'user_id' => $request->mandataire_id1, 
        
        ]);
        
    return redirect()->back()->with('ok', 'tâche créée');
        
    }


    

    /**
     * Modification d'un agenda
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        
        
        $agenda = Agenda::where('id',$request->id)->first();
        // dd( $request->heure_fin);
        $agenda->titre =  $request->titre; 
        $agenda->type_rappel =  $request->type_rappel; 
        $agenda->description =  $request->description; 
        $agenda->date_deb =  $request->date_deb; 
        $agenda->date_fin =  $request->date_fin; 
        $agenda->heure_deb =  $request->heure_deb; 
        $agenda->heure_fin =  $request->heure_fin; 
        // $agenda->est_agenda_prospect =  $request->est_agenda_prospect;            
         $agenda->est_agenda_prospect = false;
        // $agenda->est_agenda_mandataire =  $request->est_agenda_mandataire;            
         $agenda->est_agenda_mandataire = false;
        // $agenda->est_agenda_prospect =  $request->est_agenda_prospect;            
        $agenda->est_agenda_general =  true;
        $agenda->liee_a =  $request->liee_a; 
        
        if( $request->prospect_id != "null")  $agenda->prospect_id =  $request->prospect_id;        
        if( $request->mandataire_id != "null") $agenda->user_id =  $request->mandataire_id; 
        
        $agenda->est_terminee = $request->est_terminee == "true" ? true : false;             
        
    
        $agenda->update();
   
        
        // dd($request->prospect_id2);
        return redirect()->back()->with('ok', 'tâche modifiée '.$agenda->titre);
        
    }

    /**
     * suppression d'un agenda
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($agenda_id)
    {
        //
        $agenda = Agenda::where('id', $agenda_id)->first();
        
        $agenda->delete();
        return "ok";
    }
}
