<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
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
        $data = City::all();

        return view('city.city_list', compact('data'));
    }

    public function add()
    {
        $province = DB::table('province')->orderby('province_m', 'asc')->get();

        return view('city.city_add', compact('province'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'city_c' => 'required|string|min:3|unique:city',
            'city_m' => 'required|string|min:3|unique:city'
        ]);

        $form_data = array(
            'city_c' => $request->city_c,
            'city_m' => $request->city_c,
            'province_c' => $request->province_c,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('city')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'City Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on city setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new city!');
    }

    public function edit($id)
    {
        $city = DB::table('city')->where('id', $id)->get();
        $province = DB::table('province')->orderby('province_m', 'asc')->get();

        return view('city.city_edit', compact('city', 'province'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'city_c' => 'required|string|min:3',
            'city_m' => 'required|string|min:3',
            'province_c' => 'required',
        ]);

        $pos_data = array(
            'city_c' =>  $request->city_c,
            'city_m' =>  $request->city_m,
            'province_c' =>  $request->province_c,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('city')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'City Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on city setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated city!');
    }
}
