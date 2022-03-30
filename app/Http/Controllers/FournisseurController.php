<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Fournisseur;
use App\Contratfournisseur;
use App\Facture;
use Illuminate\Support\Facades\Crypt;
use PDF;
use Illuminate\Support\Facades\File ;
use Illuminate\Support\Facades\Storage;

class FournisseurController extends Controller
{
    /**
     * Affiche les fournisseurs 
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
        $fournisseurs_passerelles = Fournisseur::where([['type', "passerelle"], ['archive', false]])->get();
        $fournisseurs_autres = Fournisseur::where([['type', "autre"], ['archive', false]])->get();

        return view('fournisseur.index', compact('fournisseurs_passerelles','fournisseurs_autres'));
    }

    /**
     * Afficher le formulaire de création d'un fournisseur
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fournisseur.add');
    }

    /**
     * Sauvegarde d'un fournisseur
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
            "telephone1"=>$request->telephone1,
            "telephone2"=>$request->telephone2,
            "email"=>$request->email,
            "login"=>$request->login,
            "password"=>$request->password,
        ]);

        return redirect()->route('fournisseur.index')->with('ok', __("Nouveau fournisseur ajouté ")  );
    }

    /**
     * Afficher le 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fournisseur = Fournisseur::where('id',  Crypt::decrypt($id))->first();
        
        $agendas = array(); 
        return view('fournisseur.show',compact('fournisseur', 'agendas'));
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
            $fournisseur->telephone1 = $request->telephone1;
            $fournisseur->telephone2 = $request->telephone2;
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
    public function archiver($id)
    {
        //
    }
    
    
    
    // ###### FACTURE FOURNISSEUR ##########
    
    
    
     /**
     * Afficher le formulaire de création d'un fournisseur
     *
     * @return \Illuminate\Http\Response
     */
    public function create_facture($fournisseur_id)
    {
        $fournisseur = Fournisseur::where('id', Crypt::decrypt($fournisseur_id))->first();
        $fournisseurs = Fournisseur::where([['id' ,'<>', Crypt::decrypt($fournisseur_id)], ['archive',false]])->get();
        return view('fournisseur.facture.add', compact('fournisseurs', 'fournisseur'));
    }

    /**
     * Sauvegarde de facture fournisseur
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_facture(Request $request)
    {
        $request->validate([
            'numero' => 'required',
            'montant_ht' => 'required',
            'montant_ttc' => 'required',
            "facture_pdf" => "required|mimes:pdf|max:5000",
            
        ]);
        

        $fournisseur = Fournisseur::where('id', $request->fournisseur_id)->first();
        
        $facture = Facture::create([
            "numero"=> $request->numero,
            "fournisseur_id"=> $request->fournisseur_id,
            "type"=> "fournisseur",
            "montant_ht"=>   round($request->montant_ht,2),
            "montant_ttc"=> round($request->montant_ttc,2),
            "date_facture"=> $request->date_facture,            
            "destinataire"=> $request->destinataire,
            "description_produit"=> $request->description_produit,
        ]);
        
        
        
        if($file = $request->file('facture_pdf')){

            $name = $file->getClientOriginalName();
    
            // on sauvegarde la facture dans le repertoire fournisseur
            $path = storage_path('app/public/fournisseurs/factures');
    
            if(!File::exists($path))
                File::makeDirectory($path, 0755, true);
                
                $nom =  str_replace(['/', '\\', '<','>',':','|','?','*','#'],"-",$fournisseur->nom) ;
           
    
                $filename = strtoupper($nom)." F".$facture->numero." ".$request->montant_ht."€ $facture->id";
     
                $file->move($path,$filename.'.pdf');            
                $path = $path.'/'.$filename.'.pdf';
            
                $facture->url = $path;                            
                $facture->update();
        }
        
        
        
        return redirect()->route('fournisseur.show', Crypt::encrypt($fournisseur->id))->with('ok', __("Facture ajoutée pour le fournisseur ")  );
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_facture($facturefournisseur_id)
    {
        $facture = Facture::where('id',  Crypt::decrypt($facturefournisseur_id))->first();
        $fournisseur = Fournisseur::where('id', Crypt::decrypt($facturefournisseur_id))->first();
        $fournisseurs = Fournisseur::where([['id' ,'<>', Crypt::decrypt($facturefournisseur_id)], ['archive',false]])->get();
        
        return view('fournisseur.facture.edit',compact('facture','fournisseur','fournisseurs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_facture(Request $request, $facturefournisseur_id)
    {
        $request->validate([
            'numero' => 'required',
            'montant_ht' => 'required',
            'montant_ttc' => 'required',
        ]);

        $facture = Facture::where('id',  Crypt::decrypt($facturefournisseur_id))->first();
 
        $facture->numero = $request->numero;
        $facture->fournisseur_id = $request->fournisseur_id;
        
        $facture->montant_ht =   round($request->montant_ht,2);
        $facture->montant_ttc = round($request->montant_ttc,2);
        $facture->date_facture = $request->date_facture;            
        $facture->destinataire = $request->destinataire;
        $facture->description_produit = $request->description_produit;
  
    
        $facture->update();
       
        return redirect()->route('fournisseur.show', Crypt::encrypt($request->fournisseur_id))->with('ok', __("Facture modifiée ")  );

    }
}
