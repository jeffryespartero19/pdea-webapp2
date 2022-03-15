<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\Evidence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvidenceController extends Controller
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
        // $data = Evidence::all();

        $data = DB::table('evidence as a')
            ->join('evidence_type as b', 'a.evidence_type_id', '=', 'b.id')
            ->join('unit_measurement as c', 'a.unit_measurement_id', '=', 'c.id')
            ->select('a.id', 'a.name', 'b.name as evidence_type', 'a.unit_measurement_id', 'a.status', 'c.name as unit_measurement')
            ->orderby('a.name', 'asc')->get();


        return view('evidence.evidence_list', compact('data'));
    }

    public function add()
    {
        $evidence_type = DB::table('evidence_type')
            ->orderBy('name', 'asc')
            ->get();
        $unit_measurement = DB::table('unit_measurement')->where('status', true)->orderby('name', 'asc')->get();

        return view('evidence.evidence_add', compact('evidence_type', 'unit_measurement'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:evidence'
        ]);

        $form_data = array(
            'name' => $request->name,
            'description' => $request->description,
            'evidence_type_id' => $request->evidence_type_id,
            'unit_measurement_id' => $request->unit_measurement_id,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('evidence')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Evidence Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on evidence setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new evidence!');
    }

    public function edit($id)
    {
        $evidence = DB::table('evidence')->where('id', $id)->get();
        $evidence_type = DB::table('evidence_type')
            ->orderBy('name', 'asc')
            ->get();
        $unit_measurement = DB::table('unit_measurement')
            ->orderBy('name', 'asc')
            ->get();

        return view('evidence.evidence_edit', compact('evidence', 'evidence_type', 'unit_measurement'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3'
        ]);

        $pos_data = array(
            'name' => $request->name,
            'description' => $request->description,
            'evidence_type_id' => $request->evidence_type_id,
            'unit_measurement_id' => $request->unit_measurement_id,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('evidence')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Evidence Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on evidence setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated evidence!');
    }
}
