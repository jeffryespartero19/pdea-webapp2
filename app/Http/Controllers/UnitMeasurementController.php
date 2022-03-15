<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\UnitMeasurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitMeasurementController extends Controller
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
        $data = UnitMeasurement::all();

        return view('unit_measurement.unit_measurement_list', compact('data'));
    }

    public function add()
    {
        return view('unit_measurement.unit_measurement_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:unit_measurement'
        ]);

        $form_data = array(
            'name' => $request->name,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('unit_measurement')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Unit Measurement Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on unit of measurement setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new unit of measurement!');
    }

    public function edit($id)
    {
        $unit_measurement = DB::table('unit_measurement')->where('id', $id)->get();

        return view('unit_measurement.unit_measurement_edit', compact('unit_measurement'));
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

        DB::table('unit_measurement')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Unit Measurement Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on unit of measurement setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated unit of measurement!');
    }
}
