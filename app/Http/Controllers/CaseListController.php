<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\CaseList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CaseListController extends Controller
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
        $data = CaseList::all();

        return view('case_list.case_list', compact('data'));
    }

    public function add()
    {
        return view('case_list.case_list_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|min:3|unique:case_list'
        ]);

        $form_data = array(
            'description' => $request->description,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('case_list')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Case List Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on case list setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new case list!');
    }

    public function edit($id)
    {
        $case_list = DB::table('case_list')->where('id', $id)->get();

        return view('case_list.case_list_edit', compact('case_list'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'required|string|min:3'
        ]);

        $pos_data = array(
            'description' =>  $request->description,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('case_list')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Case List Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on case list setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated case list!');
    }
}
