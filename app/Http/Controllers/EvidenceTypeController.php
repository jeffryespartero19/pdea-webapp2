<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\EvidenceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvidenceTypeController extends Controller
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
        $data = EvidenceType::all();

        return view('evidence_type.evidence_type_list', compact('data'));
    }

    public function add()
    {
        return view('evidence_type.evidence_type_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:evidence_type'
        ]);

        $form_data = array(
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('evidence_type')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Evidence Type Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on evidence type setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new evidence type!');
    }

    public function edit($id)
    {
        $evidence_type = DB::table('evidence_type')->where('id', $id)->get();

        return view('evidence_type.evidence_type_edit', compact('evidence_type'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3'
        ]);

        $pos_data = array(
            'name' =>  $request->name,
            'description' =>  $request->description,
            'category' => $request->category,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('evidence_type')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Evidence Type Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on evidence type setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated evidence type!');
    }
}
