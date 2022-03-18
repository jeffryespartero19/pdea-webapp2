<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\IssuanceOfPreops;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\PreopsArea;
use App\PreopsTarget;
use App\PreopsTeam;
use Illuminate\Support\Carbon;
use PDF;


class IssuanceOfPreopsController extends Controller
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
        $data = DB::table('preops_header as a')
            ->join('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
            ->join('operation_type as c', 'a.operation_type_id', '=', 'c.id')
            ->select('a.id', 'a.preops_number', 'a.operation_datetime', 'b.name as operating_unit', 'c.name as operation_type', 'a.status')
            ->orderby('preops_number', 'asc')
            ->get();
        $region = DB::table('region')->orderby('region_sort', 'asc')->get();
        $operating_unit = DB::table('operating_unit')->where('status', true)->orderby('name', 'asc')->get();
        $operation_type = DB::table('operation_type')->where('status', true)->where('operation_classification_id', 2)->orderby('name', 'asc')->get();
        $regional_office = DB::table('regional_office')->orderby('print_order', 'asc')->get();

        return view('issuance_of_preops.issuance_of_preops_list', compact('data', 'region', 'operating_unit', 'operation_type', 'regional_office'));

        // return view('issuance_of_preops.issuance_of_preops_list');
    }

    public function add()
    {

        $region = DB::table('region')->where('status', true)->orderby('region_sort', 'asc')->get();
        $province = DB::table('province')->where('status', true)->orderby('province_c', 'asc')->get();
        $operating_unit = DB::table('operating_unit')->where('status', true)->orderby('name', 'asc')->get();
        $operation_type = DB::table('operation_type')->where('operation_classification_id', 2)->where('status', true)->orderby('name', 'asc')->get();
        $nationality = DB::table('nationality')->where('status', true)->orderby('name', 'asc')->get();
        $support_unit = DB::table('support_unit')->where('status', true)->orderby('name', 'asc')->get();
        $regional_office = DB::table('regional_office')->orderby('print_order', 'asc')->get();
        $regional_user = DB::table('users')->where('user_level_id', 3)->get();
        $roc_regional_office = DB::table('regional_office')->where('id', Auth::user()->regional_office_id)->get();
        $roc_regional_officer = DB::table('users')->where('regional_office_id', Auth::user()->regional_office_id)->get();
        $regional_province = DB::table('province')->where('region_c', $roc_regional_office[0]->region_c)->where('status', true)->orderby('province_m', 'asc')->get();

        date_default_timezone_set('Asia/Manila');
        $date = Carbon::now()->format('mdY');

        $preops_id = 0 + DB::table('preops_header')
            ->where('ro_code', $roc_regional_office[0]->ro_code)
            ->whereDate('coordinated_datetime', Carbon::now()->format('Y-m-d'))
            ->count();
        $preops_id += 1;
        $preops_id = sprintf("%03s", $preops_id);

        return view('issuance_of_preops.issuance_of_preops_add', compact('region', 'province', 'operating_unit', 'operation_type', 'nationality', 'support_unit', 'regional_office', 'regional_user', 'roc_regional_office', 'date', 'preops_id', 'roc_regional_officer', 'regional_province'));
    }

    public function store(Request $request)
    {

        // dd($request->all());
        $data = $request->all();
        date_default_timezone_set('Asia/Manila');
        $date = Carbon::now();

        $request->validate([
            'preops_number' => 'required|unique:preops_header',
        ]);

        $form_data = array(
            'preops_number' => $request->preops_number,
            'ro_code' => $request->ro_code,
            'province_c' => $request->hprovince_c,
            'operating_unit_id' => $request->operating_unit_id,
            'operation_type_id' => $request->operation_type_id,
            // 'support_unit_id' => $request->support_unit_id,
            'coordinated_datetime' => $request->coordinated_datetime,
            'duration' => $request->duration,
            'operation_datetime' => $request->operation_datetime,
            'validity' => $request->validity,
            'remarks' => $request->remarks,
            'reference_number' => $request->reference_number,
            'prepared_by' => $request->prepared_by,
            'approved_by' => $request->approved_by,
            'status' => true,
            'created_at' => $date,
        );

        $preops_id = DB::table('preops_header')->insertGetId($form_data);

        if ($request->hasfile('fileattach')) {
            foreach ($request->file('fileattach') as $file) {
                $filename = $file->getClientOriginalName();
                // $filename = pathinfo($fileinfo, PATHINFO_FILENAME);
                $filePath = public_path() . '/files/uploads/issuance_of_preops/';
                $file->move($filePath, $filename);

                $file_data = array(
                    'preops_number' => $request->preops_number,
                    'filenames' => $filename,
                );
                $file_id = DB::table('issuance_of_preops_files')->insertGetId($file_data);

                $file_upload = array(
                    'preops_file_id' => $file_id,
                    'filename' => $filename,
                    'transaction_type' => 1,
                    'created_at' => $date,
                );

                DB::table('file_upload_list')->insert($file_upload);
            }
        }

        // Add Support Unit
        $ops_su_data = [];

        if (!empty($data['support_unit_id'])) {
            DB::table('preops_support_unit')->where('preops_number', $request->preops_number)->delete();

            for ($i = 0; $i < count($data['support_unit_id']); $i++) {
                if ($data['support_unit_id'][$i] != NULL) {

                    $ops_su_data = [
                        'preops_number' => $request->preops_number,
                        'support_unit_id' => $data['support_unit_id'][$i],
                    ];

                    DB::table('preops_support_unit')->insert($ops_su_data);
                }
            }
        }



        // Add Areas
        $ops_area_data = [];

        for ($i = 0; $i < count($data['area']); $i++) {
            if ($data['area'][$i] != NULL) {
                $id = 0 + DB::table('preops_area')->max('id');
                $id += 1;

                $ops_area_data = [
                    'area' => $data['area'][$i],
                    'preops_number' => $request->preops_number,
                    'region_c' => $data['area_region_c'][$i],
                    'province_c' => $data['province_c'][$i],
                    'city_c' => $data['city_c'][$i],
                    'barangay_c' => $data['barangay_c'][$i],
                    'ops_status' => true,
                ];

                DB::table('preops_area')->updateOrInsert(['id' => $id], $ops_area_data);
            }
        }

        // Add Targets
        $ops_target_data = [];

        for ($i = 0; $i < count($data['target_name']); $i++) {
            if ($data['target_name'][$i] != NULL) {
                $id = 0 + DB::table('preops_target')->max('id');
                $id += 1;

                $ops_target_data = [
                    'name' => $data['target_name'][$i],
                    'nationality_id' => $data['nationality_id'][$i],
                    'preops_number' => $request->preops_number,
                ];

                DB::table('preops_target')->updateOrInsert(['id' => $id], $ops_target_data);
            }
        }

        // Add Team
        $ops_team_data = [];

        for ($i = 0; $i < count($data['team_name']); $i++) {
            if ($data['team_name'][$i] != NULL) {

                $id = 0 + DB::table('preops_team')->max('id');
                $id += 1;

                $ops_team_data = [
                    'name' => $data['team_name'][$i],
                    'position' => $data['team_position'][$i],
                    'contact' => $data['team_contact'][$i],
                    'preops_number' => $request->preops_number,
                ];

                DB::table('preops_team')->updateOrInsert(['id' => $id], $ops_team_data);
            }
        }

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Suspect Information Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on suspect information setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new suspect information!', compact('preops_id'));
    }

    public function edit($id)
    {
        $issuance_of_preops = DB::table('preops_header')->where('id', $id)->get();
        $region = DB::table('region')->orderby('region_sort', 'asc')->get();
        $province = DB::table('province as a')
            ->join('regional_office as b', 'a.region_c', '=', 'b.region_c')
            ->where('b.ro_code', $issuance_of_preops[0]->ro_code)
            ->orderby('province_m', 'asc')
            ->get();
        $city = DB::table('city')->orderby('city_m', 'asc')->get();
        $barangay = DB::table('barangay')->orderby('barangay_m', 'asc')->get();
        $operating_unit = DB::table('operating_unit')->where('status', true)->orderby('name', 'asc')->get();
        $support_unit = DB::table('support_unit')->where('status', true)->orderby('name', 'asc')->get();
        $operation_type = DB::table('operation_type')->where('operation_classification_id', 2)->where('status', true)->orderby('name', 'asc')->get();
        $nationality = DB::table('nationality')->where('status', true)->orderby('name', 'asc')->get();
        $area = DB::table('preops_area as a')
            ->join('preops_header as b', 'a.preops_number', '=', 'b.preops_number')
            ->leftjoin('barangay as c', 'a.barangay_c', '=', 'c.barangay_c')
            ->leftjoin('city as d', 'a.city_c', '=', 'd.city_c')
            ->select('a.id', 'a.area', 'a.preops_number', 'a.type', 'a.region_c', 'a.province_c', 'a.city_c', 'a.barangay_c', 'c.barangay_m', 'd.city_m')
            ->where('b.id', $id)->get();
        $target = DB::table('preops_target as a')
            ->join('preops_header as b', 'a.preops_number', '=', 'b.preops_number')
            ->select('a.id', 'a.name', 'a.preops_number', 'a.nationality_id')
            ->where('b.id', $id)->get();
        $team = DB::table('preops_team as a')
            ->join('preops_header as b', 'a.preops_number', '=', 'b.preops_number')
            ->select('a.id', 'a.name', 'a.preops_number', 'a.position', 'a.contact')
            ->where('b.id', $id)->get();
        $regional_office = DB::table('regional_office')->orderby('print_order', 'asc')->get();
        $regional_user = DB::table('users')->where('user_level_id', 3)->get();
        $issuance_of_preops_files = DB::table('issuance_of_preops_files')->where('preops_number', $issuance_of_preops[0]->preops_number)->get();
        $preops_support_unit = DB::table('preops_support_unit')->where('preops_number', $issuance_of_preops[0]->preops_number)->get();

        return view('issuance_of_preops.issuance_of_preops_edit', compact('issuance_of_preops', 'region', 'operating_unit', 'operation_type', 'nationality', 'area', 'team', 'target', 'province', 'city', 'barangay', 'support_unit', 'regional_office', 'regional_user', 'issuance_of_preops_files', 'preops_support_unit'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $data = $request->all();

        date_default_timezone_set('Asia/Manila');
        $date = Carbon::now();

        // $request->validate([
        //     'preops_number' => 'required',
        //     'ro_code' => 'required',
        //     'operating_unit_id' => 'required',
        //     'operation_type_id' => 'required',
        //     'coordinated_datetime' => 'required',
        //     'operation_datetime' => 'required',
        // ]);

        if (Auth::user()->user_level_id == 2) {
            $form_data = array(
                'preops_number' => $request->preops_number,
                'ro_code' => $request->ro_code,
                'province_c' => $request->hprovince_c,
                'operating_unit_id' => $request->operating_unit_id,
                'operation_type_id' => $request->operation_type_id,
                'coordinated_datetime' => $request->coordinated_datetime,
                'duration' => $request->duration,
                'operation_datetime' => $request->operation_datetime,
                'validity' => $request->validity,
                'remarks' => $request->remarks,
                'reference_number' => $request->reference_number,
                'prepared_by' => $request->prepared_by,
                'approved_by' => $request->approved_by,
                'status' => true,
                // 'support_unit_id' => $request->support_unit_id,
                'updated_at' => $date,

            );

            DB::table('preops_header')->where('id', $id)->update($form_data);

            if ($request->hasfile('fileattach')) {
                foreach ($request->file('fileattach') as $file) {
                    $filename = $file->getClientOriginalName();
                    // $filename = pathinfo($fileinfo, PATHINFO_FILENAME);
                    $filePath = public_path() . '/files/uploads/issuance_of_preops/';
                    $file->move($filePath, $filename);

                    $file_data = array(
                        'preops_number' => $request->preops_number,
                        'filenames' => $filename,
                    );
                    $file_id = DB::table('issuance_of_preops_files')->insertGetId($file_data);



                    $file_upload = array(
                        'preops_file_id' => $file_id,
                        'filename' => $filename,
                        'transaction_type' => 1,
                        'created_at' => $date,
                    );

                    DB::table('file_upload_list')->insert($file_upload);
                }
            }

            // Update Support Unit
            $ops_su_data = [];

            if (!empty($data['support_unit_id'])) {
                DB::table('preops_support_unit')->where('preops_number', $request->preops_number)->delete();

                for ($i = 0; $i < count($data['support_unit_id']); $i++) {
                    if ($data['support_unit_id'][$i] != NULL) {

                        $ops_su_data = [
                            'preops_number' => $request->preops_number,
                            'support_unit_id' => $data['support_unit_id'][$i],
                        ];

                        DB::table('preops_support_unit')->insert($ops_su_data);
                    }
                }
            } else {
                DB::table('preops_support_unit')->where('preops_number', $request->preops_number)->delete();
            }

            //Update Area
            $ops_area_data = [];

            if ($data['area_id'] != NULL) {
                DB::table('preops_area')->whereNotIn('id', array_filter($data['area_id']))->delete();
            }


            for ($i = 0; $i < count($data['area']); $i++) {
                if ($data['area'][$i] != NULL) {

                    if ($data['area_id'][$i] == null || $data['area_id'][$i] == 0) {
                        $id = 0 + DB::table('preops_area')->max('id');
                        $id += 1;
                    } else {
                        $id = $data['area_id'][$i];
                    }

                    $ops_area_data = [
                        'area' => $data['area'][$i],
                        'preops_number' => $request->preops_number,
                        'region_c' => $data['area_region_c'][$i],
                        'province_c' => $data['province_c'][$i],
                        'city_c' => $data['city_c'][$i],
                        'barangay_c' => $data['barangay_c'][$i],
                        'ops_status' => true,
                    ];

                    DB::table('preops_area')->updateOrInsert(['id' => $id], $ops_area_data);
                }
            }

            //Update Target
            $ops_target_data = [];

            DB::table('preops_target')->whereNotIn('id', array_filter($data['target_id']))->delete();

            for ($i = 0; $i < count($data['target_name']); $i++) {
                if ($data['target_name'][$i] != NULL) {

                    if ($data['target_id'][$i] == null || $data['target_id'][$i] == 0) {
                        $id = 0 + DB::table('preops_target')->max('id');
                        $id += 1;
                    } else {
                        $id = $data['target_id'][$i];
                    }


                    $ops_target_data = [
                        'name' => $data['target_name'][$i],
                        'nationality_id' => $data['nationality_id'][$i],
                        'preops_number' => $request->preops_number,
                    ];

                    DB::table('preops_target')->updateOrInsert(['id' => $id], $ops_target_data);
                }
            }

            $ops_team_data = [];

            DB::table('preops_team')->whereNotIn('id', array_filter($data['team_id']))->delete();

            for ($i = 0; $i < count($data['team_name']); $i++) {
                if ($data['team_name'][$i] != NULL) {

                    if ($data['team_id'][$i] == null || $data['team_id'][$i] == 0) {
                        $id = 0 + DB::table('preops_team')->max('id');
                        $id += 1;
                    } else {
                        $id = $data['team_id'][$i];
                    }


                    $ops_team_data = [
                        'name' => $data['team_name'][$i],
                        'position' => $data['team_position'][$i],
                        'contact' => $data['team_contact'][$i],
                        'preops_number' => $request->preops_number,
                    ];

                    DB::table('preops_team')->updateOrInsert(['id' => $id], $ops_team_data);
                }
            }
        } elseif (Auth::user()->user_level_id == 3) {
            if ($request->hasfile('fileattach')) {
                foreach ($request->file('fileattach') as $file) {
                    $filename = $file->getClientOriginalName();
                    // $filename = pathinfo($fileinfo, PATHINFO_FILENAME);
                    $filePath = public_path() . '/files/uploads/issuance_of_preops/';
                    $file->move($filePath, $filename);

                    $file_data = array(
                        'preops_number' => $request->preops_number,
                        'filenames' => $filename,
                    );
                    $file_id = DB::table('issuance_of_preops_files')->insertGetId($file_data);

                    $file_upload = array(
                        'preops_file_id' => $file_id,
                        'filename' => $filename,
                        'transaction_type' => 1,
                        'created_at' => $date,
                    );

                    DB::table('file_upload_list')->insert($file_upload);
                }
            }
        }

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Sudpect Classification Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on issuance of preops setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated issuance of preops!');
    }

    function get_preops_data($id)
    {
        $preops_data = DB::table('preops_header')
            ->where('id', $id)
            ->get();
        return $preops_data;
    }

    function pdf($id)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convert_preops_data_to_html($id));
        return $pdf->stream();
    }

    function convert_preops_data_to_html($id)
    {
        $preops_data = $this->get_preops_data($id);
        $regional_office = DB::table('regional_office')->where('ro_code', $preops_data[0]->ro_code)->get();
        $operating_unit = DB::table('operating_unit')->where('id', $preops_data[0]->operating_unit_id)->get();
        $support_unit = DB::table('support_unit')->where('status', true)->get();
        $operation_type = DB::table('operation_type')->where('id', $preops_data[0]->operation_type_id)->get();
        $area = DB::table('preops_area as a')
            ->join('preops_header as b', 'a.preops_number', '=', 'b.preops_number')
            ->leftjoin('region as c', 'a.region_c', '=', 'c.region_c')
            ->leftjoin('province as d', 'a.province_c', '=', 'd.province_c')
            ->leftjoin('city as e', 'a.city_c', '=', 'e.city_c')
            ->leftjoin('barangay as f', 'a.barangay_c', '=', 'f.barangay_c')
            ->select('c.region_m', 'd.province_m', 'e.city_m', 'f.barangay_m', 'a.area')
            ->where('b.id', $id)->get();

        $target = DB::table('preops_target as a')
            ->join('preops_header as b', 'a.preops_number', '=', 'b.preops_number')
            ->join('nationality as c', 'c.id', '=', 'a.nationality_id')
            ->select('a.id', 'a.name', 'a.preops_number', 'c.name as nationality')
            ->where('b.id', $id)->get();

        $operation_datetime = Carbon::createFromFormat('Y-m-d H:i:s', $preops_data[0]->operation_datetime);
        $validity = Carbon::createFromFormat('Y-m-d H:i:s', $preops_data[0]->validity);
        $duration = $operation_datetime->diffInHours($validity);

        $tbluserlevel = DB::table('tbluserlevel')->where('id', Auth::user()->user_level_id)->get();

        date_default_timezone_set('Asia/Manila');
        $date = Carbon::now();

        $output = '<html>
        <head>
            <style>
                /** Define the margins of your page **/
                @page {
                    margin: 100px 25px;
                }
    
                header {
                    position: fixed;
                    top: -60px;
                    left: 0px;
                    right: 0px;
                    height: 50px;
    
                    /** Extra personal styles **/
                    color: red;
                    text-align: center;
                    line-height: 35px;
                    font-size: 20px;
                }
    
                footer {
                    position: fixed; 
                    bottom: -60px; 
                    left: 0px; 
                    right: 0px;
                    height: 50px; 
    
                    /** Extra personal styles **/
                    color: black;
                    text-align: center;
                    line-height: 35px;
                }
            </style>
        </head>
        <body>
            <!-- Define header and footer blocks before your content -->
            <header>
            SECRET
            </header>';

        $output .= '

     <br>
                <img src="./dist/img/pdea_logo.jpg" class="col-3" style="width:100px; height:100px; float:left">
                <span style="padding-left:20px">Republic of the Philippines</span>
                <br>
                <span style="padding-left:20px">Office of the President</span>
                <hr style="margin-left:120px; margin-top:0px;  margin-bottom:0px">
                <span style="padding-left:20px; font-weight: bold; font-size:20px; margin-bottom:0px">PHILIPPINE DRUG ENFORCEMENT AGENCY</span>
                <br>
                <p style="padding-left:40px; font-size:13px; margin-top:0px; margin-left:80px">' . $regional_office[0]->address . ' | www.pdea.gov.ph | ' . $regional_office[0]->contact_number . '</p>
                <br>
                <h3 align="center">CERTIFICATE OF COORDINATION</h3>
                <span style="margin-right:110px">Issuing Office:</span><span>' . $regional_office[0]->name . '</span>
                <br>
                <span style="margin-right:39px;">Pre-Ops Control Number:</span><span style="font-weight: bold;">' . $preops_data[0]->preops_number . '</span>
                <br>
                <span style="margin-right:23px">Date and Time Coordinated:</span><span>' . Carbon::createFromFormat('Y-m-d H:i:s', $preops_data[0]->coordinated_datetime)->format('M/d/Y H:i:s') . '</span>
                <br>
                <span style="margin-right:104px">Operating Unit:</span><span style="font-weight: bold;">' . $operating_unit[0]->name . '</span>
                <br>
                <span style="margin-right:82px">Type of Operation:</span><span style="font-weight: bold;">' . $operation_type[0]->name . '</span>
                <br>
                <span style="margin-right:143px">Duration:</span><span>' . Carbon::createFromFormat('Y-m-d H:i:s', $preops_data[0]->operation_datetime)->format('M/d/Y H:i:s') . ' to ' . Carbon::createFromFormat('Y-m-d H:i:s', $preops_data[0]->validity)->format('M/d/Y H:i:s') . ' (' . $duration . ' HRS)</span>
                <br>
                <span style="margin-right:149px">Remark:</span><span>' . $preops_data[0]->remarks . '</span>
                <br>
                <br>
                <div style="background-color:green; color:white; padding-left:5px">Area(s) of Operation</div>';

        foreach ($area as $ar) {
            $output .= '
            <div  style="margin-left:40px"><span>' . $ar->area . ', ' . $ar->barangay_m . ', ' . $ar->city_m . ', ' . $ar->province_m . ', ' . $ar->region_m . '</span></div><hr>';
        }
        $output .= '
        <br>
        <div style="background-color:green; color:white; padding-left:5px">Target(s)</div>';

        foreach ($target as $tr) {
            $output .= '
            <div  style="margin-left:40px"><span>' . $tr->name . ' (' . $tr->nationality . ')</span></div>';
        }

        $output .= '
        <h4 align="center">***** nothing follows *****</h4>
        <div style="margin-right:39px; margin-bottom:40px">Prepared by:</div>
        <div style="margin-right:39px; font-weight: bold;">' . $preops_data[0]->prepared_by . '</div>
        <div style="margin-right:39px;">DUTY, ROC</div>
        <br>
        <div style="padding-left:300px; margin-bottom:40px">Approved by:</div>
        <div style="padding-left:300px; font-weight: bold;">' . $preops_data[0]->approved_by . '</div>
        <div style="padding-left:300px;">REGIONAL DIRECTOR</div>
        ';

        $output .= '
                <footer>
                    ' . $date . ' | ' . Auth::user()->name . '
                </footer>
            </body>
            </html>';

        return $output;
    }

    public function get_preops_header_count($ro_code, $province_c)
    {
        $preops_id = 0 + DB::table('preops_header')
            ->where('ro_code', $ro_code)
            ->where('province_c', $province_c)
            ->whereDate('coordinated_datetime', Carbon::now()->format('Y-m-d'))
            ->count();
        $preops_id += 1;
        $preops_id = sprintf("%03s", $preops_id);

        return json_encode($preops_id);
    }
}
