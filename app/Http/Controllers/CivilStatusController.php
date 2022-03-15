<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\CivilStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CivilStatusController extends Controller
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
        $data = DB::table('civil_status')->get();

        return view('civil_status.civil_status_list', compact('data'));
    }

    public function add()
    {
        return view('civil_status.civil_status_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:civil_status'
        ]);

        $form_data = array(
            'name' => $request->name,
            'active' => $request->has('active') ? true : false,
        );

        DB::table('civil_status')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Civil Status',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on civil status.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new civil status!');
    }

    public function edit($id)
    {
        $civil_status = DB::table('civil_status')->where('id', $id)->get();

        return view('civil_status.civil_status_edit', compact('civil_status'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3'
        ]);

        $pos_data = array(
            'name' =>  $request->name,
            'active' => $request->has('active') ? true : false,
        );

        DB::table('civil_status')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Civil Status',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on civil status.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated civil status!');
    }
}
