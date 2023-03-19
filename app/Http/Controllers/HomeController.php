<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Companies;
use Illuminate\Support\Facades\Auth;
use App\Contracts\Information;


class HomeController extends Controller implements Information
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function __construct()
    {
        $this->middleware(['auth','verified']); 
    }

    /**
     * Show the application.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $user = Auth::user();

        $infoCompanies = $this->getInfoCompanies($user);

        return view('home', compact('infoCompanies'));
    }

    /**
     *  get companies by users.
     */

    public function getInfoCompanies($user){

        return Companies::query()->where('user_id', $user->id)->get(); 

    }
}
