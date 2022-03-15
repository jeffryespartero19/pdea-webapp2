<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProvinceController extends Controller
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
        $data = Province::all();

        return view('province.province_list', compact('data'));
    }

    public function add()
    {
        $region = DB::table('region')->orderby('region_sort', 'asc')->get();

        return view('province.province_add', compact('region'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'province_c' => 'required|string|min:3|unique:province',
            'province_m' => 'required|string|min:3|unique:province'
        ]);

        $form_data = array(
            'province_c' => $request->province_c,
            'province_m' => $request->province_c,
            'region_c' => $request->region_c,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('province')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Province Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on province setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new province!');
    }

    public function edit($id)
    {
        $province = DB::table('province')->where('id', $id)->get();
        $region = DB::table('region')->orderby('region_sort', 'asc')->get();

        return view('province.province_edit', compact('province', 'region'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'province_c' => 'required|string|min:3',
            'province_m' => 'required|string|min:3',
            'region_c' => 'required',
        ]);

        $pos_data = array(
            'province_c' =>  $request->province_c,
            'province_m' =>  $request->province_m,
            'region_c' =>  $request->region_c,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('province')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Province Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on province setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated province!');
    }
}
