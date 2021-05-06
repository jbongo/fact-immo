<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Prospect;
use Illuminate\Support\Facades\Crypt;

class ProspectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prospects = Prospect::where('archive', false)->get();
        
        return view('prospect.index', compact('prospects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('prospect.add');
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
            "nom" => "required|string",
            "prenom" => "required|string",
            "civilite" => "required|string",
            "email" => "required|email|unique:prospects"
        ]);
        
        
        Prospect::create([
            "nom" => $request->nom,
            "nom_usage" => $request->nom_usage,
            "prenom" => $request->prenom,
            "civilite" => $request->civilite,
            "adresse" => $request->adresse,
            "code_postal" => $request->code_postal,
            "ville" => $request->ville,
            "telephone_fixe" => $request->telephone_fixe,
            "telephone_personnel" => $request->telephone_personnel,
            "email" => $request->email,
        ]);
        
        return  redirect()->route('prospect.index')->with('ok','prospect crée');
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $prospect = Prospect::where('id', Crypt::decrypt($id))->first();
        
        return view('prospect.show', compact('prospect'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $prospect = Prospect::where('id', Crypt::decrypt($id))->first();
        
        return view('prospect.edit', compact('prospect'));
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
        $prospect = Prospect::where('id', Crypt::decrypt($id))->first();
        
        $request->validate([
            "nom" => "required|string",
            "prenom" => "required|string",
            "civilite" => "required|string",
            "email" => "required|email"
        ]);
        
        
 
        $prospect->nom = $request->nom;
        $prospect->nom_usage = $request->nom_usage;
        $prospect->prenom = $request->prenom;
        $prospect->civilite = $request->civilite;
        $prospect->adresse = $request->adresse;
        $prospect->code_postal = $request->code_postal;
        $prospect->ville = $request->ville;
        $prospect->telephone_fixe = $request->telephone_fixe;
        $prospect->telephone_personnel = $request->telephone_personnel;
        $prospect->email = $request->email;
        
        $prospect->update();
        return redirect()->route('prospect.index')->with('ok','prospect modifié');

        
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
    
    
    
    /**
     * Archiver les prospects
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function archiver($id)
    {
        $prospect = Prospect::where('id', Crypt::decrypt($id))->first();
        
        $prostect->archive = true;
        $propstec->update();
        
        return $prospect;
    }
    
    /**
     * Consulter les archives
     *
     * @return \Illuminate\Http\Response
     */
    public function archives()
    {
        $prospects = Prospect::where('archive', true)->get();
        
        return view('prospect.archive', compact('prospects'));
    }
}
