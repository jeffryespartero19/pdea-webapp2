<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\SpotReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;
use PDF;

class SpotReportController extends Controller
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
        if (Auth::user()->user_level_id == 2) {
            $data = DB::table('spot_report_header as a')
                ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
                ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
                ->select('a.id', 'a.spot_report_number', 'a.operation_datetime', 'b.name as operating_unit_name', 'c.name as operation_type_name', 'a.status', 'a.created_at', 'a.preops_number')
                ->where('a.report_status', 0)
                ->orderby('spot_report_number', 'asc')
                ->paginate(20);

            $regional_office = DB::table('regional_office')->orderby('print_order', 'asc')->get();
        } else {
            $data = DB::table('spot_report_header as a')
                ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
                ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
                ->leftjoin('regional_office as d', 'a.region_c', '=', 'd.region_c')
                ->select('a.id', 'a.spot_report_number', 'a.operation_datetime', 'b.name as operating_unit_name', 'c.name as operation_type_name', 'a.status', 'a.created_at', 'a.preops_number')
                ->where('a.report_status', 0)
                ->where('d.id', Auth::user()->regional_office_id)
                ->orderby('spot_report_number', 'asc')
                ->paginate(20);

            $regional_office = DB::table('regional_office')
                ->where('id', Auth::user()->regional_office_id)
                ->get();
        }

        return view('spot_report.spot_report_list', compact('data', 'regional_office'));
    }

    public function fetch_data(Request $request)
    {

        if ($request->ajax()) {

            // dd($request->get('operating_unit_id'));
            $data = DB::table('spot_report_header as a')
                ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
                ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
                ->select('a.id', 'a.spot_report_number', 'a.operating_unit_id', 'operation_type_id', 'b.name as operating_unit_name', 'c.name as operation_type_name', 'a.operation_datetime', 'a.region_c', 'a.status', 'a.created_at', 'a.preops_number')
                ->where('a.report_status', 0);

            if ($request->get('region_c') != 0) {
                $data->where(['a.region_c' => $request->get('region_c')]);
            }
            if ($request->get('operating_unit_id') != 0) {
                $data->where(['a.operating_unit_id' => $request->get('operating_unit_id')]);
            }
            if ($request->get('operation_type_id') != 0) {
                $data->where(['a.operation_type_id' => $request->get('operation_type_id')]);
            }
            if ($request->get('operation_date') != 0) {
                $data->where(DB::raw("(DATE_FORMAT(a.operation_datetime,'%Y-%m-%d'))"), '>=', $request->get('operation_date'));
            }
            if ($request->get('operation_date_to') != 0) {
                $data->where(DB::raw("(DATE_FORMAT(a.operation_datetime,'%Y-%m-%d'))"), '<=', $request->get('operation_date_to'));
            }

            $data = $data->paginate(10);

            // dd($data);

            return view('spot_report.spot_report_data', compact('data'))->render();
        }
    }

    public function search_spot_report_list(Request $request)
    {
        $param = $request->get('param');

        if (Auth::user()->user_level_id == 2) {
            $data = DB::table('spot_report_header as a')
                ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
                ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
                ->select('a.id', 'a.spot_report_number', 'a.operation_datetime', 'b.name as operating_unit_name', 'c.name as operation_type_name', 'a.status', 'a.created_at', 'a.preops_number')
                ->where('a.report_status', 0)
                ->where('a.spot_report_number', 'LIKE', '%' . $param . '%')
                ->orderby('spot_report_number', 'asc')
                ->paginate(20);
        } else {
            $data = DB::table('spot_report_header as a')
                ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
                ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
                ->leftjoin('regional_office as d', 'a.region_c', '=', 'd.region_c')
                ->select('a.id', 'a.spot_report_number', 'a.operation_datetime', 'b.name as operating_unit_name', 'c.name as operation_type_name', 'a.status', 'a.created_at', 'a.preops_number')
                ->where('a.spot_report_number', 'LIKE', '%' . $param . '%')
                ->where('a.report_status', 0)
                ->where('d.id', Auth::user()->regional_office_id)
                ->orderby('spot_report_number', 'asc')
                ->paginate(20);
        }
        return view('spot_report.spot_report_data', compact('data'))->render();
    }

    public function add()
    {
        $civil_status = DB::table('civil_status')->where('active', true)->orderby('name', 'asc')->get();
        $religion = DB::table('religions')->where('active', true)->orderby('name', 'asc')->get();
        $education = DB::table('Educational_attainment')->where('status', true)->orderby('name', 'asc')->get();
        $ethnic_group = DB::table('ethnic_group')->where('status', true)->orderby('name', 'asc')->get();
        $nationality = DB::table('nationality')->where('status', true)->orderby('name', 'asc')->get();
        $occupation = DB::table('occupation')->where('status', true)->orderby('name', 'asc')->get();
        $suspect_status = DB::table('suspect_status')->where('status', true)->orderby('name', 'asc')->get();
        $suspect_classification = DB::table('suspect_classification')->where('status', true)->orderby('name', 'asc')->get();
        $suspect_category = DB::table('suspect_category')->where('status', true)->orderby('name', 'asc')->get();
        $support_unit = DB::table('support_unit')->where('status', true)->orderby('name', 'asc')->get();
        $regional_user = DB::table('users')->where('user_level_id', 3)->get();
        $evidence_type = DB::table('evidence_type')->where('status', true)->orderby('name', 'asc')->get();
        $unit_measurement = DB::table('unit_measurement')->where('status', true)->orderby('name', 'asc')->get();
        $packaging = DB::table('packaging')->where('status', true)->orderby('name', 'asc')->get();
        $region = DB::table('region')->where('status', true)->orderby('region_sort', 'asc')->get();
        $identifier = DB::table('identifier')->where('status', true)->orderby('name', 'asc')->get();

        if (Auth::user()->user_level_id == 1) {
            $sregion = DB::table('region')->where('region_c', Auth::user()->region_c)->orderby('region_sort', 'asc')->get();
        } else {
            $sregion = DB::table('region')->orderby('region_sort', 'asc')->get();
        }


        date_default_timezone_set('Asia/Manila');
        $date = Carbon::now()->format('mdY');

        // Auto Spot Number
        $spot_report_number = DB::table('spot_report_header')
            ->where('region_c', Auth::user()->region_c)
            ->whereDate('reported_date', Carbon::now()->format('Y-m-d'))
            ->count();
        $spot_report_number += 1;
        $spot_report_number = sprintf("%04s", $spot_report_number);

        // Auto SUspect Number
        $suspect_number = 0 + DB::table('suspect_information')
            ->whereDate('created_at', Carbon::now()->format('Y-m-d'))
            ->count();
        $suspect_number += 1;
        $suspect_number = sprintf("%04s", $suspect_number);

        // dd('test');

        return view('spot_report.spot_report_add', compact(
            'packaging',
            'sregion',
            'suspect_category',
            'suspect_number',
            'date',
            'spot_report_number',
            'unit_measurement',
            'evidence_type',
            'suspect_classification',
            'civil_status',
            'religion',
            'education',
            'ethnic_group',
            'nationality',
            'occupation',
            'region',
            'suspect_status',
            'support_unit',
            'regional_user',
            'identifier'
        ));
    }

    public function store(Request $request)
    {

        // dd($data = $request->all());
        $data = $request->all();

        // Auto Spot Number
        date_default_timezone_set('Asia/Manila');
        $date = Carbon::now()->format('mdY');
        $spot_report_number = DB::table('spot_report_header')
            ->where('region_c', $request->region_c)
            ->whereDate('reported_date', Carbon::now()->format('Y-m-d'))
            ->count();
        $spot_report_number += 1;
        $spot_report_number = sprintf("%04s", $spot_report_number);
        $spot_report_number = 'RO' . $request->region_c . '-' . $date . '-' . $spot_report_number;


        $form_data = array(
            'spot_report_number' => $spot_report_number,
            'operation_type_id' => $request->operation_type_id,
            'reported_date' => $request->reported_date,
            'region_c' => $request->region_c,
            'province_c' => $request->province_c,
            'city_c' => $request->city_c,
            'barangay_c' => $request->barangay_c,
            'street' => $request->street,
            'preops_number' => $request->preops_number,
            'operating_unit_id' => $request->operating_unit_id,
            'operation_datetime' => $request->operation_datetime,
            'warrant_number' => $request->warrant_number,
            'judge_name' => $request->judge_name,
            'branch' => $request->branch,
            'prepared_by' => $request->prepared_by,
            'approved_by' => $request->approved_by,
            // 'support_unit_id' => $request->support_unit_id,
            'status' => true,
            'report_header' => $request->report_header,
            'summary' => $request->summary,
            'operation_lvl' => $request->has('operation_lvl') ? true : false,
            'reference_number' => $request->reference_number,
            'created_at' => Carbon::now(),
            'hio_type_id' => $request->hio_type_id,
        );

        $sr_id = DB::table('spot_report_header')->insertGetId($form_data);

        $data2 = array(
            'with_sr' => 1,
        );
        DB::table('preops_header')->where('preops_number', $request->preops_number)->update($data2);

        if ($request->hasfile('fileattach')) {
            foreach ($request->file('fileattach') as $file) {
                $filename = $file->getClientOriginalName();
                //  $filename = pathinfo($fileinfo, PATHINFO_FILENAME);
                $filePath = public_path() . '/files/uploads/spot_reports/';
                $file->move($filePath, $filename);

                $file_data = array(
                    'spot_report_number' => $spot_report_number,
                    'filenames' => $filename,
                );
                $file_id = DB::table('spot_report_files')->insertGetId($file_data);

                date_default_timezone_set('Asia/Manila');
                $date = Carbon::now();

                $file_upload = array(
                    'spot_report_file_id' => $file_id,
                    'filename' => $filename,
                    'transaction_type' => 3,
                    'created_at' => $date,
                );

                DB::table('file_upload_list')->insert($file_upload);
            }
        }



        if (isset($data['suspect_status_id'])) {
            $spot_suspect = [];

            for ($i = 0; $i < count($data['lastname']); $i++) {
                if ($data['suspect_status_id'][$i] != 2 && $data['suspect_status_id'][$i] != 0) {

                    // Auto SUspect Number
                    $suspect_number = 0 + DB::table('suspect_information')
                        ->whereDate('created_at', Carbon::now()->format('Y-m-d'))
                        ->count();
                    $suspect_number += 1;
                    $suspect_number = sprintf("%04s", $suspect_number);
                    $date = Carbon::now()->format('mdY');

                    $suspect_number = $date . "-" . $suspect_number;

                    $id = 0 + DB::table('spot_report_suspect')->max('id');
                    $id += 1;

                    $spot_suspect = [
                        'suspect_number' => $suspect_number,
                        'spot_report_number' => $spot_report_number,
                        'lastname' => $data['lastname'][$i],
                        'firstname' => $data['firstname'][$i],
                        'middlename' => $data['middlename'][$i],
                        'alias' => $data['alias'][$i],
                        'gender' => $data['gender'][$i],
                        'birthdate' => $data['birthdate'][$i],
                        'birthplace' => $data['birthplace'][$i],
                        'nationality_id' => $data['nationality_id'][$i],
                        'civil_status_id' => $data['civil_status_id'][$i],
                        'religion_id' => $data['religion_id'][$i],
                        'educational_attainment_id' => $data['educational_attainment_id'][$i],
                        'ethnic_group_id' => $data['ethnic_group_id'][$i],
                        'occupation_id' => $data['occupation_id'][$i],
                        'identifier_id' => $data['identifier_id'][$i],
                        'region_c' => $data['present_region_c'][$i],
                        'province_c' => $data['present_province_c'][$i],
                        'city_c' => $data['present_city_c'][$i],
                        'barangay_c' => $data['present_barangay_c'][$i],
                        'street' => $data['present_street'][$i],
                        'permanent_region_c' => $data['permanent_region_c'][$i],
                        'permanent_province_c' => $data['permanent_province_c'][$i],
                        'permanent_city_c' => $data['permanent_city_c'][$i],
                        'permanent_barangay_c' => $data['permanent_barangay_c'][$i],
                        'permanent_street' => $data['permanent_street'][$i],
                        'suspect_status_id' => $data['suspect_status_id'][$i],
                        'suspect_classification_id' => $data['suspect_classification_id'][$i],
                        'suspect_category_id' => $data['suspect_category_id'][$i],
                        'suspect_sub_category_id' => $data['suspect_sub_category_id'][$i],
                        'remarks' => $data['remarks'][$i],
                        'status' => true,
                        'created_at' => Carbon::now()->format('Y-m-d'),
                        'est_birthdate' => $data['est_birthdate'][$i],
                        'whereabouts' => $data['whereabouts'][$i],
                    ];

                    $suspect_information = [
                        'suspect_number' => $suspect_number,
                        'lastname' => $data['lastname'][$i],
                        'firstname' => $data['firstname'][$i],
                        'middlename' => $data['middlename'][$i],
                        'alias' => $data['alias'][$i],
                        'gender' => $data['gender'][$i],
                        'birthdate' => $data['birthdate'][$i],
                        'birthplace' => $data['birthplace'][$i],
                        'nationality_id' => $data['nationality_id'][$i],
                        'civil_status_id' => $data['civil_status_id'][$i],
                        'religion_id' => $data['religion_id'][$i],
                        'educational_attainment_id' => $data['educational_attainment_id'][$i],
                        'ethnic_group_id' => $data['ethnic_group_id'][$i],
                        'occupation_id' => $data['occupation_id'][$i],
                        'identifier_id' => $data['identifier_id'][$i],
                        'operation_region' => $request->region_c,
                        'region_c' => $data['present_region_c'][$i],
                        'province_c' => $data['present_province_c'][$i],
                        'city_c' => $data['present_city_c'][$i],
                        'barangay_c' => $data['present_barangay_c'][$i],
                        'street' => $data['present_street'][$i],
                        'permanent_region_c' => $data['permanent_region_c'][$i],
                        'permanent_province_c' => $data['permanent_province_c'][$i],
                        'permanent_city_c' => $data['permanent_city_c'][$i],
                        'permanent_barangay_c' => $data['permanent_barangay_c'][$i],
                        'permanent_street' => $data['permanent_street'][$i],
                        'status' => true,
                        'operating_unit_id' => $request->operating_unit_id,
                        'created_at' => Carbon::now()->format('Y-m-d'),
                        'est_birthdate' => $data['est_birthdate'][$i],
                        'whereabouts' => $data['whereabouts'][$i],
                    ];

                    DB::table('spot_report_suspect')->updateOrInsert(['id' => $id], $spot_suspect);
                    DB::table('suspect_information')->updateOrInsert(['suspect_number' => $suspect_number], $suspect_information);
                } else {
                    if ($data['lastname'][$i] != null || $data['firstname'][$i] != null  || $data['alias'][$i] != null) {
                        // Auto SUspect Number
                        $suspect_number = 0 + DB::table('suspect_information')
                            ->whereDate('created_at', Carbon::now()->format('Y-m-d'))
                            ->count();
                        $suspect_number += 1;
                        $suspect_number = sprintf("%04s", $suspect_number);
                        $date = Carbon::now()->format('mdY');

                        $suspect_number = $date . "-" . $suspect_number;

                        $id = 0 + DB::table('spot_report_suspect')->max('id');
                        $id += 1;

                        $spot_suspect = [
                            'suspect_number' => $suspect_number,
                            'spot_report_number' => $spot_report_number,
                            'lastname' => $data['lastname'][$i],
                            'firstname' => $data['firstname'][$i],
                            'middlename' => $data['middlename'][$i],
                            'alias' => $data['alias'][$i],
                            'gender' => $data['gender'][$i],
                            'birthdate' => $data['birthdate'][$i],
                            'birthplace' => $data['birthplace'][$i],
                            'nationality_id' => $data['nationality_id'][$i],
                            'civil_status_id' => $data['civil_status_id'][$i],
                            'religion_id' => $data['religion_id'][$i],
                            'educational_attainment_id' => $data['educational_attainment_id'][$i],
                            'ethnic_group_id' => $data['ethnic_group_id'][$i],
                            'occupation_id' => $data['occupation_id'][$i],
                            'identifier_id' => $data['identifier_id'][$i],
                            'region_c' => $data['present_region_c'][$i],
                            'province_c' => $data['present_province_c'][$i],
                            'city_c' => $data['present_city_c'][$i],
                            'barangay_c' => $data['present_barangay_c'][$i],
                            'street' => $data['present_street'][$i],
                            'permanent_region_c' => $data['permanent_region_c'][$i],
                            'permanent_province_c' => $data['permanent_province_c'][$i],
                            'permanent_city_c' => $data['permanent_city_c'][$i],
                            'permanent_barangay_c' => $data['permanent_barangay_c'][$i],
                            'permanent_street' => $data['permanent_street'][$i],
                            'suspect_status_id' => $data['suspect_status_id'][$i],
                            'suspect_classification_id' => $data['suspect_classification_id'][$i],
                            'suspect_category_id' => $data['suspect_category_id'][$i],
                            'suspect_sub_category_id' => $data['suspect_sub_category_id'][$i],
                            'remarks' => $data['remarks'][$i],
                            'status' => true,
                            'created_at' => Carbon::now()->format('Y-m-d'),
                            'est_birthdate' => $data['est_birthdate'][$i],
                            'whereabouts' => $data['whereabouts'][$i],
                        ];

                        $suspect_information = [
                            'suspect_number' => $suspect_number,
                            'lastname' => $data['lastname'][$i],
                            'firstname' => $data['firstname'][$i],
                            'middlename' => $data['middlename'][$i],
                            'alias' => $data['alias'][$i],
                            'gender' => $data['gender'][$i],
                            'birthdate' => $data['birthdate'][$i],
                            'birthplace' => $data['birthplace'][$i],
                            'nationality_id' => $data['nationality_id'][$i],
                            'civil_status_id' => $data['civil_status_id'][$i],
                            'religion_id' => $data['religion_id'][$i],
                            'educational_attainment_id' => $data['educational_attainment_id'][$i],
                            'ethnic_group_id' => $data['ethnic_group_id'][$i],
                            'occupation_id' => $data['occupation_id'][$i],
                            'identifier_id' => $data['identifier_id'][$i],
                            'operation_region' => $request->region_c,
                            'region_c' => $data['present_region_c'][$i],
                            'province_c' => $data['present_province_c'][$i],
                            'city_c' => $data['present_city_c'][$i],
                            'barangay_c' => $data['present_barangay_c'][$i],
                            'street' => $data['present_street'][$i],
                            'permanent_region_c' => $data['permanent_region_c'][$i],
                            'permanent_province_c' => $data['permanent_province_c'][$i],
                            'permanent_city_c' => $data['permanent_city_c'][$i],
                            'permanent_barangay_c' => $data['permanent_barangay_c'][$i],
                            'permanent_street' => $data['permanent_street'][$i],
                            'status' => true,
                            'operating_unit_id' => $request->operating_unit_id,
                            'created_at' => Carbon::now()->format('Y-m-d'),
                            'est_birthdate' => $data['est_birthdate'][$i],
                            'whereabouts' => $data['whereabouts'][$i],
                        ];

                        DB::table('spot_report_suspect')->updateOrInsert(['id' => $id], $spot_suspect);
                        DB::table('suspect_information')->updateOrInsert(['suspect_number' => $suspect_number], $suspect_information);
                    }
                }
            }
        }

        if (isset($data['suspect_number_item'])) {
            $spot_item = [];

            for ($i = 0; $i < count($data['suspect_number_item']); $i++) {
                if ($data['suspect_number_item'][$i] != NULL && $data['evidence_id'][$i] != NULL) {

                    // dd($data['suspect_number_item'][$i]);

                    if ($data['suspect_number_item'][$i] != null) {
                        $sdata = explode(",", $data['suspect_number_item'][$i]);
                        $lastname = $sdata[0];
                        $firstname = $sdata[1];
                        $middlename = $sdata[2];
                        $alias = $sdata[3];
                        $birthdate = $sdata[4];

                        $query = DB::table('spot_report_suspect')
                            ->select('suspect_number');

                        if ($lastname != null) {
                            $query->where('lastname', $lastname);
                        }
                        if ($firstname != null) {
                            $query->where('firstname', $firstname);
                        }
                        if ($middlename != null) {
                            $query->where('middlename', $middlename);
                        }
                        if ($alias != null) {
                            $query->where('alias', $alias);
                        }
                        if ($birthdate != null) {
                            $query->where('birthdate', $birthdate);
                        }

                        $suspect_data = $query->get();

                        $suspect_number = $suspect_data[0]->suspect_number;

                        // dd($suspect_number);
                    } else {
                        $suspect_number = 0;
                    }

                    $id = 0 + DB::table('spot_report_evidence')->max('id');
                    $id += 1;

                    $spot_item = [
                        'suspect_number' => $suspect_number,
                        'evidence_id' => $data['evidence_id'][$i],
                        'quantity' => $data['quantity'][$i],
                        'unit' => $data['unit_measurement_id'][$i],
                        'packaging_id' => $data['packaging_id'][$i],
                        'spot_report_number' => $spot_report_number,
                        'drug' => $data['drug'][$i],
                        'markings' => $data['markings'][$i],

                    ];

                    DB::table('spot_report_evidence')->updateOrInsert(['id' => $id], $spot_item);
                }
            }
        }

        if (isset($data['support_unit_id'])) {
            $spot_su = [];

            for ($i = 0; $i < count($data['support_unit_id']); $i++) {
                if ($data['support_unit_id'][$i] != NULL) {

                    $id = 0 + DB::table('spot_report_support_unit')->max('id');
                    $id += 1;

                    $spot_su = [
                        'spot_report_number' => $spot_report_number,
                        'support_unit_id' => $data['support_unit_id'][$i],
                    ];

                    DB::table('spot_report_support_unit')->updateOrInsert(['id' => $id], $spot_su);
                }
            }
        }

        if (isset($data['suspect_number_case'])) {
            $spot_case = [];

            for ($i = 0; $i < count($data['suspect_number_case']); $i++) {
                if ($data['suspect_number_case'][$i] != NULL && $data['case_id'][$i] != NULL || $data['suspect_number_case'][$i] == 0) {

                    // dd($data['suspect_number_case'][$i]);

                    if ($data['suspect_number_case'][$i] != null && $data['suspect_number_case'][$i] != null) {
                        $sdata = explode(",", $data['suspect_number_case'][$i]);
                        $lastname = $sdata[0];
                        $firstname = $sdata[1];
                        $middlename = $sdata[2];
                        $alias = $sdata[3];
                        $birthdate = $sdata[4];

                        $query = DB::table('spot_report_suspect')
                            ->select('suspect_number');

                        if ($lastname != null) {
                            $query->where('lastname', $lastname);
                        }
                        if ($firstname != null) {
                            $query->where('firstname', $firstname);
                        }
                        if ($middlename != null) {
                            $query->where('middlename', $middlename);
                        }
                        if ($alias != null) {
                            $query->where('alias', $alias);
                        }
                        if ($birthdate != null) {
                            $query->where('birthdate', $birthdate);
                        }

                        $suspect_data = $query->get();

                        $suspect_number = $suspect_data[0]->suspect_number;
                    } else {
                        $suspect_number = 0;
                    }


                    $id = 0 + DB::table('spot_report_case')->max('id');
                    $id += 1;

                    $spot_case = [
                        'suspect_number' => $suspect_number,
                        'case_id' => $data['case_id'][$i],
                        'spot_report_number' => $spot_report_number,
                    ];

                    DB::table('spot_report_case')->updateOrInsert(['id' => $id], $spot_case);
                }
            }
        }


        $spot_team = [];

        for ($i = 0; $i < count($data['officer_name']); $i++) {
            if ($data['officer_name'][$i] != NULL) {

                $id = 0 + DB::table('spot_report_team')->max('id');
                $id += 1;

                $spot_team = [
                    'officer_name' => $data['officer_name'][$i],
                    'officer_position' => $data['officer_position'][$i],
                    'spot_report_number' => $spot_report_number,
                ];

                DB::table('spot_report_team')->updateOrInsert(['id' => $id], $spot_team);
            }
        }


        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Spot Report Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on spot report setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new spot report!')->with('sr_id', $sr_id);
    }

    public function edit($id)
    {

        $spot_report_header = DB::table('spot_report_header as a')
            ->where('a.id', $id)->get();
        $suspects = DB::table('spot_report_suspect as a')
            ->leftjoin('spot_report_header as b', 'a.spot_report_number', '=', 'b.spot_report_number')
            ->leftjoin('drug_management as c', 'a.id', '=', 'c.suspect_id')
            ->leftjoin('users as d', 'd.id', '=', 'c.user_id')
            ->leftjoin('tbluserlevel as e', 'd.user_level_id', '=', 'e.id')
            ->leftjoin('province as f', 'a.province_c', '=', 'f.province_c')
            ->leftjoin('city as g', 'a.city_c', '=', 'g.city_c')
            ->leftjoin('barangay as h', 'a.barangay_c', '=', 'h.barangay_c')
            ->leftjoin('province as i', 'a.permanent_province_c', '=', 'i.province_c')
            ->leftjoin('city as j', 'a.permanent_city_c', '=', 'j.city_c')
            ->leftjoin('barangay as k', 'a.permanent_barangay_c', '=', 'k.barangay_c')
            ->select(
                'a.id',
                'a.suspect_number',
                'a.spot_report_number',
                'a.lastname',
                'a.firstname',
                'a.middlename',
                'a.alias',
                'a.gender',
                'a.birthdate',
                'a.birthplace',
                'a.nationality_id',
                'a.civil_status_id',
                'a.religion_id',
                'a.educational_attainment_id',
                'a.ethnic_group_id',
                'a.occupation_id',
                'a.identifier_id',
                'a.region_c',
                'a.province_c',
                'a.city_c',
                'a.barangay_c',
                'a.street',
                'a.permanent_region_c',
                'a.permanent_province_c',
                'a.permanent_city_c',
                'a.permanent_barangay_c',
                'a.permanent_street',
                'a.suspect_classification_id',
                'a.suspect_status_id',
                'a.remarks',
                'a.suspect_category_id',
                'a.suspect_sub_category_id',
                'c.listed',
                'c.user_id',
                'e.name as ulvl',
                'd.name as uname',
                'a.est_birthdate',
                'a.whereabouts',
                'f.province_m as province_name',
                'g.city_m as city_name',
                'h.barangay_m as barangay_name',
                'i.province_m as permanent_province_name',
                'j.city_m as permanent_city_name',
                'k.barangay_m as permanent_barangay_name',
            )
            ->where('a.spot_report_number', $spot_report_header[0]->spot_report_number)->get();
        $operating_unit = DB::table('operating_unit')->where('id', $spot_report_header[0]->operating_unit_id)->get();
        $spot_report_evidence = DB::table('spot_report_evidence as a')
            ->join('spot_report_header as b', 'a.spot_report_number', '=', 'b.spot_report_number')
            ->select('a.id', 'a.suspect_number', 'a.spot_report_number', 'a.evidence_id', 'a.quantity', 'a.unit', 'a.packaging_id', 'a.drug', 'a.markings')
            ->where('b.id', $id)->get();
        $spot_report_case = DB::table('spot_report_case as a')
            ->join('spot_report_header as b', 'a.spot_report_number', '=', 'b.spot_report_number')
            ->select('a.id', 'a.suspect_number', 'a.spot_report_number', 'a.case_id')
            ->where('b.id', $id)->get();
        $spot_report_team = DB::table('spot_report_team as a')
            ->join('spot_report_header as b', 'a.spot_report_number', '=', 'b.spot_report_number')
            ->select('a.id', 'a.officer_name', 'a.spot_report_number', 'a.officer_position')
            ->where('b.id', $id)->get();
        $spot_report_summary = DB::table('spot_report_summary as a')
            ->join('spot_report_header as b', 'a.spot_report_number', '=', 'b.spot_report_number')
            ->select('a.id', 'a.report_header', 'a.spot_report_number', 'a.summary')
            ->where('b.id', $id)->get();

        $region = DB::table('region')->where('status', true)->orderby('region_sort', 'asc')->get();
        $province = DB::table('province')->where('region_c', $spot_report_header[0]->region_c)->orderby('province_m', 'asc')->get();
        $city = DB::table('city')->where('province_c', $spot_report_header[0]->province_c)->orderby('city_m', 'asc')->get();
        $barangay = DB::table('barangay')->where('city_c', $spot_report_header[0]->city_c)->orderby('barangay_m', 'asc')->get();
        $operation_type = DB::table('operation_type')->where('status', true)->orderby('name', 'asc')->get();
        $suspect_information = DB::table('spot_report_suspect as a')
            ->select('a.suspect_number', 'a.lastname', 'a.firstname', 'a.middlename', 'a.alias')
            ->where('a.spot_report_number', $spot_report_header[0]->spot_report_number)
            ->orderby('lastname', 'asc')->get();
        $case = DB::table('case_list')->where('status', true)->orderby('description', 'asc')->get();

        $civil_status = DB::table('civil_status')->where('active', true)->orderby('name', 'asc')->get();
        $religion = DB::table('religions')->where('active', true)->orderby('name', 'asc')->get();
        $education = DB::table('Educational_attainment')->where('status', true)->orderby('name', 'asc')->get();
        $ethnic_group = DB::table('ethnic_group')->where('status', true)->orderby('name', 'asc')->get();
        $nationality = DB::table('nationality')->where('status', true)->orderby('name', 'asc')->get();
        $occupation = DB::table('occupation')->where('status', true)->orderby('name', 'asc')->get();
        $suspect_status = DB::table('suspect_status')->where('status', true)->orderby('name', 'asc')->get();
        $suspect_classification = DB::table('suspect_classification')->where('status', true)->orderby('name', 'asc')->get();
        $suspect_category = DB::table('suspect_category')->where('status', true)->orderby('name', 'asc')->get();
        $support_unit = DB::table('support_unit')->where('status', true)->orderby('name', 'asc')->get();
        $preops_support_unit = DB::table('spot_report_support_unit as a')
            ->leftjoin('operating_unit as b', 'a.support_unit_id', '=', 'b.id')
            ->where('spot_report_number', $spot_report_header[0]->spot_report_number)
            ->get();
        $spot_report_files = DB::table('spot_report_files')->where('spot_report_number', $spot_report_header[0]->spot_report_number)->get();
        $regional_user = DB::table('users')->where('user_level_id', 3)->get();
        $evidence = DB::table('evidence')->where('status', true)->orderby('name', 'asc')->get();
        $packaging = DB::table('packaging')->where('status', true)->orderby('name', 'asc')->get();
        $unit_measurement = DB::table('unit_measurement')->where('status', true)->orderby('name', 'asc')->get();
        $is_warrant = DB::table('operation_type')
            ->where('id', $spot_report_header[0]->operation_type_id)
            ->get();
        $report_header = DB::table('spot_report_header')->orderby('report_header', 'asc')->get();
        $hio_type = DB::table('hio_type')->where('status', true)->orderby('name', 'asc')->get();
        $identifier = DB::table('identifier')->where('status', true)->orderby('name', 'asc')->get();
        $suspect_sub_category = DB::table('suspect_sub_category')->where('status', true)->orderby('name', 'asc')->get();

        return view('spot_report.spot_report_edit', compact(
            'report_header',
            'packaging',
            'suspect_category',
            'is_warrant',
            'unit_measurement',
            'evidence',
            'suspect_classification',
            'preops_support_unit',
            'support_unit',
            'civil_status',
            'religion',
            'education',
            'ethnic_group',
            'nationality',
            'occupation',
            'spot_report_evidence',
            'spot_report_case',
            'spot_report_team',
            'spot_report_summary',
            'spot_report_header',
            'region',
            'province',
            'city',
            'barangay',
            'operation_type',
            'suspect_information',
            'case',
            'suspect_status',
            'spot_report_files',
            'regional_user',
            'hio_type',
            'identifier',
            'suspect_sub_category',
            'operating_unit',
            'suspects'
        ));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $data = $request->all();
        // dd(isset($data['suspect_number_item']));
        date_default_timezone_set('Asia/Manila');

        if (Auth::user()->user_level_id == 2) {
            $pos_data = array(
                'operation_type_id' => $request->operation_type_id,
                'reported_date' => $request->reported_date,
                'region_c' => $request->region_c,
                'province_c' => $request->province_c,
                'city_c' => $request->city_c,
                'barangay_c' => $request->barangay_c,
                'street' => $request->street,
                'preops_number' => $request->preops_number,
                'operating_unit_id' => $request->operating_unit_id,
                'operation_datetime' => $request->operation_datetime,
                'warrant_number' => $request->warrant_number,
                'judge_name' => $request->judge_name,
                'branch' => $request->branch,
                'prepared_by' => $request->prepared_by,
                'approved_by' => $request->approved_by,
                // 'support_unit_id' => $request->support_unit_id,
                'status' => true,
                'report_header' => $request->report_header,
                'summary' => $request->summary,
                'operation_lvl' => $request->has('operation_lvl') ? true : false,
                'reference_number' => $request->reference_number,
                'updated_at' => Carbon::now(),
                'hio_type_id' => $request->hio_type_id,
            );


            DB::table('spot_report_header')->where('id', $id)->update($pos_data);

            if ($request->hasfile('fileattach')) {
                foreach ($request->file('fileattach') as $file) {
                    $filename = $file->getClientOriginalName();
                    // $filename = pathinfo($fileinfo, PATHINFO_FILENAME);
                    $filePath = public_path() . '/files/uploads/spot_reports/';
                    $file->move($filePath, $filename);

                    $file_data = array(
                        'spot_report_number' => $request->spot_report_number,
                        'filenames' => $filename,
                    );
                    $file_id = DB::table('spot_report_files')->insertGetId($file_data);

                    date_default_timezone_set('Asia/Manila');
                    $date = Carbon::now();

                    $file_upload = array(
                        'spot_report_file_id' => $file_id,
                        'filename' => $filename,
                        'transaction_type' => 3,
                        'created_at' => $date,
                    );

                    DB::table('file_upload_list')->insert($file_upload);
                }
            }

            if (isset($data['spot_suspect_id'])) {

                DB::table('spot_report_suspect')->where('spot_report_number', $request->spot_report_number)->whereNotIn('id', array_filter($data['spot_suspect_id']))->delete();

                $spot_suspect = [];

                for ($i = 0; $i < count($data['spot_suspect_id']); $i++) {
                    if ($data['suspect_status_id'][$i] != 2 && $data['suspect_status_id'][$i] != 0) {
                        if ($data['spot_suspect_id'][$i] == 0) {

                            // Auto SUspect Number
                            $suspect_number = 0 + DB::table('suspect_information')
                                ->whereDate('created_at', Carbon::now()->format('Y-m-d'))
                                ->count();
                            $suspect_number += 1;
                            $suspect_number = sprintf("%04s", $suspect_number);
                            $date = Carbon::now()->format('mdY');

                            $suspect_number = $date . "-" . $suspect_number;

                            $id = 0 + DB::table('spot_report_suspect')->max('id');
                            $id += 1;

                            $sid = 0 + DB::table('suspect_information')->max('id');
                            $sid += 1;

                            $spot_suspect = [
                                'suspect_number' => $suspect_number,
                                'spot_report_number' => $request->spot_report_number,
                                'lastname' => $data['lastname'][$i],
                                'firstname' => $data['firstname'][$i],
                                'middlename' => $data['middlename'][$i],
                                'alias' => $data['alias'][$i],
                                'gender' => $data['gender'][$i],
                                'birthdate' => $data['birthdate'][$i],
                                'birthplace' => $data['birthplace'][$i],
                                'nationality_id' => $data['nationality_id'][$i],
                                'civil_status_id' => $data['civil_status_id'][$i],
                                'religion_id' => $data['religion_id'][$i],
                                'educational_attainment_id' => $data['educational_attainment_id'][$i],
                                'ethnic_group_id' => $data['ethnic_group_id'][$i],
                                'occupation_id' => $data['occupation_id'][$i],
                                'identifier_id' => $data['identifier_id'][$i],
                                'region_c' => $data['present_region_c'][$i],
                                'province_c' => $data['present_province_c'][$i],
                                'city_c' => $data['present_city_c'][$i],
                                'barangay_c' => $data['present_barangay_c'][$i],
                                'street' => $data['present_street'][$i],
                                'permanent_region_c' => $data['permanent_region_c'][$i],
                                'permanent_province_c' => $data['permanent_province_c'][$i],
                                'permanent_city_c' => $data['permanent_city_c'][$i],
                                'permanent_barangay_c' => $data['permanent_barangay_c'][$i],
                                'permanent_street' => $data['permanent_street'][$i],
                                'suspect_status_id' => $data['suspect_status_id'][$i],
                                'suspect_classification_id' => $data['suspect_classification_id'][$i],
                                'suspect_category_id' => $data['suspect_category_id'][$i],
                                'suspect_sub_category_id' => $data['suspect_sub_category_id'][$i],
                                'remarks' => $data['remarks'][$i],
                                'status' => true,
                                'created_at' => Carbon::now()->format('Y-m-d'),
                                'est_birthdate' => $data['est_birthdate'][$i],
                                'whereabouts' => $data['whereabouts'][$i],
                            ];

                            $suspect_information = [
                                'suspect_number' => $suspect_number,
                                'lastname' => $data['lastname'][$i],
                                'firstname' => $data['firstname'][$i],
                                'middlename' => $data['middlename'][$i],
                                'alias' => $data['alias'][$i],
                                'gender' => $data['gender'][$i],
                                'birthdate' => $data['birthdate'][$i],
                                'birthplace' => $data['birthplace'][$i],
                                'nationality_id' => $data['nationality_id'][$i],
                                'civil_status_id' => $data['civil_status_id'][$i],
                                'religion_id' => $data['religion_id'][$i],
                                'educational_attainment_id' => $data['educational_attainment_id'][$i],
                                'ethnic_group_id' => $data['ethnic_group_id'][$i],
                                'occupation_id' => $data['occupation_id'][$i],
                                'identifier_id' => $data['identifier_id'][$i],
                                'operation_region' => $request->region_c,
                                'region_c' => $data['present_region_c'][$i],
                                'province_c' => $data['present_province_c'][$i],
                                'city_c' => $data['present_city_c'][$i],
                                'barangay_c' => $data['present_barangay_c'][$i],
                                'street' => $data['present_street'][$i],
                                'permanent_region_c' => $data['permanent_region_c'][$i],
                                'permanent_province_c' => $data['permanent_province_c'][$i],
                                'permanent_city_c' => $data['permanent_city_c'][$i],
                                'permanent_barangay_c' => $data['permanent_barangay_c'][$i],
                                'permanent_street' => $data['permanent_street'][$i],
                                'status' => true,
                                'operating_unit_id' => $request->operating_unit_id,
                                'created_at' => Carbon::now()->format('Y-m-d'),
                                'est_birthdate' => $data['est_birthdate'][$i],
                                'whereabouts' => $data['whereabouts'][$i],
                            ];

                            DB::table('spot_report_suspect')->updateOrInsert(['id' => $id], $spot_suspect);
                            DB::table('suspect_information')->updateOrInsert(['id' => $sid], $suspect_information);
                        } else if ($data['spot_suspect_id'] > 0) {
                            $id = $data['spot_suspect_id'][$i];

                            $spot_suspect = [
                                'suspect_number' => $data['suspect_number'][$i],
                                'spot_report_number' => $request->spot_report_number,
                                'lastname' => $data['lastname'][$i],
                                'firstname' => $data['firstname'][$i],
                                'middlename' => $data['middlename'][$i],
                                'alias' => $data['alias'][$i],
                                'gender' => $data['gender'][$i],
                                'birthdate' => $data['birthdate'][$i],
                                'birthplace' => $data['birthplace'][$i],
                                'nationality_id' => $data['nationality_id'][$i],
                                'civil_status_id' => $data['civil_status_id'][$i],
                                'religion_id' => $data['religion_id'][$i],
                                'educational_attainment_id' => $data['educational_attainment_id'][$i],
                                'ethnic_group_id' => $data['ethnic_group_id'][$i],
                                'occupation_id' => $data['occupation_id'][$i],
                                'identifier_id' => $data['identifier_id'][$i],
                                'region_c' => $data['present_region_c'][$i],
                                'province_c' => $data['present_province_c'][$i],
                                'city_c' => $data['present_city_c'][$i],
                                'barangay_c' => $data['present_barangay_c'][$i],
                                'street' => $data['present_street'][$i],
                                'permanent_region_c' => $data['permanent_region_c'][$i],
                                'permanent_province_c' => $data['permanent_province_c'][$i],
                                'permanent_city_c' => $data['permanent_city_c'][$i],
                                'permanent_barangay_c' => $data['permanent_barangay_c'][$i],
                                'permanent_street' => $data['permanent_street'][$i],
                                'suspect_status_id' => $data['suspect_status_id'][$i],
                                'suspect_classification_id' => $data['suspect_classification_id'][$i],
                                'suspect_category_id' => $data['suspect_category_id'][$i],
                                'suspect_sub_category_id' => $data['suspect_sub_category_id'][$i],
                                'remarks' => $data['remarks'][$i],
                                'status' => true,
                                'updated_at' => Carbon::now()->format('Y-m-d'),
                                'est_birthdate' => $data['est_birthdate'][$i],
                                'whereabouts' => $data['whereabouts'][$i],

                            ];

                            $suspect_information = [
                                'suspect_number' => $data['suspect_number'][$i],
                                'lastname' => $data['lastname'][$i],
                                'firstname' => $data['firstname'][$i],
                                'middlename' => $data['middlename'][$i],
                                'alias' => $data['alias'][$i],
                                'gender' => $data['gender'][$i],
                                'birthdate' => $data['birthdate'][$i],
                                'birthplace' => $data['birthplace'][$i],
                                'nationality_id' => $data['nationality_id'][$i],
                                'civil_status_id' => $data['civil_status_id'][$i],
                                'religion_id' => $data['religion_id'][$i],
                                'educational_attainment_id' => $data['educational_attainment_id'][$i],
                                'ethnic_group_id' => $data['ethnic_group_id'][$i],
                                'occupation_id' => $data['occupation_id'][$i],
                                'identifier_id' => $data['identifier_id'][$i],
                                'operation_region' => $request->region_c,
                                'region_c' => $data['present_region_c'][$i],
                                'province_c' => $data['present_province_c'][$i],
                                'city_c' => $data['present_city_c'][$i],
                                'barangay_c' => $data['present_barangay_c'][$i],
                                'street' => $data['present_street'][$i],
                                'permanent_region_c' => $data['permanent_region_c'][$i],
                                'permanent_province_c' => $data['permanent_province_c'][$i],
                                'permanent_city_c' => $data['permanent_city_c'][$i],
                                'permanent_barangay_c' => $data['permanent_barangay_c'][$i],
                                'permanent_street' => $data['permanent_street'][$i],
                                'status' => true,
                                'operating_unit_id' => $request->operating_unit_id,
                                'updated_at' => Carbon::now()->format('Y-m-d'),
                                'est_birthdate' => $data['est_birthdate'][$i],
                                'whereabouts' => $data['whereabouts'][$i],
                            ];

                            DB::table('spot_report_suspect')->updateOrInsert(['id' => $id], $spot_suspect);
                            DB::table('suspect_information')->updateOrInsert(['suspect_number' => $data['suspect_number'][$i]], $suspect_information);
                        }
                    } else {
                        if ($data['lastname'][$i] != null  || $data['firstname'][$i] != null  || $data['alias'][$i] != null) {
                            if ($data['spot_suspect_id'][$i] == 0) {

                                // Auto SUspect Number
                                $suspect_number = 0 + DB::table('suspect_information')
                                    ->whereDate('created_at', Carbon::now()->format('Y-m-d'))
                                    ->count();
                                $suspect_number += 1;
                                $suspect_number = sprintf("%04s", $suspect_number);
                                $date = Carbon::now()->format('mdY');

                                $suspect_number = $date . "-" . $suspect_number;

                                $id = 0 + DB::table('spot_report_suspect')->max('id');
                                $id += 1;

                                $spot_suspect = [
                                    'suspect_number' => $suspect_number,
                                    'spot_report_number' => $request->spot_report_number,
                                    'lastname' => $data['lastname'][$i],
                                    'firstname' => $data['firstname'][$i],
                                    'middlename' => $data['middlename'][$i],
                                    'alias' => $data['alias'][$i],
                                    'gender' => $data['gender'][$i],
                                    'birthdate' => $data['birthdate'][$i],
                                    'birthplace' => $data['birthplace'][$i],
                                    'nationality_id' => $data['nationality_id'][$i],
                                    'civil_status_id' => $data['civil_status_id'][$i],
                                    'religion_id' => $data['religion_id'][$i],
                                    'educational_attainment_id' => $data['educational_attainment_id'][$i],
                                    'ethnic_group_id' => $data['ethnic_group_id'][$i],
                                    'occupation_id' => $data['occupation_id'][$i],
                                    'identifier_id' => $data['identifier_id'][$i],
                                    'region_c' => $data['present_region_c'][$i],
                                    'province_c' => $data['present_province_c'][$i],
                                    'city_c' => $data['present_city_c'][$i],
                                    'barangay_c' => $data['present_barangay_c'][$i],
                                    'street' => $data['present_street'][$i],
                                    'permanent_region_c' => $data['permanent_region_c'][$i],
                                    'permanent_province_c' => $data['permanent_province_c'][$i],
                                    'permanent_city_c' => $data['permanent_city_c'][$i],
                                    'permanent_barangay_c' => $data['permanent_barangay_c'][$i],
                                    'permanent_street' => $data['permanent_street'][$i],
                                    'suspect_status_id' => $data['suspect_status_id'][$i],
                                    'suspect_classification_id' => $data['suspect_classification_id'][$i],
                                    'suspect_category_id' => $data['suspect_category_id'][$i],
                                    'suspect_sub_category_id' => $data['suspect_sub_category_id'][$i],
                                    'remarks' => $data['remarks'][$i],
                                    'status' => true,
                                    'created_at' => Carbon::now()->format('Y-m-d'),
                                    'est_birthdate' => $data['est_birthdate'][$i],
                                    'whereabouts' => $data['whereabouts'][$i],
                                ];

                                $suspect_information = [
                                    'suspect_number' => $suspect_number,
                                    'lastname' => $data['lastname'][$i],
                                    'firstname' => $data['firstname'][$i],
                                    'middlename' => $data['middlename'][$i],
                                    'alias' => $data['alias'][$i],
                                    'gender' => $data['gender'][$i],
                                    'birthdate' => $data['birthdate'][$i],
                                    'birthplace' => $data['birthplace'][$i],
                                    'nationality_id' => $data['nationality_id'][$i],
                                    'civil_status_id' => $data['civil_status_id'][$i],
                                    'religion_id' => $data['religion_id'][$i],
                                    'educational_attainment_id' => $data['educational_attainment_id'][$i],
                                    'ethnic_group_id' => $data['ethnic_group_id'][$i],
                                    'occupation_id' => $data['occupation_id'][$i],
                                    'operation_region' => $request->region_c,
                                    'region_c' => $data['present_region_c'][$i],
                                    'province_c' => $data['present_province_c'][$i],
                                    'city_c' => $data['present_city_c'][$i],
                                    'barangay_c' => $data['present_barangay_c'][$i],
                                    'street' => $data['present_street'][$i],
                                    'permanent_region_c' => $data['permanent_region_c'][$i],
                                    'permanent_province_c' => $data['permanent_province_c'][$i],
                                    'permanent_city_c' => $data['permanent_city_c'][$i],
                                    'permanent_barangay_c' => $data['permanent_barangay_c'][$i],
                                    'permanent_street' => $data['permanent_street'][$i],
                                    'status' => true,
                                    'operating_unit_id' => $request->operating_unit_id,
                                    'created_at' => Carbon::now()->format('Y-m-d'),
                                    'est_birthdate' => $data['est_birthdate'][$i],
                                    'whereabouts' => $data['whereabouts'][$i],
                                ];

                                DB::table('spot_report_suspect')->updateOrInsert(['id' => $id], $spot_suspect);
                                DB::table('suspect_information')->updateOrInsert(['suspect_number' => $data['suspect_number'][$i]], $suspect_information);
                            } else if ($data['spot_suspect_id'] > 0) {
                                $id = $data['spot_suspect_id'][$i];

                                $spot_suspect = [
                                    'suspect_number' => $data['suspect_number'][$i],
                                    'spot_report_number' => $request->spot_report_number,
                                    'lastname' => $data['lastname'][$i],
                                    'firstname' => $data['firstname'][$i],
                                    'middlename' => $data['middlename'][$i],
                                    'alias' => $data['alias'][$i],
                                    'gender' => $data['gender'][$i],
                                    'birthdate' => $data['birthdate'][$i],
                                    'birthplace' => $data['birthplace'][$i],
                                    'nationality_id' => $data['nationality_id'][$i],
                                    'civil_status_id' => $data['civil_status_id'][$i],
                                    'religion_id' => $data['religion_id'][$i],
                                    'educational_attainment_id' => $data['educational_attainment_id'][$i],
                                    'ethnic_group_id' => $data['ethnic_group_id'][$i],
                                    'occupation_id' => $data['occupation_id'][$i],
                                    'identifier_id' => $data['identifier_id'][$i],
                                    'region_c' => $data['present_region_c'][$i],
                                    'province_c' => $data['present_province_c'][$i],
                                    'city_c' => $data['present_city_c'][$i],
                                    'barangay_c' => $data['present_barangay_c'][$i],
                                    'street' => $data['present_street'][$i],
                                    'permanent_region_c' => $data['permanent_region_c'][$i],
                                    'permanent_province_c' => $data['permanent_province_c'][$i],
                                    'permanent_city_c' => $data['permanent_city_c'][$i],
                                    'permanent_barangay_c' => $data['permanent_barangay_c'][$i],
                                    'permanent_street' => $data['permanent_street'][$i],
                                    'suspect_status_id' => $data['suspect_status_id'][$i],
                                    'suspect_classification_id' => $data['suspect_classification_id'][$i],
                                    'suspect_category_id' => $data['suspect_category_id'][$i],
                                    'suspect_sub_category_id' => $data['suspect_sub_category_id'][$i],
                                    'remarks' => $data['remarks'][$i],
                                    'status' => true,
                                    'updated_at' => Carbon::now()->format('Y-m-d'),
                                    'est_birthdate' => $data['est_birthdate'][$i],
                                    'whereabouts' => $data['whereabouts'][$i],

                                ];

                                $suspect_information = [
                                    'suspect_number' => $data['suspect_number'][$i],
                                    'lastname' => $data['lastname'][$i],
                                    'firstname' => $data['firstname'][$i],
                                    'middlename' => $data['middlename'][$i],
                                    'alias' => $data['alias'][$i],
                                    'gender' => $data['gender'][$i],
                                    'birthdate' => $data['birthdate'][$i],
                                    'birthplace' => $data['birthplace'][$i],
                                    'nationality_id' => $data['nationality_id'][$i],
                                    'civil_status_id' => $data['civil_status_id'][$i],
                                    'religion_id' => $data['religion_id'][$i],
                                    'educational_attainment_id' => $data['educational_attainment_id'][$i],
                                    'ethnic_group_id' => $data['ethnic_group_id'][$i],
                                    'occupation_id' => $data['occupation_id'][$i],
                                    'identifier_id' => $data['identifier_id'][$i],
                                    'operation_region' => $request->region_c,
                                    'region_c' => $data['present_region_c'][$i],
                                    'province_c' => $data['present_province_c'][$i],
                                    'city_c' => $data['present_city_c'][$i],
                                    'barangay_c' => $data['present_barangay_c'][$i],
                                    'street' => $data['present_street'][$i],
                                    'permanent_region_c' => $data['permanent_region_c'][$i],
                                    'permanent_province_c' => $data['permanent_province_c'][$i],
                                    'permanent_city_c' => $data['permanent_city_c'][$i],
                                    'permanent_barangay_c' => $data['permanent_barangay_c'][$i],
                                    'permanent_street' => $data['permanent_street'][$i],
                                    'status' => true,
                                    'operating_unit_id' => $request->operating_unit_id,
                                    'updated_at' => Carbon::now()->format('Y-m-d'),
                                    'est_birthdate' => $data['est_birthdate'][$i],
                                    'whereabouts' => $data['whereabouts'][$i],
                                ];

                                DB::table('spot_report_suspect')->updateOrInsert(['id' => $id], $spot_suspect);
                                DB::table('suspect_information')->updateOrInsert(['suspect_number' => $data['suspect_number'][$i]], $suspect_information);
                            }
                        }
                    }
                }
            }

            if (isset($data['support_unit_id'])) {
                $spot_su = [];

                DB::table('spot_report_support_unit')->where('spot_report_number', $request->spot_report_number)->delete();

                for ($i = 0; $i < count($data['support_unit_id']); $i++) {
                    if ($data['support_unit_id'][$i] != NULL) {

                        $spot_su = [
                            'spot_report_number' => $request->spot_report_number,
                            'support_unit_id' => $data['support_unit_id'][$i],
                        ];

                        DB::table('spot_report_support_unit')->Insert($spot_su);
                    }
                }
            }

            if (empty($data['suspect_number'])) {
                // dd('test');
                DB::table('spot_report_suspect')->delete();
            }

            //Save Item Seized
            if (isset($data['suspect_number_item'])) {
                // dd('test1');
                $spot_item = [];
                DB::table('spot_report_evidence')->delete();

                for ($i = 0; $i < count($data['suspect_number_item']); $i++) {
                    if ($data['suspect_number_item'][$i] != NULL && $data['evidence_id'][$i] != NULL) {

                        if ($data['spot_evidence_id'][$i] == null) {
                            $sdata = explode(",", $data['suspect_number_item'][$i]);

                            if (isset($sdata[0])) {
                                $suspect_number1 = $sdata[0];
                            }

                            if (isset($sdata[1])) {
                                $lastname = $sdata[0];
                                $firstname = $sdata[1];
                                $middlename = $sdata[2];
                                $alias = $sdata[3];
                                $birthdate = $sdata[4];

                                $query = DB::table('spot_report_suspect')
                                    ->select('suspect_number');

                                if ($lastname != null) {
                                    $query->where('lastname', $lastname);
                                }
                                if ($firstname != null) {
                                    $query->where('firstname', $firstname);
                                }
                                if ($middlename != null) {
                                    $query->where('middlename', $middlename);
                                }
                                if ($alias != null) {
                                    $query->where('alias', $alias);
                                }
                                if ($birthdate != null) {
                                    $query->where('birthdate', $birthdate);
                                }

                                $suspect_data = $query->get();

                                $suspect_number1 = $suspect_data[0]->suspect_number;
                            }


                            $suspect_number = $suspect_number1;
                        } else if ($data['spot_evidence_id'] > 0) {
                            $suspect_number = $data['suspect_number_item'][$i];
                            $sdata = explode(",", $data['suspect_number_item'][$i]);
                            $lastname = $sdata[0];

                            if (isset($sdata[1])) {
                                $firstname = $sdata[1];
                                $middlename = $sdata[2];
                                $alias = $sdata[3];
                                $birthdate = $sdata[4];

                                $query = DB::table('spot_report_suspect')
                                    ->select('suspect_number');

                                if ($lastname != null) {
                                    $query->where('lastname', $lastname);
                                }
                                if ($firstname != null) {
                                    $query->where('firstname', $firstname);
                                }
                                if ($middlename != null) {
                                    $query->where('middlename', $middlename);
                                }
                                if ($alias != null) {
                                    $query->where('alias', $alias);
                                }
                                if ($birthdate != null) {
                                    $query->where('birthdate', $birthdate);
                                }

                                $suspect_data = $query->get();

                                $suspect_number1 = $suspect_data[0]->suspect_number;
                            }
                        }

                        $id = 0 + DB::table('spot_report_evidence')->max('id');
                        $id += 1;

                        $spot_item = [
                            'suspect_number' => $suspect_number,
                            'evidence_id' => $data['evidence_id'][$i],
                            'quantity' => $data['quantity'][$i],
                            'unit' => $data['unit_measurement_id'][$i],
                            'packaging_id' => $data['packaging_id'][$i],
                            'spot_report_number' => $request->spot_report_number,
                            'drug' => $data['drug'][$i],
                            'markings' => $data['markings'][$i],
                        ];

                        DB::table('spot_report_evidence')->updateOrInsert(['id' => $id], $spot_item);
                    }
                }
            }

            if (empty($data['suspect_number_item'])) {
                // dd('test');
                DB::table('spot_report_evidence')->delete();
            }

            //Save Suspect Case
            if (isset($data['suspect_number_case'])) {
                $spot_case = [];
                DB::table('spot_report_case')->delete();

                for ($i = 0; $i < count($data['case_id']); $i++) {
                    if ($data['case_id'][$i] != NULL && $data['suspect_number_case'][$i] != NULL) {

                        // if ($data['spot_case_id'][$i] == null) {
                        //     $sdata = explode(",", $data['suspect_number_case'][$i]);
                        //     $lastname = $sdata[0];
                        //     $firstname = $sdata[1];
                        //     $middlename = $sdata[2];
                        //     $alias = $sdata[3];
                        //     $birthdate = $sdata[4];

                        //     $suspect_data = DB::table('spot_report_suspect')
                        //         ->where('lastname', $lastname)
                        //         ->where('firstname', $firstname)
                        //         ->where('middlename', $middlename)
                        //         ->where('alias', $alias)
                        //         ->where('birthdate', $birthdate)
                        //         ->select('suspect_number')
                        //         ->get();
                        //     $suspect_number = $suspect_data[0]->suspect_number;
                        // } else if ($data['spot_case_id'] > 0) {
                        //     $suspect_number = $data['suspect_number_case'][$i];
                        // }

                        if ($data['spot_case_id'][$i] == null) {
                            $sdata = explode(",", $data['suspect_number_case'][$i]);

                            if (isset($sdata[0])) {
                                $suspect_number1 = $sdata[0];
                            }

                            if (isset($sdata[1])) {
                                $lastname = $sdata[0];
                                $firstname = $sdata[1];
                                $middlename = $sdata[2];
                                $alias = $sdata[3];
                                $birthdate = $sdata[4];

                                $query = DB::table('spot_report_suspect')
                                    ->select('suspect_number');

                                if ($lastname != null) {
                                    $query->where('lastname', $lastname);
                                }
                                if ($firstname != null) {
                                    $query->where('firstname', $firstname);
                                }
                                if ($middlename != null) {
                                    $query->where('middlename', $middlename);
                                }
                                if ($alias != null) {
                                    $query->where('alias', $alias);
                                }
                                if ($birthdate != null) {
                                    $query->where('birthdate', $birthdate);
                                }

                                $suspect_data = $query->get();

                                $suspect_number1 = $suspect_data[0]->suspect_number;
                            }


                            $suspect_number = $suspect_number1;
                        } else if ($data['spot_case_id'] > 0) {
                            $suspect_number = $data['suspect_number_case'][$i];
                            $sdata = explode(",", $data['suspect_number_case'][$i]);
                            $lastname = $sdata[0];

                            if (isset($sdata[1])) {
                                $firstname = $sdata[1];
                                $middlename = $sdata[2];
                                $alias = $sdata[3];
                                $birthdate = $sdata[4];

                                $query = DB::table('spot_report_suspect')
                                    ->select('suspect_number');

                                if ($lastname != null) {
                                    $query->where('lastname', $lastname);
                                }
                                if ($firstname != null) {
                                    $query->where('firstname', $firstname);
                                }
                                if ($middlename != null) {
                                    $query->where('middlename', $middlename);
                                }
                                if ($alias != null) {
                                    $query->where('alias', $alias);
                                }
                                if ($birthdate != null) {
                                    $query->where('birthdate', $birthdate);
                                }

                                $suspect_data = $query->get();

                                $suspect_number1 = $suspect_data[0]->suspect_number;
                            }
                        }


                        $id = 0 + DB::table('spot_report_case')->max('id');
                        $id += 1;

                        $spot_case = [
                            'suspect_number' => $suspect_number,
                            'case_id' => $data['case_id'][$i],
                            'spot_report_number' => $request->spot_report_number,
                        ];

                        DB::table('spot_report_case')->updateOrInsert(['id' => $id], $spot_case);
                    }
                }
            }



            //Save Operation Team
            $spot_team = [];

            DB::table('spot_report_team')->whereNotIn('id', array_filter($data['spot_team_id']))->delete();

            for ($i = 0; $i < count($data['officer_name']); $i++) {
                if ($data['officer_name'][$i] != NULL) {

                    if ($data['spot_team_id'][$i] == null || $data['spot_team_id'][$i] == 0) {
                        $id = 0 + DB::table('spot_report_team')->max('id');
                        $id += 1;
                    } else {
                        $id = $data['spot_team_id'][$i];
                    }

                    $spot_team = [
                        'officer_name' => $data['officer_name'][$i],
                        'officer_position' => $data['officer_position'][$i],
                        'spot_report_number' => $request->spot_report_number,
                    ];

                    DB::table('spot_report_team')->updateOrInsert(['id' => $id], $spot_team);
                }
            }
        } elseif (Auth::user()->user_level_id == 3) {
            if ($request->hasfile('fileattach')) {
                foreach ($request->file('fileattach') as $file) {
                    $filename = $file->getClientOriginalName();
                    // $filename = pathinfo($fileinfo, PATHINFO_FILENAME);
                    $filePath = public_path() . '/files/uploads/spot_reports/';
                    $file->move($filePath, $filename);

                    $file_data = array(
                        'spot_report_number' => $request->spot_report_number,
                        'filenames' => $filename,
                    );
                    $file_id = DB::table('spot_report_files')->insertGetId($file_data);

                    date_default_timezone_set('Asia/Manila');
                    $date = Carbon::now();

                    $file_upload = array(
                        'spot_report_file_id' => $file_id,
                        'filename' => $filename,
                        'transaction_type' => 3,
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
            'description' => 'Updated ' . $request->name . ' on spot report setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated spot report!');
    }

    public function get_spot_report_item_seized($spot_report_number)
    {
        $data = DB::table('spot_report_evidence')
            ->where(['spot_report_number' => $spot_report_number])
            ->get();

        return json_encode($data);
    }

    public function fileDelete($id)
    {
        $fileinfo = DB::table('spot_report_files')->where('id', $id)->get();
        if (File::exists('/files/uploads/spot_reports/' . $fileinfo[0]->filenames)) {
            unlink(public_path('/files/uploads/spot_reports/' . $fileinfo[0]->filenames));
        }
        DB::table('spot_report_files')->where('id', $id)->delete();

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Spot Report',
            'menu'    => 'Spot Report Module',
            'activity' => 'Delete',
            'description' => 'Deleted reference file.',
        );

        Audit::create($data_audit);

        return response()->json(array('success' => true));
    }

    function get_spot_report($id)
    {
        $spot_report = DB::table('spot_report_header')
            ->where('id', $id)
            ->get();
        return $spot_report;
    }

    function pdf($id)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convert_spot_report_to_html($id));
        return $pdf->stream();
    }

    // Print PDF Format
    function convert_spot_report_to_html($id)
    {
        date_default_timezone_set('Asia/Manila');
        $date = Carbon::now();

        $pos_data = array(
            'print_count' => DB::raw('print_count+1'),
            'print_date' => $date,
        );
        DB::table('spot_report_header')->where('id', $id)->update($pos_data);

        $spot_report = $this->get_spot_report($id);

        if ($spot_report[0]->preops_number == 1) {
            $regional_office = DB::table('regional_office as a')
                ->leftjoin('spot_report_header as b', 'a.region_c', '=', 'b.region_c')
                ->select('a.name', 'a.address', 'a.contact_number', 'a.report_header')
                ->where('b.region_c', $spot_report[0]->region_c)->get();
        } else {
            $regional_office = DB::table('regional_office as a')
                ->leftjoin('preops_header as b', 'a.ro_code', '=', 'b.ro_code')
                ->select('a.name', 'a.address', 'a.contact_number', 'a.report_header')
                ->where('b.preops_number', $spot_report[0]->preops_number)->get();
        }

        $region = DB::table('region')->where('region_c', $spot_report[0]->region_c)->get();
        $province = DB::table('province')->where('province_c', $spot_report[0]->province_c)->get();
        $city = DB::table('city')->where('city_c', $spot_report[0]->city_c)->get();
        $barangay = DB::table('barangay')->where('barangay_c', $spot_report[0]->barangay_c)->get();
        $operating_unit = DB::table('operating_unit')->where('id', $spot_report[0]->operating_unit_id)->get();
        $operation_type = DB::table('operation_type')->where('id', $spot_report[0]->operation_type_id)->get();
        $evidence = DB::table('spot_report_evidence as a')
            ->leftjoin('spot_report_header as b', 'a.spot_report_number', '=', 'b.spot_report_number')
            ->leftjoin('evidence as c', 'a.evidence_id', '=', 'c.id')
            ->leftjoin('unit_measurement as d', 'a.unit', '=', 'd.id')
            ->leftjoin('packaging as e', 'a.packaging_id', '=', 'e.id')
            ->select('c.name as evidence_type', 'd.name as unit_measurement', 'a.evidence', 'a.quantity', 'e.name as packaging')
            ->where('b.id', $id)->get();

        $case = DB::table('spot_report_case as a')
            ->leftjoin('spot_report_header as b', 'a.spot_report_number', '=', 'b.spot_report_number')
            ->leftjoin('case_list as c', 'a.case_id', '=', 'c.id')
            ->leftjoin('spot_report_suspect as d', 'a.suspect_number', '=', 'd.suspect_number')
            ->select('c.description as case', 'd.lastname', 'd.firstname', 'd.middlename')
            ->where('b.id', $id)->get();
        $team = DB::table('spot_report_team as a')
            ->leftjoin('spot_report_header as b', 'a.spot_report_number', '=', 'b.spot_report_number')
            ->where('b.id', $id)->get();
        $support_unit = DB::table('spot_report_support_unit as a')
            ->leftjoin('operating_unit as b', 'a.support_unit_id', '=', 'b.id')
            ->where('a.spot_report_number', $spot_report[0]->spot_report_number)
            ->select('b.description')
            ->get();

        if ($spot_report[0]->preops_number == 1) {
            $preops_number = 'Uncoordinated';
        } else {
            $preops_number = $spot_report[0]->preops_number;
        }



        // Header
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
                    color: blue;
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

                .arial {
                    font-family: Arial, Helvetica, sans-serif;
                  }
            </style>
        </head>
        <body>
            <!-- Define header and footer blocks before your content -->
            <header>
            CONFIDENTIAL
            </header>';


        $output .= '
                <img src="./files/uploads/report_header/' . $regional_office[0]->report_header . '" onerror=this.src="./files/uploads/report_header/newhead.jpg" class="col-3" style="width:100%;">
                <br>
                <br>
                <div style="text-align:center;"><h2 class="arial">' . $spot_report[0]->spot_report_number . '</h2></div>
                <div style="border:solid;" align="center"><span class="arial" style="font-size:20px">SPOT REPORT</span></div>
                <br>
                <table width="100%" style="border-collapse: collapse; border: 0px;">
                <tr style="border:none;">
                <td colspan="2" style="border: none; padding:0;" width="100%"><span class="arial" style="font-size:15px; margin-right:39px; margin-left:33px">Date Reported:</span><span>' . Carbon::createFromFormat('Y-m-d', $spot_report[0]->reported_date)->format('F d,Y') . '</span></td>
                </tr>
                <tr style="border:none;">
                <td colspan="2" style="border: none; padding:0;" width="100%"><span class="arial" style="font-size:15px; margin-right:28px; margin-left:33px;">Reporting Office:</span><span class="arial" style="font-weight:bold">' . $regional_office[0]->name . '</span></td>
                </tr>
                <tr style="border:none;">
                <td style="border: none; padding:0;" width="50%"><span class="arial" style="font-size:15px; margin-right:23px; margin-left:33px">Pre-Ops Number:</span><span class="arial" style="font-weight:bold">' . $preops_number . '</span></td>
                <td style="border: none; padding-left:20px;" width="50%"><span  style="margin-right:10px;">Date/Time of OPN:</span><span class="arial" style="font-weight:bold">' . Carbon::createFromFormat('Y-m-d H:i:s', $spot_report[0]->operation_datetime)->format('d F Y H:i:s') . '</span></td>
                </tr>
                </tr>
                <tr style="border:none;">
                <td colspan="2" style="border: none; padding:0;" width="100%"><span class="arial" style="font-size:15px; margin-right:17px; margin-left:33px">Type of Operation:</span><span class="arial" style="font-weight:bold">' . $operation_type[0]->name . '</span></td>
                </tr>
                </tr>
                <tr style="border:none;">
                <td style="border: none; padding:0;" width="50%"><span class="arial" style="font-size:15px; margin-right:39px; margin-left:33px">Operating Unit:</span><span class="arial" style="font-weight:bold">' . $operating_unit[0]->name . '</span></td>
                <td style="border: none; padding-left:20px;" width="50%"><span style="margin-right:10px;">Support Unit:</span><span class="arial" style="font-weight:bold; ">';


        $count = 0;
        foreach ($support_unit as $su) {
            $count++;
            if ($count == 1) {
                $output .= $su->description;
            } else {
                $output .= ', ' . $su->description;
            }
        }
        $output .= '</span>
        </td>
        </tr>
        </tr>
                <tr style="border:none;">
                <td colspan="2" style="border: none; padding:0;" width="100%"><span class="arial" style="font-size:15px; margin-right:17px; margin-left:33px;">Area of Operation:</span><span class="arial" style="font-weight:bold">' . $barangay[0]->barangay_m . ', ' . $city[0]->city_m . '</span></td>
                </tr>
                <tr style="border:none;">
                <td colspan="2" style="border: none; padding:0;" width="100%"><span class="arial" style="font-size:15px; margin-right:74px; margin-left:33px">Remarks:</span><span>' . $spot_report[0]->remarks . '</span></td>
                </tr>
        </table>

                <br>
                <table width="100%" style="border-collapse: collapse; border: 0px;">
                <tr style="border: 1px solid;">
                    <th class="arial" style="border: none; padding:0 12px;" width="25%" align="left">Qty</th>
                    <th class="arial" style="border: none; padding:0 12px;" width="25%" align="left">Evidence</th>
                    <th class="arial" style="border: none; padding:0 12px;" width="50%" align="left">Packaging</th>
                </tr>';

        // Evidence
        foreach ($evidence as $ar) {
            $output .= '
                <tr>
                    <td class="arial" style="border: none; padding:0 12px;" width="25%" align="left">' . $ar->quantity . ' ' . $ar->unit_measurement . '</td>
                    <td class="arial" style="border: none; padding:0 12px;" width="25%">' . $ar->evidence_type . ' - ' . $ar->evidence . '</td>
                    <td class="arial" style="border: none; padding:0 12px;" width="50%">' . $ar->packaging . '</td>
                </tr>';
        }
        $output .= '</table>';

        $output .= '
                <br>
                <table width="100%" style="border-collapse: collapse; border: 0px;">
                    <tr style="border: 1px solid;">
                        <th class="arial" style="border: none; padding:0 12px;" width="50%" align="left">Case(s) Filed</th>
                        <th class="arial" style="border: none; padding:0 12px;" width="50%" align="left">Name of Suspect</th>
                    </tr>';

        // Case
        foreach ($case as $cs) {
            $output .= '
                    <tr>
                        <td class="arial" style="border: none; padding:0 12px;" width="50%">' . $cs->case . '</td>
                        <td class="arial" style="border: none; padding:0 12px;" width="50%">' . $cs->lastname . ', ' . $cs->firstname . ' ' . $cs->middlename . '</td>
                    </tr>';
        }
        $output .= '</table>';

        $output .= '
                <br>
                <table width="100%" style="border-collapse: collapse; border: 0px;">
                    <tr style="border: 1px solid;">
                        <th class="arial" style="border: none; padding:0 12px;" width="50%" align="left">Operating Team Name</th>
                        <th class="arial" style="border: none; padding:0 12px;" width="50%" align="left">Position/Department</th>
                    </tr>';

        // Team
        foreach ($team as $tm) {
            $output .= '
                    <tr>
                        <td class="arial" style="border: none; padding:0 12px;" width="50%">' . $tm->officer_name . '</td>
                        <td class="arial" style="border: none; padding:0 12px;" width="50%">' . $tm->officer_position . '</td>
                    </tr>';
        }
        $output .= '</table>';

        $output .= '
                <br>
                <table width="100%" style="border-collapse: collapse; border: 0px;">
                    <tr style="border: 1px solid;">
                        <th class="arial" style="border: none; padding:0 12px;" width="50%" align="left">Summary</th>
                    </tr>
                </table>
                <span class="arial" style="margin-right:23px; margin-left:13px;">' . $spot_report[0]->summary . '</span>
                <h4 class="arial" align="center">*** end of report ***</h4>';

        $output .= '
                <footer>
                    ' . $date . ' | ' . Auth::user()->name . ' | ';
        if ($spot_report[0]->print_count == 1) {
            $output .= 'O';
        } else {
            $output .= 'C';
        }
        $output .= '
                </footer>
            </body>
            </html>';

        return $output;
    }

    public function get_suspect_number_count($count)
    {
        // Auto SUspect Number
        $suspect_number = 0 + DB::table('suspect_information')
            ->whereDate('created_at', Carbon::now()->format('Y-m-d'))
            ->count();
        if ($count == 0) {
            $suspect_number += 1;
        } else {
            $suspect_number += $count;
        }
        $suspect_number = sprintf("%04s", $suspect_number);

        return json_encode($suspect_number);
    }

    public function search_spot_report(Request $request)
    {

        $q = $request->q;

        if (Auth::user()->user_level_id == 2) {
            if ($q != "") {
                $data = DB::table('spot_report_header as a')
                    ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
                    ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
                    ->select('a.id', 'a.spot_report_number', 'a.operation_datetime', 'b.name as operating_unit_name', 'c.name as operation_type_name', 'a.status', 'a.created_at', 'a.preops_number')
                    ->where('a.report_status', 0)
                    ->where('a.spot_report_number', 'LIKE', '%' . $q . '%')
                    ->orWhere('a.preops_number', 'LIKE', '%' . $q . '%')
                    ->orderby('spot_report_number', 'asc')
                    ->paginate(20)
                    ->setPath('');

                // dd($data);

                $pagination = $data->appends(array(
                    'q' => $request->q
                ));

                $regional_office = DB::table('regional_office')->orderby('print_order', 'asc')->get();
                $operating_unit = DB::table('operating_unit')->where('status', true)->orderby('name', 'asc')->get();
                $operation_type = DB::table('operation_type')->where('status', true)->orderby('name', 'asc')->get();

                if (count($data) > 0) {
                    return view('spot_report.spot_report_list', compact('data', 'regional_office'));
                }
            }
        } else {
            if ($q != "") {
                $data = DB::table('spot_report_header as a')
                    ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
                    ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
                    ->leftjoin('regional_office as d', 'a.region_c', '=', 'd.region_c')
                    ->select('a.id', 'a.spot_report_number', 'a.operation_datetime', 'b.name as operating_unit_name', 'c.name as operation_type_name', 'a.status', 'a.created_at', 'a.preops_number')
                    ->where('a.spot_report_number', 'LIKE', '%' . $q . '%')
                    ->orWhere('a.preops_number', 'LIKE', '%' . $q . '%')
                    ->where('a.report_status', 0)
                    ->where('d.id', Auth::user()->regional_office_id)
                    ->orderby('spot_report_number', 'asc')
                    ->paginate(10)
                    ->setPath('');

                // dd($data);

                $pagination = $data->appends(array(
                    'q' => $request->q
                ));

                $regional_office = DB::table('regional_office')
                    ->where('id', Auth::user()->regional_office_id)
                    ->get();

                if (count($data) > 0) {
                    return view('spot_report.spot_report_list', compact('data', 'regional_office'));
                }
            }
        }

        return view('spot_report.spot_report_list', compact('data', 'regional_office'))->withMessage('No Details found. Try to search again !');
    }

    public function search_spot_report_number(Request $request)
    {
        $spot_report_number = DB::table('spot_report_header as a')
            ->leftjoin('regional_office as d', 'a.region_c', '=', 'd.region_c')
            ->where('a.spot_report_number', 'LIKE', '%' . $request->input('term', '') . '%')
            ->where('d.id', Auth::user()->regional_office_id)
            ->get(['a.id as id', 'a.spot_report_number as text']);

        // dd($spot_report_number);

        return ['results' => $spot_report_number];
    }

    public function search_preops_number(Request $request)
    {
        $data = DB::table('additional_option')->where('text', 'Uncoordinated')
            ->select('id', 'text');

        $preops_number = DB::table('preops_header as a')
            ->leftjoin('regional_office as d', 'a.region_c', '=', 'd.region_c')
            ->select('a.id', 'a.preops_number as text')
            ->where('a.preops_number', 'LIKE', '%' . $request->input('term', '') . '%')
            ->where('d.id', Auth::user()->regional_office_id)
            ->union($data)
            ->get();

        return ['results' => $preops_number];
    }

    public function fetch_suspect(Request $request)
    {
        // dd('test');
        if ($request->ajax()) {
            $suspects = DB::table('spot_report_suspect as a')
                ->leftjoin('spot_report_header as b', 'a.spot_report_number', '=', 'b.spot_report_number')
                ->leftjoin('drug_management as c', 'a.id', '=', 'c.suspect_id')
                ->leftjoin('users as d', 'd.id', '=', 'c.user_id')
                ->leftjoin('tbluserlevel as e', 'd.user_level_id', '=', 'e.id')
                ->leftjoin('province as f', 'a.province_c', '=', 'f.province_c')
                ->leftjoin('city as g', 'a.city_c', '=', 'g.city_c')
                ->leftjoin('barangay as h', 'a.barangay_c', '=', 'h.barangay_c')
                ->leftjoin('province as i', 'a.permanent_province_c', '=', 'i.province_c')
                ->leftjoin('city as j', 'a.permanent_city_c', '=', 'j.city_c')
                ->leftjoin('barangay as k', 'a.permanent_barangay_c', '=', 'k.barangay_c')
                ->select(
                    'a.id',
                    'a.suspect_number',
                    'a.spot_report_number',
                    'a.lastname',
                    'a.firstname',
                    'a.middlename',
                    'a.alias',
                    'a.gender',
                    'a.birthdate',
                    'a.birthplace',
                    'a.nationality_id',
                    'a.civil_status_id',
                    'a.religion_id',
                    'a.educational_attainment_id',
                    'a.ethnic_group_id',
                    'a.occupation_id',
                    'a.identifier_id',
                    'a.region_c',
                    'a.province_c',
                    'a.city_c',
                    'a.barangay_c',
                    'a.street',
                    'a.permanent_region_c',
                    'a.permanent_province_c',
                    'a.permanent_city_c',
                    'a.permanent_barangay_c',
                    'a.permanent_street',
                    'a.suspect_classification_id',
                    'a.suspect_status_id',
                    'a.remarks',
                    'a.suspect_category_id',
                    'a.suspect_sub_category_id',
                    'c.listed',
                    'c.user_id',
                    'e.name as ulvl',
                    'd.name as uname',
                    'a.est_birthdate',
                    'a.whereabouts',
                    'f.province_m as province_name',
                    'g.city_m as city_name',
                    'h.barangay_m as barangay_name',
                    'i.province_m as permanent_province_name',
                    'j.city_m as permanent_city_name',
                    'k.barangay_m as permanent_barangay_name',

                )
                ->where('a.spot_report_number', $request->get('spot_report_number'));

            // dd($suspects);
            return view('spot_report.spot_report_suspects', compact('suspects'))->render();
        }
    }
}
