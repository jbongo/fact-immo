<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Compromis;
use App\Contrat;
use App\Filleul;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Mail\CreationMandataire;
use Illuminate\Support\Facades\Mail;


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
      
        // dd( $password);
        
        $request->validate([
            'statut' => 'required|string',
            'nom' => 'required|string|max:150',
            'prenom' => 'required',
            'siret' => 'required|string',
            'email' => 'required|email|unique:users',
            'email_perso' => 'required|email|unique:users',
        ]);

        $user = User::create([
            'civilite' => $request->civilite,
            'nom' => $request->nom,
            'prenom'=>$request->prenom,
            'telephone1'=>$request->telephone1,
            'telephone2'=>$request->telephone2,
            'ville'=>$request->ville,
            'code_postal'=>$request->code_postal,
            'pays'=>$request->pays,
            'statut'=>$request->statut,
            'siret'=>$request->siret,
            'email'=>$request->email,
            'email_perso'=>$request->email_perso,
            'role'=>"mandataire",
            'adresse'=>$request->adresse,
            'complement_adresse'=>$request->compl_adresse,
        
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
        

        // statistiques

        $nb_affaire = Compromis::where('user_id', $id)->count();
        $nb_filleul = Filleul::where('parrain_id', $id)->count();
        $filleuls = Filleul::where('parrain_id', $id)->get();

        $parrain_id =   Filleul::where('user_id',$mandataire->id)->select('parrain_id')->first();
        $parrain = User::where('id',$parrain_id['parrain_id'])->first();

        $niveau_starter = 1;
        if($palier_starter != null){

            $palier_starter = $this->palier_unserialize($palier_starter);
            $nb_niveau_starter = sizeof($palier_starter) -1 ;
            foreach ($palier_starter as $palier) {
           
                if($mandataire->chiffre_affaire_sty >= $palier[2] && $mandataire->chiffre_affaire_sty <= $palier[3] ){
                    $niveau_starter = $palier[0];
                }elseif($mandataire->chiffre_affaire_sty > $palier_starter[ $nb_niveau_starter ][3]){
                    $niveau_starter = $palier_starter[ $nb_niveau_starter ][0];
                }
            }
        }
     

        $niveau_expert = 1;
        if($palier_expert != null){

            $palier_expert = $this->palier_unserialize($palier_expert);
            $nb_niveau_expert = sizeof($palier_expert) -1 ;
            foreach ($palier_expert as $palier) {
            
                if($mandataire->chiffre_affaire_sty >= $palier[2] && $mandataire->chiffre_affaire_sty <= $palier[3] ){
                    $niveau_expert = $palier[0];
                }elseif($mandataire->chiffre_affaire_sty > $palier_expert[ $nb_niveau_expert ][3]){
                    $niveau_expert = $palier_expert[ $nb_niveau_expert ][0];
                }
            }
        }
        return view('mandataires.show', compact(['mandataire','palier_starter','palier_expert','nb_affaire','nb_filleul','filleuls','parrain','niveau_starter','niveau_expert']));
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
        $mandataire->telephone1 = $request->telephone1; 
        $mandataire->telephone2 = $request->telephone2; 
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

    /**
     * Renvoyer les accès du mandataire.
     *
     * @param  int  $contrat_id
     * @return \Illuminate\Http\Response
     */
    public function send_access($mandataire_id,$contrat_id)
    {
        $mandataire = User::where('id',Crypt::decrypt($mandataire_id))->first();
        $contrat = Contrat::where('id',Crypt::decrypt($contrat_id))->first();

        $datedeb = date_create($contrat->date_deb_activite);
        $dateini = date_create('1899-12-30');
        $interval = date_diff($datedeb, $dateini);
        $password = "S". strtoupper (substr($mandataire->nom,0,1).substr($mandataire->nom,strlen($mandataire->nom)-1 ,1)). strtolower(substr($mandataire->prenom,0,1)).$interval->days.'@@';
       
        Mail::to($mandataire->email)->send(new CreationMandataire($mandataire,$password));

        return 1;
       

    }
}
