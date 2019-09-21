<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class MandataireController extends Controller
{

    /**
     * Déserialiser le palier
     *
     * @return \Illuminate\Http\Response
     */
    public function palier_unserialize($param)
    {
        // on construit un tableau sans les &
        $palier = explode("&", $param);
        $array = array();
        foreach($palier as $pal)
        {
            // pour chaque element du tableau, on extrait la valeur
            $tmp = substr($pal , strpos($pal, "=") + 1, strlen($pal));
            array_push($array, $tmp);
        }
        // on divise le nouveau tableau de valeur en 4 tableau de même taille
        $chunk = array_chunk($array, 4);
        // syupprime le premier tableau de notre tableau
        // array_shift($chunk);

        return $chunk;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $mandataires = User::where('role','mandataire')->get();
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
            'statut'=>$request->statut,
            'siret'=>$request->siret,
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
        $id = Crypt::decrypt($id);
        $mandataire = User::where('id', $id)->firstOrFail();

        
        $palier_starter = ($mandataire->contrat == null) ? null : $mandataire->contrat->palier_starter ;
        $palier_expert =  ($mandataire->contrat == null) ? null : $mandataire->contrat->palier_expert ;
        
        $palier_starter = $this->palier_unserialize($palier_starter);
        $palier_expert = $this->palier_unserialize($palier_expert);
       
        return view('mandataires.show', compact(['mandataire','palier_starter','palier_expert']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    
        $id = Crypt::decrypt($id);
        $mandataire = User::where('id', $id)->firstOrFail();
        return view('mandataires.edit', compact(['mandataire']));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $mandataire)
    {
        // dd($mandataire);
        if($request->email == $mandataire->email){
            $request->validate([
                'statut' => 'required|string',
                'nom' => 'required|string|max:150',
                'prenom' => 'required|string',
            ]);
        }else{
            $request->validate([
                'statut' => 'required|string',
                'nom' => 'required|string|max:150',
                'prenom' => 'required|string',
                'email' => 'required|email|unique:users',
            ]);
        }
        
        $mandataire->civilite = $request->civilite; 
        $mandataire->nom = $request->nom; 
        $mandataire->prenom = $request->prenom; 
        $mandataire->telephone = $request->telephone; 
        $mandataire->ville = $request->ville; 
        $mandataire->code_postal = $request->code_postal; 
        $mandataire->pays = $request->pays; 
        $mandataire->statut = $request->statut; 
        $mandataire->siret = $request->siret; 
        $mandataire->email = $request->email; 
        $mandataire->adresse = $request->adresse; 
        $mandataire->complement_adresse = $request->compl_adresse; 

        $mandataire->update();
        return redirect()->route('mandataire.index')->with('ok', __('mandataire modifié')  );
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
