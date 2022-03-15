<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\LocalOperatingUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocalLocalOperatingUnitController extends Controller
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
        $data = LocalOperatingUnit::all();

        return view('local_operating_unit.local_operating_unit_list', compact('data'));
    }

    public function add()
    {
        $region = DB::table('region')->orderby('region_sort', 'asc')->get();
        $operating_unit = DB::table('operating_unit')->orderby('name', 'asc')->get();

        return view('local_operating_unit.local_operating_unit_add', compact('region', 'operating_unit'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:local_operating_unit',
            'region_c' => 'required',
        ]);

        $form_data = array(
            'name' => $request->name,
            'operating_unit_id' => $request->operating_unit_id,
            'region_c' => $request->region_c,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('local_operating_unit')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Operating Unit Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on local operating unit setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new local operating unit!');
    }

    public function edit($id)
    {
        $local_operating_unit = DB::table('local_operating_unit')->where('id', $id)->get();
        $region = DB::table('region')->orderby('region_sort', 'asc')->get();
        $province = DB::table('province')->orderby('province_m', 'asc')->get();
        $city = DB::table('city')->orderby('city_m', 'asc')->get();

        return view('local_operating_unit.local_operating_unit_edit', compact('local_operating_unit', 'region', 'province', 'city'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'region_c' => 'required',
        ]);

        $pos_data = array(
            'name' => $request->name,
            'description' => $request->description,
            'region_c' => $request->region_c,
            'province_c' => $request->province_c,
            'city_c' => $request->city_c,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('local_operating_unit')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Operating Unit Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on local operating unit setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated local operating unit!');
    }
}
