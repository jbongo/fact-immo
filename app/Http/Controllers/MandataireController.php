<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class MandataireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $mandataires = User::all();
        return view ('mandataires.index',compact('mandataires'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view ('mandataires.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'statut' => 'required|string',
            'nom' => 'required|string|max:150',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:users',
        ]);

        $user = User::create([
            'civilite' => $request->civilite,
            'nom' => $request->nom,
            'prenom'=>$request->prenom,
            'telephone'=>$request->telephone,
            'ville'=>$request->ville,
            'code_postal'=>$request->code_postal,
            'pays'=>$request->pays,
            'statut'=>$request->statut,
            'email'=>$request->email,
            'email'=>$request->email,
            'role'=>"mandataire",
            'adresse'=>$request->adresse,
            'complement_adresse'=>$request->compl_adresse,
            'password' => Hash::make(\str_random(8))
        ]);

         return redirect()->route('contrat.create', ['user_id'=>Crypt::encrypt($user->id)]);

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
