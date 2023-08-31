<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Historique;
use App\User;

use DB;

class HistoriqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $historiques = Historique::where('ressource','<>','connexion')->latest()->get();
// dd($historiques);
        return view('historique.index', compact('historiques'));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function connexions()
    {
       
        
        $latestConnections = DB::table('historiques')
        ->select('user_id', DB::raw('MAX(created_at) as last_connection '))
        ->groupBy('user_id')
        ->where('ressource', 'connexion')
        ->orderBy('last_connection', 'desc')
        ->get();
    
    

   
        $historiques = [];
        foreach ($latestConnections as $connection) {
            $user = User::find($connection->user_id); 
        
      
            if ($user) {
                $hist = [
                    "user" => $user,
                    "last_connexion" => $connection->last_connection
                ];
                // $user->last_connection = $connection->last_connection;
                $historiques[] = $hist;
            }
        }
        
    // dd($historiques[0]);




        return view('historique.connexions', compact('historiques'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
