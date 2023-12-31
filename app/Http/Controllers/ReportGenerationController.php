<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportsGenerationView;

class ReportGenerationController extends Controller
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

            $region = DB::table('region')->orderby('region_sort', 'asc')->get();
            $issuance_of_preops = DB::table('preops_header as a')
                ->leftjoin('regional_office as b', 'a.ro_code', '=', 'b.ro_code')
                ->leftjoin('province as c', 'a.province_c', '=', 'c.province_c')
                ->leftjoin('operation_type as d', 'a.operation_type_id', '=', 'd.id')
                ->leftjoin('operating_unit as e', 'a.operating_unit_id', '=', 'e.id')
                ->leftjoin('negative_reason as h', 'a.negative_reason_id', '=', 'h.id')
                ->select(
                    'b.name as region',
                    'a.preops_number',
                    'c.province_m',
                    'd.id as d_operation_type_id',
                    'd.name as operation_type',
                    'e.id as e_operating_unit_id',
                    'e.name as operating_unit',
                    // 'g.name as support_unit',
                    'a.coordinated_datetime',
                    'a.operation_datetime',
                    'a.validity',
                    'a.prepared_by',
                    'a.result',
                    'h.name as negative_reason',
                    'a.received_date'
                )
                ->orderby('a.id', 'desc')
                ->paginate(10);

            return view('report_generation.report_generation_list', compact(
                'region',
                'issuance_of_preops',
            ));
        } else {
            $region = DB::table('region')->orderby('region_sort', 'asc')->get();

            $issuance_of_preops = DB::table('preops_header as a')
                ->leftjoin('regional_office as b', 'a.ro_code', '=', 'b.ro_code')
                ->leftjoin('province as c', 'a.province_c', '=', 'c.province_c')
                ->leftjoin('operation_type as d', 'a.operation_type_id', '=', 'd.id')
                ->leftjoin('operating_unit as e', 'a.operating_unit_id', '=', 'e.id')
                ->leftjoin('negative_reason as h', 'a.negative_reason_id', '=', 'h.id')
                ->select(
                    'b.name as region',
                    'a.preops_number',
                    'c.province_m',
                    'd.id as d_operation_type_id',
                    'd.name as operation_type',
                    'e.id as e_operating_unit_id',
                    'e.name as operating_unit',
                    // 'g.name as support_unit',
                    'a.coordinated_datetime',
                    'a.operation_datetime',
                    'a.validity',
                    'a.prepared_by',
                    'a.result',
                    'h.name as negative_reason',
                    'a.received_date'
                )
                ->where('b.id', Auth::user()->regional_office_id)
                ->orderby('a.id', 'desc')
                ->paginate(10);

            return view('report_generation.report_generation_list', compact(
                'region',
                'issuance_of_preops',
            ));
        }
    }


    public function getPreopsTarget($preops_number)
    {
        $data = DB::table('preops_target as a')
            ->leftjoin('nationality as b', 'a.nationality_id', '=', 'b.id')
            ->select(
                'a.name',
                'b.name as nationality',
            )
            ->where('a.preops_number', $preops_number)
            ->orderby('a.name', 'asc')
            ->get();

        return json_encode($data);
    }

    public function getPreopsSUnit($preops_number)
    {
        $data = DB::table('preops_support_unit as a')
            ->leftjoin('operating_unit as b', 'a.support_unit_id', '=', 'b.id')
            ->select(
                'b.description',
            )
            ->where('a.preops_number', $preops_number)
            ->orderby('b.description', 'asc')
            ->get();

        return json_encode($data);
    }

    public function getPreopsOTeam($preops_number)
    {
        $data = DB::table('preops_team')
            ->where('preops_number', $preops_number)
            ->orderby('name', 'asc')
            ->get();

        return json_encode($data);
    }

    public function getPreopsAOE($preops_number)
    {
        $data = DB::table('after_operation_evidence as a')
            ->leftjoin('evidence as b', 'a.evidence_id', '=', 'b.id')
            ->leftjoin('unit_measurement as c', 'a.unit_measurement_id', '=', 'c.id')
            ->select(
                'a.preops_number',
                'b.name as evidence',
                'b.name as unit',
                'a.chemist_report_number',
                'a.quantity'
            )
            ->where('a.preops_number', $preops_number)
            ->orderby('a.id', 'asc')
            ->get();

        return json_encode($data);
    }

    public function getPreopsSPOT($preops_number)
    {
        $data = DB::table('spot_report_header as a')
            ->leftjoin('preops_header as b', 'a.preops_number', '=', 'b.preops_number')
            // ->select('a.report_header', 'a.summary', 'a.prepared_by','a.operation_lvl')
            ->where('b.preops_number', $preops_number)
            ->orderby('a.id', 'asc')
            ->get();
        return json_encode($data);
    }

    public function getPreopsSPOTSuspect($preops_number)
    {
        $data = DB::table('spot_report_suspect as a')
            ->leftjoin('nationality as b', 'a.nationality_id', '=', 'b.id')
            ->leftjoin('civil_status as c', 'a.civil_status_id', '=', 'c.id')
            ->leftjoin('religions as d', 'a.religion_id', '=', 'd.id')
            ->leftjoin('educational_attainment as e', 'a.educational_attainment_id', '=', 'e.id')
            ->leftjoin('ethnic_group as f', 'a.ethnic_group_id', '=', 'f.id')
            ->leftjoin('occupation as g', 'a.occupation_id', '=', 'g.id')
            ->leftjoin('region as h', 'a.region_c', '=', 'h.region_c')
            ->leftjoin('province as i', 'a.province_c', '=', 'i.province_c')
            ->leftjoin('city as j', 'a.city_c', '=', 'j.city_c')
            ->leftjoin('barangay as k', 'a.barangay_c', '=', 'k.barangay_c')
            ->leftjoin('region as h1', 'a.permanent_region_c', '=', 'h1.region_c')
            ->leftjoin('province as i1', 'a.permanent_province_c', '=', 'i1.province_c')
            ->leftjoin('city as j1', 'a.permanent_city_c', '=', 'j1.city_c')
            ->leftjoin('barangay as k1', 'a.permanent_barangay_c', '=', 'k1.barangay_c')
            ->leftjoin('suspect_status as l', 'a.suspect_status_id', '=', 'l.id')
            ->leftjoin('suspect_classification as m', 'a.suspect_classification_id', '=', 'm.id')
            ->leftjoin('suspect_category as n', 'a.suspect_category_id', '=', 'n.id')
            ->leftjoin('spot_report_header as o', 'a.spot_report_number', '=', 'o.spot_report_number')
            ->leftjoin('drug_type as p', 'a.drug_type_id', '=', 'p.id')
            ->leftjoin('drug_management as q', 'a.id', '=', 'q.suspect_id')
            ->select(
                'o.preops_number',
                'a.spot_report_number',
                'a.suspect_number',
                'l.name as suspect_status',
                'a.lastname',
                'a.firstname',
                'a.middlename',
                'a.alias',
                'a.birthdate',
                'a.est_birthdate',
                'a.birthplace',
                'h.region_m as s_region',
                'i.province_m as s_province',
                'j.city_m as s_city',
                'k.barangay_m as s_barangay',
                'a.street',
                'h1.region_m as p_region',
                'i1.province_m as p_province',
                'j1.city_m as p_city',
                'k1.barangay_m as p_barangay',
                'a.permanent_street',
                'a.gender',
                'b.name as nationality',
                'c.name as civil_status',
                'd.name as religion',
                'e.name as educational_attainment',
                'f.name as ethnic_group',
                'g.name as occupation',
                'm.name as suspect_classification',
                'n.name as suspect_category',
                'a.whereabouts',
                'a.remarks',
                'p.name as drug_type',
                'a.drug_test_result',
                'q.listed',
                'q.ndis_id',
                'q.remarks'
            )
            ->where('o.preops_number', $preops_number)
            ->orderby('a.lastname', 'asc')
            ->get();

        return json_encode($data);
    }

    public function getPreopsSPOTEvidence($preops_number)
    {
        $data = DB::table('spot_report_evidence as a')
            ->leftjoin('spot_report_header as a1', 'a.spot_report_number', '=', 'a1.spot_report_number')
            ->leftjoin('spot_report_suspect as b', 'a.suspect_number', '=', 'b.suspect_number')
            ->leftjoin('evidence as c', 'a.evidence_id', '=', 'c.id')
            ->leftjoin('unit_measurement as d', 'a.unit', '=', 'd.id')
            ->leftjoin('packaging as e', 'a.packaging_id', '=', 'e.id')
            ->leftjoin('laboratory_facility as f', 'a.laboratory_facility_id', '=', 'f.id')
            ->select(
                'b.lastname',
                'b.firstname',
                'b.middlename',
                'a.drug',
                'a.evidence',
                'a.quantity',
                'd.name as unit_measure',
                'e.name as packaging',
                'a.markings',
                'a1.preops_number',
                'a.qty_onsite',
                'a.actual_qty',
                'a.drug_test_result',
                'a.chemist_report_number',
                'a.drug_test_result',
                'f.name as laboratory_facility'
            )
            ->where('a1.preops_number', $preops_number)
            ->orderby('b.lastname', 'asc')
            ->get();

        return json_encode($data);
    }

    public function getPreopsSPOTCase($preops_number)
    {
        $data = DB::table('spot_report_case as a')
            ->leftjoin('spot_report_header as a1', 'a.spot_report_number', '=', 'a1.spot_report_number')
            ->leftjoin('spot_report_suspect as b', 'a.suspect_number', '=', 'b.suspect_number')
            ->leftjoin('case_list as c', 'a.case_id', '=', 'c.id')
            ->select(
                'b.lastname',
                'b.firstname',
                'b.middlename',
                'c.description as case',
                'a1.preops_number',
                'a.docket_number',
                'a.case_status'
            )
            ->where('a1.preops_number', $preops_number)
            ->orderby('b.lastname', 'asc')
            ->get();


        return json_encode($data);
    }

    public function getPreopsPROSuspect($preops_number)
    {
        $data = DB::table('spot_report_suspect as a')
            ->leftjoin('nationality as b', 'a.nationality_id', '=', 'b.id')
            ->leftjoin('civil_status as c', 'a.civil_status_id', '=', 'c.id')
            ->leftjoin('religions as d', 'a.religion_id', '=', 'd.id')
            ->leftjoin('educational_attainment as e', 'a.educational_attainment_id', '=', 'e.id')
            ->leftjoin('ethnic_group as f', 'a.ethnic_group_id', '=', 'f.id')
            ->leftjoin('occupation as g', 'a.occupation_id', '=', 'g.id')
            ->leftjoin('region as h', 'a.region_c', '=', 'h.region_c')
            ->leftjoin('province as i', 'a.province_c', '=', 'i.province_c')
            ->leftjoin('city as j', 'a.city_c', '=', 'j.city_c')
            ->leftjoin('barangay as k', 'a.barangay_c', '=', 'k.barangay_c')
            ->leftjoin('region as h1', 'a.permanent_region_c', '=', 'h1.region_c')
            ->leftjoin('province as i1', 'a.permanent_province_c', '=', 'i1.province_c')
            ->leftjoin('city as j1', 'a.permanent_city_c', '=', 'j1.city_c')
            ->leftjoin('barangay as k1', 'a.permanent_barangay_c', '=', 'k1.barangay_c')
            ->leftjoin('suspect_status as l', 'a.suspect_status_id', '=', 'l.id')
            ->leftjoin('suspect_classification as m', 'a.suspect_classification_id', '=', 'm.id')
            ->leftjoin('suspect_category as n', 'a.suspect_category_id', '=', 'n.id')
            ->leftjoin('spot_report_header as o', 'a.spot_report_number', '=', 'o.spot_report_number')
            ->leftjoin('drug_type as p', 'a.drug_type_id', '=', 'p.id')
            ->leftjoin('drug_management as q', 'a.id', '=', 'q.suspect_id')
            ->select(
                'o.preops_number',
                'a.spot_report_number',
                'a.suspect_number',
                'l.name as suspect_status',
                'a.lastname',
                'a.firstname',
                'a.middlename',
                'a.alias',
                'a.birthdate',
                'a.est_birthdate',
                'a.birthplace',
                'h.region_m as s_region',
                'i.province_m as s_province',
                'j.city_m as s_city',
                'k.barangay_m as s_barangay',
                'a.street',
                'h1.region_m as p_region',
                'i1.province_m as p_province',
                'j1.city_m as p_city',
                'k1.barangay_m as p_barangay',
                'a.permanent_street',
                'a.gender',
                'b.name as nationality',
                'c.name as civil_status',
                'd.name as religion',
                'e.name as educational_attainment',
                'f.name as ethnic_group',
                'g.name as occupation',
                'm.name as suspect_classification',
                'n.name as suspect_category',
                'a.whereabouts',
                'a.remarks',
                'p.name as drug_type',
                'a.drug_test_result',
                'q.listed',
                'q.ndis_id',
                'q.remarks'
            )
            ->where('o.preops_number', $preops_number)
            ->orderby('a.lastname', 'asc')
            ->get();
        return json_encode($data);
    }

    public function getPreopsPROSuspectListed($preops_number)
    {
        $data = DB::table('spot_report_suspect as a')
            ->leftjoin('spot_report_header as o', 'a.spot_report_number', '=', 'o.spot_report_number')
            ->leftjoin('drug_management as q', 'a.id', '=', 'q.suspect_id')
            ->select('a.lastname', 'a.firstname', 'a.middlename', 'q.ndis_id', 'q.remarks', 'q.listed')
            ->where('o.preops_number', $preops_number)
            ->where('q.listed', 1)
            ->orderby('a.lastname', 'asc')
            ->get();
        return json_encode($data);
    }

    public function search_report_list(Request $request)
    {
        $param = $request->get('param');
        $param2 = $request->get('param2');
        $param3 = $request->get('param3');



        if (Auth::user()->user_level_id == 2) {
            $issuance_of_preops = DB::table('preops_header as a')
                ->leftjoin('regional_office as b', 'a.ro_code', '=', 'b.ro_code')
                ->leftjoin('province as c', 'a.province_c', '=', 'c.province_c')
                ->leftjoin('operation_type as d', 'a.operation_type_id', '=', 'd.id')
                ->leftjoin('operating_unit as e', 'a.operating_unit_id', '=', 'e.id')
                ->leftjoin('negative_reason as h', 'a.negative_reason_id', '=', 'h.id')
                ->select(
                    'b.name as region',
                    'a.preops_number',
                    'c.province_m',
                    'd.id as d_operation_type_id',
                    'd.name as operation_type',
                    'e.id as e_operating_unit_id',
                    'e.name as operating_unit',
                    // 'g.name as support_unit',
                    'a.coordinated_datetime',
                    'a.operation_datetime',
                    'a.validity',
                    'a.prepared_by',
                    'a.result',
                    'h.name as negative_reason',
                    'a.received_date'
                );


            if ($param != 0) {
                $issuance_of_preops->where('a.preops_number', 'LIKE', '%' . $param . '%');
            }
            if ($param2 != 0) {
                $issuance_of_preops->where(DB::raw("(DATE_FORMAT(a.operation_datetime,'%Y-%m-%d'))"), '<=', $request->get('param2'));
            }
            if ($param3 != 0) {
                $issuance_of_preops->where(DB::raw("(DATE_FORMAT(a.operation_datetime,'%Y-%m-%d'))"), '<=', $request->get('param3'));
            }
            $issuance_of_preops = $issuance_of_preops->orderby('a.id', 'desc')->paginate(10);
        } else {
            $issuance_of_preops = DB::table('preops_header as a')
                ->leftjoin('regional_office as b', 'a.ro_code', '=', 'b.ro_code')
                ->leftjoin('province as c', 'a.province_c', '=', 'c.province_c')
                ->leftjoin('operation_type as d', 'a.operation_type_id', '=', 'd.id')
                ->leftjoin('operating_unit as e', 'a.operating_unit_id', '=', 'e.id')
                ->leftjoin('negative_reason as h', 'a.negative_reason_id', '=', 'h.id')
                ->select(
                    'b.name as region',
                    'a.preops_number',
                    'c.province_m',
                    'd.id as d_operation_type_id',
                    'd.name as operation_type',
                    'e.id as e_operating_unit_id',
                    'e.name as operating_unit',
                    // 'g.name as support_unit',
                    'a.coordinated_datetime',
                    'a.operation_datetime',
                    'a.validity',
                    'a.prepared_by',
                    'a.result',
                    'h.name as negative_reason',
                    'a.received_date'
                )
                ->where('b.id', Auth::user()->regional_office_id);

            if ($param != 0) {
                $issuance_of_preops->where('a.preops_number', 'LIKE', '%' . $param . '%');
            }
            if ($param2 != 0) {
                $issuance_of_preops->where(DB::raw("(DATE_FORMAT(a.operation_datetime,'%Y-%m-%d'))"), '<=', $request->get('param2'));
            }
            if ($param3 != 0) {
                $issuance_of_preops->where(DB::raw("(DATE_FORMAT(a.operation_datetime,'%Y-%m-%d'))"), '<=', $request->get('param3'));
            }
            $issuance_of_preops = $issuance_of_preops->orderby('a.id', 'desc')->paginate(10);
        }
        return view('report_generation.report_generation_data', compact('issuance_of_preops'))->render();
    }

    public function export(Request $request)
    {
        $data = request()->all();
        // dd($data);

        $region = isset($data['region']) ? 1 : 0;
        $preops_number = isset($data['preops_number']) ? 1 : 0;
        $province = isset($data['province']) ? 1 : 0;
        $type_operation = isset($data['type_operation']) ? 1 : 0;
        $operating_unit = isset($data['operating_unit']) ? 1 : 0;
        $support_unit = isset($data['support_unit']) ? 1 : 0;
        $datetime_coordinate = isset($data['datetime_coordinate']) ? 1 : 0;
        $datetime_operation = isset($data['datetime_operation']) ? 1 : 0;
        $valid_until = isset($data['valid_until']) ? 1 : 0;
        $a_area = isset($data['a_area']) ? 1 : 0;
        $taget_name = isset($data['taget_name']) ? 1 : 0;
        $ot_name = isset($data['ot_name']) ? 1 : 0;
        $prepared_by = isset($data['prepared_by']) ? 1 : 0;
        $ao_result = isset($data['ao_result']) ? 1 : 0;
        $ao_negative_reason = isset($data['ao_negative_reason']) ? 1 : 0;
        $ao_illegal_drug = isset($data['ao_illegal_drug']) ? 1 : 0;
        $ao_quantity = isset($data['ao_quantity']) ? 1 : 0;
        $ao_unit_measure = isset($data['ao_unit_measure']) ? 1 : 0;
        $ao_crn = isset($data['ao_crn']) ? 1 : 0;
        $ao_date_received = isset($data['ao_date_received']) ? 1 : 0;
        $all_sr = isset($data['all_sr']) ? 1 : 0;
        $sp_hio = isset($data['sp_hio']) ? 1 : 0;
        $sp_suspect_number = isset($data['sp_suspect_number']) ? 1 : 0;
        $sp_status = isset($data['sp_status']) ? 1 : 0;
        $sp_lastname = isset($data['sp_lastname']) ? 1 : 0;
        $sp_firstname = isset($data['sp_firstname']) ? 1 : 0;
        $sp_middlename = isset($data['sp_middlename']) ? 1 : 0;
        $sp_alias = isset($data['sp_alias']) ? 1 : 0;
        $sp_birthdate = isset($data['sp_birthdate']) ? 1 : 0;
        $sp_est_birthdate = isset($data['sp_est_birthdate']) ? 1 : 0;
        $sp_birthplace = isset($data['sp_birthplace']) ? 1 : 0;
        $sp_region = isset($data['sp_region']) ? 1 : 0;
        $sp_province = isset($data['sp_province']) ? 1 : 0;
        $sp_city = isset($data['sp_city']) ? 1 : 0;
        $sp_barangay = isset($data['sp_barangay']) ? 1 : 0;
        $sp_street = isset($data['sp_street']) ? 1 : 0;
        $sp_p_region = isset($data['sp_p_region']) ? 1 : 0;
        $sp_p_province = isset($data['sp_p_province']) ? 1 : 0;
        $sp_p_city = isset($data['sp_p_city']) ? 1 : 0;
        $sp_p_barangay = isset($data['sp_p_barangay']) ? 1 : 0;
        $sp_p_street = isset($data['sp_p_street']) ? 1 : 0;
        $sp_sex = isset($data['sp_sex']) ? 1 : 0;
        $sp_civil_status = isset($data['sp_civil_status']) ? 1 : 0;
        $sp_nationality = isset($data['sp_nationality']) ? 1 : 0;
        $sp_ethnic_group = isset($data['sp_ethnic_group']) ? 1 : 0;
        $sp_religion = isset($data['sp_religion']) ? 1 : 0;
        $sp_educational_attainment = isset($data['sp_educational_attainment']) ? 1 : 0;
        $sp_occupation = isset($data['sp_occupation']) ? 1 : 0;
        $sp_classification = isset($data['sp_classification']) ? 1 : 0;
        $sp_category = isset($data['sp_category']) ? 1 : 0;
        $sp_whereabouts = isset($data['sp_whereabouts']) ? 1 : 0;
        $sp_remarks = isset($data['sp_remarks']) ? 1 : 0;
        $sp_seized_from = isset($data['sp_seized_from']) ? 1 : 0;
        $sp_drug = isset($data['sp_drug']) ? 1 : 0;
        $sp_evidence = isset($data['sp_evidence']) ? 1 : 0;
        $sp_quantity = isset($data['sp_quantity']) ? 1 : 0;
        $sp_unit = isset($data['sp_unit']) ? 1 : 0;
        $sp_packaging = isset($data['sp_packaging']) ? 1 : 0;
        $sp_markings = isset($data['sp_markings']) ? 1 : 0;
        $sp_case_type = isset($data['sp_case_type']) ? 1 : 0;
        $sp_summary = isset($data['sp_summary']) ? 1 : 0;
        $sp_prepared_by = isset($data['sp_prepared_by']) ? 1 : 0;
        $pr_suspect_name = isset($data['pr_suspect_name']) ? 1 : 0;
        $pr_suspect_classification = isset($data['pr_suspect_classification']) ? 1 : 0;
        $pr_suspect_status = isset($data['pr_suspect_status']) ? 1 : 0;
        $pr_drug_test_result = isset($data['pr_drug_test_result']) ? 1 : 0;
        $pr_drug_type = isset($data['pr_drug_type']) ? 1 : 0;
        $pr_remarks = isset($data['pr_remarks']) ? 1 : 0;
        $pr_drug_seized = isset($data['pr_drug_seized']) ? 1 : 0;
        $pr_qty_onsite = isset($data['pr_qty_onsite']) ? 1 : 0;
        $pr_actual_qty = isset($data['pr_actual_qty']) ? 1 : 0;
        $pr_unit = isset($data['pr_unit']) ? 1 : 0;
        $pr_id_drug_test_result = isset($data['pr_id_drug_test_result']) ? 1 : 0;
        $pr_id_cr_number = isset($data['pr_id_cr_number']) ? 1 : 0;
        $pr_id_laboratory = isset($data['pr_id_laboratory']) ? 1 : 0;
        $pr_cf_suspect_name = isset($data['pr_cf_suspect_name']) ? 1 : 0;
        $pr_cf_case = isset($data['pr_cf_case']) ? 1 : 0;
        $pr_cf_docket_number = isset($data['pr_cf_docket_number']) ? 1 : 0;
        $pr_cf_status = isset($data['pr_cf_status']) ? 1 : 0;
        $pr_inquest_status = isset($data['pr_inquest_status']) ? 1 : 0;
        $pr_inquest_date = isset($data['pr_inquest_date']) ? 1 : 0;
        $pr_inquest_nps = isset($data['pr_inquest_nps']) ? 1 : 0;
        $pr_inquest_prosecutor = isset($data['pr_inquest_prosecutor']) ? 1 : 0;
        $pr_inquest_office = isset($data['pr_inquest_office']) ? 1 : 0;
        $pr_prelim_status = isset($data['pr_prelim_status']) ? 1 : 0;
        $pr_prelim_date = isset($data['pr_prelim_date']) ? 1 : 0;
        $pr_prelim_nps = isset($data['pr_prelim_nps']) ? 1 : 0;
        $pr_prelim_prosecutor = isset($data['pr_prelim_prosecutor']) ? 1 : 0;
        $pr_prelim_office = isset($data['pr_prelim_office']) ? 1 : 0;
        $dv_suspect_name = isset($data['dv_suspect_name']) ? 1 : 0;
        $dv_listed = isset($data['dv_listed']) ? 1 : 0;
        $dv_ndis = isset($data['dv_ndis']) ? 1 : 0;
        $dv_remarks = isset($data['dv_remarks']) ? 1 : 0;
        $title = 'reports_generation.xlsx';
        $q = $data['q'];
        $operation_date = $data['operation_date'];
        $operation_date_to = $data['operation_date_to'];

        return Excel::download(new ReportsGenerationView(
            $region,
            $preops_number,
            $province,
            $type_operation,
            $operating_unit,
            $support_unit,
            $datetime_coordinate,
            $datetime_operation,
            $valid_until,
            $a_area,
            $taget_name,
            $ot_name,
            $prepared_by,
            $ao_result,
            $ao_negative_reason,
            $ao_illegal_drug,
            $ao_quantity,
            $ao_unit_measure,
            $ao_crn,
            $ao_date_received,
            $all_sr,
            $sp_hio,
            $sp_suspect_number,
            $sp_status,
            $sp_lastname,
            $sp_firstname,
            $sp_middlename,
            $sp_alias,
            $sp_birthdate,
            $sp_est_birthdate,
            $sp_birthplace,
            $sp_region,
            $sp_province,
            $sp_city,
            $sp_barangay,
            $sp_street,
            $sp_p_region,
            $sp_p_province,
            $sp_p_city,
            $sp_p_barangay,
            $sp_p_street,
            $sp_sex,
            $sp_civil_status,
            $sp_nationality,
            $sp_ethnic_group,
            $sp_religion,
            $sp_educational_attainment,
            $sp_occupation,
            $sp_classification,
            $sp_category,
            $sp_whereabouts,
            $sp_remarks,
            $sp_seized_from,
            $sp_drug,
            $sp_evidence,
            $sp_quantity,
            $sp_unit,
            $sp_packaging,
            $sp_markings,
            $sp_case_type,
            $sp_summary,
            $sp_prepared_by,
            $pr_suspect_name,
            $pr_suspect_classification,
            $pr_suspect_status,
            $pr_drug_test_result,
            $pr_drug_type,
            $pr_remarks,
            $pr_drug_seized,
            $pr_qty_onsite,
            $pr_actual_qty,
            $pr_unit,
            $pr_id_drug_test_result,
            $pr_id_cr_number,
            $pr_id_laboratory,
            $pr_cf_suspect_name,
            $pr_cf_case,
            $pr_cf_docket_number,
            $pr_cf_status,
            $pr_inquest_status,
            $pr_inquest_date,
            $pr_inquest_nps,
            $pr_inquest_prosecutor,
            $pr_inquest_office,
            $pr_prelim_status,
            $pr_prelim_date,
            $pr_prelim_nps,
            $pr_prelim_prosecutor,
            $pr_prelim_office,
            $dv_suspect_name,
            $dv_listed,
            $dv_ndis,
            $dv_remarks,
            $q,
            $operation_date,
            $operation_date_to

        ), $title);
    }
}
