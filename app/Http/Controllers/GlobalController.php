<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Auth;
use Illuminate\Support\Facades\View;

class GlobalController extends Controller
{
    public function getProvince($region_c)
    {
        $data = DB::table('province')
            ->where(['region_c' => $region_c])
            ->get();

        return json_encode($data);
    }

    public function getCity($province_c)
    {
        $data = DB::table('city')
            ->where(['province_c' => $province_c])
            ->get();

        return json_encode($data);
    }

    public function getBarangay($city_c)
    {
        $data = DB::table('barangay')
            ->where(['city_c' => $city_c])
            ->get();

        return json_encode($data);
    }

    public function getUsers(Request $request)
    {
        $data = $request->all();
        $userX = DB::table('users')->where('id', $data['idx'])->get();

        return ($userX);
    }

    public function get_user_log(Request $request)
    {
        $time = Carbon::now()->addMinutes(-20)->format('Y-m-d H:i:s');

        $all_users = DB::table('users')->get();

        foreach ($all_users as $au) {
            DB::table('users')
                ->where('lastActive', '<', $time)
                ->update(
                    array(
                        'is_logged_in' => 0,
                    )
                );
        }

        $users = DB::table('users')->where('is_logged_in', 1)->get();
        $on_duty = count($users);

        return ($on_duty);
    }

    public function getUser($user_id)
    {
        $data = DB::table('users')->where('id', $user_id)->get();

        return json_encode($data);
    }

    public function getPreopsNumber($region_c)
    {
        $data = DB::table('preops_header')
            ->where(['region_c' => $region_c])
            ->get();

        return json_encode($data);
    }

    public function getPreopsHeader($preops_number)
    {

        $data = DB::table('preops_header as a')
            ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
            ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
            ->leftjoin('regional_office as d', 'a.ro_code', '=', 'd.ro_code')
            ->leftjoin('region as e', 'a.region_c', '=', 'e.region_c')
            ->leftjoin('province as f', 'a.province_c', '=', 'f.province_c')
            ->select(
                'a.id',
                'd.ro_code',
                'a.preops_number',
                'a.operating_unit_id',
                'a.operation_type_id',
                'b.description as operating_unit_name',
                'c.name as operation_type_name',
                'a.validity',
                'd.region_c',
                'a.province_c',
                'a.support_unit_id',
                'f.province_m',
                DB::raw('DATE_FORMAT(a.operation_datetime, "%Y-%m-%dT%H:%m") as operation_datetime'),
            )
            ->where('a.id', $preops_number)
            ->get();

        return json_encode($data);
    }

    public function getPreopsTeam($preops_number)
    {
        $data = DB::table('preops_team')
            ->where(['preops_number' => $preops_number])
            ->get();

        return json_encode($data);
    }

    public function getPreopsArea($preops_number)
    {
        $data = DB::table('preops_area as a')
            ->leftjoin('region as b', 'a.region_c', '=', 'b.region_c')
            ->leftjoin('province as c', 'a.province_c', '=', 'c.province_c')
            ->leftjoin('city as d', 'a.city_c', '=', 'd.city_c')
            ->leftjoin('barangay as e', 'a.barangay_c', '=', 'e.barangay_c')
            ->select('a.preops_number', 'b.region_m', 'c.province_m', 'd.city_m', 'e.barangay_m', 'a.area')
            ->where(['a.preops_number' => $preops_number])
            ->get();

        return json_encode($data);
    }

    public function get_preops_list($ro_code, $operating_unit_id, $operation_type_id, $operation_date, $operation_date_to)
    {

        $data = DB::table('preops_header as a')
            ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
            ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
            ->leftjoin('spot_report_header as d', 'a.preops_number', '=', 'd.preops_number')
            ->select('a.id', 'a.preops_number', 'a.operating_unit_id', 'a.operation_type_id', 'b.description as operating_unit', 'c.name as operation_type', 'a.operation_datetime', 'a.ro_code', 'a.status', 'a.status', 'a.validity', 'd.report_status', 'a.with_aor', 'a.with_sr');

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
            $data->where(DB::raw("(DATE_FORMAT(a.operation_datetime,'%Y-%m-%d'))"), '>=', $operation_date);
        }
        if ($operation_date_to != 0) {
            $data->where(DB::raw("(DATE_FORMAT(a.operation_datetime,'%Y-%m-%d'))"), '<=', $operation_date_to);
        }

