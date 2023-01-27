<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use PDF;

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
                )
                // ->groupBy(
                //     'a.preops_number',
                //     'b.name',
                //     'c.province_m',
                //     'd.id',
                //     'd.name',
                //     'e.id',
                //     'e.name',
                //     'g.name',
                //     'a.coordinated_datetime',
                //     'a.operation_datetime',
                //     'a.validity',
                //     'a.prepared_by',
                //     'a.result',
                //     'a.negative_reason_id',
                //     'h.name',
                //     'a.received_date'
                // )
                ->paginate(10);

            // $preops_area = DB::table('preops_area as h')
            //     ->leftjoin('region as h1', 'h.region_c', '=', 'h1.region_c')
            //     ->leftjoin('province as h2', 'h.province_c', '=', 'h2.province_c')
            //     ->leftjoin('city as h3', 'h.city_c', '=', 'h3.city_c')
            //     ->leftjoin('barangay as h4', 'h.barangay_c', '=', 'h4.barangay_c')
            //     ->select(
            //         'h.preops_number',
            //         'h.area as a_area',
            //         'h1.region_m as a_region_m',
            //         'h2.province_m as a_province_m',
            //         'h3.city_m as a_city_m',
            //         'h4.barangay_m as a_barangay_m'
            //     )
            //     ->orderby('h.id', 'asc')
            //     ->get();

            // $preops_target = DB::table('preops_target as a')
            //     ->leftjoin('nationality as b', 'a.nationality_id', '=', 'b.id')
            //     ->select(
            //         'a.preops_number',
            //         'a.name',
            //         'b.name as nationality',
            //     )
            //     ->orderby('a.id', 'asc')
            //     ->get();

            // $preops_team = DB::table('preops_team')
            //     ->orderby('id', 'asc')
            //     ->get();

            // $after_operations_evidence = DB::table('after_operation_evidence as a')
            //     ->leftjoin('evidence as b', 'a.evidence_id', '=', 'b.id')
            //     ->leftjoin('unit_measurement as c', 'a.unit_measurement_id', '=', 'c.id')
            //     ->select(
            //         'a.preops_number',
            //         'b.name as evidence',
            //         'b.name as unit',
            //         'a.chemist_report_number',
            //         'a.quantity'
            //     )
            //     ->orderby('a.id', 'asc')
            //     ->get();

            // $spot_report_header = DB::table('spot_report_header')
            //     ->orderby('id', 'asc')
            //     ->get();

            // $spot_report_suspect = DB::table('spot_report_suspect as a')
            //     ->leftjoin('nationality as b', 'a.nationality_id', '=', 'b.id')
            //     ->leftjoin('civil_status as c', 'a.civil_status_id', '=', 'c.id')
            //     ->leftjoin('religions as d', 'a.religion_id', '=', 'd.id')
            //     ->leftjoin('educational_attainment as e', 'a.educational_attainment_id', '=', 'e.id')
            //     ->leftjoin('ethnic_group as f', 'a.ethnic_group_id', '=', 'f.id')
            //     ->leftjoin('occupation as g', 'a.occupation_id', '=', 'g.id')
            //     ->leftjoin('region as h', 'a.region_c', '=', 'h.region_c')
            //     ->leftjoin('province as i', 'a.province_c', '=', 'i.province_c')
            //     ->leftjoin('city as j', 'a.city_c', '=', 'j.city_c')
            //     ->leftjoin('barangay as k', 'a.barangay_c', '=', 'k.barangay_c')
            //     ->leftjoin('region as h1', 'a.permanent_region_c', '=', 'h1.region_c')
            //     ->leftjoin('province as i1', 'a.permanent_province_c', '=', 'i1.province_c')
            //     ->leftjoin('city as j1', 'a.permanent_city_c', '=', 'j1.city_c')
            //     ->leftjoin('barangay as k1', 'a.permanent_barangay_c', '=', 'k1.barangay_c')
            //     ->leftjoin('suspect_status as l', 'a.suspect_status_id', '=', 'l.id')
            //     ->leftjoin('suspect_classification as m', 'a.suspect_classification_id', '=', 'm.id')
            //     ->leftjoin('suspect_category as n', 'a.suspect_category_id', '=', 'n.id')
            //     ->leftjoin('spot_report_header as o', 'a.spot_report_number', '=', 'o.spot_report_number')
            //     ->leftjoin('drug_type as p', 'a.drug_type_id', '=', 'p.id')
            //     ->leftjoin('drug_management as q', 'a.id', '=', 'q.suspect_id')
            //     ->select(
            //         'o.preops_number',
            //         'a.spot_report_number',
            //         'a.suspect_number',
            //         'l.name as suspect_status',
            //         'a.lastname',
            //         'a.firstname',
            //         'a.middlename',
            //         'a.alias',
            //         'a.birthdate',
            //         'a.est_birthdate',
            //         'a.birthplace',
            //         'h.region_m as s_region',
            //         'i.province_m as s_province',
            //         'j.city_m as s_city',
            //         'k.barangay_m as s_barangay',
            //         'a.street',
            //         'h1.region_m as p_region',
            //         'i1.province_m as p_province',
            //         'j1.city_m as p_city',
            //         'k1.barangay_m as p_barangay',
            //         'a.permanent_street',
            //         'a.gender',
            //         'b.name as nationality',
            //         'c.name as civil_status',
            //         'd.name as religion',
            //         'e.name as educational_attainment',
            //         'f.name as ethnic_group',
            //         'g.name as occupation',
            //         'm.name as suspect_classification',
            //         'n.name as suspect_category',
            //         'a.whereabouts',
            //         'a.remarks',
            //         'p.name as drug_type',
            //         'a.drug_test_result',
            //         'q.listed',
            //         'q.ndis_id',
            //         'q.remarks'


            //     )

            //     ->orderby('a.id', 'asc')
            //     ->get();

            // $spot_report_evidence = DB::table('spot_report_evidence as a')
            //     ->leftjoin('spot_report_header as a1', 'a.spot_report_number', '=', 'a1.spot_report_number')
            //     ->leftjoin('spot_report_suspect as b', 'a.suspect_number', '=', 'b.suspect_number')
            //     ->leftjoin('evidence as c', 'a.evidence_id', '=', 'c.id')
            //     ->leftjoin('unit_measurement as d', 'a.unit', '=', 'd.id')
            //     ->leftjoin('packaging as e', 'a.packaging_id', '=', 'e.id')
            //     ->leftjoin('laboratory_facility as f', 'a.laboratory_facility_id', '=', 'f.id')
            //     ->select(
            //         'b.lastname',
            //         'b.firstname',
            //         'b.middlename',
            //         'a.drug',
            //         'a.evidence',
            //         'a.quantity',
            //         'd.name as unit_measure',
            //         'e.name as packaging',
            //         'a.markings',
            //         'a1.preops_number',
            //         'a.qty_onsite',
            //         'a.actual_qty',
            //         'a.drug_test_result',
            //         'a.chemist_report_number',
            //         'a.drug_test_result',
            //         'f.name as laboratory_facility'
            //     )
            //     ->orderby('a.id', 'asc')
            //     ->get();

            // $spot_report_case = DB::table('spot_report_case as a')
            //     ->leftjoin('spot_report_header as a1', 'a.spot_report_number', '=', 'a1.spot_report_number')
            //     ->leftjoin('spot_report_suspect as b', 'a.suspect_number', '=', 'b.suspect_number')
            //     ->leftjoin('case_list as c', 'a.case_id', '=', 'c.id')
            //     ->select(
            //         'b.lastname',
            //         'b.firstname',
            //         'b.middlename',
            //         'c.description as case',
            //         'a1.preops_number',
            //         'a.docket_number',
            //         'a.case_status'
            //     )
            //     ->orderby('a.id', 'asc')
            //     ->get();

            // $operating_unit = DB::table('operating_unit')->where('status', true)->orderby('name', 'asc')->get();
            // $operation_type = DB::table('operation_type')->where('status', true)->orderby('name', 'asc')->get();

            return view('report_generation.report_generation_list', compact(
                // 'data',
                'region',
                // 'operating_unit',
                // 'operation_type',
                'issuance_of_preops',
                // 'preops_area',
                // 'preops_target',
                // 'preops_team',
                // 'after_operations_evidence',
                // 'spot_report_header',
                // 'spot_report_suspect',
                // 'spot_report_evidence',
                // 'spot_report_case'
            ));
        } else {
            $region = DB::table('region')->orderby('region_sort', 'asc')->get();
            $issuance_of_preops = DB::table('preops_header as a')
                ->leftjoin('regional_office as b', 'a.ro_code', '=', 'b.ro_code')
                ->leftjoin('province as c', 'a.province_c', '=', 'c.province_c')
                ->leftjoin('operation_type as d', 'a.operation_type_id', '=', 'd.id')
                ->leftjoin('operating_unit as e', 'a.operating_unit_id', '=', 'e.id')
                ->leftjoin('preops_support_unit as f', 'a.preops_number', '=', 'f.preops_number')
                ->leftjoin('operating_unit as g', 'f.support_unit_id', '=', 'g.id')
                ->leftjoin('negative_reason as h', 'a.negative_reason_id', '=', 'h.id')
                ->where('b.id', Auth::user()->regional_office_id)
                ->select(
                    'b.name as region',
                    'a.preops_number',
                    'c.province_m',
                    'd.id as d_operation_type_id',
                    'd.name as operation_type',
                    'e.id as e_operating_unit_id',
                    'e.name as operating_unit',
                    'g.name as support_unit',
                    'a.coordinated_datetime',
                    'a.operation_datetime',
                    'a.validity',
                    'a.prepared_by',
                    'a.result',
                    'h.name as negative_reason',
                    'a.received_date'
                )
                ->groupBy(
                    'a.preops_number',
                    'b.name',
                    'c.province_m',
                    'd.id',
                    'd.name',
                    'e.id',
                    'e.name',
                    'g.name',
                    'a.coordinated_datetime',
                    'a.operation_datetime',
                    'a.validity',
                    'a.prepared_by',
                    'a.result',
                    'a.negative_reason_id',
                    'h.name',
                    'a.received_date'
                )
                ->paginate(20);

            $preops_area = DB::table('preops_area as h')
                ->leftjoin('region as h1', 'h.region_c', '=', 'h1.region_c')
                ->leftjoin('province as h2', 'h.province_c', '=', 'h2.province_c')
                ->leftjoin('city as h3', 'h.city_c', '=', 'h3.city_c')
                ->leftjoin('barangay as h4', 'h.barangay_c', '=', 'h4.barangay_c')
                ->select(
                    'h.preops_number',
                    'h.area as a_area',
                    'h1.region_m as a_region_m',
                    'h2.province_m as a_province_m',
                    'h3.city_m as a_city_m',
                    'h4.barangay_m as a_barangay_m'
                )
                ->orderby('h.id', 'asc')
                ->get();

            $preops_target = DB::table('preops_target as a')
                ->leftjoin('nationality as b', 'a.nationality_id', '=', 'b.id')
                ->select(
                    'a.preops_number',
                    'a.name',
                    'b.name as nationality',
                )
                ->orderby('a.id', 'asc')
                ->get();

            $preops_team = DB::table('preops_team')
                ->orderby('id', 'asc')
                ->get();

            $after_operations_evidence = DB::table('after_operation_evidence as a')
                ->leftjoin('evidence as b', 'a.evidence_id', '=', 'b.id')
                ->leftjoin('unit_measurement as c', 'a.unit_measurement_id', '=', 'c.id')
                ->select(
                    'a.preops_number',
                    'b.name as evidence',
                    'b.name as unit',
                    'a.chemist_report_number',
                    'a.quantity'
                )
                ->orderby('a.id', 'asc')
                ->get();

            $spot_report_header = DB::table('spot_report_header as a')
                ->leftjoin('regional_office as d', 'a.region_c', '=', 'd.region_c')
                ->where('d.id', Auth::user()->regional_office_id)
                ->orderby('a.id', 'asc')
                ->get();

            $spot_report_suspect = DB::table('spot_report_suspect as a')
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

                ->orderby('a.id', 'asc')
                ->get();

            $spot_report_evidence = DB::table('spot_report_evidence as a')
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
                ->orderby('a.id', 'asc')
                ->get();

            $spot_report_case = DB::table('spot_report_case as a')
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
                ->orderby('a.id', 'asc')
                ->get();

            $operating_unit = DB::table('operating_unit')->where('status', true)->orderby('name', 'asc')->get();
            $operation_type = DB::table('operation_type')->where('status', true)->orderby('name', 'asc')->get();

            return view('report_generation.report_generation_list', compact(
                'data',
                'region',
                'operating_unit',
                'operation_type',
                'issuance_of_preops',
                'preops_area',
                'preops_target',
                'preops_team',
                'after_operations_evidence',
                'spot_report_header',
                'spot_report_suspect',
                'spot_report_evidence',
                'spot_report_case'
            ));
        }
    }

    public function get_after_operation($pn)
    {

        $spot_report_header = DB::table('spot_report_header as a')
            ->where('a.id', $id)->get();
        $ao = DB::table('spot_report_suspect as a')
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
            ->where('a.spot_report_number', $pn)->get();
        
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
    
}
