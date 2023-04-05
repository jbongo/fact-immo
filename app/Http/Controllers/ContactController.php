<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Utilisateur;
use App\Entite;
use App\Individu;
use App\EntiteIndividu;
use App\Http\Requests\ContactsValidator;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * CRUD display list entite.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role === "admin")
            $query = Entite::all();
        elseif($user->role === "commercial")
            $query = Entite::where("utilisateur_id", $user->id)->get();
        else
            abort(404);
        return view('contact.index', compact('query')); 
    }
    
    
    /**
     * Page de création d'un contact
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
        return view('contact.add'); 
    }
    
    
    
    
    
    
    /**
     * CRUD display list entite.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function index_entite()
    {
        $user = Auth::user();
        if ($user->role === "admin" || $user->role === "salarie")
            $query = Entite::all();
        else if($user->role === "commercial")
            $query = Entite::where("utilisateur_id", $user->id)->get();
        else
            abort(404);
        return view('contact.index_entite', compact('query')); 
    }

    /**
     * CRUD display list individu.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function index_individu()
    {
        $user = Auth::user();
        if ($user->role === "admin" || $user->role === "salarie")
            $query = Individu::all();
        else if($user->role === "commercial")
            $query = Individu::where("utilisateur_id", $user->id)->get();
        else
            abort(404);
        return view('contact.index_individu', compact('query')); 
    }

}
