<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Outilinfo;

class OutilinfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $outils = Outilinfo::where('archive', false)->get();
        return view('outil_info.index',compact('outils'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('outil_info.add');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
    
      return  Outilinfo::create([
            "nom"=> $request->nom,
            "identifiant"=> $request->identifiant,
            "password"=> $request->password,
            "autre_champ"=> $request->autre_champ,
            "champs_valeurs"=> $request->champs,
        ]);
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
    public function edit($outil_id)
    {
        
        $outil = Outilinfo::where('id', $outil_id)->first();
        $champs = Outilinfo::champs_unserialize($outil->champs_valeurs);
     
        return view('outil_info.edit',compact('outil', 'champs') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $outil_id)
    {
        $outil = Outilinfo::where('id', $outil_id)->first();
        $outil->nom = $request->nom;
        $outil->identifiant = $request->identifiant;
        $outil->password = $request->password;
        $outil->autre_champ = $request->autre_champ;
        $outil->champs_valeurs = $request->champs;
        
        $outil->update();
        return "true";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($outil_id)
    {
        $outil = Outilinfo::where('id', $outil_id)->first();
        $outil->delete();
        
        return "true";
    }
}
