<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\Religion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReligionsController extends Controller
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
        $data = Religion::all();

        return view('religions.religion_list', compact('data'));
    }

    public function add()
    {
        return view('religions.religion_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:religions'
        ]);

        $form_data = array(
            'name' => $request->name,
            'active' => $request->has('active') ? true : false,
        );

        DB::table('religions')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Religion Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on religion setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new religion!');
    }

    public function edit($id)
    {
        $religion = DB::table('religions')->where('id', $id)->get();

        return view('religions.religion_edit', compact('religion'));
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

        DB::table('religions')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Religion Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on religion setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated religion!');
    }
}
