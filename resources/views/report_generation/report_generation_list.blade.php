@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Report Generation List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="removeCokie();">Home</a></li>
                    <li class="breadcrumb-item active">Report Generation List</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>

<form id="print_report" method="GET" action="{{ route('reports_generation.export') }}" autocomplete="off" enctype="multipart/form-data">
    @csrf
    <!-- Main content -->
    <section class="content row">
        <!-- Default box -->

        <div class="card card-info col-2">
            <div class="card-header">
                <h3 class="card-title">Filter</h3>
            </div>
            <div class="card-body" style="overflow-y: scroll; height: 100vh">
                <!-- <label>Enter Keyword:</label>
            <input id="myInput" type="text" placeholder="Search..">

            <hr> -->
                <h4>COC</h4>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="all_coc" checked>
                    <label for="all_coc" class="custom-control-label">All</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input po_item" type="checkbox" id="region" name="region" checked>
                    <label for="region" class="custom-control-label">Region</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  po_item" type="checkbox" checked id="preops_number" name="preops_number">
                    <label for="preops_number" class="custom-control-label">Preops Number</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  po_item" type="checkbox" checked id="province" name="province">
                    <label for="province" class="custom-control-label">Province</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  po_item" type="checkbox" checked id="type_operation" name="type_operation">
                    <label for="type_operation" class="custom-control-label">Type of Operation</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  po_item" type="checkbox" checked id="operating_unit" name="operating_unit">
                    <label for="operating_unit" class="custom-control-label">Lead Unit</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  po_item" type="checkbox" checked id="support_unit" name="support_unit">
                    <label for="support_unit" class="custom-control-label">Support Unit</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  po_item" type="checkbox" checked id="datetime_coordinate" name="datetime_coordinate">
                    <label for="datetime_coordinate" class="custom-control-label">Date/Time Coordinate</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  po_item" type="checkbox" checked id="datetime_operation" name="datetime_operation">
                    <label for="datetime_operation" class="custom-control-label">Date/Time Operation</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  po_item" type="checkbox" checked id="valid_until" name="valid_until">
                    <label for="valid_until" class="custom-control-label">Valid Until</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  po_item" type="checkbox" checked id="a_area" name="a_area">
                    <label for="a_area" class="custom-control-label">Area Operation</label>
                </div>
                <!-- <div class="custom-control custom-checkbox">
                <input class="custom-control-input  po_item" type="checkbox" checked id="a_region" >
                <label for="a_region" class="custom-control-label">Region</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input  po_item" type="checkbox" checked id="a_province" >
                <label for="a_province" class="custom-control-label">Province</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input  po_item" type="checkbox" checked id="a_city" >
                <label for="a_city" class="custom-control-label">City</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input  po_item" type="checkbox" checked id="a_barangay" >
                <label for="a_barangay" class="custom-control-label">Barangay</label>
            </div> -->
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  po_item" type="checkbox" checked id="taget_name" name="taget_name">
                    <label for="taget_name" class="custom-control-label">Target</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  po_item" type="checkbox" checked id="ot_name" name="ot_name">
                    <label for="ot_name" class="custom-control-label">Operating Team</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  po_item" type="checkbox" checked id="prepared_by" name="prepared_by">
                    <label for="prepared_by" class="custom-control-label">Prepared By</label>
                </div>
                <hr>
                <h4>After Operations</h4>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="all_ao" checked>
                    <label for="all_ao" class="custom-control-label">All</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input ao_item" type="checkbox" id="ao_result" name="ao_result" checked>
                    <label for="ao_result" class="custom-control-label">Operation Result</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input ao_item" type="checkbox" id="ao_negative_reason" name="ao_negative_reason" checked>
                    <label for="ao_negative_reason" class="custom-control-label">Negative Reason</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input ao_item" type="checkbox" id="ao_illegal_drug" name="ao_illegal_drug" checked>
                    <label for="ao_illegal_drug" class="custom-control-label">Illegal Drug</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input ao_item" type="checkbox" id="ao_quantity" name="ao_quantity" checked>
                    <label for="ao_quantity" class="custom-control-label">Quantity</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input ao_item" type="checkbox" id="ao_unit_measure" name="ao_unit_measure" checked>
                    <label for="ao_unit_measure" class="custom-control-label">Unit Measure</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input ao_item" type="checkbox" id="ao_crn" name="ao_crn" checked>
                    <label for="ao_crn" class="custom-control-label">Chemistry Report Number</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input ao_item" type="checkbox" id="ao_date_received" name="ao_date_received" checked>
                    <label for="ao_date_received" class="custom-control-label">Date Received</label>
                </div>

                <!-- Spot Report -->
                <hr>
                <h4>Spot Report</h4>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="all_sr" name="all_sr" checked>
                    <label for="all_sr" class="custom-control-label">All</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input sr_item" type="checkbox" id="sp_hio" name="sp_hio" checked>
                    <label for="sp_hio" class="custom-control-label">High Impact Operation</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input sr_item" type="checkbox" id="sp_suspect_number" name="sp_suspect_number" checked>
                    <label for="sp_suspect_number" class="custom-control-label">Suspect Number</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input sr_item" type="checkbox" id="sp_status" name="sp_status" checked>
                    <label for="sp_status" class="custom-control-label">Suspect Status</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input sr_item" type="checkbox" id="sp_lastname" name="sp_lastname" checked>
                    <label for="sp_lastname" class="custom-control-label">Last Name</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input sr_item" type="checkbox" id="sp_firstname" name="sp_firstname" checked>
                    <label for="sp_firstname" class="custom-control-label">First Name</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input sr_item" type="checkbox" id="sp_middlename" name="sp_middlename" checked>
                    <label for="sp_middlename" class="custom-control-label">Middle Name</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input sr_item" type="checkbox" id="sp_alias" name="sp_alias" checked>
                    <label for="sp_alias" class="custom-control-label">Alias</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input sr_item" type="checkbox" id="sp_birthdate" name="sp_birthdate" checked>
                    <label for="sp_birthdate" class="custom-control-label">Birthdate</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input sr_item" type="checkbox" id="sp_est_birthdate" name="sp_est_birthdate" checked>
                    <label for="sp_est_birthdate" class="custom-control-label">Estimated Birthdate</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_birthplace" name="sp_birthplace" checked>
                    <label for="sp_birthplace" class="custom-control-label">Birth Place</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_region" name="sp_region" checked>
                    <label for="sp_region" class="custom-control-label">Region</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_province" name="sp_province" checked>
                    <label for="sp_province" class="custom-control-label">Province</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_city" name="sp_city" checked>
                    <label for="sp_city" class="custom-control-label">City</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_barangay" name="sp_barangay" checked>
                    <label for="sp_barangay" class="custom-control-label">Barangay</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_street" name="sp_street" checked>
                    <label for="sp_street" class="custom-control-label">Street</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_p_region" name="sp_p_region" checked>
                    <label for="sp_p_region" class="custom-control-label">Permanent Region</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_p_province" name="sp_p_province" checked>
                    <label for="sp_p_province" class="custom-control-label">Permanent Province</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_p_city" name="sp_p_city" checked>
                    <label for="sp_p_city" class="custom-control-label">Permanent City</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_p_barangay" name="sp_p_barangay" checked>
                    <label for="sp_p_barangay" class="custom-control-label">Permanent Barangay</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_p_street" name="sp_p_street" checked>
                    <label for="sp_p_street" class="custom-control-label">Permanent Street</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_sex" name="sp_sex" checked>
                    <label for="sp_sex" class="custom-control-label">Sex</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_civil_status" name="sp_civil_status" checked>
                    <label for="sp_civil_status" class="custom-control-label">Civil Status</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_nationality" name="sp_nationality" checked>
                    <label for="sp_nationality" class="custom-control-label">Nationality</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_ethnic_group" name="sp_ethnic_group" checked>
                    <label for="sp_ethnic_group" class="custom-control-label">Ethnic Group</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_religion" name="sp_religion" checked>
                    <label for="sp_religion" class="custom-control-label">Religion</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_educational_attainment" name="sp_educational_attainment" checked>
                    <label for="sp_educational_attainment" class="custom-control-label">Educational Attainment</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_occupation" name="sp_occupation" checked>
                    <label for="sp_occupation" class="custom-control-label">Occupation</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_classification" name="sp_classification" checked>
                    <label for="sp_classification" class="custom-control-label">Suspect Classification</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_category" name="sp_category" checked>
                    <label for="sp_category" class="custom-control-label">Suspect Category</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_whereabouts" name="sp_whereabouts" checked>
                    <label for="sp_whereabouts" class="custom-control-label">Whereabouts</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_remarks" name="sp_remarks" checked>
                    <label for="sp_remarks" class="custom-control-label">Remarks</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_seized_from" name="sp_seized_from" checked>
                    <label for="sp_seized_from" class="custom-control-label">Seized From (Suspect)</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_drug" name="sp_drug" checked>
                    <label for="sp_drug" class="custom-control-label">Drug/Non-Drug</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_evidence" name="sp_evidence" checked>
                    <label for="sp_evidence" class="custom-control-label">Type of Evidence</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_quantity" name="sp_quantity" checked>
                    <label for="sp_quantity" class="custom-control-label">Quantity/Weight</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_unit" name="sp_unit" checked>
                    <label for="sp_unit" class="custom-control-label">Unit of Measure</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_packaging" name="sp_packaging" checked>
                    <label for="sp_packaging" class="custom-control-label">Packaging</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_markings" name="sp_markings" checked>
                    <label for="sp_markings" class="custom-control-label">Markings</label>
                </div>
                <!-- <div class="custom-control custom-checkbox">
                <input class="custom-control-input  sr_item" type="checkbox" id="sp_case_name" checked>
                <label for="sp_case_name" class="custom-control-label">Suspect Name</label>
            </div> -->
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_case_type" name="sp_case_type" checked>
                    <label for="sp_case_type" class="custom-control-label">Case(s) Filed</label>
                </div>
                <!-- <div class="custom-control custom-checkbox">
                <input class="custom-control-input  sr_item" type="checkbox" id="sp_report_header" checked>
                <label for="sp_report_header" class="custom-control-label">Report Header</label>
            </div> -->
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_summary" name="sp_summary" checked>
                    <label for="sp_summary" class="custom-control-label">Summary</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  sr_item" type="checkbox" id="sp_prepared_by" name="sp_prepared_by" checked>
                    <label for="sp_prepared_by" class="custom-control-label">Prepared By</label>
                </div>

                <!-- Progress Report -->
                <hr>
                <h4>Progress Report</h4>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="all_pr" checked>
                    <label for="all_pr" class="custom-control-label">All</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  pr_item pr_item" type="checkbox" id="pr_suspect_name" name="pr_suspect_name" checked>
                    <label for="pr_suspect_name" class="custom-control-label">Suspect Name</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  pr_item" type="checkbox" id="pr_suspect_classification" name="pr_suspect_classification" checked>
                    <label for="pr_suspect_classification" class="custom-control-label">Suspect Classification</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  pr_item" type="checkbox" id="pr_suspect_status" name="pr_suspect_status" checked>
                    <label for="pr_suspect_status" class="custom-control-label">Suspect Status</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  pr_item" type="checkbox" id="pr_drug_test_result" name="pr_drug_test_result" checked>
                    <label for="pr_drug_test_result" class="custom-control-label">Drug Test Result</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  pr_item" type="checkbox" id="pr_drug_type" name="pr_drug_type" checked>
                    <label for="pr_drug_type" class="custom-control-label">Drug Type</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  pr_item" type="checkbox" id="pr_remarks" name="pr_remarks" checked>
                    <label for="pr_remarks" class="custom-control-label">Remarks</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  pr_item" type="checkbox" id="pr_drug_seized" name="pr_drug_seized" checked>
                    <label for="pr_drug_seized" class="custom-control-label">Drug Seized</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  pr_item" type="checkbox" id="pr_qty_onsite" name="pr_qty_onsite" checked>
                    <label for="pr_qty_onsite" class="custom-control-label">Qty. Onsite</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  pr_item" type="checkbox" id="pr_actual_qty" name="pr_actual_qty" checked>
                    <label for="pr_actual_qty" class="custom-control-label">Actual Qty</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  pr_item" type="checkbox" id="pr_unit" name="pr_unit" checked>
                    <label for="pr_unit" class="custom-control-label">Unit Measurement</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  pr_item" type="checkbox" id="pr_id_drug_test_result" name="pr_id_drug_test_result" checked>
                    <label for="pr_id_drug_test_result" class="custom-control-label">Drug Test Result</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  pr_item" type="checkbox" id="pr_id_cr_number" name="pr_id_cr_number" checked>
                    <label for="pr_id_cr_number" class="custom-control-label">Chemistry Report Number</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  pr_item" type="checkbox" id="pr_id_laboratory" name="pr_id_laboratory" checked>
                    <label for="pr_id_laboratory" class="custom-control-label">Laboratory Facility</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  pr_item" type="checkbox" id="pr_cf_suspect_name" name="pr_cf_suspect_name" checked>
                    <label for="pr_cf_suspect_name" class="custom-control-label">Suspect Name</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  pr_item" type="checkbox" id="pr_cf_case" name="pr_cf_case" checked>
                    <label for="pr_cf_case" class="custom-control-label">Case Filed</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  pr_item" type="checkbox" id="pr_cf_docket_number" name="pr_cf_docket_number" checked>
                    <label for="pr_cf_docket_number" class="custom-control-label">Docket Number</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  pr_item" type="checkbox" id="pr_cf_status" name="pr_cf_status" checked>
                    <label for="pr_cf_status" class="custom-control-label">Case Status</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  pr_item" type="checkbox" id="pr_inquest_status" name="pr_inquest_status" checked>
                    <label for="pr_inquest_status" class="custom-control-label">Case Status</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  pr_item" type="checkbox" id="pr_inquest_date" name="pr_inquest_date" checked>
                    <label for="pr_inquest_date" class="custom-control-label">Date</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  pr_item" type="checkbox" id="pr_inquest_nps" name="pr_inquest_nps" checked>
                    <label for="pr_inquest_nps" class="custom-control-label">IS/NPS Number</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  pr_item" type="checkbox" id="pr_inquest_prosecutor" name="pr_inquest_prosecutor" checked>
                    <label for="pr_inquest_prosecutor" class="custom-control-label">Name of Prosecutor </label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  pr_item" type="checkbox" id="pr_inquest_office" name="pr_inquest_office" checked>
                    <label for="pr_inquest_office" class="custom-control-label">Prosecutor Office</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  pr_item" type="checkbox" id="pr_prelim_status" name="pr_prelim_status" checked>
                    <label for="pr_prelim_status" class="custom-control-label">Case Status</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  pr_item" type="checkbox" id="pr_prelim_date" name="pr_prelim_date" checked>
                    <label for="pr_prelim_date" class="custom-control-label">Date Filed in Court</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  pr_item" type="checkbox" id="pr_prelim_nps" name="pr_prelim_nps" checked>
                    <label for="pr_prelim_nps" class="custom-control-label">IS/NPS Number</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  pr_item" type="checkbox" id="pr_prelim_prosecutor" name="pr_prelim_prosecutor" checked>
                    <label for="pr_prelim_prosecutor" class="custom-control-label">Name of Prosecutor</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input  pr_item" type="checkbox" id="pr_prelim_office" name="pr_prelim_office" checked>
                    <label for="pr_prelim_office" class="custom-control-label">Prosecutor Office</label>
                </div>

                <!-- Drug Verification List -->
                <hr>
                <h4>Drug Verification List</h4>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="all_dv" checked>
                    <label for="all_dv" class="custom-control-label">All</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input dv_item" type="checkbox" id="dv_suspect_name" name="dv_suspect_name" checked>
                    <label for="dv_suspect_name" class="custom-control-label">Suspect Name</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input dv_item" type="checkbox" id="dv_listed" name="dv_listed" checked>
                    <label for="dv_listed" class="custom-control-label">Listed</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input dv_item" type="checkbox" id="dv_ndis" name="dv_ndis" checked>
                    <label for="dv_ndis" class="custom-control-label">NDIS ID</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input dv_item" type="checkbox" id="dv_remarks" name="dv_remarks" checked>
                    <label for="dv_remarks" class="custom-control-label">Remarks</label>
                </div>

            </div>
        </div>
        <!-- /.card -->

        <div class="card card-info col-10">
            <div class="row" style="padding:20px">
                <div class="form-group col-4" style="margin: 0px;">
                    <div>
                        <label for="">Search Preops Number</label>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control Preops" name="q" placeholder="Search Preops Number"> <span class="input-group-btn">
                            <button type="button" class="btn btn-default submit_search">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>

                </div>
                <div class="form-group col-4" style="margin: 0px;">
                    <div>
                        <label for="">Operation Date</label>
                    </div>
                    <div class="input-group mb-3">
                        <input id="operation_date" name="operation_date" type="date" class="form-control @error('operation') is-invalid @enderror dateSearch" value="{{ old('operation_date') }}" autocomplete="off">
                    </div>
                </div>
                <div class="form-group col-4" style="margin: 0px;">
                    <div>
                        <label for="">Operation Date To</label>
                    </div>
                    <div class="input-group mb-3">
                        <input id="operation_date_to" name="operation_date_to" type="date" class="form-control @error('operation') is-invalid @enderror dateSearch" value="{{ old('operation_date_to') }}" autocomplete="off">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Download</button>
            </div>


            <div class="card-body" style="overflow-x:auto;">
                <table id="example_info" class="table table-bordered table-striped table-hover" style="width:auto">
                    <thead>
                        <tr>
                            <th id="IOP" class="po" colspan="20" style="white-space: nowrap;  text-align:center; font-size: 30px"><input id="IOP2" name="IOP" hidden value="20"></input>Issuance of Pre-Ops</th>
                            <th id="AO" class="ao" colspan="7" style="white-space: nowrap;  text-align:center; font-size: 30px"><input id="AO2" name="AO" hidden value="7"></input>After Operations</th>
                            <th id="SP" class="sp" colspan="43" style="white-space: nowrap;  text-align:center; font-size: 30px"><input id="SP2" name="SP" hidden value="43"></input>Spot Report</th>
                            <th id="PR" class="pr" colspan="27" style="white-space: nowrap;  text-align:center; font-size: 30px"><input id="PR2" name="PR" hidden value="27"></input>Progress Report</th>
                            <th id="DV" class="dv" colspan="4" style="white-space: nowrap;  text-align:center; font-size: 30px"><input id="DV2" name="DV" hidden value="4"></input>Drug Verification List</th>
                        </tr>
                        <tr>
                            <th class="po region" rowspan="2" style="white-space: nowrap; text-align:center; font-size: 20px; vertical-align : middle;text-align:center;">Region</th>
                            <th class="po preops_number" rowspan="2" style="white-space: nowrap; text-align:center; font-size: 20px; vertical-align : middle;text-align:center;">Preops Number</th>
                            <th class="po province" rowspan="2" style="white-space: nowrap; text-align:center; font-size: 20px; vertical-align : middle;text-align:center;">Province</th>
                            <th class="po type_operation" rowspan="2" style="white-space: nowrap; text-align:center; font-size: 20px; vertical-align : middle;text-align:center;">Type Of Operation</th>
                            <th class="po operating_unit" rowspan="2" style="white-space: nowrap; text-align:center; font-size: 20px; vertical-align : middle;text-align:center;">Lead Unit</th>
                            <th class="po support_unit" rowspan="2" style="white-space: nowrap; text-align:center; font-size: 20px; vertical-align : middle;text-align:center;">Support Unit</th>
                            <th class="po datetime_coordinate" rowspan="2" style="white-space: nowrap; text-align:center; font-size: 20px; vertical-align : middle;text-align:center;">Date/Time Coordinate</th>
                            <th class="po datetime_operation" rowspan="2" style="white-space: nowrap; text-align:center; font-size: 20px; vertical-align : middle;text-align:center;">Date/Time Operation</th>
                            <th class="po valid_until" rowspan="2" style="white-space: nowrap; text-align:center; font-size: 20px; vertical-align : middle;text-align:center;">Valid Until</th>
                            <th class="ao a_area" colspan="5" style="white-space: nowrap; text-align:center; font-size: 20px">Area of Operation</th>
                            <th class="ao taget_name" colspan="2" style="white-space: nowrap;  text-align:center; font-size: 20px">Target</th>
                            <th class="ao ot_name" colspan="3" style="white-space: nowrap; text-align:center;  font-size: 20px">Operating Team</th>
                            <th class="ao prepared_by" rowspan="2" style="white-space: nowrap; text-align:center;  font-size: 20px; vertical-align : middle;text-align:center;">Prepared By</th>
                            <th class="ao ao_result" rowspan="2" style="white-space: nowrap; text-align:center;  font-size: 20px; vertical-align : middle;text-align:center;">Operation Result</th>
                            <th class="ao ao_negative_reason" rowspan="2" style="white-space: nowrap; text-align:center;  font-size: 20px; vertical-align : middle;text-align:center;">Negative Reason</th>
                            <th class="ao ao_illegal_drug" rowspan="2" style="white-space: nowrap; text-align:center;  font-size: 20px; vertical-align : middle;text-align:center;">Illegal Drug</th>
                            <th class="ao ao_quantity" rowspan="2" style="white-space: nowrap; text-align:center;  font-size: 20px; vertical-align : middle;text-align:center;">Quantity</th>
                            <th class="ao ao_unit_measure" rowspan="2" style="white-space: nowrap; text-align:center;  font-size: 20px; vertical-align : middle;text-align:center;">Unit Measure</th>
                            <th class="ao ao_crn" rowspan="2" style="white-space: nowrap; text-align:center;  font-size: 20px; vertical-align : middle;text-align:center;">Chemistry Report Number</th>
                            <th class="ao ao_date_received" rowspan="2" style="white-space: nowrap; text-align:center;  font-size: 20px; vertical-align : middle;text-align:center;">Date Received</th>
                            <th class="sp sp_hio" rowspan="2" style="white-space: nowrap; text-align:center;  font-size: 20px; vertical-align : middle;text-align:center;">High Impact Operation</th>
                            <th class="sp suspect" id="SP_suspect" colspan="30" style="white-space: nowrap;  text-align:center; font-size: 20px">Suspect</th>
                            <th class="sp item_seized" id="SP_item_seized" colspan="7" style="white-space: nowrap;  text-align:center; font-size: 20px">Item Seized</th>
                            <th class="sp case_filed" id="SP_CF" colspan="2" style="white-space: nowrap;  text-align:center; font-size: 20px">Case Filed</th>
                            <th class="sp sp_summary" colspan="2" style="white-space: nowrap;  text-align:center; font-size: 20px">Summary</th>
                            <th class="sp sp_prepared_by" rowspan="2" style="white-space: nowrap; text-align:center;  font-size: 20px; vertical-align : middle;text-align:center;">Prepared By</th>
                            <th class="pr pr_suspect" id="PR_suspect" colspan="6" style="white-space: nowrap;  text-align:center; font-size: 20px">Suspect</th>
                            <th class="pr pr_evidence" id="PR_IS" colspan="7" style="white-space: nowrap;  text-align:center; font-size: 20px">Item Seized</th>
                            <th class="pr pr_case" id="PR_CASE" colspan="4" style="white-space: nowrap;  text-align:center; font-size: 20px">Case Filed</th>
                            <th class="pr pr_inquest" id="PR_INQUEST" colspan="5" style="white-space: nowrap;  text-align:center; font-size: 20px">Inquest</th>
                            <th class="pr pr_prelim" id="PR_PRELIM" colspan="5" style="white-space: nowrap;  text-align:center; font-size: 20px">Preliminary Investigation</th>
                            <th class="dv dv_hio" id="DV_HIO" colspan="4" style="white-space: nowrap;  text-align:center; font-size: 20px">High Impact Operation</th>
                        </tr>
                        <tr>
                            <th class="ao a_area" style="white-space: nowrap">Area</th>
                            <th class="ao a_area" style="white-space: nowrap">Barangay</th>
                            <th class="ao a_area" style="white-space: nowrap">City</th>
                            <th class="ao a_area" style="white-space: nowrap">Province</th>
                            <th class="ao a_area" style="white-space: nowrap">Region</th>
                            <th class="ao taget_name" style="white-space: nowrap">Name</th>
                            <th class="ao taget_name" style="white-space: nowrap">Nationality</th>
                            <th class="ao ot_name" style="white-space: nowrap">Name</th>
                            <th class="ao ot_name" style="white-space: nowrap">Position</th>
                            <th class="ao ot_name" style="white-space: nowrap">Contact</th>
                            <th class="sp sp_suspect_number" style="white-space: nowrap">Suspect Number</th>
                            <th class="sp sp_status" style="white-space: nowrap">Suspect Status</th>
                            <th class="sp sp_lastname" style="white-space: nowrap">Last Name</th>
                            <th class="sp sp_firstname" style="white-space: nowrap">First Name</th>
                            <th class="sp sp_middlename" style="white-space: nowrap">Middle Name</th>
                            <th class="sp sp_alias" style="white-space: nowrap">Alias</th>
                            <th class="sp sp_birthdate" style="white-space: nowrap">Birthdate</th>
                            <th class="sp sp_est_birthdate" style="white-space: nowrap">Estimated Birthdate</th>
                            <th class="sp sp_birthplace" style="white-space: nowrap">Birth Place</th>
                            <th class="sp sp_region" style="white-space: nowrap">Region</th>
                            <th class="sp sp_province" style="white-space: nowrap">Province</th>
                            <th class="sp sp_city" style="white-space: nowrap">City</th>
                            <th class="sp sp_barangay" style="white-space: nowrap">Barangay</th>
                            <th class="sp sp_street" style="white-space: nowrap">Street</th>
                            <th class="sp sp_p_region" style="white-space: nowrap">Permanent Region</th>
                            <th class="sp sp_p_province" style="white-space: nowrap">Permanent Province</th>
                            <th class="sp sp_p_city" style="white-space: nowrap">Permanent City</th>
                            <th class="sp sp_p_barangay" style="white-space: nowrap">Permanent Barangay</th>
                            <th class="sp sp_p_street" style="white-space: nowrap">Permanent Street</th>
                            <th class="sp sp_sex" style="white-space: nowrap">Sex</th>
                            <th class="sp sp_civil_status" style="white-space: nowrap">Civil Status</th>
                            <th class="sp sp_nationality" style="white-space: nowrap">Nationality</th>
                            <th class="sp sp_ethnic_group" style="white-space: nowrap">Ethnic Group</th>
                            <th class="sp sp_religion" style="white-space: nowrap">Religion</th>
                            <th class="sp sp_educational_attainment" style="white-space: nowrap">Educational Attainment</th>
                            <th class="sp sp_occupation" style="white-space: nowrap">Occupation</th>
                            <th class="sp sp_classification" style="white-space: nowrap">Suspect Classification</th>
                            <th class="sp sp_category" style="white-space: nowrap">Suspect Category</th>
                            <th class="sp sp_whereabouts" style="white-space: nowrap">Whereabouts</th>
                            <th class="sp sp_remarks" style="white-space: nowrap">Remarks</th>
                            <th class="sp sp_seized_from" style="white-space: nowrap">Seized From (Suspect)</th>
                            <th class="sp sp_drug" style="white-space: nowrap">Drug/Non-Drug</th>
                            <th class="sp sp_evidence" style="white-space: nowrap">Type of Evidence</th>
                            <th class="sp sp_quantity" style="white-space: nowrap">Quantity/Weight</th>
                            <th class="sp sp_unit" style="white-space: nowrap">Unit of Measure</th>
                            <th class="sp sp_packaging" style="white-space: nowrap">Packaging</th>
                            <th class="sp sp_markings" style="white-space: nowrap">Markings</th>
                            <th class="sp sp_case_type" style="white-space: nowrap">Suspect Name</th>
                            <th class="sp sp_case_type" style="white-space: nowrap">Case(s) Filed</th>
                            <th class="sp sp_summary" style="white-space: nowrap">Report Header</th>
                            <th class="sp sp_summary" style="white-space: nowrap">Summary</th>

                            <th class="pr pr_suspect_name" style="white-space: nowrap">Suspect Name</th>
                            <th class="pr pr_suspect_classification" style="white-space: nowrap">Suspect Classification</th>
                            <th class="pr pr_suspect_status" style="white-space: nowrap">Suspect Status</th>
                            <th class="pr pr_drug_test_result" style="white-space: nowrap">Drug Test Result</th>
                            <th class="pr pr_drug_type" style="white-space: nowrap">Drug Type</th>
                            <th class="pr pr_remarks" style="white-space: nowrap">Remarks</th>
                            <th class="pr pr_drug_seized" style="white-space: nowrap">Drug Seized</th>
                            <th class="pr pr_qty_onsite" style="white-space: nowrap">Qty. Onsite</th>
                            <th class="pr pr_actual_qty" style="white-space: nowrap">Actual Qty</th>
                            <th class="pr pr_unit" style="white-space: nowrap">Unit Measurement</th>
                            <th class="pr pr_id_drug_test_result" style="white-space: nowrap">Drug Test Result</th>
                            <th class="pr pr_id_cr_number" style="white-space: nowrap">Chemistry Report Number</th>
                            <th class="pr pr_is_laboratory" style="white-space: nowrap">Laboratory Facility</th>
                            <th class="pr pr_cf_suspect_name" style="white-space: nowrap">Suspect Name</th>
                            <th class="pr pr_cf_case" style="white-space: nowrap">Case Filed</th>
                            <th class="pr pr_cf_docket_number" style="white-space: nowrap">Docket Number</th>
                            <th class="pr pr_cf_status" style="white-space: nowrap">Case Status</th>

                            <th class="pr pr_inquest_status" style="white-space: nowrap">Case Status</th>
                            <th class="pr pr_inquest_date" style="white-space: nowrap">Date</th>
                            <th class="pr pr_inquest_nps" style="white-space: nowrap">IS/NPS Number</th>
                            <th class="pr pr_inquest_prosecutor" style="white-space: nowrap">Name of Prosecutor</th>
                            <th class="pr pr_inquest_office" style="white-space: nowrap">Prosecutor Office</th>

                            <th class="pr pr_prelim_status" style="white-space: nowrap">Case Status</th>
                            <th class="pr pr_prelim_date" style="white-space: nowrap">Date Filed in Court</th>
                            <th class="pr pr_prelim_nps" style="white-space: nowrap">IS/NPS Number</th>
                            <th class="pr pr_prelim_prosecutor" style="white-space: nowrap">Name of Prosecutor</th>
                            <th class="pr pr_prelim_office" style="white-space: nowrap">Prosecutor Office</th>

                            <th class="dv dv_suspect_name" style="white-space: nowrap">Suspect Name</th>
                            <th class="dv dv_listed" style="white-space: nowrap">Listed</th>
                            <th class="dv dv_ndis" style="white-space: nowrap">NDIS ID</th>
                            <th class="dv dv_remarks" style="white-space: nowrap">Remarks</th>

                        </tr>
                    </thead>
                    <tbody id="myTable">
                        @include('report_generation.report_generation_data')
                    </tbody>

                </table>
                <input type="hidden" name="hidden_page" id="hidden_page" value="1">
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <h6>List of all Spot Report maintenance data sorted by name.</h6>
            </div>
        </div>
        <!-- /.card -->

    </section>
