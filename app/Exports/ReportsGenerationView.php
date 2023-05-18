<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;

class ReportsGenerationView implements FromView
{
    protected
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
        $operation_date_to;

    function __construct($region, $preops_number, $province, $type_operation, $operating_unit, $support_unit, $datetime_coordinate, $datetime_operation, $valid_until, $a_area, $taget_name, $ot_name, $prepared_by, $ao_result, $ao_negative_reason, $ao_illegal_drug, $ao_quantity, $ao_unit_measure, $ao_crn, $ao_date_received, $all_sr, $sp_hio, $sp_suspect_number, $sp_status, $sp_lastname, $sp_firstname, $sp_middlename, $sp_alias, $sp_birthdate, $sp_est_birthdate, $sp_birthplace, $sp_region, $sp_province, $sp_city, $sp_barangay, $sp_street, $sp_p_region, $sp_p_province, $sp_p_city, $sp_p_barangay, $sp_p_street, $sp_sex, $sp_civil_status, $sp_nationality, $sp_ethnic_group, $sp_religion, $sp_educational_attainment, $sp_occupation, $sp_classification, $sp_category, $sp_whereabouts, $sp_remarks, $sp_seized_from, $sp_drug, $sp_evidence, $sp_quantity, $sp_unit, $sp_packaging, $sp_markings, $sp_case_type, $sp_summary, $sp_prepared_by, $pr_suspect_name, $pr_suspect_classification, $pr_suspect_status, $pr_drug_test_result, $pr_drug_type, $pr_remarks, $pr_drug_seized, $pr_qty_onsite, $pr_actual_qty, $pr_unit, $pr_id_drug_test_result, $pr_id_cr_number, $pr_id_laboratory, $pr_cf_suspect_name, $pr_cf_case, $pr_cf_docket_number, $pr_cf_status, $pr_inquest_status, $pr_inquest_date, $pr_inquest_nps, $pr_inquest_prosecutor, $pr_inquest_office, $pr_prelim_status, $pr_prelim_date, $pr_prelim_nps, $pr_prelim_prosecutor, $pr_prelim_office, $dv_suspect_name, $dv_listed, $dv_ndis, $dv_remarks, $q, $operation_date, $operation_date_to)
    {
        $this->region = $region;
        $this->preops_number = $preops_number;
        $this->province = $province;
        $this->type_operation = $type_operation;
        $this->operating_unit = $operating_unit;
        $this->support_unit = $support_unit;
        $this->datetime_coordinate = $datetime_coordinate;
        $this->datetime_operation = $datetime_operation;
        $this->valid_until = $valid_until;
        $this->a_area = $a_area;
        $this->taget_name = $taget_name;
        $this->ot_name = $ot_name;
        $this->prepared_by = $prepared_by;
        $this->ao_result = $ao_result;
        $this->ao_negative_reason = $ao_negative_reason;
        $this->ao_illegal_drug = $ao_illegal_drug;
        $this->ao_quantity = $ao_quantity;
        $this->ao_unit_measure = $ao_unit_measure;
        $this->ao_crn = $ao_crn;
        $this->ao_date_received = $ao_date_received;
        $this->all_sr = $all_sr;
        $this->sp_hio = $sp_hio;
        $this->sp_suspect_number = $sp_suspect_number;
        $this->sp_status = $sp_status;
        $this->sp_lastname = $sp_lastname;
        $this->sp_firstname = $sp_firstname;
        $this->sp_middlename = $sp_middlename;
        $this->sp_alias = $sp_alias;
        $this->sp_birthdate = $sp_birthdate;
        $this->sp_est_birthdate = $sp_est_birthdate;
        $this->sp_birthplace = $sp_birthplace;
        $this->sp_region = $sp_region;
        $this->sp_province = $sp_province;
        $this->sp_city = $sp_city;
        $this->sp_barangay = $sp_barangay;
        $this->sp_street = $sp_street;
        $this->sp_p_region = $sp_p_region;
        $this->sp_p_province = $sp_p_province;
        $this->sp_p_city = $sp_p_city;
        $this->sp_p_barangay = $sp_p_barangay;
        $this->sp_p_street = $sp_p_street;
        $this->sp_sex = $sp_sex;
        $this->sp_civil_status = $sp_civil_status;
        $this->sp_nationality = $sp_nationality;
        $this->sp_ethnic_group = $sp_ethnic_group;
        $this->sp_religion = $sp_religion;
        $this->sp_educational_attainment = $sp_educational_attainment;
        $this->sp_occupation = $sp_occupation;
        $this->sp_classification = $sp_classification;
        $this->sp_category = $sp_category;
        $this->sp_whereabouts = $sp_whereabouts;
        $this->sp_remarks = $sp_remarks;
        $this->sp_seized_from = $sp_seized_from;
        $this->sp_drug = $sp_drug;
        $this->sp_evidence = $sp_evidence;
        $this->sp_quantity = $sp_quantity;
        $this->sp_unit = $sp_unit;
        $this->sp_packaging = $sp_packaging;
        $this->sp_markings = $sp_markings;
        $this->sp_case_type = $sp_case_type;
        $this->sp_summary = $sp_summary;
        $this->sp_prepared_by = $sp_prepared_by;
        $this->pr_suspect_name = $pr_suspect_name;
        $this->pr_suspect_classification = $pr_suspect_classification;
        $this->pr_suspect_status = $pr_suspect_status;
        $this->pr_drug_test_result = $pr_drug_test_result;
        $this->pr_drug_type = $pr_drug_type;
        $this->pr_remarks = $pr_remarks;
        $this->pr_drug_seized = $pr_drug_seized;
        $this->pr_qty_onsite = $pr_qty_onsite;
        $this->pr_actual_qty = $pr_actual_qty;
        $this->pr_unit = $pr_unit;
        $this->pr_id_drug_test_result = $pr_id_drug_test_result;
        $this->pr_id_cr_number = $pr_id_cr_number;
        $this->pr_id_laboratory = $pr_id_laboratory;
        $this->pr_cf_suspect_name = $pr_cf_suspect_name;
        $this->pr_cf_case = $pr_cf_case;
        $this->pr_cf_docket_number = $pr_cf_docket_number;
        $this->pr_cf_status = $pr_cf_status;
        $this->pr_inquest_status = $pr_inquest_status;
        $this->pr_inquest_date = $pr_inquest_date;
        $this->pr_inquest_nps = $pr_inquest_nps;
        $this->pr_inquest_prosecutor = $pr_inquest_prosecutor;
        $this->pr_inquest_office = $pr_inquest_office;
        $this->pr_prelim_status = $pr_prelim_status;
        $this->pr_prelim_date = $pr_prelim_date;
        $this->pr_prelim_nps = $pr_prelim_nps;
        $this->pr_prelim_prosecutor = $pr_prelim_prosecutor;
        $this->pr_prelim_office = $pr_prelim_office;
        $this->dv_suspect_name = $dv_suspect_name;
        $this->dv_listed = $dv_listed;
        $this->dv_ndis = $dv_ndis;
        $this->dv_remarks = $dv_remarks;
        $this->q = $q;
        $this->operation_date = $operation_date;
        $this->operation_date_to = $operation_date_to;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $q = $this->q;
        $operation_date = $this->operation_date;
        $operation_date_to = $this->operation_date_to;
        $region1 = $this->region;
        $preops_number = $this->preops_number;
        $province = $this->province;
        $type_operation = $this->type_operation;
        $operating_unit = $this->operating_unit;
        $support_unit = $this->support_unit;
        $datetime_coordinate = $this->datetime_coordinate;
        $datetime_operation = $this->datetime_operation;
        $valid_until = $this->valid_until;
        $a_area = $this->a_area;
        $taget_name = $this->taget_name;
        $ot_name = $this->ot_name;
        $prepared_by = $this->prepared_by;
        $ao_result = $this->ao_result;
        $ao_negative_reason = $this->ao_negative_reason;
        $ao_illegal_drug = $this->ao_illegal_drug;
        $ao_quantity = $this->ao_quantity;
        $ao_unit_measure = $this->ao_unit_measure;
        $ao_crn = $this->ao_crn;
        $ao_date_received = $this->ao_date_received;
        $all_sr = $this->all_sr;
        $sp_hio = $this->sp_hio;
        $sp_suspect_number = $this->sp_suspect_number;
        $sp_status = $this->sp_status;
        $sp_lastname = $this->sp_lastname;
        $sp_firstname = $this->sp_firstname;
        $sp_middlename = $this->sp_middlename;
        $sp_alias = $this->sp_alias;
        $sp_birthdate = $this->sp_birthdate;
        $sp_est_birthdate = $this->sp_est_birthdate;
        $sp_birthplace = $this->sp_birthplace;
        $sp_region = $this->sp_region;
        $sp_province = $this->sp_province;
        $sp_city = $this->sp_city;
        $sp_barangay = $this->sp_barangay;
        $sp_street = $this->sp_street;
        $sp_p_region = $this->sp_p_region;
        $sp_p_province = $this->sp_p_province;
        $sp_p_city = $this->sp_p_city;
        $sp_p_barangay = $this->sp_p_barangay;
        $sp_p_street = $this->sp_p_street;
        $sp_sex = $this->sp_sex;
        $sp_civil_status = $this->sp_civil_status;
        $sp_nationality = $this->sp_nationality;
        $sp_ethnic_group = $this->sp_ethnic_group;
        $sp_religion = $this->sp_religion;
        $sp_educational_attainment = $this->sp_educational_attainment;
        $sp_occupation = $this->sp_occupation;
        $sp_classification = $this->sp_classification;
        $sp_category = $this->sp_category;
        $sp_whereabouts = $this->sp_whereabouts;
        $sp_remarks = $this->sp_remarks;
        $sp_seized_from = $this->sp_seized_from;
        $sp_drug = $this->sp_drug;
        $sp_evidence = $this->sp_evidence;
        $sp_quantity = $this->sp_quantity;
        $sp_unit = $this->sp_unit;
        $sp_packaging = $this->sp_packaging;
        $sp_markings = $this->sp_markings;
        $sp_case_type = $this->sp_case_type;
        $sp_summary = $this->sp_summary;
        $sp_prepared_by = $this->sp_prepared_by;
        $pr_suspect_name = $this->pr_suspect_name;
        $pr_suspect_classification = $this->pr_suspect_classification;
        $pr_suspect_status = $this->pr_suspect_status;
        $pr_drug_test_result = $this->pr_drug_test_result;
        $pr_drug_type = $this->pr_drug_type;
        $pr_remarks = $this->pr_remarks;
        $pr_drug_seized = $this->pr_drug_seized;
        $pr_qty_onsite = $this->pr_qty_onsite;
        $pr_actual_qty = $this->pr_actual_qty;
        $pr_unit = $this->pr_unit;
        $pr_id_drug_test_result = $this->pr_id_drug_test_result;
        $pr_id_cr_number = $this->pr_id_cr_number;
        $pr_id_laboratory = $this->pr_id_laboratory;
        $pr_cf_suspect_name = $this->pr_cf_suspect_name;
        $pr_cf_case = $this->pr_cf_case;
        $pr_cf_docket_number = $this->pr_cf_docket_number;
        $pr_cf_status = $this->pr_cf_status;
        $pr_inquest_status = $this->pr_inquest_status;
        $pr_inquest_date = $this->pr_inquest_date;
        $pr_inquest_nps = $this->pr_inquest_nps;
        $pr_inquest_prosecutor = $this->pr_inquest_prosecutor;
        $pr_inquest_office = $this->pr_inquest_office;
        $pr_prelim_status = $this->pr_prelim_status;
        $pr_prelim_date = $this->pr_prelim_date;
        $pr_prelim_nps = $this->pr_prelim_nps;
        $pr_prelim_prosecutor = $this->pr_prelim_prosecutor;
        $pr_prelim_office = $this->pr_prelim_office;
        $dv_suspect_name = $this->dv_suspect_name;
        $dv_listed = $this->dv_listed;
        $dv_ndis = $this->dv_ndis;
        $dv_remarks = $this->dv_remarks;

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
                    'a.coordinated_datetime',
                    'a.operation_datetime',
                    'a.validity',
                    'a.prepared_by',
                    'a.result',
                    'h.name as negative_reason',
                    'a.received_date'
                );

