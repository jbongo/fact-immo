<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Compromis;
use App\User;
use App\Filleul;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
    //     ############ Infos de stats ##########

    $STATS = array();
    $nb_affaires = Compromis::count();
    $nb_mandataires = User::where('role','mandataire')->count();
    $nb_filleuls = Filleul::count();


    $STATS["nb_affaires"] = $nb_affaires;
    $STATS["nb_mandataires"] = $nb_mandataires;
    $STATS["nb_filleuls"] = $nb_filleuls;

        return view('home',compact("STATS"));
    }
}
