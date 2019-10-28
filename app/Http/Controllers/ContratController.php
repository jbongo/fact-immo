<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\User;
use App\Packpub;
use App\Contrat;
use App\Filleul;
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
        $modele = Contrat::where('est_modele',true)->first();

        $packs_pub = Packpub::all();
        return view ('contrat.add', compact(['parrains','user_id','packs_pub','modele']));
    }

    /**
     * Creation du model de contrat.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($contrat_id)
    {
        //
        $contrat = Contrat::where('id',Crypt::decrypt($contrat_id))->first() ;         
        $packs_pub = Packpub::all();
        $parrains = User::where([['role','mandataire'], ['id','<>', $contrat->user->id]])->get();

        
        $palier_starter =  $contrat != null ?  $this->palier_unserialize($contrat->palier_starter) : null;
        $palier_expert =  $contrat != null ? $this->palier_unserialize($contrat->palier_expert) : null;

        return view ('contrat.edit', compact(['packs_pub','parrains','contrat','palier_starter','palier_expert']));
  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $contrat_id)
    {
        $contrat = Contrat::where('id',Crypt::decrypt($contrat_id))->first() ;               

        // infos basiques
        $contrat->forfait_entree = $request->forfait_administratif + $request->forfait_carte_pro;
        $contrat->forfait_administratif = $request->forfait_administratif;
        $contrat->forfait_carte_pro = $request->forfait_carte_pro;
        $contrat->date_entree = $request->date_entree;
        $contrat->date_deb_activite = $request->date_debut;
        $contrat->ca_depart = $request->ca_depart;
        
        $contrat->est_demarrage_starter = $request->est_starter == "true" ? true : false;
        
        // Commission direct pack starter          
        $contrat->pourcentage_depart_starter = $request->pourcentage_depart_starter;
        $contrat->duree_max_starter = $request->duree_max_starter;
        $contrat->duree_gratuite_starter = $request->duree_gratuite_starter;
        $contrat->a_palier_starter = $request->check_palier_starter == "true" ? true : false;
        $contrat->palier_starter = $request->palier_starter;

        // Commission direct pack expert          
        $contrat->pourcentage_depart_expert = $request->pourcentage_depart_expert;
        $contrat->duree_max_starter_expert = $request->duree_max_starter;
        $contrat->duree_gratuite_expert = $request->duree_gratuite_expert;
        $contrat->a_palier_expert = $request->check_palier_expert == "true" ? true : false;
        $contrat->palier_expert = $request->palier_expert;
        $contrat->nombre_vente_min = $request->nombre_vente_min;
        $contrat->nombre_mini_filleul = $request->nombre_mini_filleul;
        $contrat->chiffre_affaire_mini = $request->chiffre_affaire;
        $contrat->a_soustraitre = $request->a_soustraitre;

        $contrat->prime_forfaitaire = $request->prime_max_forfait_parrain;
        $contrat->packpub_id = $request->pack_pub;  
   
        $contrat->update();
        return 1;
                
    }




     /**
     * utilisation du model de contrat.
     *
     * @return \Illuminate\Http\Response
     */
    public function model_create($user_id)
    {
        //
        $packs_pub = Packpub::all();
        $modele = Contrat::where('est_modele',true)->first();
        $palier_starter =  $modele != null ?  $this->palier_unserialize($modele->palier_starter) : null;
        $palier_expert =  $modele != null ? $this->palier_unserialize($modele->palier_expert) : null;
        $parrains = User::where([['role','mandataire'], ['id','<>', Crypt::decrypt($user_id)]])->get();

        $user_id =$user_id;
        if($modele == null){
            return view ('contrat.add', compact(['parrains','user_id','packs_pub','modele']));
        }else{
            return view ('contrat.model_add', compact(['packs_pub','modele','palier_starter','palier_expert','user_id','parrains']));
        }
    }

    /**
     * Creation du model de contrat.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_model_contrat()
    {
        //
        $packs_pub = Packpub::all();
        $modele = Contrat::where('est_modele',true)->first();
        $palier_starter =  $modele != null ?  $this->palier_unserialize($modele->palier_starter) : null;
        $palier_expert =  $modele != null ? $this->palier_unserialize($modele->palier_expert) : null;
        if($modele == null){
            return view ('parametre.modele_contrat.add', compact(['packs_pub']));
        }else{
            return view ('parametre.modele_contrat.edit', compact(['packs_pub','modele','palier_starter','palier_expert']));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
        // return $request->est_starter == "true" ? 1 : 0;
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
            "ca_depart"=>$request->ca_depart,

            "est_demarrage_starter"=>  $request->est_starter == "true" ? true : false,
            "a_parrain"=>$request->a_parrain == "true" ? true : false,
            "parrain_id"=>$request->a_parrain== "true" ? $request->parrain_id : null,
            
            // Commission direct pack starter          
            "pourcentage_depart_starter"=>$request->pourcentage_depart_starter,
            "duree_max_starter"=>$request->duree_max_starter,
            "duree_gratuite_starter"=>$request->duree_gratuite_starter,
            "a_palier_starter"=>$request->check_palier_starter == "true" ? true : false,
            "palier_starter"=>$request->palier_starter,

            // Commission direct pack expert          
            "pourcentage_depart_expert"=>$request->pourcentage_depart_expert,
            "duree_max_starter_expert"=>$request->duree_max_expert,
            "duree_gratuite_expert"=>$request->duree_gratuite_expert,
            "a_palier_expert"=>$request->check_palier_expert == "true" ? true : false,
            "palier_expert"=>$request->palier_expert,

            "nombre_vente_min"=>$request->nombre_vente_min,
            "nombre_mini_filleul"=>$request->nombre_mini_filleul,
            "chiffre_affaire_mini"=>$request->chiffre_affaire,
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
        $mandataire->chiffre_affaire = $request->ca_depart;
        $mandataire->commission = $request->est_starter == "true" ? $request->pourcentage_depart_starter : $request->pourcentage_depart_expert ;
        $mandataire->pack_actuel = $request->est_starter == "true" ? "starter" : "expert" ;
        $mandataire->update();
        
        
        // Ajout du parrain

        if($request->a_parrain == "true" ){
            $nb_filleul = Filleul::where([ ['parrain_id',$request->parrain_id]])->count();
    
            if($nb_filleul > 0){
                $rang_filleuls = Filleul::where([['parrain_id',$request->parrain_id] ])->select('rang')->get()->toArray();
                $rangs = array();

                foreach ($rang_filleuls as $rang_fill) {
                    $rangs[] = $rang_fill["rang"];
                }

                $rang = max($rangs)+1;
            }else{
                $rang = 1;
            }
                
            Filleul::create([
                "user_id" => Crypt::decrypt($request->user_id),
                "parrain_id" =>  $request->parrain_id,
                "rang"=> $rang,
                "expire" => false
            ]);

        }

        Mail::to($mandataire->email)->send(new CreationMandataire($mandataire,$password));

        return 1;
                
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_model_contrat(Request $request)
    {
      
        // return $request->est_starter == "true" ? 1 : 0;
        // parrainage
        // return "".$request->forfait_administratif;
        Contrat::create([
              // infos basiques
            "forfait_entree"=> $request->forfait_administratif + $request->forfait_carte_pro,
            "forfait_administratif"=>$request->forfait_administratif,
            "forfait_carte_pro"=>$request->forfait_carte_pro,
            "date_entree"=>$request->date_entree,
            "date_deb_activite"=>$request->date_debut,
            "ca_depart"=>$request->ca_depart,

            "est_demarrage_starter"=>  $request->est_starter == "true" ? true : false,
           
            
            // Commission direct pack starter          
            "pourcentage_depart_starter"=>$request->pourcentage_depart_starter,
            "duree_max_starter"=>$request->duree_max_starter,
            "duree_gratuite_starter"=>$request->duree_gratuite_starter,
            "a_palier_starter"=>$request->check_palier_starter == "true" ? true : false,
            "palier_starter"=>$request->palier_starter,

            // Commission direct pack expert          
            "pourcentage_depart_expert"=>$request->pourcentage_depart_expert,
            "duree_max_starter_expert"=>$request->duree_max_starter,
            "duree_gratuite_expert"=>$request->duree_gratuite_expert,
            "a_palier_expert"=>$request->check_palier_expert == "true" ? true : false,
            "palier_expert"=>$request->palier_expert,

            "nombre_vente_min"=>$request->nombre_vente_min,
            "nombre_mini_filleul"=>$request->nombre_mini_filleul,
            "chiffre_affaire_mini"=>$request->chiffre_affaire,
            "a_soustraitre"=>$request->a_soustraitre,

            "prime_forfaitaire"=>$request->prime_max_forfait_parrain,
            "packpub_id"=>$request->pack_pub,

            "est_modele"=>true,

        ]);     

        return 1;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_model_contrat(Request $request)
    {
      
        $modele = Contrat::where('est_modele',true)->first();

        // infos basiques
        $modele->forfait_entree = $request->forfait_administratif + $request->forfait_carte_pro;
        $modele->forfait_administratif = $request->forfait_administratif;
        $modele->forfait_carte_pro = $request->forfait_carte_pro;
        $modele->date_entree = $request->date_entree;
        $modele->date_deb_activite = $request->date_debut;
        $modele->ca_depart = $request->ca_depart;
        
        $modele->est_demarrage_starter = $request->est_starter == "true" ? true : false;
        
        // Commission direct pack starter          
        $modele->pourcentage_depart_starter = $request->pourcentage_depart_starter;
        $modele->duree_max_starter = $request->duree_max_starter;
        $modele->duree_gratuite_starter = $request->duree_gratuite_starter;
        $modele->a_palier_starter = $request->check_palier_starter == "true" ? true : false;
        $modele->palier_starter = $request->palier_starter;

        // Commission direct pack expert          
        $modele->pourcentage_depart_expert = $request->pourcentage_depart_expert;
        $modele->duree_max_starter_expert = $request->duree_max_starter;
        $modele->duree_gratuite_expert = $request->duree_gratuite_expert;
        $modele->a_palier_expert = $request->check_palier_expert == "true" ? true : false;
        $modele->palier_expert = $request->palier_expert;
        $modele->nombre_vente_min = $request->nombre_vente_min;
        $modele->nombre_mini_filleul = $request->nombre_mini_filleul;
        $modele->chiffre_affaire_mini = $request->chiffre_affaire;
        $modele->a_soustraitre = $request->a_soustraitre;

        $modele->prime_forfaitaire = $request->prime_max_forfait_parrain;
        $modele->packpub_id = $request->pack_pub;  
   
        $modele->update();
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
