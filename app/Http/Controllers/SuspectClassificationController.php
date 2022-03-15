<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\SuspectClassification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuspectClassificationController extends Controller
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
        $data = SuspectClassification::all();

        return view('suspect_classification.suspect_classification_list', compact('data'));
    }

    public function add()
    {
        return view('suspect_classification.suspect_classification_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:suspect_classification'
        ]);

        $form_data = array(
            'name' => $request->name,
            'description' => $request->description,
            'reason' => $request->reason,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('suspect_classification')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Suspect Classification Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on suspect classification setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new suspect classification!');
    }

    public function edit($id)
    {
        $suspect_classification = DB::table('suspect_classification')->where('id', $id)->get();

        return view('suspect_classification.suspect_classification_edit', compact('suspect_classification'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3'
        ]);

        $pos_data = array(
            'name' =>  $request->name,
            'description' =>  $request->description,
            'reason' => $request->reason,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('suspect_classification')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Sudpect Classification Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on suspect classification setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated suspect classification!');
    }
}
