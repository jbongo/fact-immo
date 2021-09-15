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
        ->select('*','contrats.id as contrat_id')
        ->where('contrats.a_demission', false)->get();
        
        $prospects = Prospect::where([['archive',false], ['est_mandataire', false]])->get();
        
        // dd($prospects);
  
        return view('agenda.index',compact('agendas','mandataires', 'prospects'));
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
            'prospect_id' => $request->prospect_id, 
            'mandataire_id' => $request->mandataire_id, 
        
        ]);
        
    return redirect()->back()->with('ok', 'tâche créee');
        
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
        
        $agenda->titre =  $request->titre; 
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
        $agenda->prospect_id =  $request->prospect_id; 
        $agenda->mandataire_id =  $request->mandataire_id; 
        
        $agenda->update();
        
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
        
        return "ok";
        $agenda->delete();
    }
}
