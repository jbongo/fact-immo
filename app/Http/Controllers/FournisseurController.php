<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Fournisseur;
use Illuminate\Support\Facades\Crypt;


class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fournisseurs = Fournisseur::all();

        return view('fournisseur.index', compact('fournisseurs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fournisseur.add');
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
            'type' => 'required',
            'nom' => 'unique:fournisseurs|required',
        ]);

        Fournisseur::create([
            "type"=>$request->type,
            "nom"=>$request->nom,
            "site_web"=>$request->site_web,
            "telephone"=>$request->telephone,
            "email"=>$request->email,
            "login"=>$request->login,
            "password"=>$request->password,
        ]);

        return redirect()->route('fournisseur.index')->with('ok', __("Nouveau fournisseur ajouté ")  );
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
        $fournisseur = Fournisseur::where('id',  Crypt::decrypt($id))->first();
        return view('fournisseur.edit',compact('fournisseur'));
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
        $request->validate([
            'type' => 'required',
            'nom' => 'required',
        ]);
        $fournisseur = Fournisseur::where('id',  Crypt::decrypt($id))->first();


      
            $fournisseur->type = $request->type;
            $fournisseur->nom = $request->nom;
            $fournisseur->site_web = $request->site_web;
            $fournisseur->telephone = $request->telephone;
            $fournisseur->email = $request->email;
            $fournisseur->login = $request->login;
            $fournisseur->password = $request->n;

            $fournisseur->update();
       

        return redirect()->route('fournisseur.index')->with('ok', __("Le fournisseur $fournisseur->nom a été modifié ")  );
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
