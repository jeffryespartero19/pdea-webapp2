<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\ProgressReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;

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
        $data = DB::table('spot_report_header as a')
            ->join('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
            ->join('operation_type as c', 'a.operation_type_id', '=', 'c.id')
            ->select('a.id', 'a.spot_report_number', 'a.operation_datetime', 'b.name as operating_unit', 'c.name as operation_type', 'a.status')
            ->where('a.report_status', 1)
            ->orderby('spot_report_number', 'asc')
            ->get();
        $region = DB::table('region')->orderby('region_sort', 'asc')->get();
        $operating_unit = DB::table('operating_unit')->where('status', true)->orderby('name', 'asc')->get();
        $operation_type = DB::table('operation_type')->where('status', true)->orderby('name', 'asc')->get();


        return view('progress_report.progress_report_list', compact('region', 'operating_unit', 'operation_type', 'data'));
    }

    public function add()
    {

        $region = DB::table('region')->orderby('region_sort', 'asc')->get();
        $operating_unit = DB::table('operating_unit')->where('status', true)->orderby('name', 'asc')->get();
        $operation_type = DB::table('operation_type')->where('status', true)->orderby('name', 'asc')->get();
        $spot_report_header = DB::table('spot_report_header')->where('status', true)->orderby('id', 'asc')->get();
        $civil_status = DB::table('civil_status')->where('active', true)->orderby('name', 'asc')->get();
        $religion = DB::table('religions')->where('active', true)->orderby('name', 'asc')->get();
        $education = DB::table('Educational_attainment')->where('status', true)->orderby('name', 'asc')->get();
        $ethnic_group = DB::table('ethnic_group')->where('status', true)->orderby('name', 'asc')->get();
        $nationality = DB::table('nationality')->where('status', true)->orderby('name', 'asc')->get();
        $occupation = DB::table('occupation')->where('status', true)->orderby('name', 'asc')->get();
        $suspect_status = DB::table('suspect_status')->where('status', true)->orderby('id', 'asc')->get();
        $regional_user = DB::table('users')->where('user_level_id', 3)->get();
        $suspect_classification = DB::table('suspect_classification')->where('status', true)->orderby('id', 'asc')->get();


        return view('progress_report.progress_report_add', compact('suspect_classification', 'region', 'operating_unit', 'spot_report_header', 'operation_type', 'civil_status', 'religion', 'education', 'ethnic_group', 'nationality', 'occupation', 'suspect_status', 'regional_user'));
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

        DB::table('spot_report_header')->where('spot_report_number', $request->spot_report_number)->update($pos_data);

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
                    ];

                    DB::table('spot_report_evidence')->updateOrInsert(['id' => $id], $spot_item);
                }
            }
        }


        //Save Suspect Case
        if (isset($data['suspect_number_case'])) {
            $spot_case = [];

            for ($i = 0; $i < count($data['spot_report_case_id']); $i++) {
                if ($data['spot_report_case_id'][$i] != NULL && $data['suspect_number_case'][$i] != NULL) {

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

        return back()->with('success', 'You have successfully updated issuance of preops!');
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
                'a.remarks',
                't.name as ulvl',
                's.name as uname',
                'r.listed',

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


        return view('progress_report.progress_report_edit', compact('suspect_classification', 'spot_report_suspect', 'spot_report_evidence', 'spot_report_case', 'region', 'province', 'city', 'barangay', 'operating_unit', 'spot_report_header', 'operation_type', 'civil_status', 'religion', 'education', 'ethnic_group', 'nationality', 'occupation', 'suspect_status', 'progress_report_files', 'regional_user'));
    }

    public function update(Request $request, $id)
    {

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

        $data = $request->all();
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
                    ];

                    DB::table('spot_report_evidence')->updateOrInsert(['id' => $id], $spot_item);
                }
            }
        }


        //Save Suspect Case
        if (isset($data['suspect_number_case'])) {
            $spot_case = [];

            for ($i = 0; $i < count($data['spot_report_case_id']); $i++) {
                if ($data['spot_report_case_id'][$i] != NULL && $data['suspect_number_case'][$i] != NULL) {

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

        return back()->with('success', 'You have successfully updated issuance of preops!');
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
}