        $data = $data->paginate(20);

        $response = array(
            'datas' => $data,
            'links' => $data->links()->render()
        );

        // dd($data);

        // return Response::json(View::make('issuance_of_preops.ajax.data', ['data' => $data])->render());

        return json_encode(View::make('issuance_of_preops.ajax.data', ['data' => $data])->render());

        // return view('issuance_of_preops.issuance_of_preops_list', compact('data', 'region', 'operating_unit', 'operation_type', 'regional_office'));
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

    public function get_spot_report_header($spot_report_number)
    {

        $data = DB::table('spot_report_header as a')
            ->leftjoin('region as b', 'a.region_c', '=', 'b.region_c')
            ->leftjoin('operating_unit as c', 'a.operating_unit_id', '=', 'c.id')
            ->leftjoin('operation_type as d', 'a.operation_type_id', '=', 'd.id')
            ->leftjoin('province as e', 'a.province_c', '=', 'e.province_c')
            ->leftjoin('city as f', 'a.city_c', '=', 'f.city_c')
            ->leftjoin('barangay as g', 'a.barangay_c', '=', 'g.barangay_c')
            ->select(
                'a.id',
                'a.spot_report_number',
                'd.name as operation_type_name',
                'a.operation_type_id',
                'a.operating_unit_id',
                'c.description as operating_unit_name',
                'a.region_c',
                'b.region_m',
                'a.operation_datetime',
                'a.province_c',
                'e.province_m',
                'a.city_c',
                'f.city_m',
                'a.barangay_c',
                'g.barangay_m',
                'a.area',
                'a.street'
            )
            ->where(['a.id' => $spot_report_number])
            ->get();

        return json_encode($data);
    }

    public function get_spot_report_list($region_c, $operating_unit_id, $operation_type_id, $operation_date, $operation_date_to)
    {
        $data = DB::table('spot_report_header as a')
            ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
            ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
            ->select('a.id', 'a.spot_report_number', 'a.operating_unit_id', 'operation_type_id', 'b.description as operating_unit_name', 'c.name as operation_type_name', 'a.operation_datetime', 'a.region_c', 'a.status', 'a.created_at', 'a.preops_number')
            ->where('a.report_status', 0);
        if ($region_c != 0) {
            $data->where(['a.region_c' => $region_c]);
        }
        if ($operating_unit_id != 0) {
            $data->where(['a.operating_unit_id' => $operating_unit_id]);
        }
        if ($operation_type_id != 0) {
            $data->where(['a.operation_type_id' => $operation_type_id]);
        }
        if ($operation_date != 0) {
            $data->where(DB::raw("(DATE_FORMAT(a.operation_datetime,'%Y-%m-%d'))"), '>=', $operation_date);
        }
        if ($operation_date_to != 0) {
            $data->where(DB::raw("(DATE_FORMAT(a.operation_datetime,'%Y-%m-%d'))"), '<=', $operation_date_to);
        }

        $data = $data->paginate(20);

        $response = array(
            'datas' => $data,
            'links' => $data->links()->render()
        );

        // dd($data);

        return json_encode($response);
    }

