<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\JailFacility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JailFacilityController extends Controller
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
        $data = JailFacility::all();

        return view('jail_facility.jail_facility_list', compact('data'));
    }

    public function add()
    {
        $region = DB::table('region')->orderby('region_sort', 'asc')->get();

        return view('jail_facility.jail_facility_add', compact('region'));
    }

    public function store(Request $request)
    {
        $request->validate([    
            'name' => 'required|string|min:3|unique:jail_facility'
        ]);

        $form_data = array(
            'name' => $request->name,
            'region_c' => $request->region_c,
            'province_c' => $request->province_c,
            'city_c' => $request->city_c,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('jail_facility')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Jail Facility Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on jail facility setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new jail facility!');
    }

    public function edit($id)
    {
        $jail_facility = DB::table('jail_facility')->where('id', $id)->get();
        $region = DB::table('region')->orderby('region_sort', 'asc')->get();
        $province = DB::table('province')->orderby('province_m', 'asc')->get();
        $city = DB::table('city')->orderby('city_m', 'asc')->get();

        return view('jail_facility.jail_facility_edit', compact('jail_facility', 'region', 'province', 'city'));
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

        DB::table('jail_facility')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Jail Facility Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on jail facility setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated jail facility!');
    }
}
