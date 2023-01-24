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
use Illuminate\Support\Facades\View;


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

    public function index(Request $request)
    {
        if (Auth::user()->user_level_id == 2) {
            $data = DB::table('preops_header as a')
                ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
                ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
                ->select('a.id', 'a.preops_number', 'a.operation_datetime', 'b.name as operating_unit', 'c.name as operation_type', 'a.status', 'a.validity', 'a.with_aor', 'a.with_sr', 'a.with_pr')
                ->orderby('a.id', 'desc')
                ->paginate(20);

            $regional_office = DB::table('regional_office')->orderby('print_order', 'asc')->get();
        } else {
            $data = DB::table('preops_header as a')
                ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
                ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
                ->leftjoin('regional_office as d', 'a.ro_code', '=', 'd.ro_code')
                ->select('a.id', 'a.preops_number', 'a.operation_datetime', 'b.description as operating_unit', 'c.name as operation_type', 'a.status', 'a.validity', 'a.with_aor', 'a.with_sr', 'a.with_pr')
                ->orderby('a.id', 'desc')
                ->where('d.id', Auth::user()->regional_office_id)
                ->orderby('a.id', 'desc')
                ->paginate(20);

            $regional_office = DB::table('regional_office')
                ->where('id', Auth::user()->regional_office_id)
                ->get();
        }

        return view('issuance_of_preops.issuance_of_preops_list', compact('data', 'regional_office'));
    }

    public function fetch_data(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('preops_header as a')
                ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
                ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
                ->select('a.id', 'a.preops_number', 'a.operating_unit_id', 'a.operation_type_id', 'b.description as operating_unit', 'c.name as operation_type', 'a.operation_datetime', 'a.ro_code', 'a.status', 'a.status', 'a.validity', 'a.with_aor', 'a.with_sr', 'a.with_pr');

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

            $data = $data->paginate(20);

            // dd($data);

            return view('issuance_of_preops.preops_data', compact('data'))->render();
        }
    }

    public function search_preops_list(Request $request)
    {

        $param = $request->get('param');

        if (Auth::user()->user_level_id == 2) {
            $data = DB::table('preops_header as a')
                ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
                ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
                ->select('a.id', 'a.preops_number', 'a.operation_datetime', 'b.name as operating_unit', 'c.name as operation_type', 'a.status', 'a.validity', 'a.with_aor', 'a.with_sr', 'a.with_pr')
                ->where('a.preops_number', 'LIKE', '%' . $param . '%')
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
                ->orderby('a.id', 'desc')
                ->paginate(20);
        }
        return view('issuance_of_preops.preops_data', compact('data'))->render();
    }

    public function add()
    {

        $region = DB::table('region')->where('status', true)->orderby('region_sort', 'asc')->get();
        $province = DB::table('province')->where('status', true)->orderby('province_c', 'asc')->get();
        // $operating_unit = DB::table('operating_unit')->where('status', true)->where('region_c', Auth::user()->region_c)->orderby('name', 'asc')->get();
        $operation_type = DB::table('operation_type')->where('status', true)->where('show_preops', true)->orderby('name', 'asc')->get();
        $nationality = DB::table('nationality')->where('status', true)->orderby('name', 'asc')->get();
        $support_unit = DB::table('support_unit')->where('status', true)->orderby('name', 'asc')->get();
        $regional_office = DB::table('regional_office')->orderby('print_order', 'asc')->get();
        $regional_user = DB::table('users')->where('user_level_id', 3)->get();
        $roc_regional_office = DB::table('regional_office')->where('id', Auth::user()->regional_office_id)->get();
        $roc_regional_officer = DB::table('users')->where('regional_office_id', Auth::user()->regional_office_id)->get();
        $regional_province = DB::table('province')->where('region_c', $roc_regional_office[0]->region_c)->where('status', true)->orderby('province_m', 'asc')->get();


        if (Auth::user()->user_level_id == 2) {
            $operating_unit = DB::table('operating_unit')->where('status', true)->orderby('name', 'asc')->get();
            $approved_by = DB::table('approved_by')->orderby('name', 'asc')->get();
        } else {
            $operating_unit = DB::table('operating_unit')->where('status', true)->where('region_c', Auth::user()->region_c)->orderby('name', 'asc')->get();
            $approved_by = DB::table('approved_by as a')
                ->join('regional_office as b', 'a.ro_code', '=', 'b.ro_code')
                ->select('a.name', 'a.id')
                ->where('b.region_c', Auth::user()->region_c)
                ->orderby('a.name', 'asc')
                ->get();
        }

        date_default_timezone_set('Asia/Manila');
        $date = Carbon::now()->format('mdY');

        $preops_id = 0 + DB::table('preops_header')
            ->where('ro_code', $roc_regional_office[0]->ro_code)
            ->whereDate('coordinated_datetime', Carbon::now()->format('Y-m-d'))
            ->count();
        $preops_id += 1;
        $preops_id = sprintf("%03s", $preops_id);

        return view('issuance_of_preops.issuance_of_preops_add', compact('region', 'province', 'operating_unit', 'operation_type', 'nationality', 'support_unit', 'regional_office', 'regional_user', 'roc_regional_office', 'date', 'preops_id', 'roc_regional_officer', 'regional_province', 'approved_by'));
    }

    public function store(Request $request)
    {

        // dd($request->all());
        $data = $request->all();
        date_default_timezone_set('Asia/Manila');
        $date = Carbon::now();

        // Auto Preops Number
        date_default_timezone_set('Asia/Manila');
        $p_date = Carbon::now()->format('mdY');
        $preops_id = 0 + DB::table('preops_header')
            ->where('ro_code', $request->ro_code)
            ->where('province_c', $request->hprovince_c)
            ->whereDate('coordinated_datetime', Carbon::now()->format('Y-m-d'))
            ->count();
        $preops_id += 1;
        $preops_id = sprintf("%03s", $preops_id);

        if (Auth::user()->user_level_id == 2) {
            $preops_number = $request->preops_number;
        } else {
            $preops_number = $request->ro_code . '-' . $request->hprovince_c . '-' . $p_date . '-' . $preops_id;
        }


        $form_data = array(
            'preops_number' => $preops_number,
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

        DB::table('preops_header')->insert($form_data);

        $preops_id_c =  DB::table('preops_header')->where('preops_number', $preops_number)->select('id')->get();

        if ($request->hasfile('fileattach')) {
            foreach ($request->file('fileattach') as $file) {
                $filename = $file->getClientOriginalName();
                // $filename = pathinfo($fileinfo, PATHINFO_FILENAME);
                $filePath = public_path() . '/files/uploads/issuance_of_preops/';
                $file->move($filePath, $filename);

                $file_data = array(
                    'preops_number' => $preops_number,
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
            DB::table('preops_support_unit')->where('preops_number', $preops_number)->delete();

            for ($i = 0; $i < count($data['support_unit_id']); $i++) {
                if ($data['support_unit_id'][$i] != NULL) {

                    $ops_su_data = [
                        'preops_number' => $preops_number,
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
                    'preops_number' => $preops_number,
                    'region_c' => $data['area_region_c'][$i],
                    'province_c' => $data['province_c'][$i],
                    'city_c' => $data['city_c'][$i],
                    'barangay_c' => $data['barangay_c'][$i],
                    'ops_status' => false,
                ];

                DB::table('preops_area')->updateOrInsert(['id' => $id], $ops_area_data);
            } else {
                $id = 0 + DB::table('preops_area')->max('id');
                $id += 1;

                $ops_area_data = [
                    'area' => 'N/A',
                    'preops_number' => $preops_number,
                    'region_c' => $data['area_region_c'][$i],
                    'province_c' => $data['province_c'][$i],
                    'city_c' => $data['city_c'][$i],
                    'barangay_c' => $data['barangay_c'][$i],
                    'ops_status' => false,
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
                    'preops_number' => $preops_number,
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
                    'preops_number' => $preops_number,
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

        $preops_id_c = $preops_id_c[0]->id;


        return back()->with('success', 'COC Issuance has been saved to records.')->with('preops_id_c', $preops_id_c);
    }

    public function edit($id)
    {
        $issuance_of_preops = DB::table('preops_header')->where('id', $id)->get();
        $operating_unit = DB::table('operating_unit')->where('id', $issuance_of_preops[0]->operating_unit_id)->get();
        $region = DB::table('region')->orderby('region_sort', 'asc')->get();
        $province = DB::table('province as a')
            ->join('regional_office as b', 'a.region_c', '=', 'b.region_c')
            ->where('b.ro_code', $issuance_of_preops[0]->ro_code)
            ->orderby('province_m', 'asc')
            ->get();
        // $operating_unit = DB::table('operating_unit')->where('status', true)->orderby('name', 'asc')->get();
        if (Auth::user()->user_level_id == 2) {
            $approved_by = DB::table('approved_by')->orderby('name', 'asc')->get();
        } else {
            $approved_by = DB::table('approved_by as a')
                ->join('regional_office as b', 'a.ro_code', '=', 'b.ro_code')
                ->select('a.name', 'a.id')
                ->where('b.region_c', Auth::user()->region_c)
                ->orderby('a.name', 'asc')
                ->get();
        }
        $operation_type = DB::table('operation_type')->where('status', true)->where('show_preops', true)->orderby('name', 'asc')->get();
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
        $preops_support_unit = DB::table('preops_support_unit as a')
            ->leftjoin('operating_unit as b', 'a.support_unit_id', '=', 'b.id')
            ->select('b.id', 'b.description')
            ->where('a.preops_number', $issuance_of_preops[0]->preops_number)->get();

        return view('issuance_of_preops.issuance_of_preops_edit', compact(
            'issuance_of_preops',
            'region',
            'operation_type',
            'nationality',
            'area',
            'team',
            'target',
            'province',
            'regional_office',
            'regional_user',
            'issuance_of_preops_files',
            'preops_support_unit',
            'approved_by',
            'operating_unit'
        ));
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
                        'ops_status' => false,
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

    // Print PDF Format
    function viewPDF1($id)
    {
        date_default_timezone_set('Asia/Manila');
        $date = Carbon::now();

        $pos_data = array(
            'print_count' => DB::raw('print_count+1'),
            'print_date' => $date,
        );
        DB::table('spot_report_header')->where('id', $id)->update($pos_data);

        $spot_report = DB::table('spot_report_header as a')
            ->leftjoin('region as b', 'a.region_c', '=', 'b.region_c')
            ->leftjoin('province as c', 'a.province_c', '=', 'c.province_c')
            ->leftjoin('city as d', 'a.city_c', '=', 'd.city_c')
            ->leftjoin('operating_unit as e', 'a.operating_unit_id', '=', 'e.id')
            ->leftjoin('operation_type as f', 'a.operation_type_id', '=', 'f.id')
            ->leftjoin('barangay as g', 'a.barangay_c', '=', 'g.barangay_c')
            ->select(
                'a.spot_report_number',
                'a.preops_number',
                'a.reported_date',
                'a.operation_datetime',
                'a.remarks',
                'a.summary',
                'a.print_count',
                'b.region_m',
                'c.province_m',
                'd.city_m',
                'e.description as operating_unit',
                'f.name as operation_type',
                'a.region_c',
                'g.barangay_m'
            )
            ->where('a.id', $id)
            ->get();

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

        $pdf = PDF::loadView('spot_report.spot_report_PDF', compact(
            'spot_report',
            'regional_office',
            'evidence',
            'case',
            'team',
            'support_unit',
            'date'
        ));
        $canvas = $pdf->getDomPDF()->getCanvas();
        $canvas->page_script('$pdf->set_opacity(.5);
        $pdf->image("/public/images/Sector_1.png", {x}, {y}, {w}, {h});');
        return $pdf->stream();
    }


    function viewPDF($id)
    {
        date_default_timezone_set('Asia/Manila');
        $date = Carbon::now();

        $pos_data = array(
            'print_count' => DB::raw('print_count+1'),
            'print_date' => $date,
        );
        DB::table('preops_header')->where('id', $id)->update($pos_data);

        $preops_data = DB::table('preops_header')
            ->where('id', $id)
            ->get();

        $regional_office = DB::table('regional_office')->where('ro_code', $preops_data[0]->ro_code)->get();
        $operating_unit = DB::table('operating_unit')->where('id', $preops_data[0]->operating_unit_id)->get();
        $support_unit = DB::table('preops_support_unit as a')
            ->leftjoin('operating_unit as b', 'a.support_unit_id', '=', 'b.id')
            ->where('a.preops_number', $preops_data[0]->preops_number)->get();
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
        $coordinated_datetime = Carbon::createFromFormat('Y-m-d H:i:s', $preops_data[0]->coordinated_datetime);
        $validity = Carbon::createFromFormat('Y-m-d H:i:s', $preops_data[0]->validity);
        $duration = $operation_datetime->diffInHours($validity);
        $approved_by = DB::table('approved_by')->where('id', $preops_data[0]->approved_by)->get();

        $pdf = PDF::loadView('issuance_of_preops.preops_PDF', compact(
            'preops_data',
            'regional_office',
            'operating_unit',
            'area',
            'target',
            'operation_datetime',
            'coordinated_datetime',
            'validity',
            'duration',
            'date',
            'operation_type',
            'approved_by',
            'support_unit'
        ));
        $canvas = $pdf->getDomPDF()->getCanvas();
        $canvas->page_script('$pdf->set_opacity(.5);
        $pdf->image("/public/images/Sector_1.png", {x}, {y}, {w}, {h});');
        return $pdf->stream();
    }

    public function get_preops_header_count($ro_code, $province_c)
    {
        date_default_timezone_set('Asia/Manila');

        $preops_id = 0 + DB::table('preops_header')
            ->where('ro_code', $ro_code)
            ->where('province_c', $province_c)
            ->whereDate('coordinated_datetime', Carbon::now()->format('Y-m-d'))
            ->count();
        $preops_id += 1;
        $preops_id = sprintf("%03s", $preops_id);

        return json_encode($preops_id);
    }

    public function search_preops(Request $request)
    {

        $q = $request->q;

        if (Auth::user()->user_level_id == 2) {
            if ($q != "") {

                $data = DB::table('preops_header as a')
                    ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
                    ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
                    ->leftjoin('spot_report_header as d', 'a.preops_number', '=', 'd.preops_number')
                    ->select('a.id', 'a.preops_number', 'a.operation_datetime', 'b.name as operating_unit', 'c.name as operation_type', 'a.status', 'a.validity', 'd.report_status', 'a.with_aor', 'a.with_sr')
                    ->where('a.preops_number', 'LIKE', '%' . $q . '%')
                    ->orderby('a.id', 'desc')
                    ->paginate(20)
                    ->setPath('');

                // dd($data);

                $pagination = $data->appends(array(
                    'q' => $request->q
                ));

                $regional_office = DB::table('regional_office')->orderby('print_order', 'asc')->get();
                $region = DB::table('region')->orderby('region_sort', 'asc')->get();
                $operating_unit = DB::table('operating_unit')->where('status', true)->orderby('description', 'asc')->get();
                $operation_type = DB::table('operation_type')->where('status', true)->where('operation_classification_id', 2)->orderby('name', 'asc')->get();

                if (count($data) > 0) {
                    return view('issuance_of_preops.issuance_of_preops_list', compact('data', 'region', 'operating_unit', 'operation_type', 'regional_office'));
                }
            }
        } else {
            if ($q != "") {

                $data = DB::table('preops_header as a')
                    ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
                    ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
                    ->leftjoin('regional_office as d', 'a.ro_code', '=', 'd.ro_code')
                    ->leftjoin('spot_report_header as e', 'a.preops_number', '=', 'e.preops_number')
                    ->select('a.id', 'a.preops_number', 'a.operation_datetime', 'b.description as operating_unit', 'c.name as operation_type', 'a.status', 'a.validity', 'e.report_status', 'a.with_aor', 'a.with_sr')
                    ->where('a.preops_number', 'LIKE', '%' . $q . '%')
                    ->where('d.id', Auth::user()->regional_office_id)
                    ->orderby('a.id', 'desc')
                    ->paginate(20)
                    ->setPath('');

                // dd($data);

                $pagination = $data->appends(array(
                    'q' => $request->q
                ));

                $regional_office = DB::table('regional_office')
                    ->where('id', Auth::user()->regional_office_id)
                    ->get();
                $region = DB::table('region')->orderby('region_sort', 'asc')->get();
                $operating_unit = DB::table('operating_unit')->where('status', true)->orderby('description', 'asc')->get();
                $operation_type = DB::table('operation_type')->where('status', true)->where('operation_classification_id', 2)->orderby('name', 'asc')->get();
                if (count($data) > 0) {
                    return view('issuance_of_preops.issuance_of_preops_list', compact('data', 'region', 'operating_unit', 'operation_type', 'regional_office'));
                }
            }
        }

        return view('issuance_of_preops.issuance_of_preops_list')->withMessage('No Details found. Try to search again !');
    }

    public function get_preops_header($preops_number)
    {
        dd($preops_number);
        date_default_timezone_set('Asia/Manila');

        $data = 0 + DB::table('preops_header as a')
            ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
            ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
            ->select(
                'a.id',
                'a.preops_number',
                'a.operation_datetime',
                'b.description as operating_unit',
                'c.name as operation_type',
                'a.status',
                'a.validity',
                'a.operating_unit_id',
                'a.operation_type_id'
            )
            ->where('id', $preops_number)
            ->get();
        return json_encode($data);
    }
}
