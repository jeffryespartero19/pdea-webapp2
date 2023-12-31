<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\ProgressReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;
use PDF;

class ProgressReportController extends Controller
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
                ->select(
                    'a.id',
                    'a.spot_report_number',
                    'a.operation_datetime',
                    'b.description as operating_unit_name',
                    'c.name as operation_type_name',
                    'a.status',
                    'a.preops_number'
                )
                ->where('a.report_status', 1)
                ->orderby('a.id', 'desc')
                ->paginate(20);

            $region = DB::table('region')->orderby('region_sort', 'asc')->get();
        } else {
            $data = DB::table('spot_report_header as a')
                ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
                ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
                ->leftjoin('regional_office as d', 'a.region_c', '=', 'd.region_c')
                ->select(
                    'a.id',
                    'a.spot_report_number',
                    'a.operation_datetime',
                    'b.description as operating_unit_name',
                    'c.name as operation_type_name',
                    'a.status',
                    'a.preops_number'
                )
                ->where('a.report_status', 1)
                ->where('d.id', Auth::user()->regional_office_id)
                ->orderby('a.id', 'desc')
                ->paginate(20);

            $region = DB::table('region as a')
                ->join('regional_office as d', 'a.region_c', '=', 'd.region_c')
                ->where('d.id', Auth::user()->regional_office_id)
                ->get();
        }


        // $operating_unit = DB::table('operating_unit')->where('status', true)->orderby('name', 'asc')->get();
        // $operation_type = DB::table('operation_type')->where('status', true)->orderby('name', 'asc')->get();


        return view('progress_report.progress_report_list', compact('region', 'data'));
    }

    public function fetch_data(Request $request)
    {

        if ($request->ajax()) {

            $param1 = $request->get('tnumber');
            $area = $request->get('area');
            $suspect = $request->get('suspect');

            // dd($request->get('operating_unit_id'));
            $data = DB::table('spot_report_header as a')
                ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
                ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
                ->select('a.id', 'a.spot_report_number', 'a.operating_unit_id', 'operation_type_id', 'b.description as operating_unit_name', 'c.name as operation_type_name', 'a.operation_datetime', 'a.region_c', 'a.status', 'a.created_at', 'a.preops_number')
                ->where('a.report_status', 1);

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
            if ($request->get('area') != null) {
                $data->where('a.area', 'LIKE', '%' . $area . '%');
            }
            if ($request->get('tnumber') != null) {
                if (str_contains($request->get('tnumber'), 'uncoor')) {
                    $data->where(function ($query) {
                        return $query->where(['a.preops_number' => 1]);
                    });
                } else {
                    $data->where(function ($query)  use ($param1) {
                        return $query->where('a.spot_report_number', 'LIKE', '%' . $param1 . '%')
                            ->orWhere('a.preops_number', 'LIKE', '%' . $param1 . '%');
                    });
                }
            }
            if ($request->get('suspect') != null) {
                $sr_id = DB::table('spot_report_suspect as a')
                    ->leftjoin('spot_report_header as b', 'a.spot_report_number', '=', 'b.spot_report_number')
                    ->select(
                        'b.id'
                    )
                    ->where('a.lastname', 'LIKE', '%' . $suspect . '%')
                    ->orWhere('a.firstname', 'LIKE', '%' . $suspect . '%')
                    ->orWhere('a.middlename', 'LIKE', '%' . $suspect . '%')
                    ->orWhere('a.alias', 'LIKE', '%' . $suspect . '%');
                $data->whereIn('a.id', $sr_id);
            }

            $data = $data->orderby('a.id', 'desc')->paginate(20);

            // dd($data);

            return view('progress_report.progress_report_data', compact('data'))->render();
        }
    }

    public function search_spot_report_list(Request $request)
    {
        $param = $request->get('param');

        if (Auth::user()->user_level_id == 2) {
            $data = DB::table('spot_report_header as a')
                ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
                ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
                ->select('a.id', 'a.spot_report_number', 'a.operation_datetime', 'b.description as operating_unit_name', 'c.name as operation_type_name', 'a.status', 'a.created_at', 'a.preops_number')
                ->where('a.report_status', 1)
                ->where('a.spot_report_number', 'LIKE', '%' . $param . '%')
                ->orderby('a.id', 'desc')
                ->paginate(20);
        } else {
            $data = DB::table('spot_report_header as a')
                ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
                ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
                ->leftjoin('regional_office as d', 'a.region_c', '=', 'd.region_c')
                ->select('a.id', 'a.spot_report_number', 'a.operation_datetime', 'b.description as operating_unit_name', 'c.name as operation_type_name', 'a.status', 'a.created_at', 'a.preops_number')
                ->where('a.spot_report_number', 'LIKE', '%' . $param . '%')
                ->where('a.report_status', 1)
                ->where('d.id', Auth::user()->regional_office_id)
                ->orderby('a.id', 'desc')
                ->paginate(20);
        }
        return view('progress_report.progress_report_data', compact('data'))->render();
    }

    public function add()
    {

        $region = DB::table('region')->orderby('region_sort', 'asc')->get();
        $operating_unit = DB::table('operating_unit')->where('status', true)->orderby('name', 'asc')->get();
        $operation_type = DB::table('operation_type')->where('status', true)->orderby('name', 'asc')->get();

        if (Auth::user()->user_level_id == 2) {
            $spot_report_header = DB::table('spot_report_header as a')
                ->leftjoin('regional_office as b', 'a.region_c', '=', 'b.region_c')
                ->where('a.status', true)
                ->where('a.report_status', 0)
                ->orderby('a.id', 'desc')->get();
        } else {
            $spot_report_header = DB::table('spot_report_header as a')
                ->leftjoin('regional_office as b', 'a.region_c', '=', 'b.region_c')
                ->where('a.status', true)
                ->where('a.report_status', 0)
                ->where('b.id', Auth::user()->regional_office_id)
                ->orderby('a.id', 'desc')->get();
        }

        $civil_status = DB::table('civil_status')->where('active', true)->orderby('name', 'asc')->get();
        $religion = DB::table('religions')->where('active', true)->orderby('name', 'asc')->get();
        $education = DB::table('Educational_attainment')->where('status', true)->orderby('name', 'asc')->get();
        $ethnic_group = DB::table('ethnic_group')->where('status', true)->orderby('name', 'asc')->get();
        $nationality = DB::table('nationality')->where('status', true)->orderby('name', 'asc')->get();
        $occupation = DB::table('occupation')->where('status', true)->orderby('name', 'asc')->get();
        $suspect_status = DB::table('suspect_status')->where('status', true)->orderby('id', 'asc')->get();
        $regional_user = DB::table('users')->where('user_level_id', 3)->get();
        $suspect_classification = DB::table('suspect_classification')->where('status', true)->orderby('id', 'asc')->get();
        $laboratory_facility = DB::table('laboratory_facility')->where('status', true)->orderby('id', 'asc')->get();
        $drug_type = DB::table('drug_type')->where('status', true)->orderby('id', 'asc')->get();
        $identifier = DB::table('identifier')->where('status', true)->orderby('name', 'asc')->get();
        $suspect_category = DB::table('suspect_category')->where('status', true)->orderby('id', 'asc')->get();
        $suspect_sub_category = DB::table('suspect_sub_category')->where('status', true)->orderby('id', 'asc')->get();
        $case = DB::table('case_list')->where('status', true)->orderby('description', 'asc')->get();

        return view('progress_report.progress_report_add', compact(
            'laboratory_facility',
            'drug_type',
            'suspect_classification',
            'region',
            'operating_unit',
            'spot_report_header',
            'operation_type',
            'civil_status',
            'religion',
            'education',
            'ethnic_group',
            'nationality',
            'occupation',
            'suspect_status',
            'regional_user',
            'identifier',
            'suspect_category',
            'suspect_sub_category',
            'case'
        ));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->all();
        // dd(isset($data['suspect_number_item']));


        $pos_data = array(
            'reference_number' => $request->reference_number,
            'approved_by' => $request->approved_by,
            'prepared_by' => $request->prepared_by,
            'progress_reported_date' => date('Y-m-d'),
            'case_status_date' => $request->case_status_date,
            'case_status' => $request->case_status,
            'procecutor_name' => $request->procecutor_name,
            'procecutor_office' => $request->procecutor_office,
            'modified_by' => $request->modified_by,
            'prelim_case_date' => $request->prelim_case_date,
            'prelim_prosecutor' => $request->prelim_prosecutor,
            'prelim_prosecutor_office' => $request->prelim_prosecutor_office,
            'prelim_case_status' => $request->prelim_case_status,
            'is_number' => $request->is_number,
            'report_header' => $request->report_header,
            'summary' => $request->summary,
            'report_status' => 1,
            'prelim_is_number' => $request->prelim_is_number,
        );

        DB::table('spot_report_header')->where('id', $request->spot_report_number)->update($pos_data);

        $pr_id =  DB::table('spot_report_header')->where('id', $request->spot_report_number)->select('id')->get();
        $preops_number =  DB::table('spot_report_header')->where('id', $request->spot_report_number)->select('preops_number')->get();

        // dd($preops_number[0]->preops_number);

        if ($preops_number[0]->preops_number != null && $preops_number[0]->preops_number != 1) {
            $form_data2 = array(
                'with_pr' => true,
            );

            DB::table('preops_header')->where('preops_number', $preops_number[0]->preops_number)->update($form_data2);
        }



        if ($request->file('fileattach')) {

            foreach ($request->file('fileattach') as $file) {
                $filename = $file->getClientOriginalName();
                // $filename = pathinfo($fileinfo, PATHINFO_FILENAME);
                $filePath = public_path() . '/files/uploads/progress_reports/';
                $file->move($filePath, $filename);

                $file_data = array(
                    'spot_report_number' => $request->spot_report_number,
                    'filenames' => $filename,
                );

                $file_id = DB::table('progress_report_files')->insertGetId($file_data);

                date_default_timezone_set('Asia/Manila');
                $date = Carbon::now();

                $file_upload = array(
                    'after_operation_file_id' => $file_id,
                    'filename' => $filename,
                    'transaction_type' => 4,
                    'created_at' => $date,
                );

                DB::table('file_upload_list')->insert($file_upload);
            }
        }

        //Save Suspect Info
        if (isset($data['suspect_number'])) {
            // dd('test1');
            $spot_item = [];

            for ($i = 0; $i < count($data['suspect_number']); $i++) {
                if ($data['suspect_number'][$i] != NULL && $data['suspect_number'][$i] != 0) {

                    $suspect_number = $data['suspect_number'][$i];

                    $spot_item = [
                        'drug_test_result' => $data['drug_test_result'][$i],
                        'drug_type_id' => $data['drug_type_id'][$i],
                    ];

                    DB::table('spot_report_suspect')->updateOrInsert(['suspect_number' => $suspect_number], $spot_item);
                }
            }
        }

        //Save Item Seized
        if (isset($data['spot_report_evidence_id'])) {
            // dd('test1');
            $spot_item = [];

            for ($i = 0; $i < count($data['spot_report_evidence_id']); $i++) {
                if ($data['spot_report_evidence_id'][$i] != NULL && $data['evidence'][$i] != NULL) {

                    $id = $data['spot_report_evidence_id'][$i];

                    $spot_item = [
                        'qty_onsite' => $data['qty_onsite'][$i],
                        'actual_qty' => $data['actual_qty'][$i],
                        'drug_test_result' => $data['e_drug_test_result'][$i],
                        'chemist_report_number' => $data['chemist_report_number'][$i],
                        'laboratory_facility_id' => $data['laboratory_facility_id'][$i],
                    ];

                    DB::table('spot_report_evidence')->updateOrInsert(['id' => $id], $spot_item);
                }
            }
        }


        //Save Suspect Case
        if (isset($data['suspect_number_case'])) {
            $spot_case = [];

            for ($i = 0; $i < count($data['spot_report_case_id']); $i++) {
                if ($data['spot_report_case_id'][$i] == '0' && $data['suspect_number_case'][$i] == '0') {

                    $id = 0;

                    if ($data['suspect_no'][$i] != null && $data['case_id'][$i] != null) {
                        $spot_case = [
                            'spot_report_number' => $request->spot_report_number,
                            'suspect_number' => $data['suspect_no'][$i],
                            'case_id' => $data['case_id'][$i],
                            'docket_number' => $data['docket_number'][$i],
                            'case_status' => $data['c_case_status'][$i],
                        ];

                        DB::table('spot_report_case')->Insert($spot_case);
                    }
                } elseif ($data['spot_report_case_id'][$i] != NULL && $data['suspect_number_case'][$i] != NULL && $data['spot_report_case_id'][$i] != 0 && $data['suspect_number_case'][$i] != 0) {
                    $id = $data['spot_report_case_id'][$i];

                    $spot_case = [
                        'docket_number' => $data['docket_number'][$i],
                        'case_status' => $data['c_case_status'][$i],
                    ];

                    DB::table('spot_report_case')->updateOrInsert(['id' => $id], $spot_case);
                }
            }
        }

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Spot And Progress Report',
            'menu'    => 'Progress Report',
            'activity' => 'Update',
            'description' => 'Updated Progress Report Record',
        );

        Audit::create($data_audit);

        $pr_id = $pr_id[0]->id;

        return back()->with('success', 'You have successfully updated progress report!')->with('pr_id', $pr_id);
    }

    public function edit($id)
    {
        $spot_report_header = DB::table('spot_report_header')->where('id', $id)->get();
        $region = DB::table('region')->orderby('region_sort', 'asc')->get();
        $operating_unit = DB::table('operating_unit')->where('status', true)->where('id', $spot_report_header[0]->operating_unit_id)->orderby('name', 'asc')->get();
        $operation_type = DB::table('operation_type')->where('status', true)->where('id', $spot_report_header[0]->operation_type_id)->orderby('name', 'asc')->get();
        $region = DB::table('region')->where('status', true)->where('region_c', $spot_report_header[0]->region_c)->orderby('region_sort', 'asc')->get();
        $province = DB::table('province')->where('province_c', $spot_report_header[0]->province_c)->orderby('province_m', 'asc')->get();
        $city = DB::table('city')->where('city_c', $spot_report_header[0]->city_c)->orderby('city_m', 'asc')->get();
        $barangay = DB::table('barangay')->where('barangay_c', $spot_report_header[0]->barangay_c)->orderby('barangay_m', 'asc')->get();
        $civil_status = DB::table('civil_status')->where('active', true)->orderby('name', 'asc')->get();
        $religion = DB::table('religions')->where('active', true)->orderby('name', 'asc')->get();
        $education = DB::table('Educational_attainment')->where('status', true)->orderby('name', 'asc')->get();
        $ethnic_group = DB::table('ethnic_group')->where('status', true)->orderby('name', 'asc')->get();
        $nationality = DB::table('nationality')->where('status', true)->orderby('name', 'asc')->get();
        $occupation = DB::table('occupation')->where('status', true)->orderby('name', 'asc')->get();
        $suspect_status = DB::table('suspect_status')->where('status', true)->orderby('id', 'asc')->get();
        $suspect_classification = DB::table('suspect_classification')->where('status', true)->orderby('id', 'asc')->get();
        $drug_type = DB::table('drug_type')->where('status', true)->orderby('id', 'asc')->get();
        $laboratory_facility = DB::table('laboratory_facility')->where('status', true)->orderby('id', 'asc')->get();
        $spot_report_suspect = DB::table('spot_report_suspect as a')
            ->leftjoin('drug_management as r', 'a.id', '=', 'r.suspect_id')
            ->leftjoin('users as s', 's.id', '=', 'r.user_id')
            ->leftjoin('tbluserlevel as t', 's.user_level_id', '=', 't.id')
            ->where('spot_report_number', $spot_report_header[0]->spot_report_number)
            ->select(
                'a.suspect_number',
                'a.lastname',
                'a.firstname',
                'a.middlename',
                'a.alias',
                'a.birthdate',
                'a.birthplace',
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
                'a.gender',
                'a.civil_status_id',
                'a.nationality_id',
                'a.ethnic_group_id',
                'a.religion_id',
                'a.educational_attainment_id',
                'a.occupation_id',
                'a.suspect_status_id',
                'a.suspect_classification_id',
                'a.suspect_category_id',
                'a.suspect_sub_category_id',
                'a.remarks',
                't.name as ulvl',
                's.name as uname',
                'r.listed',
                'a.drug_test_result',
                'a.drug_type_id',
                'a.identifier_id',

            )
            ->get();
        $spot_report_evidence = DB::table('spot_report_evidence as a')
            ->join('spot_report_suspect as b', 'a.suspect_number', '=', 'b.suspect_number')
            ->join('evidence as c', 'a.evidence_id', '=', 'c.id')
            ->join('unit_measurement as d', 'c.unit_measurement_id', '=', 'd.id')
            ->select(
                'a.id',
                'a.suspect_number',
                'b.lastname',
                'b.firstname',
                'b.middlename',
                'b.alias',
                'a.qty_onsite',
                'a.actual_qty',
                'c.name as evidence',
                'd.name as unit_measurement',
                'a.chemist_report_number',
                'a.drug_test_result',
                'a.laboratory_facility_id',
                'a.quantity'
            )
            ->where('a.spot_report_number', $spot_report_header[0]->spot_report_number)
            ->where('a.drug', 'drug')
            ->get();
        $spot_report_case = DB::table('spot_report_case as a')
            ->join('spot_report_suspect as b', 'a.suspect_number', '=', 'b.suspect_number')
            ->join('case_list as c', 'a.case_id', '=', 'c.id')
            ->select(
                'a.id as spot_report_case_id',
                'a.suspect_number',
                'b.lastname',
                'b.firstname',
                'b.middlename',
                'b.alias',
                'a.case_id',
                'c.description',
                'a.docket_number',
                'a.case_status',
            )
            ->where('a.spot_report_number', $spot_report_header[0]->spot_report_number)->get();

        $progress_report_files = DB::table('progress_report_files')->where('spot_report_number', $spot_report_header[0]->spot_report_number)->get();
        $regional_user = DB::table('users')->where('user_level_id', 3)->get();
        $identifier = DB::table('identifier')->where('status', true)->orderby('name', 'asc')->get();
        $suspect_category = DB::table('suspect_category')->where('status', true)->orderby('name', 'asc')->get();
        $suspect_sub_category = DB::table('suspect_sub_category')->where('status', true)->orderby('name', 'asc')->get();
        $case = DB::table('case_list')->where('status', true)->orderby('description', 'asc')->get();

        return view('progress_report.progress_report_edit', compact(
            'laboratory_facility',
            'drug_type',
            'suspect_classification',
            'spot_report_suspect',
            'spot_report_evidence',
            'spot_report_case',
            'region',
            'province',
            'city',
            'barangay',
            'operating_unit',
            'spot_report_header',
            'operation_type',
            'civil_status',
            'religion',
            'education',
            'ethnic_group',
            'nationality',
            'occupation',
            'suspect_status',
            'progress_report_files',
            'regional_user',
            'identifier',
            'suspect_category',
            'suspect_sub_category',
            'case'
        ));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        if (Auth::user()->user_level_id == 2) {
            $pos_data = array(
                'reference_number' => $request->reference_number,
                'approved_by' => $request->approved_by,
                'prepared_by' => $request->prepared_by,
                'progress_reported_date' => date('Y-m-d'),
                'case_status_date' => $request->case_status_date,
                'case_status' => $request->case_status,
                'procecutor_name' => $request->procecutor_name,
                'procecutor_office' => $request->procecutor_office,
                'modified_by' => $request->modified_by,
                'prelim_case_date' => $request->prelim_case_date,
                'prelim_prosecutor' => $request->prelim_prosecutor,
                'prelim_prosecutor_office' => $request->prelim_prosecutor_office,
                'prelim_case_status' => $request->prelim_case_status,
                'is_number' => $request->is_number,
                'report_header' => $request->report_header,
                'summary' => $request->summary,
                'report_status' => 1,
                'prelim_is_number' => $request->prelim_is_number,
            );

            DB::table('spot_report_header')->where('spot_report_number', $request->spot_report_number)->update($pos_data);

            //Save Suspect Info
            if (isset($data['suspect_number'])) {
                // dd('test1');
                $spot_suspect = [];

                for ($i = 0; $i < count($data['suspect_number']); $i++) {
                    if ($data['suspect_number'][$i] != NULL && $data['suspect_number'][$i] != 0) {

                        $suspect_number = $data['suspect_number'][$i];

                        $spot_suspect = [
                            'drug_test_result' => $data['drug_test_result'][$i],
                            'drug_type_id' => $data['drug_type_id'][$i],
                        ];

                        DB::table('spot_report_suspect')->updateOrInsert(['suspect_number' => $suspect_number], $spot_suspect);
                    }
                }
            }


            //Save Item Seized
            if (isset($data['spot_report_evidence_id'])) {
                // dd('test1');
                $spot_item = [];

                for ($i = 0; $i < count($data['spot_report_evidence_id']); $i++) {
                    if ($data['spot_report_evidence_id'][$i] != NULL) {

                        $id = $data['spot_report_evidence_id'][$i];

                        $spot_item = [
                            'qty_onsite' => $data['qty_onsite'][$i],
                            'actual_qty' => $data['actual_qty'][$i],
                            'drug_test_result' => $data['e_drug_test_result'][$i],
                            'chemist_report_number' => $data['chemist_report_number'][$i],
                            'laboratory_facility_id' => $data['laboratory_facility_id'][$i],
                        ];

                        DB::table('spot_report_evidence')->updateOrInsert(['id' => $id], $spot_item);
                    }
                }
            }


            //Save Suspect Case
            if (isset($data['suspect_number_case'])) {
                $spot_case = [];

                for ($i = 0; $i < count($data['spot_report_case_id']); $i++) {
                    if ($data['spot_report_case_id'][$i] == '0' && $data['suspect_number_case'][$i] == '0') {

                        $id = 0;

                        if ($data['suspect_no'][$i] != null && $data['case_id'][$i] != null) {
                            $spot_case = [
                                'spot_report_number' => $request->spot_report_number,
                                'suspect_number' => $data['suspect_no'][$i],
                                'case_id' => $data['case_id'][$i],
                                'docket_number' => $data['docket_number'][$i],
                                'case_status' => $data['c_case_status'][$i],
                            ];

                            DB::table('spot_report_case')->Insert($spot_case);
                        }
                    } elseif ($data['spot_report_case_id'][$i] != NULL && $data['suspect_number_case'][$i] != NULL && $data['spot_report_case_id'][$i] != 0 && $data['suspect_number_case'][$i] != 0) {
                        $id = $data['spot_report_case_id'][$i];

                        $spot_case = [
                            'docket_number' => $data['docket_number'][$i],
                            'case_status' => $data['c_case_status'][$i],
                        ];

                        DB::table('spot_report_case')->updateOrInsert(['id' => $id], $spot_case);
                    }
                }
            }

            if ($request->hasfile('fileattach')) {
                foreach ($request->file('fileattach') as $file) {
                    $filename = $file->getClientOriginalName();
                    // $filename = pathinfo($fileinfo, PATHINFO_FILENAME);
                    $filePath = public_path() . '/files/uploads/progress_reports/';
                    $file->move($filePath, $filename);

                    $file_data = array(
                        'spot_report_number' => $request->spot_report_number,
                        'filenames' => $filename,
                    );
                    $file_id = DB::table('progress_report_files')->insertGetId($file_data);

                    date_default_timezone_set('Asia/Manila');
                    $date = Carbon::now();

                    $file_upload = array(
                        'after_operation_file_id' => $file_id,
                        'filename' => $filename,
                        'transaction_type' => 4,
                        'created_at' => $date,
                    );

                    DB::table('file_upload_list')->insert($file_upload);
                }
            }
        } elseif (Auth::user()->user_level_id == 3) {
            if ($request->hasfile('fileattach')) {
                foreach ($request->file('fileattach') as $file) {
                    $filename = $file->getClientOriginalName();
                    // $filename = pathinfo($fileinfo, PATHINFO_FILENAME);
                    $filePath = public_path() . '/files/uploads/progress_reports/';
                    $file->move($filePath, $filename);

                    $file_data = array(
                        'spot_report_number' => $request->spot_report_number,
                        'filenames' => $filename,
                    );
                    $file_id = DB::table('progress_report_files')->insertGetId($file_data);

                    date_default_timezone_set('Asia/Manila');
                    $date = Carbon::now();

                    $file_upload = array(
                        'after_operation_file_id' => $file_id,
                        'filename' => $filename,
                        'transaction_type' => 4,
                        'created_at' => $date,
                    );

                    DB::table('file_upload_list')->insert($file_upload);
                }
            }
        }



        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Spot And Progress Report',
            'menu'    => 'Progress Report',
            'activity' => 'Update',
            'description' => 'Updated Progress Report Record',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated progress report!');
    }

    public function fileDelete($id)
    {
        $fileinfo = DB::table('progress_report_files')->where('id', $id)->get();
        if (File::exists('/files/uploads/progress_reports/' . $fileinfo[0]->filenames)) {
            unlink(public_path('/files/uploads/progress_reports/' . $fileinfo[0]->filenames));
        }
        DB::table('progress_report_files')->where('id', $id)->delete();

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Progress Report',
            'menu'    => 'Progress Report Module',
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


    // Print PDF Format
    function viewPDF($id)
    {
        $spot_report = $this->get_spot_report($id);


        $regional_office = DB::table('regional_office as a')
            ->leftjoin('preops_header as b', 'a.ro_code', '=', 'b.ro_code')
            ->select('a.name', 'a.address', 'a.contact_number', 'a.report_header')
            ->where('b.preops_number', $spot_report[0]->preops_number)->get();
        $region = DB::table('region')->where('region_c', $spot_report[0]->region_c)->get();
        $province = DB::table('province')->where('province_c', $spot_report[0]->province_c)->get();
        $city = DB::table('city')->where('city_c', $spot_report[0]->city_c)->get();
        $barangay = DB::table('barangay')->where('barangay_c', $spot_report[0]->barangay_c)->get();
        $operating_unit = DB::table('operating_unit')->where('id', $spot_report[0]->operating_unit_id)->get();
        $operation_type = DB::table('operation_type')->where('id', $spot_report[0]->operation_type_id)->get();

        $suspect = DB::table('spot_report_suspect as a')
            ->leftjoin('spot_report_header as b', 'a.spot_report_number', '=', 'b.spot_report_number')
            ->leftjoin('drug_type as c', 'a.drug_type_id', '=', 'c.id')
            ->select(
                'a.lastname',
                'a.firstname',
                'a.middlename',
                'a.alias',
                'a.drug_test_result',
                'a.whereabouts',
                'c.name as drug_name'
            )
            ->where('b.id', $id)->get();
        $evidence = DB::table('spot_report_evidence as a')
            ->leftjoin('spot_report_header as b', 'a.spot_report_number', '=', 'b.spot_report_number')
            ->leftjoin('evidence as c', 'a.evidence_id', '=', 'c.id')
            ->leftjoin('packaging as e', 'a.packaging_id', '=', 'e.id')
            ->leftjoin('unit_measurement as d', 'a.unit', '=', 'd.id')
            ->select('c.name as evidence_type', 'd.name as unit_measurement', 'a.evidence', 'a.quantity', 'a.actual_qty', 'e.name as packaging')
            ->where('b.id', $id)->get();
        $case = DB::table('spot_report_case as a')
            ->leftjoin('spot_report_header as b', 'a.spot_report_number', '=', 'b.spot_report_number')
            ->leftjoin('case_list as c', 'a.case_id', '=', 'c.id')
            ->leftjoin('spot_report_suspect as d', 'a.suspect_number', '=', 'd.suspect_number')
            ->select('c.description as case', 'd.lastname', 'd.firstname', 'd.middlename', 'a.case_status')
            ->where('b.id', $id)->get();
        $team = DB::table('spot_report_team as a')
            ->leftjoin('spot_report_header as b', 'a.spot_report_number', '=', 'b.spot_report_number')
            ->where('b.id', $id)->get();

        $reported_date = Carbon::createFromFormat('Y-m-d', $spot_report[0]->reported_date)->format('F j,Y');
        $operation_datetime = Carbon::createFromFormat('Y-m-d H:i:s', $spot_report[0]->operation_datetime)->format('F j, Y g:i A');

        // date_default_timezone_set('Asia/Manila');
        $date = Carbon::now();
        $Sdate = Carbon::now()->format('F j, Y g:i A');

        $pdf = PDF::loadView('progress_report.progress_report_PDF', compact(
            'spot_report',
            'regional_office',
            'region',
            'province',
            'city',
            'barangay',
            'operating_unit',
            'operation_type',
            'suspect',
            'date',
            'evidence',
            'case',
            'team',
            'reported_date',
            'operation_datetime',
            'Sdate'
        ));
        $canvas = $pdf->getDomPDF()->getCanvas();
        $canvas->page_script('$pdf->set_opacity(.5);
        $pdf->image("/public/images/Sector_1.png", {x}, {y}, {w}, {h});');
        return $pdf->stream();
    }

    public function search_spot_report_number(Request $request)
    {
        if (Auth::user()->user_level_id == 2) {
            $spot_report_number = DB::table('spot_report_header as a')
                ->where('a.spot_report_number', 'LIKE', '%' . $request->input('term', '') . '%')
                ->where('a.report_status', 0)
                ->orderby('a.id', 'desc')
                ->get(['a.id as id', 'a.spot_report_number as text']);
        } else {
            $spot_report_number = DB::table('spot_report_header as a')
                ->leftjoin('regional_office as d', 'a.region_c', '=', 'd.region_c')
                ->where('a.spot_report_number', 'LIKE', '%' . $request->input('term', '') . '%')
                ->where('d.id', Auth::user()->regional_office_id)
                ->where('a.report_status', 0)
                ->orderby('a.id', 'desc')
                ->get(['a.id as id', 'a.spot_report_number as text']);
        }
        return ['results' => $spot_report_number];
    }
}