</form>
<!-- /.content -->

<!-- Set menu to collapse and active -->
@endsection

@section('scripts')

<script>
    $(document).ready(function() {
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        function DataFilter() {
            var page = $('#hidden_page').val();
            var operation_date = $('#operation_date').val();
            var operation_date_to = $('#operation_date_to').val();

            if (operation_date == '' || operation_date == null) {
                operation_date = 0;
            }
            if (operation_date_to == '' || operation_date_to == null) {
                operation_date_to = 0;
            }

            // $.ajax({
            //     url: "/report_generation_list/fetch_data?page=" + page + "&operation_date=" + operation_date + "&operation_date_to=" + operation_date_to,
            //     success: function(data) {
            //         // alert('test')
            //         $('tbody').html('');
            //         $('tbody').html(data);
            //     }
            // });

            $(".pr_number").each(function() {
                var preops_number = $(this).text();
                var $row = $(this).closest('tr');

                $.ajax({
                    type: "GET",
                    url: "/get_preops_support_unit/" + preops_number,
                    fail: function() {
                        alert("request failed");
                    },
                    success: function(data) {
                        var data = JSON.parse(data);

                        if (data.length > 0) {
                            data.forEach(element => {
                                $($row.find("td:eq(5)")).append(element["description"] + '<br>');
                            });
                        }
                    }
                });

                $.ajax({
                    type: "GET",
                    url: "/get_preops_area/" + preops_number,
                    fail: function() {
                        alert("request failed");
                    },
                    success: function(data) {
                        var data = JSON.parse(data);

                        if (data.length > 0) {
                            data.forEach(element => {
                                $($row.find("td:eq(9)")).append(element["area"] + '<br>');
                                if (element["barangay_m"] != null) {
                                    $($row.find("td:eq(10)")).append(element["barangay_m"] + '<br>');
                                }
                                if (element["city_m"] != null) {
                                    $($row.find("td:eq(11)")).append(element["city_m"] + '<br>');
                                }
                                if (element["province_m"] != null) {
                                    $($row.find("td:eq(12)")).append(element["province_m"] + '<br>');
                                }
                                $($row.find("td:eq(13)")).append(element["region_m"] + '<br>');
                            });
                        }


                    }
                });

                $.ajax({
                    type: "GET",
                    url: "/get_preops_target/" + preops_number,
                    fail: function() {
                        alert("request failed");
                    },
                    success: function(data) {
                        var data = JSON.parse(data);

                        if (data.length > 0) {
                            data.forEach(element => {
                                $($row.find("td:eq(14)")).append(element["name"] + '<br>');
                                $($row.find("td:eq(15)")).append(element["nationality"] + '<br>');
                            });
                        }


                    }
                });

                $.ajax({
                    type: "GET",
                    url: "/get_preops_operating_team/" + preops_number,
                    fail: function() {
                        alert("request failed");
                    },
                    success: function(data) {
                        var data = JSON.parse(data);

                        if (data.length > 0) {
                            data.forEach(element => {
                                $($row.find("td:eq(16)")).append(element["name"] + '<br>');
                                $($row.find("td:eq(17)")).append(element["position"] + '<br>');
                                $($row.find("td:eq(18)")).append(element["contact"] + '<br>');
                            });
                        }


                    }
                });

                $.ajax({
                    type: "GET",
                    url: "/get_after_operation_evidence/" + preops_number,
                    fail: function() {
                        alert("request failed");
                    },
                    success: function(data) {
                        var data = JSON.parse(data);

                        if (data.length > 0) {
                            data.forEach(element => {
                                $($row.find("td:eq(22)")).append(element["evidence"] + '<br>');
                                $($row.find("td:eq(23)")).append(element["quantity"] + '<br>');
                                $($row.find("td:eq(24)")).append(element["unit"] + '<br>');
                                $($row.find("td:eq(25)")).append(element["chemist_report_number"] + '<br>');
                            });
                        }


                    }
                });

                $.ajax({
                    type: "GET",
                    url: "/get_preops_spot/" + preops_number,
                    fail: function() {
                        alert("request failed");
                    },
                    success: function(data) {
                        var data = JSON.parse(data);

                        if (data.length > 0) {
                            data.forEach(element => {
                                if (element["operation_lvl"] == 1) {
                                    $($row.find("td:eq(27)")).append('Yes <br>');
                                } else {
                                    $($row.find("td:eq(27)")).append('No <br>');
                                }
                                $($row.find("td:eq(67)")).append(element["report_header"] + '<br>');
                                $($row.find("td:eq(68)")).append(element["summary"] + '<br>');
                                $($row.find("td:eq(69)")).append(element["prepared_by"] + '<br>');
                                $($row.find("td:eq(87)")).append(element["case_status"] + '<br>');
                                $($row.find("td:eq(88)")).append(element["case_status_date"] + '<br>');
                                $($row.find("td:eq(89)")).append(element["is_number"] + '<br>');
                                $($row.find("td:eq(90)")).append(element["procecutor_name"] + '<br>');
                                $($row.find("td:eq(91)")).append(element["procecutor_office"] + '<br>');
                                $($row.find("td:eq(92)")).append(element["prelim_case_status"] + '<br>');
                                $($row.find("td:eq(93)")).append(element["prelim_case_date"] + '<br>');
                                $($row.find("td:eq(94)")).append(element["prelim_is_number"] + '<br>');
                                $($row.find("td:eq(95)")).append(element["prelim_prosecutor"] + '<br>');
                                $($row.find("td:eq(96)")).append(element["prelim_prosecutor_office"] + '<br>');
                            });
                        }
                    }
                });

                $.ajax({
                    type: "GET",
                    url: "/get_preops_spot_suspect/" + preops_number,
                    fail: function() {
                        alert("request failed");
                    },
                    success: function(data) {
                        var data = JSON.parse(data);

                        if (data.length > 0) {
                            data.for(element => {
                                alert('test');
                                $($row.find("td:eq(28)")).append(element["suspect_number"] + '<br>');
                                $($row.find("td:eq(29)")).append(element["suspect_status"] + '<br>');
                                $($row.find("td:eq(30)")).append(element["lastname"] + '<br>');
                                $($row.find("td:eq(31)")).append(element["firstname"] + '<br>');
                                $($row.find("td:eq(32)")).append(element["middlename"] + '<br>');
                                $($row.find("td:eq(33)")).append(element["alias"] + '<br>');
                                $($row.find("td:eq(34)")).append(element["birthdate"] + '<br>');
                                if (element["est_birthdate"] == 1) {
                                    $($row.find("td:eq(35)")).append('Yes <br>');
                                } else {
                                    $($row.find("td:eq(35)")).append('No <br>');
                                }
                                if (element["birthplace"] != null && element["birthplace"] != '') {
                                    $($row.find("td:eq(36)")).append(element["birthplace"] + '<br>');
                                }
                                if (element["s_region"] != null && element["s_region"] != '') {
                                    $($row.find("td:eq(37)")).append(element["s_region"] + '<br>');
                                }
                                if (element["s_province"] != null && element["s_province"] != '') {
                                    $($row.find("td:eq(38)")).append(element["s_province"] + '<br>');
                                }
                                if (element["s_city"] != null && element["s_city"] != '') {
                                    $($row.find("td:eq(39)")).append(element["s_city"] + '<br>');
                                }
                                if (element["s_barangay"] != null && element["s_barangay"] != '') {
                                    $($row.find("td:eq(40)")).append(element["s_barangay"] + '<br>');
                                }
                                if (element["street"] != null && element["street"] != '') {
                                    $($row.find("td:eq(41)")).append(element["street"] + '<br>');
                                }
                                if (element["p_region"] != null && element["p_region"] != '') {
                                    $($row.find("td:eq(42)")).append(element["p_region"] + '<br>');
                                }
                                if (element["p_province"] != null && element["p_province"] != '') {
                                    $($row.find("td:eq(43)")).append(element["p_province"] + '<br>');
                                }
                                if (element["p_city"] != null && element["p_city"] != '') {
                                    $($row.find("td:eq(44)")).append(element["p_city"] + '<br>');
                                }
                                if (element["p_barangay"] != null && element["p_barangay"] != '') {
                                    $($row.find("td:eq(45)")).append(element["p_barangay"] + '<br>');
                                }
                                if (element["permanent_street"] != null && element["permanent_street"] != '') {
                                    $($row.find("td:eq(46)")).append(element["permanent_street"] + '<br>');
                                }
                                if (element["gender"] != null && element["gender"] != '') {
                                    $($row.find("td:eq(47)")).append(element["gender"] + '<br>');
                                }
                                if (element["civil_status"] != null && element["civil_status"] != '') {
                                    $($row.find("td:eq(48)")).append(element["civil_status"] + '<br>');
                                }
                                if (element["nationality"] != null && element["nationality"] != '') {
                                    $($row.find("td:eq(49)")).append(element["nationality"] + '<br>');
                                }
                                if (element["ethnic_group"] != null && element["ethnic_group"] != '') {
                                    $($row.find("td:eq(50)")).append(element["ethnic_group"] + '<br>');
                                }
                                if (element["religion"] != null && element["religion"] != '') {
                                    $($row.find("td:eq(51)")).append(element["religion"] + '<br>');
                                }
                                if (element["educational_attainment"] != null && element["educational_attainment"] != '') {
                                    $($row.find("td:eq(52)")).append(element["educational_attainment"] + '<br>');
                                }
                                if (element["occupation"] != null && element["occupation"] != '') {
                                    $($row.find("td:eq(53)")).append(element["occupation"] + '<br>');
                                }
                                if (element["suspect_classification"] != null && element["suspect_classification"] != '') {
                                    $($row.find("td:eq(54)")).append(element["suspect_classification"] + '<br>');
                                }
                                if (element["suspect_category"] != null && element["suspect_category"] != '') {
                                    $($row.find("td:eq(55)")).append(element["suspect_category"] + '<br>');
                                }
                                if (element["whereabouts"] != null && element["whereabouts"] != '') {
                                    $($row.find("td:eq(56)")).append(element["whereabouts"] + '<br>');
                                }
                                if (element["remarks"] != null && element["remarks"] != '') {
                                    $($row.find("td:eq(57)")).append(element["remarks"] + '<br>');
                                }

                                $($row.find("td:eq(70)")).append(element["lastname"] + ', ' + element["firstname"] + ' ' + element["middlename"] + '<br>');
                                $($row.find("td:eq(71)")).append(element["suspect_classification"] + '<br>');
                                $($row.find("td:eq(72)")).append(element["suspect_status"] + '<br>');
                                $($row.find("td:eq(73)")).append(element["drug_test_result"] + '<br>');
                                $($row.find("td:eq(74)")).append(element["drug_type"] + '<br>');
                                $($row.find("td:eq(75)")).append(element["remarks"] + '<br>');
                            });
                        }
                    }
                });

                $.ajax({
                    type: "GET",
                    url: "/get_preops_spot_suspect_listed/" + preops_number,
                    fail: function() {
                        alert("request failed");
                    },
                    success: function(data) {
                        var data = JSON.parse(data);

                        if (data.length > 0) {
                            data.forEach(element => {
                                $($row.find("td:eq(97)")).append(element["lastname"] + ', ' + element["firstname"] + ' ' + element["middlename"] + '<br>');
                                if (element["listed"] == 1) {
                                    $($row.find("td:eq(98)")).append('Yes <br>');
                                } else {
                                    $($row.find("td:eq(98)")).append('No <br>');
                                }
                                $($row.find("td:eq(99)")).append(element["ndis_id"] + '<br>');
                                $($row.find("td:eq(100)")).append(element["remarks"] + '<br>');
                            });
                        }
                    }
                });

                $.ajax({
                    type: "GET",
                    url: "/get_preops_spot_evidence/" + preops_number,
                    fail: function() {
                        alert("request failed");
                    },
                    success: function(data) {
                        var data = JSON.parse(data);

                        if (data.length > 0) {
                            data.forEach(element => {
                                $($row.find("td:eq(58)")).append(element["lastname"] + ', ' + element["firstname"] + ' ' + element["middlename"] + '<br>');
                                $($row.find("td:eq(59)")).append(element["drug"] + '<br>');
                                $($row.find("td:eq(60)")).append(element["evidence"] + '<br>');
                                $($row.find("td:eq(61)")).append(element["quantity"] + '<br>');
                                $($row.find("td:eq(62)")).append(element["unit_measure"] + '<br>');
                                $($row.find("td:eq(63)")).append(element["packaging"] + '<br>');
                                $($row.find("td:eq(64)")).append(element["markings"] + '<br>');
                                $($row.find("td:eq(76)")).append(element["evidence"] + '<br>');
                                $($row.find("td:eq(77)")).append(element["qty_onsite"] + '<br>');
                                $($row.find("td:eq(78)")).append(element["actual_qty"] + '<br>');
                                $($row.find("td:eq(79)")).append(element["unit_measure"] + '<br>');
                                $($row.find("td:eq(80)")).append(element["drug_test_result"] + '<br>');
                                $($row.find("td:eq(81)")).append(element["chemist_report_number"] + '<br>');
                                $($row.find("td:eq(82)")).append(element["laboratory_facility"] + '<br>');
                            });
                        }
                    }
                });

                $.ajax({
                    type: "GET",
                    url: "/get_preops_spot_case/" + preops_number,
                    fail: function() {
                        alert("request failed");
                    },
                    success: function(data) {
                        var data = JSON.parse(data);

                        if (data.length > 0) {
                            data.forEach(element => {
                                $($row.find("td:eq(65)")).append(element["lastname"] + ', ' + element["firstname"] + ' ' + element["middlename"] + '<br>');
                                $($row.find("td:eq(66)")).append(element["case"] + '<br>');

                                $($row.find("td:eq(83)")).append(element["lastname"] + ', ' + element["firstname"] + ' ' + element["middlename"] + '<br>');
                                $($row.find("td:eq(84)")).append(element["case"] + '<br>');
                                $($row.find("td:eq(85)")).append(element["docket_number"] + '<br>');
                                $($row.find("td:eq(86)")).append(element["case_status"] + '<br>');
                            });
                        }
                    }
                });

                $.ajax({
                    type: "GET",
                    url: "/get_preops_progress_suspect/" + preops_number,
                    fail: function() {
                        alert("request failed");
                    },
                    success: function(data) {
                        var data = JSON.parse(data);

                        if (data.length > 0) {
                            data.forEach(element => {
                                $($row.find("td:eq(28)")).append(element["suspect_number"] + '<br>');
                                $($row.find("td:eq(29)")).append(element["suspect_status"] + '<br>');
                                $($row.find("td:eq(30)")).append(element["lastname"] + '<br>');
                                $($row.find("td:eq(31)")).append(element["firstname"] + '<br>');
                                $($row.find("td:eq(32)")).append(element["middlename"] + '<br>');
                                $($row.find("td:eq(33)")).append(element["alias"] + '<br>');
                                $($row.find("td:eq(34)")).append(element["birthdate"] + '<br>');
                                if (element["est_birthdate"] == 1) {
                                    $($row.find("td:eq(35)")).append('Yes <br>');
                                } else {
                                    $($row.find("td:eq(35)")).append('No <br>');
                                }
                                $($row.find("td:eq(36)")).append(element["birthplace"] + '<br>');
                                $($row.find("td:eq(37)")).append(element["s_region"] + '<br>');
                                $($row.find("td:eq(38)")).append(element["s_province"] + '<br>');
                                $($row.find("td:eq(39)")).append(element["s_city"] + '<br>');
                                $($row.find("td:eq(40)")).append(element["s_barangay"] + '<br>');
                                $($row.find("td:eq(41)")).append(element["street"] + '<br>');
                                $($row.find("td:eq(42)")).append(element["p_region"] + '<br>');
                                $($row.find("td:eq(43)")).append(element["p_province"] + '<br>');
                                $($row.find("td:eq(44)")).append(element["p_city"] + '<br>');
                                $($row.find("td:eq(45)")).append(element["p_barangay"] + '<br>');
                                $($row.find("td:eq(46)")).append(element["permanent_street"] + '<br>');
                                $($row.find("td:eq(47)")).append(element["gender"] + '<br>');
                                $($row.find("td:eq(48)")).append(element["civil_status"] + '<br>');
                                $($row.find("td:eq(49)")).append(element["nationality"] + '<br>');
                                $($row.find("td:eq(50)")).append(element["ethnic_group"] + '<br>');
                                $($row.find("td:eq(51)")).append(element["religion"] + '<br>');
                                $($row.find("td:eq(52)")).append(element["educational_attainment"] + '<br>');
                                $($row.find("td:eq(53)")).append(element["occupation"] + '<br>');
                                $($row.find("td:eq(54)")).append(element["suspect_classification"] + '<br>');
                                $($row.find("td:eq(55)")).append(element["suspect_category"] + '<br>');
                                $($row.find("td:eq(56)")).append(element["whereabouts"] + '<br>');
                                $($row.find("td:eq(57)")).append(element["remarks"] + '<br>');
                            });
                        }
                    }
                });

                $('td:contains("null")').text(' ');
            });

        }

        $(".submit_search").on("click", function() {
            var param = $('.Preops').val();
            var page = $('#hidden_page').val();
            $.ajax({
                url: "/reports_generation/search_report_list?page=" + page + "&param=" + param,
                success: function(data) {
                    $('tbody').html('');
                    $('tbody').html(data);

                    DataFilter();
                }
            });

        });

        $(".dateSearch").on("change", function() {
            var param = $('.Preops').val();
            var page = $('#hidden_page').val();
            var param2 = $('#operation_date').val();
            var param3 = $('#operation_date_to').val();

            if (param2 == '' || param2 == null) {
                param2 = 0;
            }
            if (param3 == '' || param3 == null) {
                param3 = 0;
            }

            $.ajax({
                url: "/reports_generation/search_report_list?page=" + page + "&param=" + param + "&param2=" + param2 + "&param3=" + param3,
                success: function(data) {
                    $('tbody').html('');
                    $('tbody').html(data);

                    DataFilter();
                }
            });

        });

        DataFilter();

    });




    $('#operation_date').change(function() {
        $('#hidden_page').val(1);
        SpotReportFilter();
    });

    $('#operation_date_to').change(function() {
        $('#hidden_page').val(1);
        SpotReportFilter();
    });
