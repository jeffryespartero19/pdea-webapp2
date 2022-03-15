<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AuditController extends Controller
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

    public function index()
    {

        $data = DB::table('users')
            ->join('audits', 'users.id', '=', 'audits.user_id')
            ->select('users.photo', 'users.name', 'audits.module', 'audits.menu', 'audits.activity', 'audits.description', 'audits.created_at')
            ->orderBy('audits.created_at', 'desc')
            ->get();

        return view('users.audits', compact('data'));
    }
}