    public function get_spot_report_suspect($spot_report_number)
    {
        // dd($spot_report_number);
        $data = DB::table('spot_report_suspect as a')
            ->leftjoin('spot_report_header as aa', 'aa.spot_report_number', '=', 'a.spot_report_number')
            ->leftjoin('region as b', 'a.region_c', '=', 'b.region_c')
            ->leftjoin('region as c', 'a.permanent_region_c', '=', 'c.region_c')
            ->leftjoin('province as d', 'a.province_c', '=', 'd.province_c')
            ->leftjoin('province as e', 'a.permanent_province_c', '=', 'e.province_c')
            ->leftjoin('city as f', 'a.city_c', '=', 'f.city_c')
            ->leftjoin('city as g', 'a.permanent_city_c', '=', 'g.city_c')
            ->leftjoin('barangay as h', 'a.barangay_c', '=', 'h.barangay_c')
            ->leftjoin('barangay as i', 'a.permanent_barangay_c', '=', 'i.barangay_c')
            ->leftjoin('civil_status as j', 'a.civil_status_id', '=', 'j.id')
            ->leftjoin('nationality as k', 'a.nationality_id', '=', 'k.id')
            ->leftjoin('ethnic_group as l', 'a.ethnic_group_id', '=', 'l.id')
            ->leftjoin('religions as m', 'a.religion_id', '=', 'm.id')
            ->leftjoin('educational_attainment as n', 'a.educational_attainment_id', '=', 'n.id')
            ->leftjoin('occupation as o', 'a.occupation_id', '=', 'o.id')
            ->leftjoin('suspect_status as p', 'a.suspect_status_id', '=', 'p.id')
            ->leftjoin('suspect_classification as q', 'a.suspect_classification_id', '=', 'q.id')
            ->leftjoin('drug_management as r', 'a.id', '=', 'r.suspect_id')
            ->leftjoin('users as s', 's.id', '=', 'r.user_id')
            ->leftjoin('tbluserlevel as t', 's.user_level_id', '=', 't.id')
            ->leftjoin('suspect_category as u', 'a.suspect_category_id', '=', 'u.id')
            ->leftjoin('suspect_sub_category as v', 'a.suspect_sub_category_id', '=', 'v.id')
            ->leftjoin('suspect_status as w', 'a.suspect_status_id', '=', 'w.id')
            ->leftjoin('identifier as x', 'a.identifier_id', '=', 'x.id')

            ->select(
                'a.id',
                'a.suspect_number',
                'a.lastname',
                'a.firstname',
                'a.middlename',
                'a.alias',
                'a.birthdate',
                'a.est_birthdate',
                'a.birthplace',
                'b.region_m',
                'c.region_m as permanent_region_m',
                'd.province_m',
                'e.province_m as permanent_province_m',
                'f.city_m',
                'g.city_m as permanent_city_m',
                'h.barangay_m',
                'i.barangay_m as permanent_barangay_m',
                'a.street',
                'a.street as permanent_street',
                'a.gender',
                'j.name as civil_status',
                'k.name as nationality',
                'l.name as ethnic_group',
                'm.name as religion',
                'n.name as educational_attainment',
                'o.name as occupation',
                'p.name as suspect_status',
                'q.name as suspect_classification',
                'a.remarks',
                't.name as ulvl',
                's.name as uname',
                'r.listed',
                'u.name as suspect_category',
                'v.name as suspect_sub_category',
                'w.name as suspect_status',
                'x.name as identifier',

            )
            ->where(['aa.id' => $spot_report_number])
            ->get();

        // dd($data);

        return json_encode($data);
    }


    public function get_spot_report_evidence_drug($spot_report_number)
    {
        $data = DB::table('spot_report_evidence as a')
            ->leftjoin('spot_report_header as aa', 'aa.spot_report_number', '=', 'a.spot_report_number')
            ->leftjoin('spot_report_suspect as b', 'a.suspect_number', '=', 'b.suspect_number')
            ->leftjoin('evidence as c', 'a.evidence_id', '=', 'c.id')
            ->leftjoin('unit_measurement as d', 'c.unit_measurement_id', '=', 'd.id')
            ->select(
                'a.id as spot_report_evidence_id',
                'b.suspect_number',
                'b.lastname',
                'b.firstname',
                'b.middlename',
                'b.alias',
                'c.name as evidence',
                'd.name as unit_measurement',
                'a.quantity'
            )
            ->where(['aa.id' => $spot_report_number])
            ->where(['a.drug' => 'drug'])
            ->get();

        return json_encode($data);
    }

