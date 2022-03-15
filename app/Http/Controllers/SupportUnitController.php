<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\SupportUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupportUnitController extends Controller
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
        $data = SupportUnit::all();

        return view('support_unit.support_unit_list', compact('data'));
    }

    public function add()
    {
        return view('support_unit.support_unit_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:support_unit'
        ]);

        $form_data = array(
            'name' => $request->name,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('support_unit')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Support Unit Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on support unit setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new support unit!');
    }

    public function edit($id)
    {
        $support_unit = DB::table('support_unit')->where('id', $id)->get();

        return view('support_unit.support_unit_edit', compact('support_unit'));
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

        DB::table('support_unit')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Support Unit Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on support unit setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated support unit!');
    }
}
