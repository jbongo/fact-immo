<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Commission;

class CommissionController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $commissions = Commission::all();
        return view ('mandataires.index',compact('commissions'));
    }

}
