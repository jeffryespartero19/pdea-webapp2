<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\GroupAffiliation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupAffiliationController extends Controller
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
        $data = GroupAffiliation::all();

        return view('group_affiliation.group_affiliation_list', compact('data'));
    }

    public function add()
    {
        return view('group_affiliation.group_affiliation_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:group_affiliation'
        ]);

        $form_data = array(
            'name' => $request->name,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('group_affiliation')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'GroupAffiliation Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on group affiliation setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new group affiliation!');
    }

    public function edit($id)
    {
        $group_affiliation = DB::table('group_affiliation')->where('id', $id)->get();

        return view('group_affiliation.group_affiliation_edit', compact('group_affiliation'));
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

        DB::table('group_affiliation')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'GroupAffiliation Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on group affiliation setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated group affiliation!');
    }
}
