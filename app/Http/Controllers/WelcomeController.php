<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $duty = DB::table('users')->where('is_logged_in', 1)->get();

        $on_duty=count($duty);
      
        return view('welcome', compact('on_duty'));
    }
}
