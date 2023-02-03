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
}
