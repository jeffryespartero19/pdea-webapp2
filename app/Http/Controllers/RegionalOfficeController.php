<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\RegionalOffice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegionalOfficeController extends Controller
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
        $data = DB::table('regional_office')->where('status', true)->orderby('print_order', 'desc')->get();

        return view('regional_office.regional_office_list', compact('data'));
    }

    public function add()
    {
        $region = DB::table('region')->where('status', true)->orderby('region_sort', 'asc')->get();

        return view('regional_office.regional_office_add', compact('region'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:regional_office'
        ]);

        $form_data = array(
            'region_c' => $request->region_c,
            'name' => $request->name,
            'ro_code' => $request->ro_code,
            'description' => $request->description,
            'report_output' => $request->description,
            'print_order' => $request->print_order,
            'address' => $request->address,
            'contact_number' => $request->contact_number,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('regional_office')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Regional Office Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on regional office setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new regional office!');
    }

    public function edit($id)
    {
        $regional_office = DB::table('regional_office')->where('id', $id)->get();
        $region = DB::table('region')->where('status', true)->orderby('region_sort', 'asc')->get();


        return view('regional_office.regional_office_edit', compact('regional_office', 'region'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3'
        ]);

        $pos_data = array(
            'region_c' => $request->region_c,
            'name' => $request->name,
            'ro_code' => $request->ro_code,
            'description' => $request->description,
            'report_output' => $request->description,
            'print_order' => $request->print_order,
            'address' => $request->address,
            'contact_number' => $request->contact_number,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('regional_office')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Regional Office Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on regional office setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated regional office!');
    }

    public function getROProvince($ro_code)
    {
        $details = DB::table('regional_office')
            ->where(['ro_code' => $ro_code])
            ->select('region_c')
            ->get();

        $data = DB::table('province')
            ->where(['region_c' => $details[0]->region_c])
            ->where('status', true)
            ->orderby('province_m', 'asc')
            ->get();

        return json_encode($data);
    }

    public function getRODetails($ro_code)
    {
        $data = DB::table('regional_office')
            ->where(['ro_code' => $ro_code])
            ->select('region_c')
            ->get();

        return json_encode($data);
    }

    public function getRORegion($ro_code)
    {
        $details = DB::table('regional_office')
            ->where(['ro_code' => $ro_code])
            ->select('region_c')
            ->get();

        $data = DB::table('region')
            ->where(['region_c' => $details[0]->region_c])
            ->where('status', true)
            ->orderby('region_m', 'asc')
            ->get();

        return json_encode($data);
    }
}
