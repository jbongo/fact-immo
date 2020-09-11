<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
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

        $articles = Article::where([['fournisseur_id', $request->fournisseur_id], ['a_expire', false]])->update(['a_expire' => true]);

     

        
        Article::create([
            "libelle"=>$request->libelle,
            "description"=>$request->description,
            "quantite"=>$request->quantite,
            "prix_achat"=>$request->prix_achat,
            "coefficient"=>$request->coefficient,
            "date_achat"=>$request->date_achat,
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
       Article::where('id', Crypt::decrypt($article_id))
                    ->update([
                        "libelle"=>$request->libelle,
                        "description"=>$request->description,
                        "quantite"=>$request->quantite,
                        "prix_achat"=>$request->prix_achat,
                        "coefficient"=>$request->coefficient,
                        "date_achat"=>$request->date_achat,
                    ]);

                            
        return redirect()->route('article.index', Crypt::encrypt($request->fournisseur_id))->with('ok', __("article modifié ")  );
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
