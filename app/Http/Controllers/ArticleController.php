<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Historiquearticle;
use App\Fournisseur;
use App\Contrat;
use Illuminate\Support\Facades\Crypt;

class ArticleController extends Controller
{
    /**
     * Afficher la liste des articles du fournisseur passé en paramètre
     *
     * @return \Illuminate\Http\Response
     */
    public function index($fournisseur_id)
    {
        $articles = Article::where('fournisseur_id',Crypt::decrypt($fournisseur_id))->latest()->get();
        $fournisseur = Fournisseur::where('id', Crypt::decrypt($fournisseur_id))->first();
   
        // dd($articles);
        return view('article.index', compact('articles','fournisseur'));
    }
    
    /**
     * Afficher la liste des articles de type annonces
     *
     * @return \Illuminate\Http\Response
     */
    public function passerelles()
    {
        $articles = Article::where([['type','annonce'], ['a_expire', false]])->latest()->get();
        
        $contrats = Contrat::where([['est_fin_droit_suite', false],['user_id', '<>', null]])->get();
        // ->select('packpub_id')
    
        $annonces_consommee = 0;
        foreach ($contrats as $contrat) {
            $annonces_consommee += $contrat->packpub->qte_annonce;
        }
      
      
        
        return view('article.passerelles', compact('articles','annonces_consommee'));
    }

    /**
     * Page de création d'un article du fournisseur passé en paramètre
     *
     * @return \Illuminate\Http\Response
     */
    public function create($fournisseur_id)
    {
        $fournisseur = Fournisseur::where('id', Crypt::decrypt($fournisseur_id))->first();
       
        
        return view('article.add', compact('fournisseur'));
    }

    /**
     * Création d'un article
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        


        $request->validate([
            'libelle' => 'required',
            'type' => 'required',
            'quantite' => 'required',
            'prix_achat' => 'required',
            'coefficient' => 'required',
            'date_achat' => 'required',
           
        ]);

        // $articles = Article::where([['fournisseur_id', $request->fournisseur_id], ['a_expire', false]])->update(['a_expire' => true]);

     

        
        Article::create([
            "type"=>$request->type,
            "libelle"=>$request->libelle,
            "description"=>$request->description,
            "quantite"=>$request->quantite,
            "prix_achat"=>$request->prix_achat,
            "coefficient"=>$request->coefficient,
            "date_achat"=>$request->date_achat,
            "date_expiration"=>$request->date_expiration,
            "a_expire"=>false,
            "fournisseur_id"=>$request->fournisseur_id,
            
        ]);


      

        return redirect()->route('article.index', Crypt::encrypt($request->fournisseur_id))->with('ok', __("Nouvel article ajouté ")  );
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
     * page de Modification d'un article
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($article_id)
    {
        $article = Article::where('id', Crypt::decrypt($article_id))->first();

        return view('article.edit', compact('article'));
    }

    /**
     * Modification d'un article
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $article_id)
    {
        // dd($request->date_achat);
    
    
            $article = Article::where('id', Crypt::decrypt($article_id))->first();
            
        $modif_type =  $article->type == $request->type ? false : true;
        $modif_libelle =  $article->libelle == $request->libelle ? false : true;
        $modif_description =  $article->description == $request->description ? false : true;
        $modif_quantite =  $article->quantite == $request->quantite ? false : true;
        $modif_prix_achat =  $article->prix_achat == $request->prix_achat ? false : true;
        $modif_coefficient =  $article->coefficient == $request->coefficient ? false : true;
        $modif_date_achat =  $article->date_achat->format('Y-m-d') == $request->date_achat ? false : true;
        $modif_date_expiration =   $article->date_expiration != null ? ( $article->date_expiration->format('Y-m-d') == $request->date_expiration ? false : true) :  false;
        
        Historiquearticle::create([        
            "article_id"=>$article->id,            
            "type"=>$article->type,            
            "modif_type"=> $modif_type,            
            "libelle"=>$article->libelle,            
            "modif_libelle"=> $modif_libelle,            
            "description"=>$article->description,            
            "modif_description"=> $modif_description,            
            "quantite"=>$article->quantite,            
            "modif_quantite"=> $modif_quantite,            
            "prix_achat"=>$article->prix_achat,            
            "modif_prix_achat"=> $modif_prix_achat,            
            "coefficient"=>$article->coefficient,            
            "modif_coefficient"=> $modif_coefficient,            
            "date_achat"=>$article->date_achat,            
            "modif_date_achat"=> $modif_date_achat,            
            "date_expiration"=>$article->date_expiration,            
            "modif_date_expiration"=> $modif_date_expiration,
        ]);
        
        
        Article::where('id', Crypt::decrypt($article_id))
        ->update([
            "type"=>$request->type,
            "libelle"=>$request->libelle,
            "description"=>$request->description,
            "quantite"=>$request->quantite,
            "prix_achat"=>$request->prix_achat,
            "coefficient"=>$request->coefficient,
            "date_achat"=>$request->date_achat,
            "date_expiration"=>$request->date_expiration,
        ]);
             
                            
        return redirect()->route('article.index', Crypt::encrypt($request->fournisseur_id))->with('ok', __("article modifié ")  );
    }

    
    /**
     * Retourne l'historique des articles
     *
     * @return \Illuminate\Http\Response
     */
    public function historique($article_id)
    {
        $article = article::where('id',Crypt::decrypt($article_id))->first() ;        
        $articles = Historiquearticle::where('article_id',$article->id)->get() ;        
        
        
        return view('article.historique.index', compact('articles','article'));

    }
    
    
    /**
     * Affiche un histoque de article
     *
     * @return \Illuminate\Http\Response
     */
    public function historique_show($article_id)
    {
        $article = Historiquearticle::where('id',Crypt::decrypt($article_id))->first() ;        

        return view('article.historique.show', compact(['article']));

    }
    
    
    
}
