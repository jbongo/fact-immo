<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Compromis;
use Auth;
use App\User;
use Illuminate\Support\Facades\Crypt;

class CompromisController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $compromis = array();
        if(Auth::user()->role =="admin") {
            $compromis = Compromis::get()->all();
        }else{
            $compromis = Compromis::where('user_id',Auth::user()->id)->get();
        }
        //  dd($compromis);
        return view ('compromis.index',compact('compromis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view ('compromis.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'numero_mandat' => 'required|unique:compromis',
        ]);
        $compromis = Compromis::create([
            "user_id"=> Auth::user()->id,
            "description_bien"=> $request->description_bien,
            "ville_bien"=> $request->ville_bien,
            "civilite_vendeur"=> $request->civilite_vendeur,
            "nom_vendeur"=> $request->nom_vendeur,
            "prenom_vendeur"=>$request->prenom_vendeur,
            "adresse1_vendeur"=>$request->adresse1_vendeur,
            "adresse2_vendeur"=>$request->adresse2_vendeur,
            "code_postal_vendeur"=>$request->code_postal_vendeur,
            "ville_vendeur"=>$request->ville_vendeur,
            "civilite_acquereur"=>$request->civilite_acquereur,
            "nom_acquereur"=>$request->nom_acquereur,
            "prenom_acquereur"=>$request->prenom_acquereur,
            "adresse1_acquereur"=>$request->adresse1_acquereur,
            "adresse2_acquereur"=>$request->adresse2_acquereur,
            "code_postal_acquereur"=>$request->code_postal_acquereur,
            "ville_acquereur"=>$request->ville_acquereur,
            "numero_mandat"=>$request->numero_mandat,
            "date_mandat"=>$request->date_mandat,
            "est_partage_agent"=>$request->partage == "Non" ? false : true,
            "nom_agent"=>$request->nom_agent,
            "pourcentage_agent"=>$request->pourcentage_agent,
            "montant_deduis_net"=>$request->montant_deduis,
            "frais_agence"=>$request->frais_agence,
            "charge"=>$request->charge,
            "net_vendeur"=>$request->net_vendeur,
            "scp_notaire"=>$request->scp_notaire,
            ]);
            


        return redirect()->route('compromis.show', ['id' => Crypt::encrypt($compromis->id)]); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $compromis = Compromis::where('id',$id)->first();
        // dd($compromis);
        return view('compromis.show', compact('compromis'));
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
     * modifier le compromis
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Compromis $compromis)
    {
        // dd($compromis);
        if($request->numero_mandat != $compromis->numero_mandat){
            $request->validate([
                'numero_mandat' => 'required|unique:compromis',
            ]);
        }

        $compromis->description_bien = $request->description_bien;
        $compromis->ville_bien = $request->ville_bien;
        $compromis->civilite_vendeur = $request->civilite_vendeur;
        $compromis->nom_vendeur = $request->nom_vendeur;
        $compromis->prenom_vendeur = $request->prenom_vendeur;
        $compromis->adresse1_vendeur = $request->adresse1_vendeur;
        $compromis->adresse2_vendeur = $request->adresse2_vendeur;
        $compromis->code_postal_vendeur = $request->code_postal_vendeur;
        $compromis->ville_vendeur = $request->ville_vendeur;
        $compromis->civilite_acquereur = $request->civilite_acquereur;
        $compromis->nom_acquereur = $request->nom_acquereur;
        $compromis->prenom_acquereur = $request->prenom_acquereur;
        $compromis->adresse1_acquereur = $request->adresse1_acquereur;
        $compromis->adresse2_acquereur = $request->adresse2_acquereur;
        $compromis->code_postal_acquereur = $request->code_postal_acquereur;
        $compromis->ville_acquereur = $request->ville_acquereur;
        $compromis->numero_mandat = $request->numero_mandat;
        $compromis->date_mandat = $request->date_mandat;
        $compromis->est_partage_agent = $request->partage == "Non" ? false : true;
        $compromis->nom_agent = $request->nom_agent;
        $compromis->pourcentage_agent = $request->pourcentage_agent;
        $compromis->montant_deduis_net = $request->montant_deduis;
        $compromis->frais_agence = $request->frais_agence;
        $compromis->charge = $request->charge;
        $compromis->net_vendeur = $request->net_vendeur;
        $compromis->scp_notaire = $request->scp_notaire;
        
        $compromis->update();
        return redirect()->route('compromis.index')->with('ok', __('compromis modifié')  );
    }

    /**
     * modifier une partie du compromis dans la demande de facture stylimmo
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_part(Request $request, Compromis $compromis)
    {
        // dd($compromis);
        if($request->numero_mandat != $compromis->numero_mandat){
            $request->validate([
                'numero_mandat' => 'required|unique:compromis',
            ]);
        }

        $compromis->description_bien = $request->description_bien;
        $compromis->ville_bien = $request->ville_bien;
        $compromis->civilite_vendeur = $request->civilite_vendeur;
        $compromis->nom_vendeur = $request->nom_vendeur;
        $compromis->prenom_vendeur = $request->prenom_vendeur;
        $compromis->adresse1_vendeur = $request->adresse1_vendeur;
        $compromis->adresse2_vendeur = $request->adresse2_vendeur;
        $compromis->code_postal_vendeur = $request->code_postal_vendeur;
        $compromis->ville_vendeur = $request->ville_vendeur;
        $compromis->civilite_acquereur = $request->civilite_acquereur;
        $compromis->nom_acquereur = $request->nom_acquereur;
        $compromis->prenom_acquereur = $request->prenom_acquereur;
        $compromis->adresse1_acquereur = $request->adresse1_acquereur;
        $compromis->adresse2_acquereur = $request->adresse2_acquereur;
        $compromis->code_postal_acquereur = $request->code_postal_acquereur;
        $compromis->ville_acquereur = $request->ville_acquereur;
        $compromis->numero_mandat = $request->numero_mandat;
        $compromis->date_mandat = $request->date_mandat;
        $compromis->est_partage_agent = $request->partage == "Non" ? false : true;
        $compromis->nom_agent = $request->nom_agent;
        $compromis->pourcentage_agent = $request->pourcentage_agent;
        $compromis->montant_deduis_net = $request->montant_deduis;
        $compromis->frais_agence = $request->frais_agence;
        $compromis->charge = $request->charge;
        $compromis->net_vendeur = $request->net_vendeur;
        $compromis->scp_notaire = $request->scp_notaire;
        
        $compromis->update();
        return redirect()->route('compromis.index')->with('ok', __('compromis modifié')  );
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
