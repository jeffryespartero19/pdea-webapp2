<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegionController extends Controller
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
        $data = Region::all();

        return view('region.region_list', compact('data'));
    }

    public function add()
    {
        return view('region.region_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'region_c' => 'required|string|unique:region',
            'region_m' => 'required|string|unique:region',
            'abbreviation' => 'required|string|unique:region'
        ]);

        $form_data = array(
            'region_c' => $request->region_c,
            'region_m' => $request->region_m,
            'abbreviation' => $request->abbreviation,
            'region_sort' => $request->region_sort,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('region')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Region Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on region setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new region!');
    }

    public function edit($id)
    {
        $region = DB::table('region')->where('id', $id)->get();

        return view('region.region_edit', compact('region'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'region_c' => 'required|string',
            'region_m' => 'required|string',
            'abbreviation' => 'required|string',
        ]);

        $pos_data = array(
            'region_c' =>  $request->region_c,
            'region_m' =>  $request->region_m,
            'abbreviation' => $request->abbreviation,
            'region_sort' => $request->region_sort,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('region')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Region Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on region setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated region!');
    }
}
