<?php

namespace App\Http\Controllers;

use App\Packpub;
use App\Tva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class PackpubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packs = Packpub::all();
        return view('parametre.pack_pub.index',compact('packs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('parametre.pack_pub.add');        
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
            'nom' => 'required|unique:packpubs',
            'qte_annonce' => 'required|numeric',
            'tarif_ht' => 'required|numeric',
        ]);
        Packpub::create([
            "nom"=>$request->nom,
            "qte_annonce"=>$request->qte_annonce,
            "tarif_ht"=>$request->tarif_ht,
            "tarif"=>$request->tarif_ht * Tva::coefficient_tva(),
            "type"=>$request->type,
        ]);
        
        return  redirect()->route('pack_pub.index')->with('ok',__('Nouveau pack pub enregistré'));
        
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Packpub  $packpub
     * @return \Illuminate\Http\Response
     */
    public function edit( $packpub)
    {
        // dd($packpub);
        $pack = Packpub::where('id',Crypt::decrypt($packpub))->first();

        return view('parametre.pack_pub.edit',compact('pack')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Packpub  $packpub
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $packpub)
    {
       
        $pack = Packpub::where('id',Crypt::decrypt($packpub))->first();

        // dd($pack);
        if($request->nom == $pack->nom){
            $request->validate([
                'nom' => 'required',
                'qte_annonce' => 'required|numeric',
                'tarif_ht' => 'required|numeric',
            ]);
        }else{
            $request->validate([
                'nom' => 'required|unique:packpubs',
                'qte_annonce' => 'required|numeric',
                'tarif_ht' => 'required|numeric',
            ]);
        }
        
        $pack->nom = $request->nom;
        $pack->qte_annonce = $request->qte_annonce;
        $pack->tarif_ht = $request->tarif_ht;
        $pack->tarif = $request->tarif_ht * Tva::coefficient_tva();
        $pack->type = $request->type;
        $pack->update();
        
        return  redirect()->route('pack_pub.index')->with('ok',__('le pack pub a été modifié'));
    }

    /**
     *Archiver un pack
     *
     * @param  \App\Packpub  $packpub
     * @return \Illuminate\Http\Response
     */
    public function archiver($packpub, $action = 1)
    {
        $pack = Packpub::where('id',$packpub)->first();

        $pack->archive = $action == 1 ? true : false;
        $pack->update();
        return  redirect()->route('pack_pub.index')->with('ok',__('le pack pub a été modifié'));

    }
}
