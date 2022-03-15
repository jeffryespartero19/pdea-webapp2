<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\SuspectStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuspectStatusController extends Controller
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
        $data = SuspectStatus::all();

        return view('suspect_status.suspect_status_list', compact('data'));
    }

    public function add()
    {
        return view('suspect_status.suspect_status_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:suspect_status'
        ]);

        $form_data = array(
            'name' => $request->name,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('suspect_status')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Suspect Status Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on suspect status setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new suspect status!');
    }

    public function edit($id)
    {
        $suspect_status = DB::table('suspect_status')->where('id', $id)->get();

        return view('suspect_status.suspect_status_edit', compact('suspect_status'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3'
        ]);

        $pos_data = array(
            'name' =>  $request->name,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('suspect_status')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Suspect Status Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on suspect status setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated suspect status!');
    }
}
