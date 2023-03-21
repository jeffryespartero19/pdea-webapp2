<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\AfterOperationReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;

class AfterOperationReportController extends Controller
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
            $data = DB::table('preops_header as a')
                ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
                ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
                ->select('a.id', 'a.preops_number', 'a.operation_datetime', 'b.description as operating_unit_name', 'c.name as operation_type_name', 'a.status', 'a.aor_date')
                ->where('a.with_aor', 1)
                ->orderby('a.id', 'desc')
                ->paginate(20);

            $regional_office = DB::table('regional_office')->orderby('print_order', 'asc')->get();
        } else {
            $data = DB::table('preops_header as a')
                ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
                ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
                ->join('regional_office as d', 'a.ro_code', '=', 'd.ro_code')
                ->select('a.id', 'a.preops_number', 'a.operation_datetime', 'b.description as operating_unit_name', 'c.name as operation_type_name', 'a.status', 'a.aor_date')
                ->where('a.with_aor', 1)
                ->where('d.id', Auth::user()->regional_office_id)
                ->orderby('a.id', 'desc')
                ->paginate(20);

            $regional_office = DB::table('regional_office')
                ->where('id', Auth::user()->regional_office_id)
                ->get();
        }

        $region = DB::table('region')->orderby('region_sort', 'asc')->get();

        return view('after_operation_report.after_operation_report_list', compact('data', 'region', 'regional_office'));
    }

    public function fetch_data(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('preops_header as a')
                ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
                ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
                ->select('a.id', 'a.preops_number', 'a.operating_unit_id', 'operation_type_id', 'b.description as operating_unit_name', 'c.name as operation_type_name', 'a.operation_datetime', 'a.aor_date', 'a.status')
                ->where('a.with_aor', 1);
            if ($request->get('ro_code') != 0) {
                $data->where(['a.ro_code' => $request->get('ro_code')]);
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

            $data = $data->orderby('a.id', 'desc')->paginate(20);

            return view('after_operation_report.after_operation_data', compact('data'))->render();
        }
    }

    public function search_preops_list(Request $request)
    {
        $param = $request->get('param');

        if (Auth::user()->user_level_id == 2) {
            $data = DB::table('preops_header as a')
                ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
                ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
                ->select('a.id', 'a.preops_number', 'a.operation_datetime', 'b.description as operating_unit', 'c.name as operation_type', 'a.status', 'a.validity', 'a.with_aor', 'a.with_sr', 'a.with_pr')
                ->where('a.preops_number', 'LIKE', '%' . $param . '%')
                ->where('a.with_aor', 1)
                ->orderby('a.id', 'desc')
                ->paginate(20);
        } else {
            $data = DB::table('preops_header as a')
                ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
                ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
                ->leftjoin('regional_office as d', 'a.ro_code', '=', 'd.ro_code')
                ->select('a.id', 'a.preops_number', 'a.operation_datetime', 'b.description as operating_unit', 'c.name as operation_type', 'a.status', 'a.validity', 'a.with_aor', 'a.with_sr', 'a.with_pr')
                ->where('a.preops_number', 'LIKE', '%' . $param . '%')
                ->where('d.id', Auth::user()->regional_office_id)
                ->where('a.with_aor', 1)
                ->orderby('a.id', 'desc')
                ->paginate(20);
        }
        return view('after_operation_report.after_operation_data', compact('data'))->render();
    }

    public function add()
    {

        $region = DB::table('region')->orderby('region_sort', 'asc')->get();
        $operating_unit = DB::table('operating_unit')->where('status', true)->orderby('name', 'asc')->get();
        $operation_type = DB::table('operation_type')->where('status', true)->orderby('name', 'asc')->get();
        $negative_reason = DB::table('negative_reason')->where('status', true)->orderby('name', 'asc')->get();


        if (Auth::user()->user_level_id == 2) {
            $preops = DB::table('preops_header')
                ->where('status', true)
                ->where('with_aor', 0)
                ->where('with_sr', 0)
                ->orderby('id', 'desc')->get();
        } else {
            $preops = DB::table('preops_header as a')
                ->leftjoin('regional_office as b', 'a.ro_code', '=', 'b.ro_code')
                ->where('a.status', true)
                ->where('b.id', Auth::user()->regional_office_id)
                ->where('a.with_aor', 0)
                ->where('a.with_sr', 0)
                ->orderby('a.id', 'desc')->get();
        }


        $regional_office = DB::table('regional_office')->orderby('print_order', 'asc')->get();
        $evidence = DB::table('evidence as a')
            ->join('evidence_type as b', 'a.evidence_type_id', '=', 'b.id')
            ->where('a.status', true)
            ->where('b.category', 'drug')
            ->select('a.id', 'a.name')->get();
        $unit_measurement = DB::table('unit_measurement')->where('status', true)->get();


        return view('after_operation_report.after_operation_report_add', compact('region', 'operating_unit', 'operation_type', 'preops', 'regional_office', 'unit_measurement', 'negative_reason', 'evidence'));
    }

    public function store(Request $request)
    {

        $data = $request->all();

        // dd($data);
        date_default_timezone_set('Asia/Manila');
        $aor_date = Carbon::now();

        $form_data = array(
            'received_date' => $request->received_date,
            'result' => $request->result,
            'negative_reason_id' => $request->negative_reason_id,
            'date_reported' => $request->date_reported,
            'with_aor' => 1,
            'aor_date' => $aor_date,
        );

        DB::table('preops_header')->where('id', $request->preops_number)->update($form_data);

        if ($request->hasfile('fileattach')) {
            foreach ($request->file('fileattach') as $file) {
                $filename = $file->getClientOriginalName();
                //$filename = pathinfo($fileinfo, PATHINFO_FILENAME);
                $filePath = public_path() . '/files/uploads/after_operations/';
                $file->move($filePath, $filename);

                $file_data = array(
                    'preops_number' => $request->preops_number,
                    'filenames' => $filename,
                );

                $file_id = DB::table('after_operation_files')->insertGetId($file_data);

                date_default_timezone_set('Asia/Manila');
                $date = Carbon::now();

                $file_upload = array(
                    'after_operation_file_id' => $file_id,
                    'filename' => $filename,
                    'transaction_type' => 2,
                    'created_at' => $date,
                );

                DB::table('file_upload_list')->insert($file_upload);
            }
        }

        //Save Item Seized
        if (isset($data['evidence_id'])) {
            // dd('test1');

            $item_seized = [];

            for ($i = 0; $i < count($data['evidence_id']); $i++) {
                if ($data['evidence_id'][$i] != NULL) {

                    $id = 0 + DB::table('after_operation_evidence')->max('id');
                    $id += 1;

                    $item_seized = [
                        'preops_number' => $request->preops_number,
                        'evidence_id' => $data['evidence_id'][$i],
                        'quantity' => $data['quantity'][$i],
                        'unit_measurement_id' => $data['unit_measurement_id'][$i],
                        'chemist_report_number' => $data['chemist_report_number'][$i],
                    ];

                    DB::table('after_operation_evidence')->updateOrInsert(['id' => $id], $item_seized);
                }
            }
        }

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'After Preops Report Setup',
            'activity' => 'Add',
            'description' => 'Added After Operations Report.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new After operations report!');
    }

    public function edit($preops_number)
    {
        $preops_header = DB::table('preops_header as a')
            ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
            ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
            ->select('a.id', 'a.ro_code', 'a.preops_number', 'a.operating_unit_id', 'operation_type_id', 'b.description as operating_unit_name', 'c.name as operation_type_name', 'a.operation_datetime', 'a.validity', 'a.received_date', 'a.result', 'a.negative_reason_id', 'a.date_reported', 'a.filename')
            ->where(['preops_number' => $preops_number])
            ->get();
        $region = DB::table('region')->orderby('region_sort', 'asc')->get();

        $after_operation_files = DB::table('after_operation_files')->where('preops_number', $preops_number)->get();
        $item_seized = DB::table('after_operation_evidence')->where('preops_number', $preops_number)->get();
        $regional_office = DB::table('regional_office')->orderby('print_order', 'asc')->get();
        $unit_measurement = DB::table('unit_measurement')->where('status', true)->get();
        $negative_reason = DB::table('negative_reason')->where('status', true)->orderby('name', 'asc')->get();
        $evidence = DB::table('evidence as a')
            ->leftjoin('evidence_type as b', 'a.evidence_type_id', '=', 'b.id')
            ->where('a.status', true)
            ->where('b.category', 'drug')
            ->select('a.id', 'a.name')->get();


        return view('after_operation_report.after_operation_report_edit', compact('evidence', 'preops_header', 'region', 'after_operation_files', 'item_seized', 'regional_office', 'unit_measurement', 'negative_reason'));
    }

    public function update(Request $request, $preops_number)
    {
        $data = $request->all();

        if (Auth::user()->user_level_id == 2) {
            $pos_data = array(
                'received_date' => $request->received_date,
                'result' => $request->result,
                'negative_reason_id' => $request->negative_reason_id,
                'date_reported' => $request->date_reported,
                'with_aor' => 1,
            );

            DB::table('preops_header')->where('preops_number', $request->preops_number)->update($pos_data);

            if ($request->hasfile('fileattach')) {
                foreach ($request->file('fileattach') as $file) {
                    $filename = $file->getClientOriginalName();
                    // $filename = pathinfo($fileinfo, PATHINFO_FILENAME);
                    $filePath = public_path() . '/files/uploads/after_operations/';
                    $file->move($filePath, $filename);

                    $file_data = array(
                        'preops_number' => $request->preops_number,
                        'filenames' => $filename,
                    );
                    $file_id = DB::table('after_operation_files')->insertGetId($file_data);

                    date_default_timezone_set('Asia/Manila');
                    $date = Carbon::now();

                    $file_upload = array(
                        'after_operation_file_id' => $file_id,
                        'filename' => $filename,
                        'transaction_type' => 2,
                        'created_at' => $date,
                    );

                    DB::table('file_upload_list')->insert($file_upload);
                }
            }

            //Save Item Seized
            if (isset($data['evidence_id'])) {
                // dd('test1');
                DB::table('after_operation_evidence')->whereNotIn('id', array_filter($data['aoe_id']))->delete();

                $aoe_item = [];

                for ($i = 0; $i < count($data['evidence_id']); $i++) {
                    if ($data['evidence_id'][$i] != NULL) {

                        if ($data['aoe_id'][$i] == null || $data['aoe_id'][$i] == 0) {
                            $id = 0 + DB::table('after_operation_evidence')->max('id');
                            $id += 1;
                        } else {
                            $id = $data['aoe_id'][$i];
                        }

                        $aoe_item = [
                            'preops_number' => $request->preops_number,
                            'evidence_id' => $data['evidence_id'][$i],
                            'quantity' => $data['quantity'][$i],
                            'unit_measurement_id' => $data['unit_measurement_id'][$i],
                            'chemist_report_number' => $data['chemist_report_number'][$i],
                        ];

                        DB::table('after_operation_evidence')->updateOrInsert(['id' => $id], $aoe_item);
                    }
                }
            }
        } elseif (Auth::user()->user_level_id == 3) {
            if ($request->hasfile('fileattach')) {
                foreach ($request->file('fileattach') as $file) {
                    $filename = $file->getClientOriginalName();
                    // $filename = pathinfo($fileinfo, PATHINFO_FILENAME);
                    $filePath = public_path() . '/files/uploads/after_operations/';
                    $file->move($filePath, $filename);

                    $file_data = array(
                        'preops_number' => $request->preops_number,
                        'filenames' => $filename,
                    );
                    $file_id = DB::table('after_operation_files')->insertGetId($file_data);

                    date_default_timezone_set('Asia/Manila');
                    $date = Carbon::now();

                    $file_upload = array(
                        'after_operation_file_id' => $file_id,
                        'filename' => $filename,
                        'transaction_type' => 2,
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
            'menu'    => 'After Preops Report Setup',
            'activity' => 'Add',
            'description' => 'Added After Operations Report.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated After operations report!');
    }

    public function fileDelete($id)
    {
        $fileinfo = DB::table('after_operation_files')->where('id', $id)->get();
        if (File::exists('/files/uploads/after_operations/' . $fileinfo[0]->filenames)) {
            unlink(public_path('/files/uploads/after_operations/' . $fileinfo[0]->filenames));
        }
        DB::table('after_operation_files')->where('id', $id)->delete();

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'After Operations',
            'menu'    => 'After Operations Module',
            'activity' => 'Delete',
            'description' => 'Deleted reference file.',
        );

        Audit::create($data_audit);

        return response()->json(array('success' => true));
    }

    public function get_after_operation_list($ro_code, $operating_unit_id, $operation_type_id, $operation_date)
    {
        $data = DB::table('preops_header as a')
            ->join('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
            ->join('operation_type as c', 'a.operation_type_id', '=', 'c.id')
            ->select('a.id', 'a.preops_number', 'a.operating_unit_id', 'operation_type_id', 'b.description as operating_unit_name', 'c.name as operation_type_name', 'a.operation_datetime', 'a.ro_code', 'a.status')
            ->whereNotNull('date_reported');
        if ($ro_code != 0) {
            $data->where(['a.ro_code' => $ro_code]);
        }
        if ($operating_unit_id != 0) {
            $data->where(['a.operating_unit_id' => $operating_unit_id]);
        }
        if ($operation_type_id != 0) {
            $data->where(['a.operation_type_id' => $operation_type_id]);
        }
        if ($operation_date != 0) {
            $data->where(DB::raw("(DATE_FORMAT(a.operation_datetime,'%Y-%m-%d'))"), $operation_date);
        }

        $data = $data->get();

        return json_encode($data);
    }

    public function search_preops_number(Request $request)
    {

        if (Auth::user()->user_level_id == 2) {
            $preops_number = DB::table('preops_header as a')
                ->select('a.id', 'a.preops_number as text')
                ->where('a.preops_number', 'LIKE', '%' . $request->input('term', '') . '%')
                ->where('a.with_aor', 0)
                ->where('a.with_sr', 0)
                ->orderby('a.id', 'desc')
                ->get();
        } else {
            $preops_number = DB::table('preops_header as a')
                ->leftjoin('regional_office as d', 'a.ro_code', '=', 'd.ro_code')
                ->select('a.id', 'a.preops_number as text')
                ->where('a.preops_number', 'LIKE', '%' . $request->input('term', '') . '%')
                ->where('d.id', Auth::user()->regional_office_id)
                ->where('a.with_sr', 0)
                ->where('a.with_aor', 0)
                ->orderby('a.id', 'desc')
                ->get();
        }


        return ['results' => $preops_number];
    }
}
