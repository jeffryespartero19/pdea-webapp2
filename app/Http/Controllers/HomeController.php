<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        date_default_timezone_set('Asia/Manila');
        $now = Carbon::now();

        $total_coc = 0 + DB::table('preops_header')
            ->count();
        $pending_coc = 0 + DB::table('preops_header')
            ->where('validity', '>', $now)
            ->where('operation_datetime', '>', $now)
            ->count();
        $active_coc = 0 + DB::table('preops_header')
            ->where('validity', '>', $now)
            ->where('operation_datetime', '<', $now)
            ->count();
        $expired_coc = 0 + DB::table('preops_header')
            ->where('with_aor', 0)
            ->where('with_sr', 0)
            ->where('validity', '<', $now)
            ->count();
        $total_aor = 0 + DB::table('preops_header')
            ->where('with_aor', 1)
            ->count();
        $total_sr = 0 + DB::table('preops_header')
            ->where('with_sr', 1)
            ->count();
        $submitted_report = $total_aor + $total_sr;

        return view('home', compact('total_coc', 'pending_coc', 'active_coc', 'expired_coc', 'submitted_report'));
    }
}
