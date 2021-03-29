<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Historiquearticle;
use App\Fournisseur;
use Illuminate\Support\Facades\Crypt;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($fournisseur_id)
    {
        $articles = Article::where('fournisseur_id',Crypt::decrypt($fournisseur_id))->get();
        $fournisseur = Fournisseur::where('id', Crypt::decrypt($fournisseur_id))->first();
   
        // dd($articles);
        return view('article.index', compact('articles','fournisseur'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($fournisseur_id)
    {
        $fournisseur = Fournisseur::where('id', Crypt::decrypt($fournisseur_id))->first();
       
        
        return view('article.add', compact('fournisseur'));
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
            'libelle' => 'required',
            'quantite' => 'required',
            'prix_achat' => 'required',
            'coefficient' => 'required',
            'date_achat' => 'required',
           
        ]);

        // $articles = Article::where([['fournisseur_id', $request->fournisseur_id], ['a_expire', false]])->update(['a_expire' => true]);

     

        
        Article::create([
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
     * Show the form for editing the specified resource.
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $article_id)
    {
        // dd($request->date_achat);
    
    
            $article = Article::where('id', Crypt::decrypt($article_id))->first();
            
        $modif_libelle =  $article->libelle == $request->libelle ? false : true;
        $modif_description =  $article->description == $request->description ? false : true;
        $modif_quantite =  $article->quantite == $request->quantite ? false : true;
        $modif_prix_achat =  $article->prix_achat == $request->prix_achat ? false : true;
        $modif_coefficient =  $article->coefficient == $request->coefficient ? false : true;
        $modif_date_achat =  $article->date_achat->format('Y-m-d') == $request->date_achat ? false : true;
        $modif_date_expiration =   $article->date_expiration != null ? ( $article->date_expiration->format('Y-m-d') == $request->date_expiration ? false : true) :  false;
        
        Historiquearticle::create([        
            "article_id"=>$article->id,            
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
    
      
    
    
//   dd($parrain);
        return view('article.historique.show', compact(['article']));

    }
    
    
    
}
