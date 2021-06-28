<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $userNumber = DB::table('users')->pluck('id')->count();
        $areaNumber = DB::table('areas')->pluck('id')->count();

        return view('layouts.dashboard')
            ->with('userNumber', $userNumber)
            ->with('areaNumber',$areaNumber) ;
    }
}
