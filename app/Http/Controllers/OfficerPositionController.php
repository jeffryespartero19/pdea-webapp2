<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\OfficerPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfficerPositionController extends Controller
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
        $data = OfficerPosition::all();

        return view('officer_position.officer_position_list', compact('data'));
    }

    public function add()
    {
        return view('officer_position.officer_position_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:officer_position'
        ]);

        $form_data = array(
            'name' => $request->name,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('officer_position')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Officer Position Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on officer position setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new officer position!');
    }

    public function edit($id)
    {
        $officer_position = DB::table('officer_position')->where('id', $id)->get();

        return view('officer_position.officer_position_edit', compact('officer_position'));
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

        DB::table('officer_position')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Officer Position Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on officer position setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated officer position!');
    }
}