            if (isset($q)) {
                $issuance_of_preops->where('a.preops_number', 'LIKE', '%' . $q . '%');
            }
            if (isset($operation_date)) {
                $issuance_of_preops->where(DB::raw("(DATE_FORMAT(a.operation_datetime,'%Y-%m-%d'))"), '<=', $operation_date);
            }
            if (isset($operation_date_to)) {
                $issuance_of_preops->where(DB::raw("(DATE_FORMAT(a.operation_datetime,'%Y-%m-%d'))"), '<=', $operation_date_to);
            }
            $issuance_of_preops = $issuance_of_preops->orderby('a.id', 'desc')->get();
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
                ->where('b.id', Auth::user()->regional_office_id);

            if (isset($q)) {
                $issuance_of_preops->where('a.preops_number', 'LIKE', '%' . $q . '%');
            }
            if (isset($operation_date)) {
                $issuance_of_preops->where(DB::raw("(DATE_FORMAT(a.operation_datetime,'%Y-%m-%d'))"), '<=', $operation_date);
            }
            if (isset($operation_date_to)) {
                $issuance_of_preops->where(DB::raw("(DATE_FORMAT(a.operation_datetime,'%Y-%m-%d'))"), '<=', $operation_date_to);
            }
            $issuance_of_preops = $issuance_of_preops->orderby('a.id', 'desc')->get();
        }

        $preops_support_unit = DB::table('preops_support_unit as a')
            ->leftjoin('operating_unit as b', 'a.support_unit_id', '=', 'b.id')
            ->select(
                'b.description',
                'a.preops_number'
            )
            ->orderby('b.description', 'asc')
            ->get();

        $preops_area = DB::table('preops_area as a')
            ->leftjoin('region as b', 'a.region_c', '=', 'b.region_c')
            ->leftjoin('province as c', 'a.province_c', '=', 'c.province_c')
            ->leftjoin('city as d', 'a.city_c', '=', 'd.city_c')
            ->leftjoin('barangay as e', 'a.barangay_c', '=', 'e.barangay_c')
            ->select('a.preops_number', 'b.region_m', 'c.province_m', 'd.city_m', 'e.barangay_m', 'a.area')
            ->get();

        $preops_target = DB::table('preops_target as a')
            ->leftjoin('nationality as b', 'a.nationality_id', '=', 'b.id')
            ->select(
                'a.name',
                'b.name as nationality',
                'a.preops_number'
            )
            ->orderby('a.name', 'asc')
            ->get();

        $preops_team = DB::table('preops_team')
            ->orderby('name', 'asc')
            ->get();

        $after_operation_evidence = DB::table('after_operation_evidence as a')
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
            ->leftjoin('preops_header as b', 'a.preops_number', '=', 'b.preops_number')
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
            ->orderby('a.lastname', 'asc')
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
            ->orderby('b.lastname', 'asc')
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
            ->orderby('b.lastname', 'asc')
            ->get();

        $spot_report_suspect2 = DB::table('spot_report_suspect as a')
            ->leftjoin('spot_report_header as o', 'a.spot_report_number', '=', 'o.spot_report_number')
            ->leftjoin('drug_management as q', 'a.id', '=', 'q.suspect_id')
            ->select('a.lastname', 'a.firstname', 'a.middlename', 'q.ndis_id', 'q.remarks', 'q.listed', 'o.preops_number')
            ->where('q.listed', 1)
            ->orderby('a.lastname', 'asc')
            ->get();

        return view('report_generation.ReportGenerationExcel', compact(
            'region1',
            'issuance_of_preops',
            'region',
            'preops_number',
            'province',
            'type_operation',
            'operating_unit',
            'support_unit',
            'datetime_coordinate',
            'datetime_operation',
            'valid_until',
            'a_area',
            'taget_name',
            'ot_name',
            'prepared_by',
            'ao_result',
            'ao_negative_reason',
            'ao_illegal_drug',
            'ao_quantity',
            'ao_unit_measure',
            'ao_crn',
            'ao_date_received',
            'all_sr',
            'sp_hio',
            'sp_suspect_number',
            'sp_status',
            'sp_lastname',
            'sp_firstname',
            'sp_middlename',
            'sp_alias',
            'sp_birthdate',
            'sp_est_birthdate',
            'sp_birthplace',
            'sp_region',
            'sp_province',
            'sp_city',
            'sp_barangay',
            'sp_street',
            'sp_p_region',
            'sp_p_province',
            'sp_p_city',
            'sp_p_barangay',
            'sp_p_street',
            'sp_sex',
            'sp_civil_status',
            'sp_nationality',
            'sp_ethnic_group',
            'sp_religion',
            'sp_educational_attainment',
            'sp_occupation',
            'sp_classification',
            'sp_category',
            'sp_whereabouts',
            'sp_remarks',
            'sp_seized_from',
            'sp_drug',
            'sp_evidence',
            'sp_quantity',
            'sp_unit',
            'sp_packaging',
            'sp_markings',
            'sp_case_type',
            'sp_summary',
            'sp_prepared_by',
            'pr_suspect_name',
            'pr_suspect_classification',
            'pr_suspect_status',
            'pr_drug_test_result',
            'pr_drug_type',
            'pr_remarks',
            'pr_drug_seized',
            'pr_qty_onsite',
            'pr_actual_qty',
            'pr_unit',
            'pr_id_drug_test_result',
            'pr_id_cr_number',
            'pr_id_laboratory',
            'pr_cf_suspect_name',
            'pr_cf_case',
            'pr_cf_docket_number',
            'pr_cf_status',
            'pr_inquest_status',
            'pr_inquest_date',
            'pr_inquest_nps',
            'pr_inquest_prosecutor',
            'pr_inquest_office',
            'pr_prelim_status',
            'pr_prelim_date',
            'pr_prelim_nps',
            'pr_prelim_prosecutor',
            'pr_prelim_office',
            'dv_suspect_name',
            'dv_listed',
            'dv_ndis',
            'dv_remarks',
            'preops_support_unit',
            'preops_area',
            'preops_target',
            'preops_team',
            'after_operation_evidence',
            'spot_report_header',
            'spot_report_suspect',
            'spot_report_evidence',
            'spot_report_case',
            'spot_report_suspect2'
        ));
    }
}
