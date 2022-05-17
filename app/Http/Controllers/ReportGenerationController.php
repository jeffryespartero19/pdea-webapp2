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
            $data = DB::table('spot_report_header as a')
                ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
                ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
                ->select('a.id', 'a.spot_report_number', 'a.operation_datetime', 'b.name as operating_unit', 'c.name as operation_type', 'a.status', 'a.created_at')
                ->where('a.report_status', 0)
                ->orderby('spot_report_number', 'asc')
                ->get();

            $region = DB::table('region')->orderby('region_sort', 'asc')->get();
            $issuance_of_preops = DB::table('preops_header as a')
                ->leftjoin('regional_office as b', 'a.ro_code', '=', 'b.ro_code')
                ->leftjoin('province as c', 'a.province_c', '=', 'b.province_c')
                ->select(
                    'b.name as region',
                    'a.preops_number',
                    'c.province_m'
                )
                ->get();
        } else {
            $data = DB::table('spot_report_header as a')
                ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
                ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
                ->join('regional_office as d', 'a.region_c', '=', 'd.region_c')
                ->select('a.id', 'a.spot_report_number', 'a.operation_datetime', 'b.name as operating_unit', 'c.name as operation_type', 'a.status', 'a.created_at')
                ->where('a.report_status', 0)
                ->where('d.id', Auth::user()->regional_office_id)
                ->orderby('spot_report_number', 'asc')
                ->get();

            $region = DB::table('region as a')
                ->join('regional_office as d', 'a.region_c', '=', 'd.region_c')
                ->where('d.id', Auth::user()->regional_office_id)
                ->get();
            $issuance_of_preops = DB::table('preops_header as a')
                ->leftjoin('regional_office as b', 'a.ro_code', '=', 'b.ro_code')
                ->leftjoin('province as c', 'a.province_c', '=', 'c.province_c')
                ->leftjoin('operation_type as d', 'a.operation_type_id', '=', 'd.id')
                ->leftjoin('operating_unit as e', 'a.operating_unit_id', '=', 'e.id')
                ->leftjoin('preops_support_unit as f', 'a.preops_number', '=', 'f.preops_number')
                ->leftjoin('operating_unit as g', 'f.support_unit_id', '=', 'g.id')
                ->leftjoin('negative_reason as h', 'a.negative_reason_id', '=', 'h.id')
                // ->leftjoin('region as h1', 'h.region_c', '=', 'h1.region_c')
                // ->leftjoin('province as h2', 'h.province_c', '=', 'h2.province_c')
                // ->leftjoin('city as h3', 'h.city_c', '=', 'h3.city_c')
                // ->leftjoin('barangay as h4', 'h.barangay_c', '=', 'h4.barangay_c')
                // ->leftjoin('preops_target as i', 'a.preops_number', '=', 'i.preops_number')
                // ->leftjoin('nationality as i1', 'i.nationality_id', '=', 'i1.id')
                // ->leftjoin('preops_team as j', 'a.preops_number', '=', 'j.preops_number')
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
                    // 'h.preops_number as h_preops_number',
                    // 'h.area as a_area',
                    // 'h1.region_m as a_region_m',
                    // 'h2.province_m as a_province_m',
                    // 'h3.city_m as a_city_m',
                    // 'h4.barangay_m as a_barangay_m',
                    // 'i.preops_number as t_preops_number',
                    // 'i.name as target_name',
                    // 'i1.name as t_nationality',
                    // 'j.preops_number as j_preops_number',
                    // 'j.name as ot_name',
                    // 'j.position as ot_position',
                    // 'j.contact as ot_contact',
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
                    // 'h.preops_number',
                    // 'h.area',
                    // 'h1.region_m',
                    // 'h2.province_m',
                    // 'h3.city_m',
                    // 'h4.barangay_m',
                    // 'i.preops_number',
                    // 'i.name',
                    // 'i1.name',
                    // 'j.preops_number',
                    // 'j.name',
                    // 'j.position',
                    // 'j.contact',
                    'a.prepared_by',
                    'a.result',
                    'a.negative_reason_id',
                    'h.name',
                    'a.received_date'
                )
                ->get();
        }

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

        $spot_report_header = DB::table('spot_report_header')
            ->orderby('id', 'asc')
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
                'a.remarks'


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
            'spot_report_suspect'
        ));
    }
}
