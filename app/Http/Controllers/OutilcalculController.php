<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class OutilcalculController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = User::where([['role','mandataire']])->orderBy("nom")->get();
        return view('outil_calcul', compact('users'));
    }


    /**
     * Calcul du chiffre d'affre du mandataire
     *
     * @return \Illuminate\Http\Response
     */
    public function ca(Request $request )
    {

        $user  = User::where('id', $request->user_id)->first();
        
        $ca =  $user->chiffre_affaire($request->date_deb, $request->date_fin);
        $ca_assoc =  $user->chiffre_affaire_styl_associe($request->date_deb, $request->date_fin);

        return array($ca,$ca_assoc);
    }



 /**
     * Calcul du chiffre d'affre du mandataire
     *
     * @return \Illuminate\Http\Response
     */
    public function ca_styl(Request $request )
    {

        $user  = User::where('id', $request->user_id)->first();


        return $user->chiffre_affaire_styl($request->date_deb, $request->date_fin);
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
