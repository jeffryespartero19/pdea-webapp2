<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\EthnicGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EthnicGroupController extends Controller
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
        $data = EthnicGroup::all();

        return view('ethnic_group.ethnic_group_list', compact('data'));
    }

    public function add()
    {
        return view('ethnic_group.ethnic_group_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:ethnic_group'
        ]);

        $form_data = array(
            'name' => $request->name,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('ethnic_group')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Ethnic Group Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on ethnic group setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new ethnic group!');
    }

    public function edit($id)
    {
        $ethnic_group = DB::table('ethnic_group')->where('id', $id)->get();

        return view('ethnic_group.ethnic_group_edit', compact('ethnic_group'));
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

        DB::table('ethnic_group')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Ethnic Group Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on ethnic group setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated ethnic group!');
    }
}