</script>

<script>
    $(document).on('click', '#all_coc', function() {
        if ($(this).is(":checked")) {
            $('.po').attr('hidden', false);
            $('.po_item').prop('checked', true);
            $('#IOP').prop("colspan", 20);
            $('#IOP2').val(20);

        } else {
            $('.po').attr('hidden', true);
            $('.po_item').prop('checked', false);
            $('#IOP').prop("colspan", 1);
            $('#IOP2').val(1);
        }
    });
    $(document).on('click', '#all_ao', function() {
        if ($(this).is(":checked")) {
            $('.ao').attr('hidden', false);
            $('.ao_item').prop('checked', true);
            $('#AO').prop("colspan", 20);
            $('#AO2').val(20);

        } else {
            $('.ao').attr('hidden', true);
            $('.ao_item').prop('checked', false);
            $('#AO').prop("colspan", 1);
            $('#AO2').val(1);
        }
    });
    $(document).on('click', '#all_sr', function() {
        if ($(this).is(":checked")) {
            $('.sp').attr('hidden', false);
            $('.sr_item').prop('checked', true);
            $('#SP').prop("colspan", 43);
            $('#SP2').val(43);
        } else {
            $('.sp').attr('hidden', true);
            $('.sr_item').prop('checked', false);
            $('#SP').prop("colspan", 1);
            $('#SP2').val(1);
        }
    });
    $(document).on('click', '#all_pr', function() {
        if ($(this).is(":checked")) {
            $('.pr').attr('hidden', false);
            $('.pr_item').prop('checked', true);
            $('#PR').prop("colspan", 20);
            $('#PR2').val(20);
        } else {
            $('.pr').attr('hidden', true);
            $('.pr_item').prop('checked', false);
            $('#PR').prop("colspan", 1);
            $('#PR2').val(1);
        }
    });
    $(document).on('click', '#all_dv', function() {
        if ($(this).is(":checked")) {
            $('.dv').attr('hidden', false);
            $('.dv_item').prop('checked', true);
            $('#DV').prop("colspan", 20)
            $('#DV2').val(20);

        } else {
            $('.dv').attr('hidden', true);
            $('.dv_item').prop('checked', false);
            $('#DV').prop("colspan", 1)
            $('#DV2').val(1);
        }
    });
    $(document).on('click', '#region', function() {
        if ($(this).is(":checked")) {
            $('.region').attr('hidden', false);
            if ($('#IOP').prop("colspan") == 1 && $('#IOP').is(":hidden") == true) {
                $('#IOP').attr('hidden', false);
            } else {
                $iop = $('#IOP').prop("colspan") + 1;
                $('#IOP').prop("colspan", $iop);
                $('#IOP2').val($iop);
            }

        } else {
            $('.region').attr('hidden', true);
            if ($('#IOP').prop("colspan") == 1) {
                $('#IOP').attr('hidden', true);
            } else {
                $iop = $('#IOP').prop("colspan") - 1;
                $('#IOP').prop("colspan", $iop);
                $('#IOP2').val($iop);
            }
        }
    });
    $(document).on('click', '#preops_number', function() {
        if ($(this).is(":checked")) {
            $('.preops_number').attr('hidden', false);
            if ($('#IOP').prop("colspan") == 1 && $('#IOP').is(":hidden") == true) {
                $('#IOP').attr('hidden', false);
            } else {
                $iop = $('#IOP').prop("colspan") + 1;
                $('#IOP').prop("colspan", $iop);
                $('#IOP2').val($iop);
            }
        } else {
            $('.preops_number').attr('hidden', true);
            if ($('#IOP').prop("colspan") == 1) {
                $('#IOP').attr('hidden', true);
            } else {
                $iop = $('#IOP').prop("colspan") - 1;
                $('#IOP').prop("colspan", $iop);
                $('#IOP2').val($iop);
            }
        }
    });
    $(document).on('click', '#province', function() {
        if ($(this).is(":checked")) {
            $('.province').attr('hidden', false);
            if ($('#IOP').prop("colspan") == 1 && $('#IOP').is(":hidden") == true) {
                $('#IOP').attr('hidden', false);
            } else {
                $iop = $('#IOP').prop("colspan") + 1;
                $('#IOP').prop("colspan", $iop);
                $('#IOP2').val($iop);
            }
        } else {
            $('.province').attr('hidden', true);
            if ($('#IOP').prop("colspan") == 1) {
                $('#IOP').attr('hidden', true);
            } else {
                $iop = $('#IOP').prop("colspan") - 1;
                $('#IOP').prop("colspan", $iop);
                $('#IOP2').val($iop);
            }
        }
    });
    $(document).on('click', '#type_operation', function() {
        if ($(this).is(":checked")) {
            $('.type_operation').attr('hidden', false);
            if ($('#IOP').prop("colspan") == 1 && $('#IOP').is(":hidden") == true) {
                $('#IOP').attr('hidden', false);
            } else {
                $iop = $('#IOP').prop("colspan") + 1;
                $('#IOP').prop("colspan", $iop);
                $('#IOP2').val($iop);
            }
        } else {
            $('.type_operation').attr('hidden', true);
            if ($('#IOP').prop("colspan") == 1) {
                $('#IOP').attr('hidden', true);
            } else {
                $iop = $('#IOP').prop("colspan") - 1;
                $('#IOP').prop("colspan", $iop);
                $('#IOP2').val($iop);
            }
        }
    });
    $(document).on('click', '#operating_unit', function() {
        if ($(this).is(":checked")) {
            $('.operating_unit').attr('hidden', false);
            if ($('#IOP').prop("colspan") == 1 && $('#IOP').is(":hidden") == true) {
                $('#IOP').attr('hidden', false);
            } else {
                $iop = $('#IOP').prop("colspan") + 1;
                $('#IOP').prop("colspan", $iop);
                $('#IOP2').val($iop);
            }
        } else {
            $('.operating_unit').attr('hidden', true);
            if ($('#IOP').prop("colspan") == 1) {
                $('#IOP').attr('hidden', true);
            } else {
                $iop = $('#IOP').prop("colspan") - 1;
                $('#IOP').prop("colspan", $iop);
                $('#IOP2').val($iop);
            }
        }
    });
    $(document).on('click', '#support_unit', function() {
        if ($(this).is(":checked")) {
            $('.support_unit').attr('hidden', false);
            if ($('#IOP').prop("colspan") == 1 && $('#IOP').is(":hidden") == true) {
                $('#IOP').attr('hidden', false);
            } else {
                $iop = $('#IOP').prop("colspan") + 1;
                $('#IOP').prop("colspan", $iop);
                $('#IOP2').val($iop);
            }
        } else {
            $('.support_unit').attr('hidden', true);
            if ($('#IOP').prop("colspan") == 1) {
                $('#IOP').attr('hidden', true);
            } else {
                $iop = $('#IOP').prop("colspan") - 1;
                $('#IOP').prop("colspan", $iop);
                $('#IOP2').val($iop);
            }
        }
    });
    $(document).on('click', '#datetime_coordinate', function() {
        if ($(this).is(":checked")) {
            $('.datetime_coordinate').attr('hidden', false);
            if ($('#IOP').prop("colspan") == 1 && $('#IOP').is(":hidden") == true) {
                $('#IOP').attr('hidden', false);
            } else {
                $iop = $('#IOP').prop("colspan") + 1;
                $('#IOP').prop("colspan", $iop);
                $('#IOP2').val($iop);
            }
        } else {
            $('.datetime_coordinate').attr('hidden', true);
            if ($('#IOP').prop("colspan") == 1) {
                $('#IOP').attr('hidden', true);
            } else {
                $iop = $('#IOP').prop("colspan") - 1;
                $('#IOP').prop("colspan", $iop);
                $('#IOP2').val($iop);
            }
        }
    });
    $(document).on('click', '#datetime_operation', function() {
        if ($(this).is(":checked")) {
            $('.datetime_operation').attr('hidden', false);
            if ($('#IOP').prop("colspan") == 1 && $('#IOP').is(":hidden") == true) {
                $('#IOP').attr('hidden', false);
            } else {
                $iop = $('#IOP').prop("colspan") + 1;
                $('#IOP').prop("colspan", $iop);
                $('#IOP2').val($iop);
            }
        } else {
            $('.datetime_operation').attr('hidden', true);
            if ($('#IOP').prop("colspan") == 1) {
                $('#IOP').attr('hidden', true);
            } else {
                $iop = $('#IOP').prop("colspan") - 1;
                $('#IOP').prop("colspan", $iop);
                $('#IOP2').val($iop);
            }
        }
    });
    $(document).on('click', '#valid_until', function() {
        if ($(this).is(":checked")) {
            $('.valid_until').attr('hidden', false);
            if ($('#IOP').prop("colspan") == 1 && $('#IOP').is(":hidden") == true) {
                $('#IOP').attr('hidden', false);
            } else {
                $iop = $('#IOP').prop("colspan") + 1;
                $('#IOP').prop("colspan", $iop);
                $('#IOP2').val($iop);
            }
        } else {
            $('.valid_until').attr('hidden', true);
            if ($('#IOP').prop("colspan") == 1) {
                $('#IOP').attr('hidden', true);
            } else {
                $iop = $('#IOP').prop("colspan") - 1;
                $('#IOP').prop("colspan", $iop);
                $('#IOP2').val($iop);
            }
        }
    });
    $(document).on('click', '#a_area', function() {
        if ($(this).is(":checked")) {
            $('.a_area').attr('hidden', false);
            if ($('#IOP').prop("colspan") == 5 && $('#IOP').is(":hidden") == true) {
                $('#IOP').attr('hidden', false);
            } else {
                $iop = $('#IOP').prop("colspan") + 5;
                $('#IOP').prop("colspan", $iop);
                $('#IOP2').val($iop);
            }

        } else {
            $('.a_area').attr('hidden', true);
            if ($('#IOP').prop("colspan") == 5) {
                $('#IOP').attr('hidden', true);
            } else {
                $iop = $('#IOP').prop("colspan") - 5;
                $('#IOP').prop("colspan", $iop);
                $('#IOP2').val($iop);
            }

        }
    });
    $(document).on('click', '#taget_name', function() {
        if ($(this).is(":checked")) {
            $('.taget_name').attr('hidden', false);
            if ($('#IOP').prop("colspan") == 2 && $('#IOP').is(":hidden") == true) {
                $('#IOP').attr('hidden', false);
            } else {
                $iop = $('#IOP').prop("colspan") + 2;
                $('#IOP').prop("colspan", $iop);
                $('#IOP2').val($iop);
            }
        } else {
            $('.taget_name').attr('hidden', true);
            if ($('#IOP').prop("colspan") == 2) {
                $('#IOP').attr('hidden', true);
            } else {
                $iop = $('#IOP').prop("colspan") - 2;
                $('#IOP').prop("colspan", $iop);
                $('#IOP2').val($iop);
            }
        }
    });
    // $(document).on('click', '#target_nationality', function() {
    //     if ($(this).is(":checked")) {
    //         $('.target_nationality').attr('hidden', false);
    //         $iop = $('#IOP').prop("colspan") + 1;
    //         $('#IOP').prop("colspan", $iop);
    $('#IOP2').val($iop);
    //     } else {
    //         $('.target_nationality').attr('hidden', true);
    //         $iop = $('#IOP').prop("colspan") - 1;
    //         $('#IOP').prop("colspan", $iop);
    $('#IOP2').val($iop);
    //     }
    // });
    $(document).on('click', '#ot_name', function() {
        if ($(this).is(":checked")) {
            $('.ot_name').attr('hidden', false);
            if ($('#IOP').prop("colspan") == 3 && $('#IOP').is(":hidden") == true) {
                $('#IOP').attr('hidden', false);
            } else {
                $iop = $('#IOP').prop("colspan") + 3;
                $('#IOP').prop("colspan", $iop);
                $('#IOP2').val($iop);
            }
        } else {
            $('.ot_name').attr('hidden', true);
            if ($('#IOP').prop("colspan") == 3) {
                $('#IOP').attr('hidden', true);
            } else {
                $iop = $('#IOP').prop("colspan") - 3;
                $('#IOP').prop("colspan", $iop);
                $('#IOP2').val($iop);
            }
        }
    });
    $(document).on('click', '#prepared_by', function() {
        if ($(this).is(":checked")) {
            $('.prepared_by').attr('hidden', false);
            if ($('#IOP').prop("colspan") == 1 && $('#IOP').is(":hidden") == true) {
                $('#IOP').attr('hidden', false);
            } else {
                $iop = $('#IOP').prop("colspan") + 1;
                $('#IOP').prop("colspan", $iop);
                $('#IOP2').val($iop);
            }
        } else {
            $('.prepared_by').attr('hidden', true);
            if ($('#IOP').prop("colspan") == 1) {
                $('#IOP').attr('hidden', true);
            } else {
                $iop = $('#IOP').prop("colspan") - 1;
                $('#IOP').prop("colspan", $iop);
                $('#IOP2').val($iop);
            }
        }
    });
    $(document).on('click', '#ao_result', function() {
        if ($(this).is(":checked")) {
            $('.ao_result').attr('hidden', false);
            if ($('#AO').prop("colspan") == 1 && $('#AO').is(":hidden") == true) {
                $('#AO').attr('hidden', false);
            } else {
                $iop = $('#AO').prop("colspan") + 1;
                $('#AO').prop("colspan", $iop);
                $('#AO2').val($iop);
            }
        } else {
            $('.ao_result').attr('hidden', true);
            if ($('#AO').prop("colspan") == 1) {
                $('#AO').attr('hidden', true);
            } else {
                $iop = $('#AO').prop("colspan") - 1;
                $('#AO').prop("colspan", $iop);
                $('#AO2').val($iop);
            }
        }
    });
    $(document).on('click', '#ao_negative_reason', function() {
        if ($(this).is(":checked")) {
            $('.ao_negative_reason').attr('hidden', false);
            if ($('#AO').prop("colspan") == 1 && $('#AO').is(":hidden") == true) {
                $('#AO').attr('hidden', false);
            } else {
                $iop = $('#AO').prop("colspan") + 1;
                $('#AO').prop("colspan", $iop);
                $('#AO2').val($iop);
            }
        } else {
            $('.ao_negative_reason').attr('hidden', true);
            if ($('#AO').prop("colspan") == 1) {
                $('#AO').attr('hidden', true);
            } else {
                $iop = $('#AO').prop("colspan") - 1;
                $('#AO').prop("colspan", $iop);
                $('#AO2').val($iop);
            }
        }
    });
    $(document).on('click', '#ao_illegal_drug', function() {
        if ($(this).is(":checked")) {
            $('.ao_illegal_drug').attr('hidden', false);
            if ($('#AO').prop("colspan") == 1 && $('#AO').is(":hidden") == true) {
                $('#AO').attr('hidden', false);
            } else {
                $iop = $('#AO').prop("colspan") + 1;
                $('#AO').prop("colspan", $iop);
                $('#AO2').val($iop);
            }
        } else {
            $('.ao_illegal_drug').attr('hidden', true);
            if ($('#AO').prop("colspan") == 1) {
                $('#AO').attr('hidden', true);
            } else {
                $iop = $('#AO').prop("colspan") - 1;
                $('#AO').prop("colspan", $iop);
                $('#AO2').val($iop);
            }
        }
    });
    $(document).on('click', '#ao_quantity', function() {
        if ($(this).is(":checked")) {
            $('.ao_quantity').attr('hidden', false);
            if ($('#AO').prop("colspan") == 1 && $('#AO').is(":hidden") == true) {
                $('#AO').attr('hidden', false);
            } else {
                $iop = $('#AO').prop("colspan") + 1;
                $('#AO').prop("colspan", $iop);
                $('#AO2').val($iop);
            }
        } else {
            $('.ao_quantity').attr('hidden', true);
            if ($('#AO').prop("colspan") == 1) {
                $('#AO').attr('hidden', true);
            } else {
                $iop = $('#AO').prop("colspan") - 1;
                $('#AO').prop("colspan", $iop);
                $('#AO2').val($iop);
            }
        }
    });
    $(document).on('click', '#ao_unit_measure', function() {
        if ($(this).is(":checked")) {
            $('.ao_unit_measure').attr('hidden', false);
            if ($('#AO').prop("colspan") == 1 && $('#AO').is(":hidden") == true) {
                $('#AO').attr('hidden', false);
            } else {
                $iop = $('#AO').prop("colspan") + 1;
                $('#AO').prop("colspan", $iop);
                $('#AO2').val($iop);
            }
        } else {
            $('.ao_unit_measure').attr('hidden', true);
            if ($('#AO').prop("colspan") == 1) {
                $('#AO').attr('hidden', true);
            } else {
                $iop = $('#AO').prop("colspan") - 1;
                $('#AO').prop("colspan", $iop);
                $('#AO2').val($iop);
            }
        }
    });
    $(document).on('click', '#ao_crn', function() {
        if ($(this).is(":checked")) {
            $('.ao_crn').attr('hidden', false);
            if ($('#AO').prop("colspan") == 1 && $('#AO').is(":hidden") == true) {
                $('#AO').attr('hidden', false);
            } else {
                $iop = $('#AO').prop("colspan") + 1;
                $('#AO').prop("colspan", $iop);
                $('#AO2').val($iop);
            }
        } else {
            $('.ao_crn').attr('hidden', true);
            if ($('#AO').prop("colspan") == 1) {
                $('#AO').attr('hidden', true);
            } else {
                $iop = $('#AO').prop("colspan") - 1;
                $('#AO').prop("colspan", $iop);
                $('#AO2').val($iop);
            }
        }
    });
    $(document).on('click', '#ao_date_received', function() {
        if ($(this).is(":checked")) {
            $('.ao_date_received').attr('hidden', false);
            if ($('#AO').prop("colspan") == 1 && $('#AO').is(":hidden") == true) {
                $('#AO').attr('hidden', false);
            } else {
                $iop = $('#AO').prop("colspan") + 1;
                $('#AO').prop("colspan", $iop);
                $('#AO2').val($iop);
            }
        } else {
            $('.ao_date_received').attr('hidden', true);
            if ($('#AO').prop("colspan") == 1) {
                $('#AO').attr('hidden', true);
            } else {
                $iop = $('#AO').prop("colspan") - 1;
                $('#AO').prop("colspan", $iop);
                $('#AO2').val($iop);
            }
        }
    });

    // SPOT REPORT Labels
    $(document).on('click', '#sp_hio', function() {
        if ($(this).is(":checked")) {
            $('.sp_hio').attr('hidden', false);
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }
        } else {
            $('.sp_hio').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }
        }
    });
    $(document).on('click', '#sp_suspect_number', function() {
        if ($(this).is(":checked")) {

            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_suspect_number').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_suspect_number').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_suspect_number').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_suspect_number').attr('hidden', false);

                }
            }
        } else {
            $('.sp_suspect_number').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_suspect').prop("colspan") == 1) {
                $('#SP_suspect').attr('hidden', true);
            } else {
                $iop = $('#SP_suspect').prop("colspan") - 1;
                $('#SP_suspect').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_status', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_status').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_status').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_status').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_status').attr('hidden', false);

                }
            }
        } else {
            $('.sp_status').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_suspect').prop("colspan") == 1) {
                $('#SP_suspect').attr('hidden', true);
            } else {
                $iop = $('#SP_suspect').prop("colspan") - 1;
                $('#SP_suspect').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_lastname', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_lastname').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_lastname').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_lastname').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_lastname').attr('hidden', false);

                }
            }
        } else {
            $('.sp_lastname').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_suspect').prop("colspan") == 1) {
                $('#SP_suspect').attr('hidden', true);
            } else {
                $iop = $('#SP_suspect').prop("colspan") - 1;
                $('#SP_suspect').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_firstname', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_firstname').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_firstname').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_firstname').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_firstname').attr('hidden', false);

                }
            }
        } else {
            $('.sp_firstname').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_suspect').prop("colspan") == 1) {
                $('#SP_suspect').attr('hidden', true);
            } else {
                $iop = $('#SP_suspect').prop("colspan") - 1;
                $('#SP_suspect').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_middlename', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_middlename').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_middlename').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_middlename').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_middlename').attr('hidden', false);

                }
            }
        } else {
            $('.sp_middlename').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_suspect').prop("colspan") == 1) {
                $('#SP_suspect').attr('hidden', true);
            } else {
                $iop = $('#SP_suspect').prop("colspan") - 1;
                $('#SP_suspect').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_alias', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_alias').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_alias').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_alias').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_alias').attr('hidden', false);

                }
            }
        } else {
            $('.sp_alias').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_suspect').prop("colspan") == 1) {
                $('#SP_suspect').attr('hidden', true);
            } else {
                $iop = $('#SP_suspect').prop("colspan") - 1;
                $('#SP_suspect').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_birthdate', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_birthdate').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_birthdate').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_birthdate').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_birthdate').attr('hidden', false);

                }
            }
        } else {
            $('.sp_birthdate').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_suspect').prop("colspan") == 1) {
                $('#SP_suspect').attr('hidden', true);
            } else {
                $iop = $('#SP_suspect').prop("colspan") - 1;
                $('#SP_suspect').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_est_birthdate', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_est_birthdate').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_est_birthdate').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_est_birthdate').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_est_birthdate').attr('hidden', false);

                }
            }
        } else {
            $('.sp_est_birthdate').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_suspect').prop("colspan") == 1) {
                $('#SP_suspect').attr('hidden', true);
            } else {
                $iop = $('#SP_suspect').prop("colspan") - 1;
                $('#SP_suspect').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_birthplace', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_birthplace').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_birthplace').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_birthplace').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_birthplace').attr('hidden', false);

                }
            }
        } else {
            $('.sp_birthplace').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_suspect').prop("colspan") == 1) {
                $('#SP_suspect').attr('hidden', true);
            } else {
                $iop = $('#SP_suspect').prop("colspan") - 1;
                $('#SP_suspect').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_region', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_region').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_region').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_region').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_region').attr('hidden', false);

                }
            }
        } else {
            $('.sp_region').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_suspect').prop("colspan") == 1) {
                $('#SP_suspect').attr('hidden', true);
            } else {
                $iop = $('#SP_suspect').prop("colspan") - 1;
                $('#SP_suspect').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_province', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_province').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_province').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_province').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_province').attr('hidden', false);

                }
            }
        } else {
            $('.sp_province').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_suspect').prop("colspan") == 1) {
                $('#SP_suspect').attr('hidden', true);
            } else {
                $iop = $('#SP_suspect').prop("colspan") - 1;
                $('#SP_suspect').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_city', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_city').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_city').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_city').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_city').attr('hidden', false);

                }
            }
        } else {
            $('.sp_city').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_suspect').prop("colspan") == 1) {
                $('#SP_suspect').attr('hidden', true);
            } else {
                $iop = $('#SP_suspect').prop("colspan") - 1;
                $('#SP_suspect').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_barangay', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_barangay').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_barangay').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_barangay').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_barangay').attr('hidden', false);

                }
            }
        } else {
            $('.sp_barangay').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_suspect').prop("colspan") == 1) {
                $('#SP_suspect').attr('hidden', true);
            } else {
                $iop = $('#SP_suspect').prop("colspan") - 1;
                $('#SP_suspect').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_street', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_street').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_street').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_street').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_street').attr('hidden', false);

                }
            }
        } else {
            $('.sp_street').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_suspect').prop("colspan") == 1) {
                $('#SP_suspect').attr('hidden', true);
            } else {
                $iop = $('#SP_suspect').prop("colspan") - 1;
                $('#SP_suspect').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_p_region', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_p_region').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_p_region').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_p_region').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_p_region').attr('hidden', false);

                }
            }
        } else {
            $('.sp_p_region').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_suspect').prop("colspan") == 1) {
                $('#SP_suspect').attr('hidden', true);
            } else {
                $iop = $('#SP_suspect').prop("colspan") - 1;
                $('#SP_suspect').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_p_province', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_p_province').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_p_province').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_p_province').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_p_province').attr('hidden', false);

                }
            }
        } else {
            $('.sp_p_province').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_suspect').prop("colspan") == 1) {
                $('#SP_suspect').attr('hidden', true);
            } else {
                $iop = $('#SP_suspect').prop("colspan") - 1;
                $('#SP_suspect').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_p_city', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_p_city').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_p_city').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_p_city').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_p_city').attr('hidden', false);

                }
            }
        } else {
            $('.sp_p_city').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_suspect').prop("colspan") == 1) {
                $('#SP_suspect').attr('hidden', true);
            } else {
                $iop = $('#SP_suspect').prop("colspan") - 1;
                $('#SP_suspect').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_p_barangay', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_p_barangay').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_p_barangay').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_p_barangay').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_p_barangay').attr('hidden', false);

                }
            }
        } else {
            $('.sp_p_barangay').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_suspect').prop("colspan") == 1) {
                $('#SP_suspect').attr('hidden', true);
            } else {
                $iop = $('#SP_suspect').prop("colspan") - 1;
                $('#SP_suspect').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_p_street', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_p_street').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_p_street').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_p_street').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_p_street').attr('hidden', false);

                }
            }
        } else {
            $('.sp_p_street').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_suspect').prop("colspan") == 1) {
                $('#SP_suspect').attr('hidden', true);
            } else {
                $iop = $('#SP_suspect').prop("colspan") - 1;
                $('#SP_suspect').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_sex', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_sex').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_sex').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_sex').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_sex').attr('hidden', false);

                }
            }
        } else {
            $('.sp_sex').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_suspect').prop("colspan") == 1) {
                $('#SP_suspect').attr('hidden', true);
            } else {
                $iop = $('#SP_suspect').prop("colspan") - 1;
                $('#SP_suspect').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_civil_status', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_civil_status').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_civil_status').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_civil_status').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_civil_status').attr('hidden', false);

                }
            }
        } else {
            $('.sp_civil_status').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_suspect').prop("colspan") == 1) {
                $('#SP_suspect').attr('hidden', true);
            } else {
                $iop = $('#SP_suspect').prop("colspan") - 1;
                $('#SP_suspect').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_nationality', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_nationality').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_nationality').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_nationality').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_nationality').attr('hidden', false);

                }
            }
        } else {
            $('.sp_nationality').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_suspect').prop("colspan") == 1) {
                $('#SP_suspect').attr('hidden', true);
            } else {
                $iop = $('#SP_suspect').prop("colspan") - 1;
                $('#SP_suspect').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_ethnic_group', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_ethnic_group').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_ethnic_group').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_ethnic_group').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_ethnic_group').attr('hidden', false);

                }
            }
        } else {
            $('.sp_ethnic_group').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_suspect').prop("colspan") == 1) {
                $('#SP_suspect').attr('hidden', true);
            } else {
                $iop = $('#SP_suspect').prop("colspan") - 1;
                $('#SP_suspect').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_religion', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_religion').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_religion').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_religion').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_religion').attr('hidden', false);

                }
            }
        } else {
            $('.sp_religion').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_suspect').prop("colspan") == 1) {
                $('#SP_suspect').attr('hidden', true);
            } else {
                $iop = $('#SP_suspect').prop("colspan") - 1;
                $('#SP_suspect').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_educational_attainment', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_educational_attainment').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_educational_attainment').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_educational_attainment').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_educational_attainment').attr('hidden', false);

                }
            }
        } else {
            $('.sp_educational_attainment').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_suspect').prop("colspan") == 1) {
                $('#SP_suspect').attr('hidden', true);
            } else {
                $iop = $('#SP_suspect').prop("colspan") - 1;
                $('#SP_suspect').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_occupation', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_occupation').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_occupation').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_occupation').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_occupation').attr('hidden', false);

                }
            }
        } else {
            $('.sp_occupation').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_suspect').prop("colspan") == 1) {
                $('#SP_suspect').attr('hidden', true);
            } else {
                $iop = $('#SP_suspect').prop("colspan") - 1;
                $('#SP_suspect').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_classification', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_classification').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_classification').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_classification').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_classification').attr('hidden', false);

                }
            }
        } else {
            $('.sp_classification').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_suspect').prop("colspan") == 1) {
                $('#SP_suspect').attr('hidden', true);
            } else {
                $iop = $('#SP_suspect').prop("colspan") - 1;
                $('#SP_suspect').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_category', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_category').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_category').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_category').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_category').attr('hidden', false);

                }
            }
        } else {
            $('.sp_category').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_suspect').prop("colspan") == 1) {
                $('#SP_suspect').attr('hidden', true);
            } else {
                $iop = $('#SP_suspect').prop("colspan") - 1;
                $('#SP_suspect').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_whereabouts', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_whereabouts').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_whereabouts').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_whereabouts').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_whereabouts').attr('hidden', false);

                }
            }
        } else {
            $('.sp_whereabouts').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_suspect').prop("colspan") == 1) {
                $('#SP_suspect').attr('hidden', true);
            } else {
                $iop = $('#SP_suspect').prop("colspan") - 1;
                $('#SP_suspect').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_remarks', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_remarks').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_remarks').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_suspect').prop("colspan") == 1 && $('#SP_suspect').is(":hidden") == true) {
                    $('#SP_suspect').attr('hidden', false);
                    $('.sp_remarks').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_suspect').prop("colspan") + 1;
                    $('#SP_suspect').prop("colspan", $iop2);
                    $('.sp_remarks').attr('hidden', false);

                }
            }
        } else {
            $('.sp_remarks').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_suspect').prop("colspan") == 1) {
                $('#SP_suspect').attr('hidden', true);
            } else {
                $iop = $('#SP_suspect').prop("colspan") - 1;
                $('#SP_suspect').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_seized_from', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_item_seized').prop("colspan") == 1 && $('#SP_item_seized').is(":hidden") == true) {
                    $('#SP_item_seized').attr('hidden', false);
                    $('.sp_seized_from').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_item_seized').prop("colspan") + 1;
                    $('#SP_item_seized').prop("colspan", $iop2);
                    $('.sp_seized_from').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_item_seized').prop("colspan") == 1 && $('#SP_item_seized').is(":hidden") == true) {
                    $('#SP_item_seized').attr('hidden', false);
                    $('.sp_seized_from').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_item_seized').prop("colspan") + 1;
                    $('#SP_item_seized').prop("colspan", $iop2);
                    $('.sp_seized_from').attr('hidden', false);

                }
            }
        } else {
            $('.sp_seized_from').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_item_seized').prop("colspan") == 1) {
                $('#SP_item_seized').attr('hidden', true);
            } else {
                $iop = $('#SP_item_seized').prop("colspan") - 1;
                $('#SP_item_seized').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_drug', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_item_seized').prop("colspan") == 1 && $('#SP_item_seized').is(":hidden") == true) {
                    $('#SP_item_seized').attr('hidden', false);
                    $('.sp_drug').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_item_seized').prop("colspan") + 1;
                    $('#SP_item_seized').prop("colspan", $iop2);
                    $('.sp_drug').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_item_seized').prop("colspan") == 1 && $('#SP_item_seized').is(":hidden") == true) {
                    $('#SP_item_seized').attr('hidden', false);
                    $('.sp_drug').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_item_seized').prop("colspan") + 1;
                    $('#SP_item_seized').prop("colspan", $iop2);
                    $('.sp_drug').attr('hidden', false);

                }
            }
        } else {
            $('.sp_drug').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_item_seized').prop("colspan") == 1) {
                $('#SP_item_seized').attr('hidden', true);
            } else {
                $iop = $('#SP_item_seized').prop("colspan") - 1;
                $('#SP_item_seized').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_evidence', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_item_seized').prop("colspan") == 1 && $('#SP_item_seized').is(":hidden") == true) {
                    $('#SP_item_seized').attr('hidden', false);
                    $('.sp_evidence').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_item_seized').prop("colspan") + 1;
                    $('#SP_item_seized').prop("colspan", $iop2);
                    $('.sp_evidence').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_item_seized').prop("colspan") == 1 && $('#SP_item_seized').is(":hidden") == true) {
                    $('#SP_item_seized').attr('hidden', false);
                    $('.sp_evidence').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_item_seized').prop("colspan") + 1;
                    $('#SP_item_seized').prop("colspan", $iop2);
                    $('.sp_evidence').attr('hidden', false);

                }
            }
        } else {
            $('.sp_evidence').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_item_seized').prop("colspan") == 1) {
                $('#SP_item_seized').attr('hidden', true);
            } else {
                $iop = $('#SP_item_seized').prop("colspan") - 1;
                $('#SP_item_seized').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_quantity', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_item_seized').prop("colspan") == 1 && $('#SP_item_seized').is(":hidden") == true) {
                    $('#SP_item_seized').attr('hidden', false);
                    $('.sp_quantity').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_item_seized').prop("colspan") + 1;
                    $('#SP_item_seized').prop("colspan", $iop2);
                    $('.sp_quantity').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_item_seized').prop("colspan") == 1 && $('#SP_item_seized').is(":hidden") == true) {
                    $('#SP_item_seized').attr('hidden', false);
                    $('.sp_quantity').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_item_seized').prop("colspan") + 1;
                    $('#SP_item_seized').prop("colspan", $iop2);
                    $('.sp_quantity').attr('hidden', false);

                }
            }
        } else {
            $('.sp_quantity').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_item_seized').prop("colspan") == 1) {
                $('#SP_item_seized').attr('hidden', true);
            } else {
                $iop = $('#SP_item_seized').prop("colspan") - 1;
                $('#SP_item_seized').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_unit', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_item_seized').prop("colspan") == 1 && $('#SP_item_seized').is(":hidden") == true) {
                    $('#SP_item_seized').attr('hidden', false);
                    $('.sp_unit').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_item_seized').prop("colspan") + 1;
                    $('#SP_item_seized').prop("colspan", $iop2);
                    $('.sp_unit').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_item_seized').prop("colspan") == 1 && $('#SP_item_seized').is(":hidden") == true) {
                    $('#SP_item_seized').attr('hidden', false);
                    $('.sp_unit').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_item_seized').prop("colspan") + 1;
                    $('#SP_item_seized').prop("colspan", $iop2);
                    $('.sp_unit').attr('hidden', false);

                }
            }
        } else {
            $('.sp_unit').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_item_seized').prop("colspan") == 1) {
                $('#SP_item_seized').attr('hidden', true);
            } else {
                $iop = $('#SP_item_seized').prop("colspan") - 1;
                $('#SP_item_seized').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_packaging', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_item_seized').prop("colspan") == 1 && $('#SP_item_seized').is(":hidden") == true) {
                    $('#SP_item_seized').attr('hidden', false);
                    $('.sp_packaging').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_item_seized').prop("colspan") + 1;
                    $('#SP_item_seized').prop("colspan", $iop2);
                    $('.sp_packaging').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_item_seized').prop("colspan") == 1 && $('#SP_item_seized').is(":hidden") == true) {
                    $('#SP_item_seized').attr('hidden', false);
                    $('.sp_packaging').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_item_seized').prop("colspan") + 1;
                    $('#SP_item_seized').prop("colspan", $iop2);
                    $('.sp_packaging').attr('hidden', false);

                }
            }
        } else {
            $('.sp_packaging').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_item_seized').prop("colspan") == 1) {
                $('#SP_item_seized').attr('hidden', true);
            } else {
                $iop = $('#SP_item_seized').prop("colspan") - 1;
                $('#SP_item_seized').prop("colspan", $iop)
            }
        }
    });
    $(document).on('click', '#sp_markings', function() {
        if ($(this).is(":checked")) {
            if ($('#SP').prop("colspan") == 1 && $('#SP').is(":hidden") == true) {
                $('#SP').attr('hidden', false);
                if ($('#SP_item_seized').prop("colspan") == 1 && $('#SP_item_seized').is(":hidden") == true) {
                    $('#SP_item_seized').attr('hidden', false);
                    $('.sp_markings').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_item_seized').prop("colspan") + 1;
                    $('#SP_item_seized').prop("colspan", $iop2);
                    $('.sp_markings').attr('hidden', false);

                }
            } else {
                $iop = $('#SP').prop("colspan") + 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
                if ($('#SP_item_seized').prop("colspan") == 1 && $('#SP_item_seized').is(":hidden") == true) {
                    $('#SP_item_seized').attr('hidden', false);
                    $('.sp_markings').attr('hidden', false);

                } else {
                    $iop2 = $('#SP_item_seized').prop("colspan") + 1;
                    $('#SP_item_seized').prop("colspan", $iop2);
                    $('.sp_markings').attr('hidden', false);

                }
            }
        } else {
            $('.sp_markings').attr('hidden', true);
            if ($('#SP').prop("colspan") == 1) {
                $('#SP').attr('hidden', true);
            } else {
                $iop = $('#SP').prop("colspan") - 1;
                $('#SP').prop("colspan", $iop);
                $('#SP2').val($iop);
            }

            if ($('#SP_item_seized').prop("colspan") == 1) {
                $('#SP_item_seized').attr('hidden', true);
            } else {
                $iop = $('#SP_item_seized').prop("colspan") - 1;
                $('#SP_item_seized').prop("colspan", $iop)
            }
        }
    });
    // $(document).on('click', '#sp_case_name', function() {
    //     if ($(this).is(":checked")) {
    //         $('.sp_case_name').attr('hidden', false);
    //         $iop = $('#SP').prop("colspan") + 1;
    //         $('#SP').prop("colspan", $iop);
    $('#SP2').val($iop);
    //         $iop2 = $('#SP_CF').prop("colspan") + 1;
    //         $('#SP_CF').prop("colspan", $iop)
    //     } else {
    //         $('.sp_case_name').attr('hidden', true);
    //         $iop = $('#SP').prop("colspan") - 1;
    //         $('#SP').prop("colspan", $iop);
    $('#SP2').val($iop);
    //         $iop2 = $('#SP_CF').prop("colspan") - 1;
    //         $('#SP_CF').prop("colspan", $iop2)
    //     }
    // });
    $(document).on('click', '#sp_case_type', function() {
        if ($(this).is(":checked")) {
            $('.sp_case_type').attr('hidden', false);
            $iop = $('#SP').prop("colspan") + 2;
            $('#SP').prop("colspan", $iop);
            $('#SP2').val($iop);
            $('#SP_CF').attr('hidden', false);
        } else {
            $('.sp_case_type').attr('hidden', true);
            $iop = $('#SP').prop("colspan") - 2;
            $('#SP').prop("colspan", $iop);
            $('#SP2').val($iop);
            $('#SP_CF').attr('hidden', true);
        }
    });
    // $(document).on('click', '#sp_report_header', function() {
    //     if ($(this).is(":checked")) {
    //         $('.sp_report_header').attr('hidden', false);
    //         $iop = $('#SP').prop("colspan") + 1;
    //         $('#SP').prop("colspan", $iop);
    $('#SP2').val($iop);
    //         $iop2 = $('#SP_suspect').prop("colspan") + 1;
    //         $('#SP_suspect').prop("colspan", $iop)
    //     } else {
    //         $('.sp_report_header').attr('hidden', true);
    //         $iop = $('#SP').prop("colspan") - 1;
    //         $('#SP').prop("colspan", $iop);
    $('#SP2').val($iop);
    //         $iop2 = $('#SP_suspect').prop("colspan") - 1;
    //         $('#SP_suspect').prop("colspan", $iop2)
    //     }
    // });
    $(document).on('click', '#sp_summary', function() {
        if ($(this).is(":checked")) {
            $('.sp_summary').attr('hidden', false);
            $iop = $('#SP').prop("colspan") + 2;
            $('#SP').prop("colspan", $iop);
            $('#SP2').val($iop);
        } else {
            $('.sp_summary').attr('hidden', true);
            $iop = $('#SP').prop("colspan") - 2;
            $('#SP').prop("colspan", $iop);
            $('#SP2').val($iop);
        }
    });
    $(document).on('click', '#sp_prepared_by', function() {
        if ($(this).is(":checked")) {
            $('.sp_prepared_by').attr('hidden', false);
            $iop = $('#SP').prop("colspan") + 1;
        } else {
            $('.sp_prepared_by').attr('hidden', true);
            $iop = $('#SP').prop("colspan") - 1;
        }
    });

    // Progress Report Menu

    $(document).on('click', '#pr_suspect_name', function() {
        if ($(this).is(":checked")) {
            if ($('#PR').prop("colspan") == 1 && $('#PR').is(":hidden") == true) {
                $('#PR').attr('hidden', false);
                if ($('#PR_suspect').prop("colspan") == 1 && $('#PR_suspect').is(":hidden") == true) {
                    $('#PR_suspect').attr('hidden', false);
                    $('.pr_suspect_name').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_suspect').prop("colspan") + 1;
                    $('#PR_suspect').prop("colspan", $iop2);
                    $('.pr_suspect_name').attr('hidden', false);

                }
            } else {
                $iop = $('#PR').prop("colspan") + 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
                if ($('#PR_suspect').prop("colspan") == 1 && $('#PR_suspect').is(":hidden") == true) {
                    $('#PR_suspect').attr('hidden', false);
                    $('.pr_suspect_name').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_suspect').prop("colspan") + 1;
                    $('#PR_suspect').prop("colspan", $iop2);
                    $('.pr_suspect_name').attr('hidden', false);

                }
            }
        } else {
            $('.pr_suspect_name').attr('hidden', true);
            if ($('#PR').prop("colspan") == 1) {
                $('#PR').attr('hidden', true);
            } else {
                $iop = $('#PR').prop("colspan") - 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
            }

            if ($('#PR_suspect').prop("colspan") == 1) {
                $('#PR_suspect').attr('hidden', true);
            } else {
                $iop = $('#PR_suspect').prop("colspan") - 1;
                $('#PR_suspect').prop("colspan", $iop);
            }
        }
    });

    $(document).on('click', '#pr_suspect_classification', function() {
        if ($(this).is(":checked")) {
            if ($('#PR').prop("colspan") == 1 && $('#PR').is(":hidden") == true) {
                $('#PR').attr('hidden', false);
                if ($('#PR_suspect').prop("colspan") == 1 && $('#PR_suspect').is(":hidden") == true) {
                    $('#PR_suspect').attr('hidden', false);
                    $('.pr_suspect_classification').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_suspect').prop("colspan") + 1;
                    $('#PR_suspect').prop("colspan", $iop2);
                    $('.pr_suspect_classification').attr('hidden', false);

                }
            } else {
                $iop = $('#PR').prop("colspan") + 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
                if ($('#PR_suspect').prop("colspan") == 1 && $('#PR_suspect').is(":hidden") == true) {
                    $('#PR_suspect').attr('hidden', false);
                    $('.pr_suspect_classification').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_suspect').prop("colspan") + 1;
                    $('#PR_suspect').prop("colspan", $iop2);
                    $('.pr_suspect_classification').attr('hidden', false);

                }
            }
        } else {
            $('.pr_suspect_classification').attr('hidden', true);
            if ($('#PR').prop("colspan") == 1) {
                $('#PR').attr('hidden', true);
            } else {
                $iop = $('#PR').prop("colspan") - 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
            }

            if ($('#PR_suspect').prop("colspan") == 1) {
                $('#PR_suspect').attr('hidden', true);
            } else {
                $iop = $('#PR_suspect').prop("colspan") - 1;
                $('#PR_suspect').prop("colspan", $iop)
            }
        }
    });

    $(document).on('click', '#pr_suspect_status', function() {
        if ($(this).is(":checked")) {
            if ($('#PR').prop("colspan") == 1 && $('#PR').is(":hidden") == true) {
                $('#PR').attr('hidden', false);
                if ($('#PR_suspect').prop("colspan") == 1 && $('#PR_suspect').is(":hidden") == true) {
                    $('#PR_suspect').attr('hidden', false);
                    $('.pr_suspect_status').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_suspect').prop("colspan") + 1;
                    $('#PR_suspect').prop("colspan", $iop2);
                    $('.pr_suspect_status').attr('hidden', false);

                }
            } else {
                $iop = $('#PR').prop("colspan") + 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
                if ($('#PR_suspect').prop("colspan") == 1 && $('#PR_suspect').is(":hidden") == true) {
                    $('#PR_suspect').attr('hidden', false);
                    $('.pr_suspect_status').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_suspect').prop("colspan") + 1;
                    $('#PR_suspect').prop("colspan", $iop2);
                    $('.pr_suspect_status').attr('hidden', false);

                }
            }
        } else {
            $('.pr_suspect_status').attr('hidden', true);
            if ($('#PR').prop("colspan") == 1) {
                $('#PR').attr('hidden', true);
            } else {
                $iop = $('#PR').prop("colspan") - 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
            }

            if ($('#PR_suspect').prop("colspan") == 1) {
                $('#PR_suspect').attr('hidden', true);
            } else {
                $iop = $('#PR_suspect').prop("colspan") - 1;
                $('#PR_suspect').prop("colspan", $iop)
            }
        }
    });

    $(document).on('click', '#pr_drug_test_result', function() {
        if ($(this).is(":checked")) {
            if ($('#PR').prop("colspan") == 1 && $('#PR').is(":hidden") == true) {
                $('#PR').attr('hidden', false);
                if ($('#PR_suspect').prop("colspan") == 1 && $('#PR_suspect').is(":hidden") == true) {
                    $('#PR_suspect').attr('hidden', false);
                    $('.pr_drug_test_result').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_suspect').prop("colspan") + 1;
                    $('#PR_suspect').prop("colspan", $iop2);
                    $('.pr_drug_test_result').attr('hidden', false);

                }
            } else {
                $iop = $('#PR').prop("colspan") + 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
                if ($('#PR_suspect').prop("colspan") == 1 && $('#PR_suspect').is(":hidden") == true) {
                    $('#PR_suspect').attr('hidden', false);
                    $('.pr_drug_test_result').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_suspect').prop("colspan") + 1;
                    $('#PR_suspect').prop("colspan", $iop2);
                    $('.pr_drug_test_result').attr('hidden', false);

                }
            }
        } else {
            $('.pr_drug_test_result').attr('hidden', true);
            if ($('#PR').prop("colspan") == 1) {
                $('#PR').attr('hidden', true);
            } else {
                $iop = $('#PR').prop("colspan") - 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
            }

            if ($('#PR_suspect').prop("colspan") == 1) {
                $('#PR_suspect').attr('hidden', true);
            } else {
                $iop = $('#PR_suspect').prop("colspan") - 1;
                $('#PR_suspect').prop("colspan", $iop)
            }
        }
    });

    $(document).on('click', '#pr_drug_type', function() {
        if ($(this).is(":checked")) {
            if ($('#PR').prop("colspan") == 1 && $('#PR').is(":hidden") == true) {
                $('#PR').attr('hidden', false);
                if ($('#PR_suspect').prop("colspan") == 1 && $('#PR_suspect').is(":hidden") == true) {
                    $('#PR_suspect').attr('hidden', false);
                    $('.pr_drug_type').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_suspect').prop("colspan") + 1;
                    $('#PR_suspect').prop("colspan", $iop2);
                    $('.pr_drug_type').attr('hidden', false);

                }
            } else {
                $iop = $('#PR').prop("colspan") + 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
                if ($('#PR_suspect').prop("colspan") == 1 && $('#PR_suspect').is(":hidden") == true) {
                    $('#PR_suspect').attr('hidden', false);
                    $('.pr_drug_type').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_suspect').prop("colspan") + 1;
                    $('#PR_suspect').prop("colspan", $iop2);
                    $('.pr_drug_type').attr('hidden', false);

                }
            }
        } else {
            $('.pr_drug_type').attr('hidden', true);
            if ($('#PR').prop("colspan") == 1) {
                $('#PR').attr('hidden', true);
            } else {
                $iop = $('#PR').prop("colspan") - 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
            }

            if ($('#PR_suspect').prop("colspan") == 1) {
                $('#PR_suspect').attr('hidden', true);
            } else {
                $iop = $('#PR_suspect').prop("colspan") - 1;
                $('#PR_suspect').prop("colspan", $iop)
            }
        }
    });

    $(document).on('click', '#pr_remarks', function() {
        if ($(this).is(":checked")) {
            if ($('#PR').prop("colspan") == 1 && $('#PR').is(":hidden") == true) {
                $('#PR').attr('hidden', false);
                if ($('#PR_suspect').prop("colspan") == 1 && $('#PR_suspect').is(":hidden") == true) {
                    $('#PR_suspect').attr('hidden', false);
                    $('.pr_remarks').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_suspect').prop("colspan") + 1;
                    $('#PR_suspect').prop("colspan", $iop2);
                    $('.pr_remarks').attr('hidden', false);

                }
            } else {
                $iop = $('#PR').prop("colspan") + 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
                if ($('#PR_suspect').prop("colspan") == 1 && $('#PR_suspect').is(":hidden") == true) {
                    $('#PR_suspect').attr('hidden', false);
                    $('.pr_remarks').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_suspect').prop("colspan") + 1;
                    $('#PR_suspect').prop("colspan", $iop2);
                    $('.pr_remarks').attr('hidden', false);

                }
            }
        } else {
            $('.pr_remarks').attr('hidden', true);
            if ($('#PR').prop("colspan") == 1) {
                $('#PR').attr('hidden', true);
            } else {
                $iop = $('#PR').prop("colspan") - 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
            }

            if ($('#PR_suspect').prop("colspan") == 1) {
                $('#PR_suspect').attr('hidden', true);
            } else {
                $iop = $('#PR_suspect').prop("colspan") - 1;
                $('#PR_suspect').prop("colspan", $iop)
            }
        }
    });

    $(document).on('click', '#pr_drug_seized', function() {
        if ($(this).is(":checked")) {
            if ($('#PR').prop("colspan") == 1 && $('#PR').is(":hidden") == true) {
                $('#PR').attr('hidden', false);
                if ($('#PR_IS').prop("colspan") == 1 && $('#PR_IS').is(":hidden") == true) {
                    $('#PR_IS').attr('hidden', false);
                    $('.pr_drug_seized').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_IS').prop("colspan") + 1;
                    $('#PR_IS').prop("colspan", $iop2);
                    $('.pr_drug_seized').attr('hidden', false);

                }
            } else {
                $iop = $('#PR').prop("colspan") + 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
                if ($('#PR_IS').prop("colspan") == 1 && $('#PR_IS').is(":hidden") == true) {
                    $('#PR_IS').attr('hidden', false);
                    $('.pr_drug_seized').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_IS').prop("colspan") + 1;
                    $('#PR_IS').prop("colspan", $iop2);
                    $('.pr_drug_seized').attr('hidden', false);

                }
            }
        } else {
            $('.pr_drug_seized').attr('hidden', true);
            if ($('#PR').prop("colspan") == 1) {
                $('#PR').attr('hidden', true);
            } else {
                $iop = $('#PR').prop("colspan") - 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
            }

            if ($('#PR_IS').prop("colspan") == 1) {
                $('#PR_IS').attr('hidden', true);
            } else {
                $iop = $('#PR_IS').prop("colspan") - 1;
                $('#PR_IS').prop("colspan", $iop)
            }
        }
    });

    $(document).on('click', '#pr_qty_onsite', function() {
        if ($(this).is(":checked")) {
            if ($('#PR').prop("colspan") == 1 && $('#PR').is(":hidden") == true) {
                $('#PR').attr('hidden', false);
                if ($('#PR_IS').prop("colspan") == 1 && $('#PR_IS').is(":hidden") == true) {
                    $('#PR_IS').attr('hidden', false);
                    $('.pr_qty_onsite').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_IS').prop("colspan") + 1;
                    $('#PR_IS').prop("colspan", $iop2);
                    $('.pr_qty_onsite').attr('hidden', false);

                }
            } else {
                $iop = $('#PR').prop("colspan") + 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
                if ($('#PR_IS').prop("colspan") == 1 && $('#PR_IS').is(":hidden") == true) {
                    $('#PR_IS').attr('hidden', false);
                    $('.pr_qty_onsite').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_IS').prop("colspan") + 1;
                    $('#PR_IS').prop("colspan", $iop2);
                    $('.pr_qty_onsite').attr('hidden', false);

                }
            }
        } else {
            $('.pr_qty_onsite').attr('hidden', true);
            if ($('#PR').prop("colspan") == 1) {
                $('#PR').attr('hidden', true);
            } else {
                $iop = $('#PR').prop("colspan") - 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
            }

            if ($('#PR_IS').prop("colspan") == 1) {
                $('#PR_IS').attr('hidden', true);
            } else {
                $iop = $('#PR_IS').prop("colspan") - 1;
                $('#PR_IS').prop("colspan", $iop)
            }
        }
    });

    $(document).on('click', '#pr_actual_qty', function() {
        if ($(this).is(":checked")) {
            if ($('#PR').prop("colspan") == 1 && $('#PR').is(":hidden") == true) {
                $('#PR').attr('hidden', false);
                if ($('#PR_IS').prop("colspan") == 1 && $('#PR_IS').is(":hidden") == true) {
                    $('#PR_IS').attr('hidden', false);
                    $('.pr_actual_qty').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_IS').prop("colspan") + 1;
                    $('#PR_IS').prop("colspan", $iop2);
                    $('.pr_actual_qty').attr('hidden', false);

                }
            } else {
                $iop = $('#PR').prop("colspan") + 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
                if ($('#PR_IS').prop("colspan") == 1 && $('#PR_IS').is(":hidden") == true) {
                    $('#PR_IS').attr('hidden', false);
                    $('.pr_actual_qty').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_IS').prop("colspan") + 1;
                    $('#PR_IS').prop("colspan", $iop2);
                    $('.pr_actual_qty').attr('hidden', false);

                }
            }
        } else {
            $('.pr_actual_qty').attr('hidden', true);
            if ($('#PR').prop("colspan") == 1) {
                $('#PR').attr('hidden', true);
            } else {
                $iop = $('#PR').prop("colspan") - 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
            }

            if ($('#PR_IS').prop("colspan") == 1) {
                $('#PR_IS').attr('hidden', true);
            } else {
                $iop = $('#PR_IS').prop("colspan") - 1;
                $('#PR_IS').prop("colspan", $iop)
            }
        }
    });

    $(document).on('click', '#pr_unit', function() {
        if ($(this).is(":checked")) {
            if ($('#PR').prop("colspan") == 1 && $('#PR').is(":hidden") == true) {
                $('#PR').attr('hidden', false);
                if ($('#PR_IS').prop("colspan") == 1 && $('#PR_IS').is(":hidden") == true) {
                    $('#PR_IS').attr('hidden', false);
                    $('.pr_unit').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_IS').prop("colspan") + 1;
                    $('#PR_IS').prop("colspan", $iop2);
                    $('.pr_unit').attr('hidden', false);

                }
            } else {
                $iop = $('#PR').prop("colspan") + 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
                if ($('#PR_IS').prop("colspan") == 1 && $('#PR_IS').is(":hidden") == true) {
                    $('#PR_IS').attr('hidden', false);
                    $('.pr_unit').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_IS').prop("colspan") + 1;
                    $('#PR_IS').prop("colspan", $iop2);
                    $('.pr_unit').attr('hidden', false);

                }
            }
        } else {
            $('.pr_unit').attr('hidden', true);
            if ($('#PR').prop("colspan") == 1) {
                $('#PR').attr('hidden', true);
            } else {
                $iop = $('#PR').prop("colspan") - 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
            }

            if ($('#PR_IS').prop("colspan") == 1) {
                $('#PR_IS').attr('hidden', true);
            } else {
                $iop = $('#PR_IS').prop("colspan") - 1;
                $('#PR_IS').prop("colspan", $iop)
            }
        }
    });

    $(document).on('click', '#pr_id_drug_test_result', function() {
        if ($(this).is(":checked")) {
            if ($('#PR').prop("colspan") == 1 && $('#PR').is(":hidden") == true) {
                $('#PR').attr('hidden', false);
                if ($('#PR_IS').prop("colspan") == 1 && $('#PR_IS').is(":hidden") == true) {
                    $('#PR_IS').attr('hidden', false);
                    $('.pr_id_drug_test_result').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_IS').prop("colspan") + 1;
                    $('#PR_IS').prop("colspan", $iop2);
                    $('.pr_id_drug_test_result').attr('hidden', false);

                }
            } else {
                $iop = $('#PR').prop("colspan") + 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
                if ($('#PR_IS').prop("colspan") == 1 && $('#PR_IS').is(":hidden") == true) {
                    $('#PR_IS').attr('hidden', false);
                    $('.pr_id_drug_test_result').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_IS').prop("colspan") + 1;
                    $('#PR_IS').prop("colspan", $iop2);
                    $('.pr_id_drug_test_result').attr('hidden', false);

                }
            }
        } else {
            $('.pr_id_drug_test_result').attr('hidden', true);
            if ($('#PR').prop("colspan") == 1) {
                $('#PR').attr('hidden', true);
            } else {
                $iop = $('#PR').prop("colspan") - 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
            }

            if ($('#PR_IS').prop("colspan") == 1) {
                $('#PR_IS').attr('hidden', true);
            } else {
                $iop = $('#PR_IS').prop("colspan") - 1;
                $('#PR_IS').prop("colspan", $iop)
            }
        }
    });

    $(document).on('click', '#pr_id_cr_number', function() {
        if ($(this).is(":checked")) {
            if ($('#PR').prop("colspan") == 1 && $('#PR').is(":hidden") == true) {
                $('#PR').attr('hidden', false);
                if ($('#PR_IS').prop("colspan") == 1 && $('#PR_IS').is(":hidden") == true) {
                    $('#PR_IS').attr('hidden', false);
                    $('.pr_id_cr_number').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_IS').prop("colspan") + 1;
                    $('#PR_IS').prop("colspan", $iop2);
                    $('.pr_id_cr_number').attr('hidden', false);

                }
            } else {
                $iop = $('#PR').prop("colspan") + 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
                if ($('#PR_IS').prop("colspan") == 1 && $('#PR_IS').is(":hidden") == true) {
                    $('#PR_IS').attr('hidden', false);
                    $('.pr_id_cr_number').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_IS').prop("colspan") + 1;
                    $('#PR_IS').prop("colspan", $iop2);
                    $('.pr_id_cr_number').attr('hidden', false);

                }
            }
        } else {
            $('.pr_id_cr_number').attr('hidden', true);
            if ($('#PR').prop("colspan") == 1) {
                $('#PR').attr('hidden', true);
            } else {
                $iop = $('#PR').prop("colspan") - 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
            }

            if ($('#PR_IS').prop("colspan") == 1) {
                $('#PR_IS').attr('hidden', true);
            } else {
                $iop = $('#PR_IS').prop("colspan") - 1;
                $('#PR_IS').prop("colspan", $iop)
            }
        }
    });

    $(document).on('click', '#pr_id_laboratory', function() {
        if ($(this).is(":checked")) {
            if ($('#PR').prop("colspan") == 1 && $('#PR').is(":hidden") == true) {
                $('#PR').attr('hidden', false);
                if ($('#PR_IS').prop("colspan") == 1 && $('#PR_IS').is(":hidden") == true) {
                    $('#PR_IS').attr('hidden', false);
                    $('.pr_id_laboratory').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_IS').prop("colspan") + 1;
                    $('#PR_IS').prop("colspan", $iop2);
                    $('.pr_id_laboratory').attr('hidden', false);

                }
            } else {
                $iop = $('#PR').prop("colspan") + 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
                if ($('#PR_IS').prop("colspan") == 1 && $('#PR_IS').is(":hidden") == true) {
                    $('#PR_IS').attr('hidden', false);
                    $('.pr_id_laboratory').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_IS').prop("colspan") + 1;
                    $('#PR_IS').prop("colspan", $iop2);
                    $('.pr_id_laboratory').attr('hidden', false);

                }
            }
        } else {
            $('.pr_id_laboratory').attr('hidden', true);
            if ($('#PR').prop("colspan") == 1) {
                $('#PR').attr('hidden', true);
            } else {
                $iop = $('#PR').prop("colspan") - 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
            }

            if ($('#PR_IS').prop("colspan") == 1) {
                $('#PR_IS').attr('hidden', true);
            } else {
                $iop = $('#PR_IS').prop("colspan") - 1;
                $('#PR_IS').prop("colspan", $iop)
            }
        }
    });

    $(document).on('click', '#pr_cf_suspect_name', function() {
        if ($(this).is(":checked")) {
            if ($('#PR').prop("colspan") == 1 && $('#PR').is(":hidden") == true) {
                $('#PR').attr('hidden', false);
                if ($('#PR_CASE').prop("colspan") == 1 && $('#PR_CASE').is(":hidden") == true) {
                    $('#PR_CASE').attr('hidden', false);
                    $('.pr_cf_suspect_name').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_CASE').prop("colspan") + 1;
                    $('#PR_CASE').prop("colspan", $iop2);
                    $('.pr_cf_suspect_name').attr('hidden', false);

                }
            } else {
                $iop = $('#PR').prop("colspan") + 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
                if ($('#PR_CASE').prop("colspan") == 1 && $('#PR_CASE').is(":hidden") == true) {
                    $('#PR_CASE').attr('hidden', false);
                    $('.pr_cf_suspect_name').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_CASE').prop("colspan") + 1;
                    $('#PR_CASE').prop("colspan", $iop2);
                    $('.pr_cf_suspect_name').attr('hidden', false);

                }
            }
        } else {
            $('.pr_cf_suspect_name').attr('hidden', true);
            if ($('#PR').prop("colspan") == 1) {
                $('#PR').attr('hidden', true);
            } else {
                $iop = $('#PR').prop("colspan") - 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
            }

            if ($('#PR_CASE').prop("colspan") == 1) {
                $('#PR_CASE').attr('hidden', true);
            } else {
                $iop = $('#PR_CASE').prop("colspan") - 1;
                $('#PR_CASE').prop("colspan", $iop)
            }
        }
    });

    $(document).on('click', '#pr_cf_case', function() {
        if ($(this).is(":checked")) {
            if ($('#PR').prop("colspan") == 1 && $('#PR').is(":hidden") == true) {
                $('#PR').attr('hidden', false);
                if ($('#PR_CASE').prop("colspan") == 1 && $('#PR_CASE').is(":hidden") == true) {
                    $('#PR_CASE').attr('hidden', false);
                    $('.pr_cf_case').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_CASE').prop("colspan") + 1;
                    $('#PR_CASE').prop("colspan", $iop2);
                    $('.pr_cf_case').attr('hidden', false);

                }
            } else {
                $iop = $('#PR').prop("colspan") + 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
                if ($('#PR_CASE').prop("colspan") == 1 && $('#PR_CASE').is(":hidden") == true) {
                    $('#PR_CASE').attr('hidden', false);
                    $('.pr_cf_case').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_CASE').prop("colspan") + 1;
                    $('#PR_CASE').prop("colspan", $iop2);
                    $('.pr_cf_case').attr('hidden', false);

                }
            }
        } else {
            $('.pr_cf_case').attr('hidden', true);
            if ($('#PR').prop("colspan") == 1) {
                $('#PR').attr('hidden', true);
            } else {
                $iop = $('#PR').prop("colspan") - 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
            }

            if ($('#PR_CASE').prop("colspan") == 1) {
                $('#PR_CASE').attr('hidden', true);
            } else {
                $iop = $('#PR_CASE').prop("colspan") - 1;
                $('#PR_CASE').prop("colspan", $iop)
            }
        }
    });

    $(document).on('click', '#pr_cf_docket_number', function() {
        if ($(this).is(":checked")) {
            if ($('#PR').prop("colspan") == 1 && $('#PR').is(":hidden") == true) {
                $('#PR').attr('hidden', false);
                if ($('#PR_CASE').prop("colspan") == 1 && $('#PR_CASE').is(":hidden") == true) {
                    $('#PR_CASE').attr('hidden', false);
                    $('.pr_cf_docket_number').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_CASE').prop("colspan") + 1;
                    $('#PR_CASE').prop("colspan", $iop2);
                    $('.pr_cf_docket_number').attr('hidden', false);

                }
            } else {
                $iop = $('#PR').prop("colspan") + 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
                if ($('#PR_CASE').prop("colspan") == 1 && $('#PR_CASE').is(":hidden") == true) {
                    $('#PR_CASE').attr('hidden', false);
                    $('.pr_cf_docket_number').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_CASE').prop("colspan") + 1;
                    $('#PR_CASE').prop("colspan", $iop2);
                    $('.pr_cf_docket_number').attr('hidden', false);

                }
            }
        } else {
            $('.pr_cf_docket_number').attr('hidden', true);
            if ($('#PR').prop("colspan") == 1) {
                $('#PR').attr('hidden', true);
            } else {
                $iop = $('#PR').prop("colspan") - 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
            }

            if ($('#PR_CASE').prop("colspan") == 1) {
                $('#PR_CASE').attr('hidden', true);
            } else {
                $iop = $('#PR_CASE').prop("colspan") - 1;
                $('#PR_CASE').prop("colspan", $iop)
            }
        }
    });

    $(document).on('click', '#pr_cf_status', function() {
        if ($(this).is(":checked")) {
            if ($('#PR').prop("colspan") == 1 && $('#PR').is(":hidden") == true) {
                $('#PR').attr('hidden', false);
                if ($('#PR_CASE').prop("colspan") == 1 && $('#PR_CASE').is(":hidden") == true) {
                    $('#PR_CASE').attr('hidden', false);
                    $('.pr_cf_status').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_CASE').prop("colspan") + 1;
                    $('#PR_CASE').prop("colspan", $iop2);
                    $('.pr_cf_status').attr('hidden', false);

                }
            } else {
                $iop = $('#PR').prop("colspan") + 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
                if ($('#PR_CASE').prop("colspan") == 1 && $('#PR_CASE').is(":hidden") == true) {
                    $('#PR_CASE').attr('hidden', false);
                    $('.pr_cf_status').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_CASE').prop("colspan") + 1;
                    $('#PR_CASE').prop("colspan", $iop2);
                    $('.pr_cf_status').attr('hidden', false);

                }
            }
        } else {
            $('.pr_cf_status').attr('hidden', true);
            if ($('#PR').prop("colspan") == 1) {
                $('#PR').attr('hidden', true);
            } else {
                $iop = $('#PR').prop("colspan") - 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
            }

            if ($('#PR_CASE').prop("colspan") == 1) {
                $('#PR_CASE').attr('hidden', true);
            } else {
                $iop = $('#PR_CASE').prop("colspan") - 1;
                $('#PR_CASE').prop("colspan", $iop)
            }
        }
    });

    $(document).on('click', '#pr_inquest_status', function() {
        if ($(this).is(":checked")) {
            if ($('#PR').prop("colspan") == 1 && $('#PR').is(":hidden") == true) {
                $('#PR').attr('hidden', false);
                if ($('#PR_INQUEST').prop("colspan") == 1 && $('#PR_INQUEST').is(":hidden") == true) {
                    $('#PR_INQUEST').attr('hidden', false);
                    $('.pr_inquest_status').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_INQUEST').prop("colspan") + 1;
                    $('#PR_INQUEST').prop("colspan", $iop2);
                    $('.pr_inquest_status').attr('hidden', false);

                }
            } else {
                $iop = $('#PR').prop("colspan") + 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
                if ($('#PR_INQUEST').prop("colspan") == 1 && $('#PR_INQUEST').is(":hidden") == true) {
                    $('#PR_INQUEST').attr('hidden', false);
                    $('.pr_inquest_status').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_INQUEST').prop("colspan") + 1;
                    $('#PR_INQUEST').prop("colspan", $iop2);
                    $('.pr_inquest_status').attr('hidden', false);

                }
            }
        } else {
            $('.pr_inquest_status').attr('hidden', true);
            if ($('#PR').prop("colspan") == 1) {
                $('#PR').attr('hidden', true);
            } else {
                $iop = $('#PR').prop("colspan") - 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
            }

            if ($('#PR_INQUEST').prop("colspan") == 1) {
                $('#PR_INQUEST').attr('hidden', true);
            } else {
                $iop = $('#PR_INQUEST').prop("colspan") - 1;
                $('#PR_INQUEST').prop("colspan", $iop)
            }
        }
    });

    $(document).on('click', '#pr_inquest_nps', function() {
        if ($(this).is(":checked")) {
            if ($('#PR').prop("colspan") == 1 && $('#PR').is(":hidden") == true) {
                $('#PR').attr('hidden', false);
                if ($('#PR_INQUEST').prop("colspan") == 1 && $('#PR_INQUEST').is(":hidden") == true) {
                    $('#PR_INQUEST').attr('hidden', false);
                    $('.pr_inquest_nps').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_INQUEST').prop("colspan") + 1;
                    $('#PR_INQUEST').prop("colspan", $iop2);
                    $('.pr_inquest_nps').attr('hidden', false);

                }
            } else {
                $iop = $('#PR').prop("colspan") + 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
                if ($('#PR_INQUEST').prop("colspan") == 1 && $('#PR_INQUEST').is(":hidden") == true) {
                    $('#PR_INQUEST').attr('hidden', false);
                    $('.pr_inquest_nps').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_INQUEST').prop("colspan") + 1;
                    $('#PR_INQUEST').prop("colspan", $iop2);
                    $('.pr_inquest_nps').attr('hidden', false);

                }
            }
        } else {
            $('.pr_inquest_nps').attr('hidden', true);
            if ($('#PR').prop("colspan") == 1) {
                $('#PR').attr('hidden', true);
            } else {
                $iop = $('#PR').prop("colspan") - 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
            }

            if ($('#PR_INQUEST').prop("colspan") == 1) {
                $('#PR_INQUEST').attr('hidden', true);
            } else {
                $iop = $('#PR_INQUEST').prop("colspan") - 1;
                $('#PR_INQUEST').prop("colspan", $iop)
            }
        }
    });

    $(document).on('click', '#pr_inquest_date', function() {
        if ($(this).is(":checked")) {
            if ($('#PR').prop("colspan") == 1 && $('#PR').is(":hidden") == true) {
                $('#PR').attr('hidden', false);
                if ($('#PR_INQUEST').prop("colspan") == 1 && $('#PR_INQUEST').is(":hidden") == true) {
                    $('#PR_INQUEST').attr('hidden', false);
                    $('.pr_inquest_date').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_INQUEST').prop("colspan") + 1;
                    $('#PR_INQUEST').prop("colspan", $iop2);
                    $('.pr_inquest_date').attr('hidden', false);

                }
            } else {
                $iop = $('#PR').prop("colspan") + 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
                if ($('#PR_INQUEST').prop("colspan") == 1 && $('#PR_INQUEST').is(":hidden") == true) {
                    $('#PR_INQUEST').attr('hidden', false);
                    $('.pr_inquest_date').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_INQUEST').prop("colspan") + 1;
                    $('#PR_INQUEST').prop("colspan", $iop2);
                    $('.pr_inquest_date').attr('hidden', false);

                }
            }
        } else {
            $('.pr_inquest_date').attr('hidden', true);
            if ($('#PR').prop("colspan") == 1) {
                $('#PR').attr('hidden', true);
            } else {
                $iop = $('#PR').prop("colspan") - 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
            }

            if ($('#PR_INQUEST').prop("colspan") == 1) {
                $('#PR_INQUEST').attr('hidden', true);
            } else {
                $iop = $('#PR_INQUEST').prop("colspan") - 1;
                $('#PR_INQUEST').prop("colspan", $iop)
            }
        }
    });

    $(document).on('click', '#pr_inquest_prosecutor', function() {
        if ($(this).is(":checked")) {
            if ($('#PR').prop("colspan") == 1 && $('#PR').is(":hidden") == true) {
                $('#PR').attr('hidden', false);
                if ($('#PR_INQUEST').prop("colspan") == 1 && $('#PR_INQUEST').is(":hidden") == true) {
                    $('#PR_INQUEST').attr('hidden', false);
                    $('.pr_inquest_prosecutor').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_INQUEST').prop("colspan") + 1;
                    $('#PR_INQUEST').prop("colspan", $iop2);
                    $('.pr_inquest_prosecutor').attr('hidden', false);

                }
            } else {
                $iop = $('#PR').prop("colspan") + 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
                if ($('#PR_INQUEST').prop("colspan") == 1 && $('#PR_INQUEST').is(":hidden") == true) {
                    $('#PR_INQUEST').attr('hidden', false);
                    $('.pr_inquest_prosecutor').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_INQUEST').prop("colspan") + 1;
                    $('#PR_INQUEST').prop("colspan", $iop2);
                    $('.pr_inquest_prosecutor').attr('hidden', false);

                }
            }
        } else {
            $('.pr_inquest_prosecutor').attr('hidden', true);
            if ($('#PR').prop("colspan") == 1) {
                $('#PR').attr('hidden', true);
            } else {
                $iop = $('#PR').prop("colspan") - 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
            }

            if ($('#PR_INQUEST').prop("colspan") == 1) {
                $('#PR_INQUEST').attr('hidden', true);
            } else {
                $iop = $('#PR_INQUEST').prop("colspan") - 1;
                $('#PR_INQUEST').prop("colspan", $iop)
            }
        }
    });

    $(document).on('click', '#pr_inquest_office', function() {
        if ($(this).is(":checked")) {
            if ($('#PR').prop("colspan") == 1 && $('#PR').is(":hidden") == true) {
                $('#PR').attr('hidden', false);
                if ($('#PR_INQUEST').prop("colspan") == 1 && $('#PR_INQUEST').is(":hidden") == true) {
                    $('#PR_INQUEST').attr('hidden', false);
                    $('.pr_inquest_office').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_INQUEST').prop("colspan") + 1;
                    $('#PR_INQUEST').prop("colspan", $iop2);
                    $('.pr_inquest_office').attr('hidden', false);

                }
            } else {
                $iop = $('#PR').prop("colspan") + 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
                if ($('#PR_INQUEST').prop("colspan") == 1 && $('#PR_INQUEST').is(":hidden") == true) {
                    $('#PR_INQUEST').attr('hidden', false);
                    $('.pr_inquest_office').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_INQUEST').prop("colspan") + 1;
                    $('#PR_INQUEST').prop("colspan", $iop2);
                    $('.pr_inquest_office').attr('hidden', false);

                }
            }
        } else {
            $('.pr_inquest_office').attr('hidden', true);
            if ($('#PR').prop("colspan") == 1) {
                $('#PR').attr('hidden', true);
            } else {
                $iop = $('#PR').prop("colspan") - 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
            }

            if ($('#PR_INQUEST').prop("colspan") == 1) {
                $('#PR_INQUEST').attr('hidden', true);
            } else {
                $iop = $('#PR_INQUEST').prop("colspan") - 1;
                $('#PR_INQUEST').prop("colspan", $iop)
            }
        }
    });

    $(document).on('click', '#pr_prelim_status', function() {
        if ($(this).is(":checked")) {
            if ($('#PR').prop("colspan") == 1 && $('#PR').is(":hidden") == true) {
                $('#PR').attr('hidden', false);
                if ($('#PR_PRELIM').prop("colspan") == 1 && $('#PR_PRELIM').is(":hidden") == true) {
                    $('#PR_PRELIM').attr('hidden', false);
                    $('.pr_prelim_status').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_PRELIM').prop("colspan") + 1;
                    $('#PR_PRELIM').prop("colspan", $iop2);
                    $('.pr_prelim_status').attr('hidden', false);

                }
            } else {
                $iop = $('#PR').prop("colspan") + 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
                if ($('#PR_PRELIM').prop("colspan") == 1 && $('#PR_PRELIM').is(":hidden") == true) {
                    $('#PR_PRELIM').attr('hidden', false);
                    $('.pr_prelim_status').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_PRELIM').prop("colspan") + 1;
                    $('#PR_PRELIM').prop("colspan", $iop2);
                    $('.pr_prelim_status').attr('hidden', false);

                }
            }
        } else {
            $('.pr_prelim_status').attr('hidden', true);
            if ($('#PR').prop("colspan") == 1) {
                $('#PR').attr('hidden', true);
            } else {
                $iop = $('#PR').prop("colspan") - 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
            }

            if ($('#PR_PRELIM').prop("colspan") == 1) {
                $('#PR_PRELIM').attr('hidden', true);
            } else {
                $iop = $('#PR_PRELIM').prop("colspan") - 1;
                $('#PR_PRELIM').prop("colspan", $iop)
            }
        }
    });

    $(document).on('click', '#pr_prelim_date', function() {
        if ($(this).is(":checked")) {
            if ($('#PR').prop("colspan") == 1 && $('#PR').is(":hidden") == true) {
                $('#PR').attr('hidden', false);
                if ($('#PR_PRELIM').prop("colspan") == 1 && $('#PR_PRELIM').is(":hidden") == true) {
                    $('#PR_PRELIM').attr('hidden', false);
                    $('.pr_prelim_date').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_PRELIM').prop("colspan") + 1;
                    $('#PR_PRELIM').prop("colspan", $iop2);
                    $('.pr_prelim_date').attr('hidden', false);

                }
            } else {
                $iop = $('#PR').prop("colspan") + 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
                if ($('#PR_PRELIM').prop("colspan") == 1 && $('#PR_PRELIM').is(":hidden") == true) {
                    $('#PR_PRELIM').attr('hidden', false);
                    $('.pr_prelim_date').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_PRELIM').prop("colspan") + 1;
                    $('#PR_PRELIM').prop("colspan", $iop2);
                    $('.pr_prelim_date').attr('hidden', false);

                }
            }
        } else {
            $('.pr_prelim_date').attr('hidden', true);
            if ($('#PR').prop("colspan") == 1) {
                $('#PR').attr('hidden', true);
            } else {
                $iop = $('#PR').prop("colspan") - 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
            }

            if ($('#PR_PRELIM').prop("colspan") == 1) {
                $('#PR_PRELIM').attr('hidden', true);
            } else {
                $iop = $('#PR_PRELIM').prop("colspan") - 1;
                $('#PR_PRELIM').prop("colspan", $iop)
            }
        }
    });

    $(document).on('click', '#pr_prelim_nps', function() {
        if ($(this).is(":checked")) {
            if ($('#PR').prop("colspan") == 1 && $('#PR').is(":hidden") == true) {
                $('#PR').attr('hidden', false);
                if ($('#PR_PRELIM').prop("colspan") == 1 && $('#PR_PRELIM').is(":hidden") == true) {
                    $('#PR_PRELIM').attr('hidden', false);
                    $('.pr_prelim_nps').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_PRELIM').prop("colspan") + 1;
                    $('#PR_PRELIM').prop("colspan", $iop2);
                    $('.pr_prelim_nps').attr('hidden', false);

                }
            } else {
                $iop = $('#PR').prop("colspan") + 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
                if ($('#PR_PRELIM').prop("colspan") == 1 && $('#PR_PRELIM').is(":hidden") == true) {
                    $('#PR_PRELIM').attr('hidden', false);
                    $('.pr_prelim_nps').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_PRELIM').prop("colspan") + 1;
                    $('#PR_PRELIM').prop("colspan", $iop2);
                    $('.pr_prelim_nps').attr('hidden', false);

                }
            }
        } else {
            $('.pr_prelim_nps').attr('hidden', true);
            if ($('#PR').prop("colspan") == 1) {
                $('#PR').attr('hidden', true);
            } else {
                $iop = $('#PR').prop("colspan") - 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
            }

            if ($('#PR_PRELIM').prop("colspan") == 1) {
                $('#PR_PRELIM').attr('hidden', true);
            } else {
                $iop = $('#PR_PRELIM').prop("colspan") - 1;
                $('#PR_PRELIM').prop("colspan", $iop)
            }
        }
    });

    $(document).on('click', '#pr_prelim_prosecutor', function() {
        if ($(this).is(":checked")) {
            if ($('#PR').prop("colspan") == 1 && $('#PR').is(":hidden") == true) {
                $('#PR').attr('hidden', false);
                if ($('#PR_PRELIM').prop("colspan") == 1 && $('#PR_PRELIM').is(":hidden") == true) {
                    $('#PR_PRELIM').attr('hidden', false);
                    $('.pr_prelim_prosecutor').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_PRELIM').prop("colspan") + 1;
                    $('#PR_PRELIM').prop("colspan", $iop2);
                    $('.pr_prelim_prosecutor').attr('hidden', false);

                }
            } else {
                $iop = $('#PR').prop("colspan") + 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
                if ($('#PR_PRELIM').prop("colspan") == 1 && $('#PR_PRELIM').is(":hidden") == true) {
                    $('#PR_PRELIM').attr('hidden', false);
                    $('.pr_prelim_prosecutor').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_PRELIM').prop("colspan") + 1;
                    $('#PR_PRELIM').prop("colspan", $iop2);
                    $('.pr_prelim_prosecutor').attr('hidden', false);

                }
            }
        } else {
            $('.pr_prelim_prosecutor').attr('hidden', true);
            if ($('#PR').prop("colspan") == 1) {
                $('#PR').attr('hidden', true);
            } else {
                $iop = $('#PR').prop("colspan") - 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
            }

            if ($('#PR_PRELIM').prop("colspan") == 1) {
                $('#PR_PRELIM').attr('hidden', true);
            } else {
                $iop = $('#PR_PRELIM').prop("colspan") - 1;
                $('#PR_PRELIM').prop("colspan", $iop)
            }
        }
    });

    $(document).on('click', '#pr_prelim_office', function() {
        if ($(this).is(":checked")) {
            if ($('#PR').prop("colspan") == 1 && $('#PR').is(":hidden") == true) {
                $('#PR').attr('hidden', false);
                if ($('#PR_PRELIM').prop("colspan") == 1 && $('#PR_PRELIM').is(":hidden") == true) {
                    $('#PR_PRELIM').attr('hidden', false);
                    $('.pr_prelim_office').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_PRELIM').prop("colspan") + 1;
                    $('#PR_PRELIM').prop("colspan", $iop2);
                    $('.pr_prelim_office').attr('hidden', false);

                }
            } else {
                $iop = $('#PR').prop("colspan") + 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
                if ($('#PR_PRELIM').prop("colspan") == 1 && $('#PR_PRELIM').is(":hidden") == true) {
                    $('#PR_PRELIM').attr('hidden', false);
                    $('.pr_prelim_office').attr('hidden', false);

                } else {
                    $iop2 = $('#PR_PRELIM').prop("colspan") + 1;
                    $('#PR_PRELIM').prop("colspan", $iop2);
                    $('.pr_prelim_office').attr('hidden', false);

                }
            }
        } else {
            $('.pr_prelim_office').attr('hidden', true);
            if ($('#PR').prop("colspan") == 1) {
                $('#PR').attr('hidden', true);
            } else {
                $iop = $('#PR').prop("colspan") - 1;
                $('#PR').prop("colspan", $iop);
                $('#PR2').val($iop);
            }

            if ($('#PR_PRELIM').prop("colspan") == 1) {
                $('#PR_PRELIM').attr('hidden', true);
            } else {
                $iop = $('#PR_PRELIM').prop("colspan") - 1;
                $('#PR_PRELIM').prop("colspan", $iop)
            }
        }
    });

    // Drug Verification Menu

    $(document).on('click', '#dv_suspect_name', function() {
        if ($(this).is(":checked")) {
            if ($('#DV').prop("colspan") == 1 && $('#DV').is(":hidden") == true) {
                $('#DV').attr('hidden', false);
                if ($('#DV_HIO').prop("colspan") == 1 && $('#DV_HIO').is(":hidden") == true) {
                    $('#DV_HIO').attr('hidden', false);
                    $('.dv_suspect_name').attr('hidden', false);

                } else {
                    $iop2 = $('#DV_HIO').prop("colspan") + 1;
                    $('#DV_HIO').prop("colspan", $iop2);
                    $('.dv_suspect_name').attr('hidden', false);

                }
            } else {
                $iop = $('#DV').prop("colspan") + 1;
                $('#DV').prop("colspan", $iop);
                $('#DV2').val($iop);
                if ($('#DV_HIO').prop("colspan") == 1 && $('#DV_HIO').is(":hidden") == true) {
                    $('#DV_HIO').attr('hidden', false);
                    $('.dv_suspect_name').attr('hidden', false);

                } else {
                    $iop2 = $('#DV_HIO').prop("colspan") + 1;
                    $('#DV_HIO').prop("colspan", $iop2);
                    $('.dv_suspect_name').attr('hidden', false);

                }
            }
        } else {
            $('.dv_suspect_name').attr('hidden', true);
            if ($('#DV').prop("colspan") == 1) {
                $('#DV').attr('hidden', true);
            } else {
                $iop = $('#DV').prop("colspan") - 1;
                $('#DV').prop("colspan", $iop)
                $('#DV2').val($iop);
            }

            if ($('#DV_HIO').prop("colspan") == 1) {
                $('#DV_HIO').attr('hidden', true);
            } else {
                $iop = $('#DV_HIO').prop("colspan") - 1;
                $('#DV_HIO').prop("colspan", $iop)
            }
        }
    });

    $(document).on('click', '#dv_listed', function() {
        if ($(this).is(":checked")) {
            if ($('#DV').prop("colspan") == 1 && $('#DV').is(":hidden") == true) {
                $('#DV').attr('hidden', false);
                if ($('#DV_HIO').prop("colspan") == 1 && $('#DV_HIO').is(":hidden") == true) {
                    $('#DV_HIO').attr('hidden', false);
                    $('.dv_listed').attr('hidden', false);

                } else {
                    $iop2 = $('#DV_HIO').prop("colspan") + 1;
                    $('#DV_HIO').prop("colspan", $iop2);
                    $('.dv_listed').attr('hidden', false);

                }
            } else {
                $iop = $('#DV').prop("colspan") + 1;
                $('#DV').prop("colspan", $iop);
                $('#DV2').val($iop);
                if ($('#DV_HIO').prop("colspan") == 1 && $('#DV_HIO').is(":hidden") == true) {
                    $('#DV_HIO').attr('hidden', false);
                    $('.dv_listed').attr('hidden', false);

                } else {
                    $iop2 = $('#DV_HIO').prop("colspan") + 1;
                    $('#DV_HIO').prop("colspan", $iop2);
                    $('.dv_listed').attr('hidden', false);

                }
            }
        } else {
            $('.dv_listed').attr('hidden', true);
            if ($('#DV').prop("colspan") == 1) {
                $('#DV').attr('hidden', true);
            } else {
                $iop = $('#DV').prop("colspan") - 1;
                $('#DV').prop("colspan", $iop)
                $('#DV2').val($iop);
            }

            if ($('#DV_HIO').prop("colspan") == 1) {
                $('#DV_HIO').attr('hidden', true);
            } else {
                $iop = $('#DV_HIO').prop("colspan") - 1;
                $('#DV_HIO').prop("colspan", $iop)
            }
        }
    });

    $(document).on('click', '#dv_ndis', function() {
        if ($(this).is(":checked")) {
            if ($('#DV').prop("colspan") == 1 && $('#DV').is(":hidden") == true) {
                $('#DV').attr('hidden', false);
                if ($('#DV_HIO').prop("colspan") == 1 && $('#DV_HIO').is(":hidden") == true) {
                    $('#DV_HIO').attr('hidden', false);
                    $('.dv_ndis').attr('hidden', false);

                } else {
                    $iop2 = $('#DV_HIO').prop("colspan") + 1;
                    $('#DV_HIO').prop("colspan", $iop2);
                    $('.dv_ndis').attr('hidden', false);

                }
            } else {
                $iop = $('#DV').prop("colspan") + 1;
                $('#DV').prop("colspan", $iop);
                $('#DV2').val($iop);
                if ($('#DV_HIO').prop("colspan") == 1 && $('#DV_HIO').is(":hidden") == true) {
                    $('#DV_HIO').attr('hidden', false);
                    $('.dv_ndis').attr('hidden', false);

                } else {
                    $iop2 = $('#DV_HIO').prop("colspan") + 1;
                    $('#DV_HIO').prop("colspan", $iop2);
                    $('.dv_ndis').attr('hidden', false);

                }
            }
        } else {
            $('.dv_ndis').attr('hidden', true);
            if ($('#DV').prop("colspan") == 1) {
                $('#DV').attr('hidden', true);
            } else {
                $iop = $('#DV').prop("colspan") - 1;
                $('#DV').prop("colspan", $iop)
                $('#DV2').val($iop);
            }

            if ($('#DV_HIO').prop("colspan") == 1) {
                $('#DV_HIO').attr('hidden', true);
            } else {
                $iop = $('#DV_HIO').prop("colspan") - 1;
                $('#DV_HIO').prop("colspan", $iop)
            }
        }
    });

    $(document).on('click', '#dv_remarks', function() {
        if ($(this).is(":checked")) {
            if ($('#DV').prop("colspan") == 1 && $('#DV').is(":hidden") == true) {
                $('#DV').attr('hidden', false);
                if ($('#DV_HIO').prop("colspan") == 1 && $('#DV_HIO').is(":hidden") == true) {
                    $('#DV_HIO').attr('hidden', false);
                    $('.dv_remarks').attr('hidden', false);

                } else {
                    $iop2 = $('#DV_HIO').prop("colspan") + 1;
                    $('#DV_HIO').prop("colspan", $iop2);
                    $('.dv_remarks').attr('hidden', false);

                }
            } else {
                $iop = $('#DV').prop("colspan") + 1;
                $('#DV').prop("colspan", $iop);
                $('#DV2').val($iop);
                if ($('#DV_HIO').prop("colspan") == 1 && $('#DV_HIO').is(":hidden") == true) {
                    $('#DV_HIO').attr('hidden', false);
                    $('.dv_remarks').attr('hidden', false);

                } else {
                    $iop2 = $('#DV_HIO').prop("colspan") + 1;
                    $('#DV_HIO').prop("colspan", $iop2);
                    $('.dv_remarks').attr('hidden', false);

                }
            }
        } else {
            $('.dv_remarks').attr('hidden', true);
            if ($('#DV').prop("colspan") == 1) {
                $('#DV').attr('hidden', true);
            } else {
                $iop = $('#DV').prop("colspan") - 1;
                $('#DV').prop("colspan", $iop)
                $('#DV2').val($iop);
            }

            if ($('#DV_HIO').prop("colspan") == 1) {
                $('#DV_HIO').attr('hidden', true);
            } else {
                $iop = $('#DV_HIO').prop("colspan") - 1;
                $('#DV_HIO').prop("colspan", $iop)
            }
        }
    });
</script>

<script>
    $(function() {
        $('#report_generation_link').addClass('active');
    });
</script>




@endsection