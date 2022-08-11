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
                ->select('a.id', 'a.spot_report_number', 'a.operation_datetime', 'b.name as operating_unit', 'c.name as operation_type', 'a.status', 'a.created_at', 'a.preops_number')
                ->where('a.report_status', 0)
                ->orderby('spot_report_number', 'asc')
                ->get();

            $region = DB::table('region')->orderby('region_sort', 'asc')->get();
        } else {
            $data = DB::table('spot_report_header as a')
                ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
                ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
                ->leftjoin('regional_office as d', 'a.region_c', '=', 'd.region_c')
                ->select('a.id', 'a.spot_report_number', 'a.operation_datetime', 'b.name as operating_unit', 'c.name as operation_type', 'a.status', 'a.created_at', 'a.preops_number')
                ->where('a.report_status', 0)
                ->where('d.id', Auth::user()->regional_office_id)
                ->orderby('spot_report_number', 'asc')
                ->get();

            $region = DB::table('region as a')
                ->join('regional_office as d', 'a.region_c', '=', 'd.region_c')
                ->where('d.id', Auth::user()->regional_office_id)
                ->get();
        }


        $operating_unit = DB::table('operating_unit')->where('status', true)->orderby('name', 'asc')->get();
        $operation_type = DB::table('operation_type')->where('status', true)->orderby('name', 'asc')->get();

        return view('spot_report.spot_report_list', compact('data', 'region', 'operating_unit', 'operation_type'));
    }

    public function add()
    {
        $spot_report_header = DB::table('spot_report_header')->get();

        $city = DB::table('city')->orderby('city_m', 'asc')->get();
        $barangay = DB::table('barangay')->orderby('barangay_m', 'asc')->get();

        $operation_type = DB::table('operation_type')->where('status', true)->orderby('name', 'asc')->get();
        $hio_type = DB::table('hio_type')->where('status', true)->orderby('name', 'asc')->get();
        $operation_type_spot_report = DB::table('operation_type')->where('status', true)->where('show_spot_report', true)->orderby('name', 'asc')->get();


        if (Auth::user()->user_level_id == 2) {
            $preops_header = DB::table('preops_header')
                ->whereNotIn('preops_number', function ($query) {
                    $query->select('preops_number')->from('spot_report_header');
                })
                ->where('status', true)
                ->where('with_aor', 0)
                ->orderby('id', 'desc')
                ->get();
            $operating_unit = DB::table('operating_unit')->where('status', true)->orderby('name', 'asc')->get();
        } else {
            $preops_header = DB::table('preops_header as a')
                ->leftjoin('regional_office as b', 'a.ro_code', '=', 'b.ro_code')
                ->whereNotIn('a.preops_number', function ($query) {
                    $query->select('preops_number')->from('spot_report_header');
                })
                ->where('a.status', true)
                ->where('a.with_aor', 0)
                ->where('b.id', Auth::user()->regional_office_id)
                ->orderby('a.id', 'desc')
                ->get();
            $operating_unit = DB::table('operating_unit')->where('status', true)->where('region_c', Auth::user()->region_c)->orderby('name', 'asc')->get();
        }

        $report_header = DB::table('spot_report_header')->orderby('report_header', 'asc')->get();
        $suspect_information = DB::table('suspect_information')->where('status', true)->orderby('lastname', 'asc')->get();
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
        $regional_user = DB::table('users')->where('user_level_id', 3)->get();
        $evidence_type = DB::table('evidence_type')->where('status', true)->orderby('name', 'asc')->get();
        $unit_measurement = DB::table('unit_measurement')->where('status', true)->orderby('name', 'asc')->get();
        $packaging = DB::table('packaging')->where('status', true)->orderby('name', 'asc')->get();
        $roc_regional_office = DB::table('regional_office')->where('id', Auth::user()->regional_office_id)->get();
        $region = DB::table('region')->where('status', true)->orderby('region_sort', 'asc')->get();
        $province = DB::table('province')->orderby('province_m', 'asc')->get();
        $identifier = DB::table('identifier')->where('status', true)->orderby('name', 'asc')->get();

        if (Auth::user()->user_level_id == 1) {
            $sregion = DB::table('region')->where('region_c', $roc_regional_office[0]->region_c)->orderby('region_sort', 'asc')->get();
        } else {
            $sregion = DB::table('region')->orderby('region_sort', 'asc')->get();
        }


        date_default_timezone_set('Asia/Manila');
        $date = Carbon::now()->format('mdY');

        // Auto Spot Number
        $spot_report_number = DB::table('spot_report_header')
            ->where('region_c', $roc_regional_office[0]->region_c)
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

        return view('spot_report.spot_report_add', compact(
            'report_header',
            'packaging',
            'sregion',
            'suspect_category',
            'suspect_number',
            'roc_regional_office',
            'date',
            'spot_report_number',
            'unit_measurement',
            'evidence_type',
            'suspect_classification',
            'province',
            'city',
            'barangay',
            'civil_status',
            'religion',
            'education',
            'ethnic_group',
            'nationality',
            'occupation',
            'case',
            'operation_type',
            'operating_unit',
            'region',
            'preops_header',
            'suspect_information',
            'suspect_status',
            'support_unit',
            'regional_user',
            'operation_type_spot_report',
            'hio_type',
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

                        $suspect_data = DB::table('suspect_information')
                            ->where('lastname', $lastname)
                            ->where('firstname', $firstname)
                            ->where('middlename', $middlename)
                            ->where('alias', $alias)
                            ->where('birthdate', $birthdate)
                            ->select('suspect_number')
                            ->get();
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

                        $suspect_data = DB::table('spot_report_suspect')
                            ->where('lastname', $lastname)
                            ->where('firstname', $firstname)
                            ->where('middlename', $middlename)
                            ->where('alias', $alias)
                            ->where('birthdate', $birthdate)
                            ->select('suspect_number')
                            ->get();
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
        $spot_report_header = DB::table('spot_report_header')->where('id', $id)->get();
        $spot_report_suspect = DB::table('spot_report_suspect as a')
            ->join('spot_report_header as b', 'a.spot_report_number', '=', 'b.spot_report_number')
            ->leftjoin('drug_management as c', 'a.id', '=', 'c.suspect_id')
            ->leftjoin('users as d', 'd.id', '=', 'c.user_id')
            ->leftjoin('tbluserlevel as e', 'd.user_level_id', '=', 'e.id')
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

            )
            ->where('b.id', $id)->get();
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
        $province = DB::table('province')->orderby('province_m', 'asc')->get();
        $city = DB::table('city')->orderby('city_m', 'asc')->get();
        $barangay = DB::table('barangay')->orderby('barangay_m', 'asc')->get();
        // $operating_unit = DB::table('operating_unit')->where('status', true)->orderby('name', 'asc')->get();
        if (Auth::user()->user_level_id == 2) {
            $operating_unit = DB::table('operating_unit')->where('status', true)->orderby('name', 'asc')->get();
        } else {
            $operating_unit = DB::table('operating_unit')->where('status', true)->where('region_c', Auth::user()->region_c)->orderby('name', 'asc')->get();
        }
        $operation_type = DB::table('operation_type')->where('status', true)->orderby('name', 'asc')->get();
        $preops_header = DB::table('preops_header')->where('status', true)->orderby('id', 'asc')->get();
        $suspect_information = DB::table('spot_report_suspect as a')
            ->join('spot_report_header as b', 'a.spot_report_number', '=', 'b.spot_report_number')
            ->select('a.suspect_number', 'a.lastname', 'a.firstname', 'a.middlename', 'a.alias')
            ->where('b.id', $id)
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
        $preops_support_unit = DB::table('spot_report_support_unit')
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
            'spot_report_suspect',
            'spot_report_evidence',
            'spot_report_case',
            'spot_report_team',
            'spot_report_summary',
            'spot_report_header',
            'region',
            'province',
            'city',
            'barangay',
            'operating_unit',
            'operation_type',
            'preops_header',
            'suspect_information',
            'case',
            'suspect_status',
            'spot_report_files',
            'regional_user',
            'hio_type',
            'identifier',
            'suspect_sub_category'
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
                                'identifier' => $data['identifier'][$i],
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

                                $suspect_data = DB::table('spot_report_suspect')
                                    ->where('lastname', $lastname)
                                    ->where('firstname', $firstname)
                                    ->where('middlename', $middlename)
                                    ->where('alias', $alias)
                                    ->where('birthdate', $birthdate)
                                    ->select('suspect_number')
                                    ->get();

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

                                $suspect_data = DB::table('suspect_information')
                                    ->where('lastname', $lastname)
                                    ->where('firstname', $firstname)
                                    ->where('middlename', $middlename)
                                    ->where('alias', $alias)
                                    ->where('birthdate', $birthdate)
                                    ->select('suspect_number')
                                    ->get();
                                $suspect_number = $suspect_data[0]->suspect_number;
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

                                $suspect_data = DB::table('spot_report_suspect')
                                    ->where('lastname', $lastname)
                                    ->where('firstname', $firstname)
                                    ->where('middlename', $middlename)
                                    ->where('alias', $alias)
                                    ->where('birthdate', $birthdate)
                                    ->select('suspect_number')
                                    ->get();

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

                                $suspect_data = DB::table('suspect_information')
                                    ->where('lastname', $lastname)
                                    ->where('firstname', $firstname)
                                    ->where('middlename', $middlename)
                                    ->where('alias', $alias)
                                    ->where('birthdate', $birthdate)
                                    ->select('suspect_number')
                                    ->get();
                                $suspect_number = $suspect_data[0]->suspect_number;
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
                ->join('spot_report_header as b', 'a.region_c', '=', 'b.region_c')
                ->select('a.name', 'a.address', 'a.contact_number', 'a.report_header')
                ->where('b.region_c', $spot_report[0]->region_c)->get();
        } else {
            $regional_office = DB::table('regional_office as a')
                ->join('preops_header as b', 'a.ro_code', '=', 'b.ro_code')
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
            ->join('spot_report_header as b', 'a.spot_report_number', '=', 'b.spot_report_number')
            ->join('evidence as c', 'a.evidence_id', '=', 'c.id')
            ->join('unit_measurement as d', 'a.unit', '=', 'd.id')
            ->select('c.name as evidence_type', 'd.name as unit_measurement', 'a.evidence', 'a.quantity')
            ->where('b.id', $id)->get();

        $case = DB::table('spot_report_case as a')
            ->join('spot_report_header as b', 'a.spot_report_number', '=', 'b.spot_report_number')
            ->join('case_list as c', 'a.case_id', '=', 'c.id')
            ->join('spot_report_suspect as d', 'a.suspect_number', '=', 'd.suspect_number')
            ->select('c.description as case', 'd.lastname', 'd.firstname', 'd.middlename')
            ->where('b.id', $id)->get();
        $team = DB::table('spot_report_team as a')
            ->join('spot_report_header as b', 'a.spot_report_number', '=', 'b.spot_report_number')
            ->where('b.id', $id)->get();
        $support_unit = DB::table('spot_report_support_unit as a')
            ->leftjoin('support_unit as b', 'a.support_unit_id', '=', 'b.id')
            ->where('a.spot_report_number', $spot_report[0]->spot_report_number)
            ->select('b.name')
            ->get();



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
                <div style="text-align:center;"><h2>' . $spot_report[0]->spot_report_number . '</h2></div>
                <div style="border:solid;" align="center"><span style="font-size:20px">SPOT REPORT</span></div>
                <br>
                <span style="margin-right:39px; margin-left:33px">Date Reported:</span><span>' . Carbon::createFromFormat('Y-m-d', $spot_report[0]->reported_date)->format('F d,Y') . '</span>
                <br>
                <span style="margin-right:23px; margin-left:33px;">Reporting Office:</span><span style="font-weight:bold">' . $regional_office[0]->name . '</span>
                <br>
                <br>
                <span style="margin-right:23px; margin-left:33px">Pre-Ops Number:</span><span style="font-weight:bold">' . $spot_report[0]->preops_number . '</span>
                <span style="margin-right:8px; margin-left:33px">Date/Time of OPN:</span><span style="font-weight:bold">' . Carbon::createFromFormat('Y-m-d H:i:s', $spot_report[0]->operation_datetime)->format('d F Y H:i:s') . '</span>
                <br>
                <span style="margin-right:35px; margin-left:33px">Operating Unit:</span><span style="font-weight:bold">' . $operating_unit[0]->name . '</span>
                <br>
                <span style="margin-right:14px; margin-left:33px">Type of Operation:</span><span style="font-weight:bold">' . $operation_type[0]->name . '</span>
                <br>
                <span style="margin-right:49px; margin-left:33px">Support Unit:</span><span style="font-weight:bold">';

        $count = 0;
        foreach ($support_unit as $su) {
            $count++;
            if ($count == 1) {
                $output .= $su->name;
            } else {
                $output .= ', ' . $su->name;
            }
        }
        $output .= '</span>
                
                <br>
                <br>
                <span style="margin-right:14px; margin-left:33px">Area of Operation:</span>
                <p style="margin-right:14px; margin-left:33px; margin-top: 5px;"><u>' . $barangay[0]->barangay_m . ', ' . $city[0]->city_m . '</u></p>
                <span style="margin-right:74px; margin-left:33px">Remarks:</span><span>' . $spot_report[0]->remarks . '</span>
                <br>
                <br>
                <table width="100%" style="border-collapse: collapse; border: 0px;">
                <tr style="border: 1px solid;">
                    <th style="border: none; padding:0 12px;" width="25%" align="left">Qty</th>
                    <th style="border: none; padding:0 12px;" width="25%" align="left">Evidence</th>
                    <th style="border: none; padding:0 12px;" width="50%" align="left">Packaging</th>
                </tr>';

        // Evidence
        foreach ($evidence as $ar) {
            $output .= '
                <tr>
                    <td style="border: none; padding:0 12px;" width="25%" align="left">' . $ar->quantity . ' ' . $ar->unit_measurement . '</td>
                    <td style="border: none; padding:0 12px;" width="25%">' . $ar->evidence_type . ' - ' . $ar->evidence . '</td>
                    <td style="border: none; padding:0 12px;" width="50%">Sample</td>
                </tr>';
        }
        $output .= '</table>';

        $output .= '
                <br>
                <table width="100%" style="border-collapse: collapse; border: 0px;">
                    <tr style="border: 1px solid;">
                        <th style="border: none; padding:0 12px;" width="50%" align="left">Case(s) Filed</th>
                        <th style="border: none; padding:0 12px;" width="50%" align="left">Name of Suspect</th>
                    </tr>';

        // Case
        foreach ($case as $cs) {
            $output .= '
                    <tr>
                        <td style="border: none; padding:0 12px;" width="50%">' . $cs->case . '</td>
                        <td style="border: none; padding:0 12px;" width="50%">' . $cs->lastname . ', ' . $cs->firstname . ' ' . $cs->middlename . '</td>
                    </tr>';
        }
        $output .= '</table>';

        $output .= '
                <br>
                <table width="100%" style="border-collapse: collapse; border: 0px;">
                    <tr style="border: 1px solid; border-bottom:none">
                        <th style="border: none; padding:0 12px;" width="50%" align="left">Operating Team</th>
                        <th style="border: none; padding:0 12px;" width="50%" align="left"></th>
                    </tr>
                    <tr style="border: 1px solid; border-top:none">
                        <th style="border: none; padding:0 12px;" width="50%" align="left">Name</th>
                        <th style="border: none; padding:0 12px;" width="50%" align="left">Position/Department</th>
                    </tr>';

        // Team
        foreach ($team as $tm) {
            $output .= '
                    <tr>
                        <td style="border: none; padding:0 12px;" width="50%">' . $tm->officer_name . '</td>
                        <td style="border: none; padding:0 12px;" width="50%">' . $tm->officer_position . '</td>
                    </tr>';
        }
        $output .= '</table>';

        $output .= '
                <br>
                <table width="100%" style="border-collapse: collapse; border: 0px;">
                    <tr style="border: 1px solid;">
                        <th style="border: none; padding:0 12px;" width="50%" align="left">Summary</th>
                    </tr>
                </table>
                <span style="margin-right:23px; margin-left:13px;">' . $spot_report[0]->summary . '</span>
                <h4 align="center">*** end of report ***</h4>';

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
}
