<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\Occupation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OccupationController extends Controller
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
        $data = Occupation::all();

        return view('occupation.occupation_list', compact('data'));
    }

    public function add()
    {
        return view('occupation.occupation_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:occupation'
        ]);

        $form_data = array(
            'name' => $request->name,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('occupation')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Occupation Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on occupation setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new occupation!');
    }

    public function edit($id)
    {
        $occupation = DB::table('occupation')->where('id', $id)->get();

        return view('occupation.occupation_edit', compact('occupation'));
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

        DB::table('occupation')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Occupation Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on occupation setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated occupation!');
    }
}
