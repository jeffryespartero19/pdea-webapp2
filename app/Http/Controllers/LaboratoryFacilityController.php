<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\LaboratoryFacility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaboratoryFacilityController extends Controller
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
        $data = LaboratoryFacility::all();

        return view('laboratory_facility.laboratory_facility_list', compact('data'));
    }

    public function add()
    {
        $region = DB::table('region')->orderby('region_sort', 'asc')->get();

        return view('laboratory_facility.laboratory_facility_add', compact('region'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:laboratory_facility'
        ]);

        $form_data = array(
            'name' => $request->name,
            'region_c' => $request->region_c,
            'province_c' => $request->province_c,
            'city_c' => $request->city_c,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('laboratory_facility')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Laboratory Facility Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on laboratory facility setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new laboratory facility!');
    }

    public function edit($id)
    {
        $laboratory_facility = DB::table('laboratory_facility')->where('id', $id)->get();
        $region = DB::table('region')->orderby('region_sort', 'asc')->get();
        $province = DB::table('province')->orderby('province_m', 'asc')->get();
        $city = DB::table('city')->orderby('city_m', 'asc')->get();

        return view('laboratory_facility.laboratory_facility_edit', compact('laboratory_facility', 'region', 'province', 'city'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3'
        ]);

        $pos_data = array(
            'name' =>  $request->name,
            'region_c' => $request->region_c,
            'province_c' => $request->province_c,
            'city_c' => $request->city_c,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('laboratory_facility')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Laboratory Facility Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on laboratory facility setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated laboratory facility!');
    }
}
