<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\Barangay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangayController extends Controller
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
        $data = DB::table('barangay as a')
            ->leftjoin('city as b', 'a.city_c', '=', 'b.city_c')
            ->select(
                'a.id',
                'a.barangay_c',
                'a.barangay_m',
                'a.status',
                'b.city_m',
                'b.city_c',

            )
            ->orderby('a.id', 'asc')
            ->paginate(20);

        return view('barangay.barangay_list', compact('data'));
    }

    public function add()
    {
        $region = DB::table('region')->orderby('region_m', 'asc')->get();

        return view('barangay.barangay_add', compact('region'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barangay_c' => 'required|string|min:3|unique:barangay',
            'barangay_m' => 'required|string|min:3|unique:barangay'
        ]);

        $form_data = array(
            'barangay_c' => $request->barangay_c,
            'barangay_m' => $request->barangay_m,
            'city_c' => $request->city_c,
            'status' => $request->has('status') ? true : false,
            'uacs' => 0,
        );

        DB::table('barangay')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Barangay Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on barangay setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new barangay!');
    }

    public function edit($id)
    {
        $barangay = DB::table('barangay as a')
            ->leftjoin('city as b', 'a.city_c', '=', 'b.city_c')
            ->leftjoin('province as c', 'b.province_c', '=', 'c.province_c')
            ->leftjoin('region as d', 'c.region_c', '=', 'd.region_c')
            ->select(
                'a.id',
                'a.barangay_c',
                'a.barangay_m',
                'a.status',
                'b.city_m',
                'c.province_m',
                'b.city_c',
                'c.province_c',
                'c.region_c',

            )
            ->where('a.id', $id)->get();
        $region = DB::table('region')->orderby('region_m', 'asc')->get();

        return view('barangay.barangay_edit', compact('barangay', 'region'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'barangay_c' => 'required|string|min:3',
            'barangay_m' => 'required|string|min:3',
            'city_c' => 'required',
        ]);

        $pos_data = array(
            'barangay_c' =>  $request->barangay_c,
            'barangay_m' =>  $request->barangay_m,
            'city_c' =>  $request->city_c,
            'status' => $request->has('status') ? true : false,
            'uacs' => 0,
        );

        DB::table('barangay')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Barangay Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on barangay setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated barangay!');
    }

    public function search_barangay_list(Request $request)
    {
        $param = $request->get('param');

        $data = DB::table('barangay as a')
            ->leftjoin('city as b', 'a.city_c', '=', 'b.city_c')
            ->select(
                'a.id',
                'a.barangay_c',
                'a.barangay_m',
                'a.status',
                'b.city_m',
                'b.city_c',
            )
            ->where('a.barangay_m', 'LIKE', '%' . $param . '%')
            ->orWhere('a.barangay_c', 'LIKE', '%' . $param . '%')
            ->orderby('a.id', 'asc')
            ->paginate(20);

        return view('barangay.barangay_list_data', compact('data'))->render();
    }
}
