<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\User;
use App\Contrat;
class ContratController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($user_id)
    {
        //
        $parrains = User::where('role','mandataire')->get();
        return view ('contrat.add', compact(['parrains','user_id']));
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
        
        Contrat::create([
            "forfait_entree"=>$request->forfait_entree,
            "est_demarrage_starter"=>$request->est_starter == "on" ? true:false,
            "a_parrain"=>$request->a_parrain== "on" ? true:false,
            "parrain_id"=>$request->a_parrain== "on" ? $request->parrain_id : null,
            "date_entree"=>$request->date_entree,
            "date_deb_activite"=>$request->date_debut,

            "type_plan"=>$request->type_plan,
            "pourcentage_depart"=>$request->pourcentage_depart,
            "duree_max_starter"=>$request->duree_max_starter,
            "duree_gratuite"=>$request->duree_gratuite,

            "nombre_vente_min"=>$request->nombre_vente_min,
            "nombre_mini_filleul"=>$request->nombre_mini_filleul,
            "chiffre_affaire"=>$request->chiffre_affaire,
            "a_soustraitre"=>$request->a_soustraitre,


            "prime_forfaitaire"=>$request->prime_forfaitaire,
            "tarif_mensuel"=>$request->tarif_mensuel,
            "nombre_annonce"=>$request->nombre_annonce,
            "prime_forfaitaire"=>$request->prime_forfaitaire,
        ]);

        return  json_encode( $request);
                
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
