<?php

namespace App\Http\Controllers;
use App\Offre;
use Auth;
use App\User;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Http\Request;
class OffreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //
        // $offres = Offre::all();
        $offres = array();
        if(Auth::user()->role =="admin") {
            $offres = Offre::get()->all();
        }else{
            $offres = Offre::where('user_id',Auth::user()->id)->get();
        }
        //  dd($offres);
        return view ('offres.index',compact('offres'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view ('offres.add');
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
        $offres = Offre::create([
            "user_id"=> Auth::user()->id,
            "type_offre" => $request->type_offre,
            "designation"=> $request->designation,
            "civilite_vendeur"=> $request->civilite_vendeur,
            "nom_vendeur"=> $request->nom_vendeur,
            "prenom_vendeur"=>$request->prenom_vendeur,
            "adresse1_vendeur"=>$request->adresse1_vendeur,
            "adresse2_vendeur"=>$request->adresse2_vendeur,
            "code_postal_vendeur"=>$request->codepostal_vendeur,
            "ville_vendeur"=>$request->ville_vendeur,
            "civilite_acquereur"=>$request->civilite_acquereur,
            "nom_acquereur"=>$request->nom_acquereur,
            "prenom_acquereur"=>$request->prenom_acquereur,
            "adresse1_acquereur"=>$request->adresse1_acquereur,
            "adresse2_acquereur"=>$request->adresse2_acquereur,
            "code_postal_acquereur"=>$request->codepostal2_acquereur,
            "ville_acquereur"=>$request->ville2_acquereur,
            "numero_mandat"=>$request->numero_mandat,
            "date_mandat"=>$request->date_mandat,
            "est_partage_agent"=>$request->partage == "Non" ? false : true,
            "nom_agent"=>$request->nom_agent,
            "pourcentage_agent"=>$request->pourcentage,
            "montant_deduis_net"=>$request->montant_deduis,
            "charge"=>$request->charge,
            "net_vendeur"=>$request->net_vendeur,
            "scp_notaire"=>$request->scp_notaire,
            "date_vente"=>$request->date_vente,
            ]);
            


        return redirect()->route('offre.show', ['id' => Crypt::encrypt($offres->id)]); 
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
        $offre = Offre::where('id',$id)->first();
        // dd($offre);
        return view('offres.show', compact('offre'));
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
