<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Compromis;
use App\Contrat;
use App\Filleul;
use App\Facture;
use App\Parametre;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Mail\CreationMandataire;
use Illuminate\Support\Facades\Mail;
use Auth;
use App\Historique;
use App\Updatejeton;
use Illuminate\Support\Facades\File ;



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
        $mandataires = User::where('role','mandataire')->orderBy('nom')->get();
        
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
      
        //  dd( $request);
        
        $request->validate([
            'statut' => 'required|string',
            'nom' => 'required|string|max:150',
            'prenom' => 'required',
            // 'siret' => 'string',
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
            'numero_tva'=>$request->numero_tva,
            'email'=>$request->email,
            'email_perso'=>$request->email_perso,
            'role'=>"mandataire",
            'adresse'=>$request->adresse,
            'complement_adresse'=>$request->compl_adresse,
            'code_client'=>$request->code_client,
            'numero_rsac'=>$request->numero_rsac,
        
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
        
        $parrain = $parrain_id != null ? User::where('id',$parrain_id['parrain_id'])->first() : null;
        
        // historique de connexions
        $connexions = Historique::where([['user_id', $id], ['ressource', 'connexion']])->orderBy('id','desc')->take(5)->get();
       

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
        return view('mandataires.show', compact(['mandataire','palier_starter','palier_expert','nb_affaire','nb_filleul','filleuls','parrain','niveau_starter','niveau_expert','connexions']));
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
     
     
        if(Auth::user()->role == "admin"){
        
        
        
            if($request->email == $mandataire->email){
                
                if($request->email_perso == $mandataire->email_perso){
    
                    $request->validate([
                        'statut' => 'required|string',
                        'nom' => 'required|string|max:150',
                        'prenom' => 'required|string',
                    ]);
                }
                else{
                    $request->validate([
                        'statut' => 'required|string',
                        'nom' => 'required|string|max:150',
                        'prenom' => 'required|string',
                        'email_perso' => 'required|email|unique:users',
    
                    ]);
                }
            }else{
    
                if($request->email_perso == $mandataire->email_perso){
                    $request->validate([
                        'statut' => 'required|string',
                        'nom' => 'required|string|max:150',
                        'prenom' => 'required|string',
                        'email' => 'required|email|unique:users',
                    ]);
                }
                else{
                    $request->validate([
                        'statut' => 'required|string',
                        'nom' => 'required|string|max:150',
                        'prenom' => 'required|string',
                        'email' => 'required|email|unique:users',
                        'email_perso' => 'required|email|unique:users',
                    ]);
                }
    
            }
    
            
            if($request->code_client != $mandataire->code_client){        
                $request->validate(['code_client' => 'unique:users',]);
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
            $mandataire->email = $request->email; 
            $mandataire->email_perso = $request->email_perso; 
            $mandataire->adresse = $request->adresse; 
            $mandataire->complement_adresse = $request->compl_adresse; 
            $mandataire->code_client = $request->code_client; 
      
            
           

        
            $contrat = $mandataire->contrat ;
            if($contrat != null && ( $file = $request->file('contrat_pdf')) ){
    
    
                // dd($request->file('contrat_pdf'));
    
                // $request->validate([
                //     'contrat_pdf' => 'mimes:pdf',
                // ]);
        
                    $extension = $file->getClientOriginalExtension();
                    
            
                    // on sauvegarde la facture dans le repertoire du mandataire
                    $path = storage_path('app/public/'.$contrat->id.'/contrat');
            
                    if(!File::exists($path))
                        File::makeDirectory($path, 0755, true);
            
                        $filename = 'contrat_'.$mandataire->nom.' '.$mandataire->prenom ;
             
                        $file->move($path,$filename.'.'.$extension);            
                        $path = $path.'/'.$filename.'.'.$extension;
                    
                        $contrat->contrat_pdf = $path;
                        
                        
                        $contrat->update();
        
            }
            
        }
            $mandataire->numero_tva = $request->numero_tva; 
            $mandataire->siret = $request->siret; 
            $mandataire->numero_rsac = $request->numero_rsac; 
       
        
        $mandataire->update();
        return redirect()->route('mandataire.edit', Crypt::encrypt($mandataire->id))->with('ok', __('Infos modifiées')  );
    }

    /**
     * reactiver le mandataire demissionnaire
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activer($mandataire_id)
    {
        
        $mandataire = User::where('id', $mandataire_id)->first();
        
        $contrat = $mandataire->contrat;
        
        $contrat->a_demission = false ;
        $contrat->est_fin_droit_suite = false ;
        
        
        $password = $mandataire->password;
    //    return $password;
        
        $password = str_replace('_demission','',$password);
        
        $mandataire->password = $password;
      
        
        $contrat->date_demission = null ;
        $contrat->date_fin_preavis = null ;
        $contrat->date_fin_droit_suite = null ;
        
        
        $mandataire->update();
        $contrat->update();
       return "ok";
        
        
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
       
        if(Hash::make($mandataire->password) !=Hash::make($password)){
            $mandataire->password = Hash::make($password) ;
            $mandataire->update();
        }
        Mail::to($mandataire->email)->send(new CreationMandataire($mandataire,$password));

        return 1;
       

    }

    /**
     * Switcher sur un mandataire étant admin.
     *
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function switch_user($user_id)
    {
       
        $user = User::where('id',Crypt::decrypt($user_id))->first();
        session(['is_switch'=> true]);
        session(['admin_id'=> Auth::user()->id]);

        
        Historique::create([
            "user_id"=> Auth::user()->id,
            "ressource_id"=> Crypt::decrypt($user_id),
            "ressource"=> "connexion",
            "action"=> "s'est connecté en tant que $user->nom  $user->prenom",
        ]);
        Auth::login($user);

        return redirect('home');
       

    }

    /**
     * Switcher sur un mandataire étant admin.
     *
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function unswitch_user()
    {
       
        $user = User::where('id',1)->first();
        // dd($user);
        Auth::login($user);
        session(['is_switch'=> null]);
        session(['admin_id'=> null]);
        
        return redirect('home');
    
    }




    // ###### Calculs stats test

       /**
     * stats pour un mandataire
     *
     * @param  int  $mandataire_id
     * @return \Illuminate\Http\Response
     */
    public function stats_user($mandataire_id)
    { 
        // Dans cette partie on détermine le jour exaxt de il y'a 12 mois
        $today = date("Y-m-d");//  aujourd'hui 
        $date = strtotime( date("Y-m-d", strtotime($today)) . " -1 year");    // aujourd'hui  - 1 ans   

        $date_12 = date("Y-m-d",$date);

        $mandataire = User::where('id', $mandataire_id)->first();
        

    //   on réccupère toutes les factures honoraires, partage,  valide du mandataire et dont la date est superieur aux 12 derniers mois
        $fact_directs = Facture::where([['user_id',$mandataire_id],['date_facture','>=',$date_12],['statut','valide']])->whereIn('type',['honoraire','partage'])->get();
        // dd($fact_directs);
        $ca_direct = 0 ;
        foreach ($fact_directs as $fact) {
            $ca_direct += $fact->montant_ht ;
        }

        $ca_indirect = 0;
     //   on réccupère toutes les factures parrainage valide du mandataire et dont la date est superieur aux 12 derniers mois
    $fact_indirects = Facture::where([['user_id',$mandataire_id],['date_facture','>=',$date_12],['statut','valide']])->whereIn('type',['parrainage','parrainage-partage'])->get();
     // dd($fact_indirects);
     foreach ($fact_indirects as $fact) {
         $ca_indirect += $fact->montant_ht ;
     }

    //  On réccupère les ventes des 12 derniers mois
    $vente_12 = Compromis::where([['user_id',$mandataire_id],['demande_facture',2]])->count();

    // On réccupère le nombre de filleul du mandataire
    $nb_filleul = Filleul::where('parrain_id',$mandataire_id)->count();




    //   ############ Chiffre d'affaire global / mois sur année civile  n et n-1 ##########
    
     // on determine les anneés n et n-1
    $annee_n = date('Y');
    $annee_n_1 = $annee_n-1;


    $CA_N = array();
        $ca_global_N = array();
        $ca_attente_N = array();
        $ca_encaisse_N = array();
        $ca_previsionel_N = array();
    $CA_N_1 = array();

    for ($i=1; $i <= 12 ; $i++) { 
        //   Sur l'année N
               
        $i < 10 ? $month = "0$i" : $month = $i;
       
        $ca_glo_n = Compromis::where([['date_vente','like',"%$annee_n-$month%"],['demande_facture','<=',2]])->sum('frais_agence');
        $ca_global_N [] = $ca_glo_n;


        $compros_styls = Compromis::where([['date_vente','like',"%$annee_n-$month%"],['demande_facture',2]])->get();
        // dd($compros_styls);


        #####ca non encaissé, en attente de payement
        // on parcour les facture stylimmo non encaissée pour réccupérer les montant_ht  
        $ca_att_n = 0;
        if($compros_styls != null){
            foreach ($compros_styls as $compros_styl) {
                if($compros_styl->getFactureStylimmo()->encaissee == 0){
                    $ca_att_n +=  $compros_styl->frais_agence ;
                }
            }
        }
        $ca_attente_N [] = $ca_att_n;

        #####ca encaissé
        // on parcour les facture stylimmo  encaissée pour réccupérer les montant_ht  
        $ca_encai_n = 0;
        if($compros_styls != null){
            foreach ($compros_styls as $compros_styl) {
                if($compros_styl->getFactureStylimmo()->encaissee == 1){
                    $ca_encai_n +=  $compros_styl->frais_agence ;
                }
            }
        }

// 
    

        // $ca_encai_n = Facture::where([['type','stylimmo'],['date_facture','like',"%$annee_n-$month%"],["encaissee",1]])->sum('montant_ht');
        $ca_encaisse_N [] = $ca_encai_n;
        
        $ca_previ_n = Compromis::where([['date_vente','like',"%$annee_n-$month%"],['demande_facture','<',2]])->sum('frais_agence');
        $ca_previsionel_N [] = $ca_previ_n;
    }
// dd($ca_global_N);

    $CA_N[] = $ca_global_N; 
    $CA_N[] = $ca_attente_N; 
    $CA_N[] = $ca_encaisse_N; 
    $CA_N[] = $ca_previsionel_N; 
    
    // dd($CA_N);
    // $a_date = "2011-02";  
    // dd (date("Y-m-t", strtotime($a_date)));
    // dd(date("Y"));

   
        $parrains = User::where([['role','mandataire']])->get();
 

        return view('calculs_stats',compact('mandataire','ca_direct','ca_indirect','vente_12','nb_filleul','parrains'));
    }
    

    public function store_parrain(Request $request, $mandataire_id){
        

        $nb_filleul = Filleul::where([ ['parrain_id',$request->parrain_id]])->count();
        $parrain = User::where('id',$request->parrain_id)->first();
      
        // on détermine le nombre d'année depuis la date de début d'activité du parrain dans le but de determiner le cycle dans le quel nous somme
        $nb_annee = intval( (strtotime(date('Y-m-d')) - strtotime($parrain->contrat->date_deb_activite->format('Y-m-d'))) / (86400 *365) ) ;
        $cycle_actuel = intval($nb_annee / 3 ) + 1;
      
    
     
        $date_deb_parrain = $parrain->contrat->date_deb_activite;

        if($nb_filleul > 0){

            // On détermine le rang du filleul dans le cycle


            $rang_filleuls = Filleul::where([['parrain_id',$request->parrain_id],['cycle',$cycle_actuel] ])->select('rang')->get()->toArray();
            $rangs = array();

            foreach ($rang_filleuls as $rang_fill) {
                $rangs[] = $rang_fill["rang"];
            }

            $rang = max($rangs)+1;

          
        }else{

            $rang = 1;
            $cycle_actuel = 1;
        }
        $parametre = Parametre::first();
        $comm_parrain = unserialize($parametre->comm_parrain) ;

        $r = $rang > 3 ? "n" : $rang ;
        $pourcentage = $comm_parrain["p_1_".$r];

        // dd($pourcentage);
        // dd($cycle_actuel);
        Filleul::create([
            "user_id" => Crypt::decrypt($request->user_id),
            "parrain_id" =>  $request->parrain_id,
            "rang"=> $rang,
            "cycle"=> $cycle_actuel,
            "pourcentage"=> $pourcentage,
            "expire" => false
        ]);

        
    }


    /**
     *Affiche l'historique des jetons cosmmés pour chaque mandataire
     *
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function historique_jeton($user_id)
    {
       
        $mandataire = User::where('id', Crypt::decrypt($user_id))->first();
       
        $factures = Facture::where([['user_id', Crypt::decrypt($user_id)], ['nb_mois_deduis', '>', 0]])->get();
        $total_deduis = Facture::where([['user_id', Crypt::decrypt($user_id)], ['nb_mois_deduis', '>', 0]])->sum('nb_mois_deduis');
        
        $total_restant = $mandataire->nb_mois_pub_restant;
        
        $updatejetons = Updatejeton::where('user_id', Crypt::decrypt($user_id))->get();
        
        return view('mandataires.historique_jeton',compact('factures','mandataire','total_deduis','total_restant','updatejetons'));
    
    }
    
    
    /**
     *Affiche la liste des mandataires et leurs jetons
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function mandataires_jetons()
    {
       
        $contrats = Contrat::where([['deduis_jeton', true],['user_id','<>', null]])->get();
       
       
        return view('mandataires.jetons',compact('contrats'));
    
    }


    /**
     * Modifier le nombre de jeton du mandataire
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function update_jetons(Request $request, $user_id)
    {
       
        $mandataire = User::where('id', Crypt::decrypt($user_id))->first();
        
        
        Updatejeton::create([
        
            "user_id" => Crypt::decrypt($user_id),
            "admin_id" => Auth::user()->id,
            "jetons_deduis" => $request->jetons,
            "jetons_avant_deduction" => $mandataire->nb_mois_pub_restant
        ]);
        
        
        $mandataire->nb_mois_pub_restant += $request->jetons;
        

        $mandataire->update();
        
   
       
        return redirect()->route('mandataire.historique_jeton',$user_id )->with('ok', 'Le nombre de jetons du mandataire a été modifié');
       
     
    
    }

    

    /**
     *Affiche l'historique des factures pub pour chaqsue mandataire
     *
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function historique_facture_pub($user_id)
    {
       
        $mandataire = User::where('id', Crypt::decrypt($user_id))->first();
       
        $factures = Facture::where([['user_id', Crypt::decrypt($user_id)], ['type', 'pack_pub']])->orderBy('encaissee', 'ASC')->get();
        
        $montant_du =  Facture::where([['user_id', Crypt::decrypt($user_id)], ['type', 'pack_pub'], ['encaissee', false]])->sum('montant_ttc');
        
      
        
        return view('mandataires.historique_facture_pub',compact('factures','mandataire','montant_du'));
    
    }
    
    
    /**
     *Affiche la liste des mandataires et leurs factures pub
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function mandataires_facture_pub()
    {
       
        $contrats = Contrat::where([['est_fin_droit_suite', false],['deduis_jeton', false],['user_id','<>', null]])->get();      
       
        return view('mandataires.facture_pub',compact('contrats'));
    
    }

    
}
