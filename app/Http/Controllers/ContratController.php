<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\User;
use App\Contrat;
use Illuminate\Support\Facades\Mail;
use App\Mail\CreationMandataire;
use Illuminate\Support\Facades\Hash;




class ContratController extends Controller
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
        array_shift($chunk);

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
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($user_id)
    {
        //
        $parrains = User::where([['role','mandataire'], ['id','<>', Crypt::decrypt($user_id)]])->get();
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
      
        // parrainage
        // return "".$request->forfait_administratif;
        Contrat::create([
              // infos basiques
            "user_id" => Crypt::decrypt($request->user_id) ,
            "forfait_entree"=> $request->forfait_administratif + $request->forfait_carte_pro,
            "forfait_administratif"=>$request->forfait_administratif,
            "forfait_carte_pro"=>$request->forfait_carte_pro,
            "date_entree"=>$request->date_entree,
            "date_deb_activite"=>$request->date_debut,
            // "ca_depart"=>$request->ca_depart,
            "est_demarrage_starter"=>$request->est_starter == "on" ? true:false,
            "a_parrain"=>$request->a_parrain== "on" ? true:false,
            "parrain_id"=>$request->a_parrain== "on" ? $request->parrain_id : null,
            
            // Commission direct pack starter          
            "pourcentage_depart_starter"=>$request->pourcentage_depart_starter,
            "duree_max_starter"=>$request->duree_max_starter,
            "duree_gratuite_starter"=>$request->duree_gratuite_starter,
            "a_palier_starter"=>$request->check_palier_starter== "on" ? true:false,
            "palier_starter"=>$request->palier_starter,

            // Commission direct pack expert          
            "pourcentage_depart_expert"=>$request->pourcentage_depart_expert,
            "duree_max_starter_expert"=>$request->duree_max_starter,
            "duree_gratuite_expert"=>$request->duree_gratuite_expert,
            "a_palier_expert"=>$request->check_palier_expert== "on" ? true:false,
            "palier_expert"=>$request->palier_expert,

            "nombre_vente_min"=>$request->nombre_vente_min,
            "nombre_mini_filleul"=>$request->nombre_mini_filleul,
            "chiffre_affaire"=>$request->chiffre_affaire,
            "a_soustraitre"=>$request->a_soustraitre,

            "prime_forfaitaire"=>$request->prime_max_forfait_parrain,
            "packpub_id"=>$request->pack_pub,

        ]);
        // Génération du mot de passe
        
        $mandataire = User::where('id',Crypt::decrypt($request->user_id))->first();

        $datedeb = date_create($request->date_debut);
        $dateini = date_create('1899-12-30');
        $interval = date_diff($datedeb, $dateini);
        $password = "S". strtoupper (substr($mandataire->nom,0,1).substr($mandataire->nom,strlen($mandataire->nom)-1 ,1)). strtolower(substr($mandataire->prenom,0,1)).$interval->days.'@@';


        $mandataire->password = Hash::make($password) ;
        $mandataire->update();

        Mail::to($mandataire->email)->send(new CreationMandataire($mandataire,$password));

        return 1;
                
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