    public function get_spot_report_case($spot_report_number)
    {
        $data = DB::table('spot_report_case as a')
            ->leftjoin('spot_report_header as aa', 'aa.spot_report_number', '=', 'a.spot_report_number')
            ->leftjoin('spot_report_suspect as b', 'a.suspect_number', '=', 'b.suspect_number')
            ->leftjoin('case_list as c', 'a.case_id', '=', 'c.id')
            ->select(
                'a.id as spot_report_case_id',
                'b.suspect_number',
                'b.lastname',
                'b.firstname',
                'b.middlename',
                'b.alias',
                'c.description',
            )
            ->where(['aa.id' => $spot_report_number])
            ->get();

        return json_encode($data);
    }

    public function get_progress_report_list($region_c, $operating_unit_id, $operation_type_id, $operation_date)
    {
        $data = DB::table('spot_report_header as a')
            ->join('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
            ->join('operation_type as c', 'a.operation_type_id', '=', 'c.id')
            ->select('a.id', 'a.spot_report_number', 'a.operating_unit_id', 'operation_type_id', 'b.description as operating_unit_name', 'c.name as operation_type_name', 'a.operation_datetime', 'a.region_c', 'a.status')
            ->where('a.report_status', 1);
        if ($region_c != 0) {
            $data->where(['a.region_c' => $region_c]);
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

    public function getDrugManagement($suspect_id)
    {
        $data = DB::table('drug_management as a')
            ->rightjoin('spot_report_suspect as b', 'a.suspect_id', '=', 'b.id')
            ->select('a.id', 'a.suspect_id', 'b.lastname', 'b.firstname', 'b.middlename', 'a.listed', 'a.ndis_id', 'a.remarks', 'b.suspect_category_id', 'b.suspect_sub_category_id', 'b.suspect_classification_id', 'b.identifier_id')
            ->where('b.id', $suspect_id)
            ->get();

        // dd($data);
        return json_encode($data);
    }

    public function getPreopsSupportUnit($preops_number)
    {
        $data = DB::table('preops_support_unit as a')
            ->leftjoin('preops_header as c', 'a.preops_number', '=', 'c.preops_number')
            ->leftjoin('operating_unit as b', 'a.support_unit_id', '=', 'b.id')
            ->select('b.id', 'b.description')
            ->where(['c.id' => $preops_number])
            ->get();

        return json_encode($data);
    }

    public function getUnitMeasure($evidence_id)
    {
        $data = DB::table('evidence as a')
            ->join('unit_measurement as b', 'a.unit_measurement_id', '=', 'b.id')
            ->select('b.name as unit_measurement', 'b.id')
            ->where(['a.id' => $evidence_id])
            ->get();

        return json_encode($data);
    }

    public function getEvidenceType($category)
    {
        $data = DB::table('evidence as a')
            ->join('evidence_type as b', 'a.evidence_type_id', '=', 'b.id')
            ->select('a.name as evidence', 'a.id')
            ->where(['b.category' => $category])
            ->get();

        return json_encode($data);
    }

    public function get_operation_type($operation_type_id)
    {
        $data = DB::table('operation_type')
            ->where(['id' => $operation_type_id])
            ->get();

        return json_encode($data);
    }

    public function get_province_details($province_c)
    {
        $data = DB::table('province')
            ->where(['province_c' => $province_c])
            ->get();

        return json_encode($data);
    }

    public function get_suspect_category($suspect_classification_id)
    {
        $data = DB::table('suspect_category')
            ->where(['suspect_classification_id' => $suspect_classification_id])
            ->get();

        return json_encode($data);
    }

    public function get_suspect_sub_category($suspect_category_id)
    {
        $data = DB::table('suspect_sub_category')
            ->where(['suspect_category_id' => $suspect_category_id])
            ->get();

        return json_encode($data);
    }

    public function get_operating_unit($ro_code)
    {
        $data = DB::table('operating_unit as a')
            ->join('regional_office as b', 'a.region_c', '=', 'b.region_c')
            ->select('a.name', 'a.id', 'a.description')
            ->where(['b.ro_code' => $ro_code])
            ->get(['a.id as id', 'a.description as text']);

        // return json_encode($data);

        // $operating_unit = DB::table('support_unit as a')
        //     ->where('a.name', 'LIKE', '%' . $request->input('term', '') . '%')
        //     ->get(['a.id as id', 'a.name as text']);

        // dd($operating_unit);

        return ['results' => $data];
    }

    public function get_approved_by($ro_code)
    {
        $data = DB::table('approved_by')
            ->where(['ro_code' => $ro_code])
            ->get();

        return json_encode($data);
    }

    public function get_operation_category($operation_classification_id)
    {
        $data = DB::table('operation_category')
            ->where(['operation_classification_id' => $operation_classification_id])
            ->get();

        return json_encode($data);
    }

    public function search_operating_unit(Request $request)
    {
        // if (Auth::user()->user_level_id == 2) {
        $operating_unit = DB::table('operating_unit as a')
            ->where('a.description', 'LIKE', '%' . $request->input('term', '') . '%')
            ->get(['a.id as id', 'a.description as text']);
        // } else {
        //     $operating_unit = DB::table('operating_unit as a')
        //         ->leftjoin('regional_office as d', 'a.region_c', '=', 'd.region_c')
        //         ->where('a.description', 'LIKE', '%' . $request->input('term', '') . '%')
        //         ->where('a.region_c', Auth::user()->region_c)
        //         ->get(['a.id as id', 'a.description as text']);
        // }

        return ['results' => $operating_unit];
    }

    public function search_operating_unit_ro_code(Request $request)
    {
        $operating_unit = DB::table('operating_unit as a')
            ->leftjoin('regional_office as d', 'a.region_c', '=', 'd.region_c')
            ->where('a.description', 'LIKE', '%' . $request->term . '%')
            // ->where('d.ro_code', $request->ro_code)
            ->get(['a.id as id', 'a.description as text']);

        return ['results' => $operating_unit];
    }

    public function search_operating_unit_region_c(Request $request)
    {
        $operating_unit = DB::table('operating_unit as a')
            ->where('a.description', 'LIKE', '%' . $request->input('term', '') . '%')
            ->where('a.region_c', $request->region_c)
            ->get(['a.id as id', 'a.description as text']);

        return ['results' => $operating_unit];
    }

    public function search_support_unit(Request $request)
    {
        $operating_unit = DB::table('support_unit as a')
            ->where('a.name', 'LIKE', '%' . $request->input('term', '') . '%')
            ->get(['a.id as id', 'a.name as text']);

        // dd($operating_unit);

        return ['results' => $operating_unit];
    }

    public function search_operation_type(Request $request)
    {
        $operation_type = DB::table('operation_type as a')
            ->where('a.name', 'LIKE', '%' . $request->input('term', '') . '%')
            ->get(['a.id as id', 'a.name as text']);
        return ['results' => $operation_type];
    }

    public function search_operation_type_ro_code(Request $request)
    {
        $operation_type = DB::table('operation_type as a')
            ->where('a.name', 'LIKE', '%' . $request->input('term', '') . '%')
            ->where('d.ro_code', $request->ro_code)
            ->get(['a.id as id', 'a.name as text']);
        return ['results' => $operation_type];
    }

    public function search_operation_type_show(Request $request)
    {
        // dd('test');
        if ($request->show == 'spot') {
            $operation_type = DB::table('operation_type as a')
                ->where('a.name', 'LIKE', '%' . $request->term . '%')
                ->where('a.show_spot_report', true)
                ->orderby('name', 'asc')
                ->get(['a.id as id', 'a.name as text']);
        } elseif ($request->show == 'preops') {
            $operation_type = DB::table('operation_type as a')
                ->where('a.name', 'LIKE', '%' . $request->term . '%')
                ->where('a.show_preops', true)
                ->orderby('name', 'asc')
                ->get(['a.id as id', 'a.name as text']);
        }
        return ['results' => $operation_type];
    }

    public function search_case(Request $request)
    {
        $case = DB::table('case_list as a')
            ->where('a.description', 'LIKE', '%' . $request->input('term', '') . '%')
            ->where('a.status', 1)
            ->get(['a.id as id', 'a.description as text']);
        return ['results' => $case];
    }

    public function get_hio_type(Request $request)
    {
        $data = DB::table('hio_type as a')
            ->where('a.status', 1)
            ->get();
        return json_encode($data);
    }

    public function search_nationality(Request $request)
    {
        $nationality = DB::table('nationality as a')
            ->where('a.name', 'LIKE', '%' . $request->input('term', '') . '%')
            ->get(['a.id as id', 'a.name as text']);
        return ['results' => $nationality];
    }

    public function search_civil_status(Request $request)
    {
        $civil_status = DB::table('civil_status as a')
            ->where('a.name', 'LIKE', '%' . $request->input('term', '') . '%')
            ->get(['a.id as id', 'a.name as text']);
        return ['results' => $civil_status];
    }

    public function search_ethnic_group(Request $request)
    {
        $civil_status = DB::table('ethnic_group as a')
            ->where('a.name', 'LIKE', '%' . $request->input('term', '') . '%')
            ->get(['a.id as id', 'a.name as text']);
        return ['results' => $civil_status];
    }

    public function search_religion(Request $request)
    {
        $religion = DB::table('religions as a')
            ->where('a.name', 'LIKE', '%' . $request->input('term', '') . '%')
            ->get(['a.id as id', 'a.name as text']);
        return ['results' => $religion];
    }

    public function search_education(Request $request)
    {
        $educational_attainment = DB::table('educational_attainment as a')
            ->where('a.name', 'LIKE', '%' . $request->input('term', '') . '%')
            ->get(['a.id as id', 'a.name as text']);
        return ['results' => $educational_attainment];
    }

    public function search_occupation(Request $request)
    {
        $occupation = DB::table('occupation as a')
            ->where('a.name', 'LIKE', '%' . $request->input('term', '') . '%')
            ->get(['a.id as id', 'a.name as text']);
        return ['results' => $occupation];
    }

    public function search_identifier(Request $request)
    {
        $identifier = DB::table('identifier as a')
            ->where('a.name', 'LIKE', '%' . $request->input('term', '') . '%')
            ->get(['a.id as id', 'a.name as text']);
        return ['results' => $identifier];
    }

    public function search_suspect_classification(Request $request)
    {
        $data = DB::table('suspect_classification as a')
            ->where('a.description', 'LIKE', '%' . $request->input('term', '') . '%')
            ->get(['a.id as id', 'a.description as text']);
        return ['results' => $data];
    }

    public function search_suspect_category(Request $request)
    {
        $data = DB::table('suspect_category as a')
            ->where('a.name', 'LIKE', '%' . $request->input('term', '') . '%')
            ->get(['a.id as id', 'a.name as text']);
        return ['results' => $data];
    }

    public function search_suspect_sub_category(Request $request)
    {
        $data = DB::table('suspect_sub_category as a')
            ->where('a.name', 'LIKE', '%' . $request->input('term', '') . '%')
            ->get(['a.id as id', 'a.name as text']);
        return ['results' => $data];
    }

    public function search_evidence(Request $request)
    {
        $case = DB::table('evidence as a')
            ->where('a.name', 'LIKE', '%' . $request->input('term', '') . '%')
            ->where('a.status', 1)
            ->get(['a.id as id', 'a.name as text']);
        return ['results' => $case];
    }
}
