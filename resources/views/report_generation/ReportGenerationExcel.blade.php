<table id="example_info" class="table table-bordered table-striped table-hover" style="width:auto">
    <thead>
        <tr>
            <th id="IOP" class="po" colspan="20" style="white-space: nowrap;  text-align:center; font-size: 30px">Issuance of Pre-Ops</th>
            <th id="AO" class="ao" colspan="7" style="white-space: nowrap;  text-align:center; font-size: 30px">After Operations</th>
            <th id="SP" class="sp" colspan="43" style="white-space: nowrap;  text-align:center; font-size: 30px">Spot Report</th>
            <th id="PR" class="pr" colspan="27" style="white-space: nowrap;  text-align:center; font-size: 30px">Progress Report</th>
            <th id="DV" class="dv" colspan="4" style="white-space: nowrap;  text-align:center; font-size: 30px">Drug Verification List</th>
        </tr>
        <tr>
            @if($region1 != 0)<th class="po region" rowspan="2" style="white-space: nowrap; text-align:center; font-size: 20px; vertical-align : middle;text-align:center;">Region</th>@endif
            @if($preops_number != 0)<th class="po preops_number" rowspan="2" style="white-space: nowrap; text-align:center; font-size: 20px; vertical-align : middle;text-align:center;">Preops Number</th>@endif
            @if($province != 0)<th class="po province" rowspan="2" style="white-space: nowrap; text-align:center; font-size: 20px; vertical-align : middle;text-align:center;">Province</th>@endif
            @if($type_operation != 0)<th class="po type_operation" rowspan="2" style="white-space: nowrap; text-align:center; font-size: 20px; vertical-align : middle;text-align:center;">Type Of Operation</th>@endif
            @if($operating_unit != 0)<th class="po operating_unit" rowspan="2" style="white-space: nowrap; text-align:center; font-size: 20px; vertical-align : middle;text-align:center;">Lead Unit</th>@endif
            @if($support_unit != 0)<th class="po support_unit" rowspan="2" style="white-space: nowrap; text-align:center; font-size: 20px; vertical-align : middle;text-align:center;">Support Unit</th>@endif
            @if($datetime_coordinate != 0)<th class="po datetime_coordinate" rowspan="2" style="white-space: nowrap; text-align:center; font-size: 20px; vertical-align : middle;text-align:center;">Date/Time Coordinate</th>@endif
            @if($datetime_operation != 0)<th class="po datetime_operation" rowspan="2" style="white-space: nowrap; text-align:center; font-size: 20px; vertical-align : middle;text-align:center;">Date/Time Operation</th>@endif
            @if($valid_until != 0)<th class="po valid_until" rowspan="2" style="white-space: nowrap; text-align:center; font-size: 20px; vertical-align : middle;text-align:center;">Valid Until</th>@endif
            @if($a_area != 0)<th class="ao a_area" colspan="5" style="white-space: nowrap; text-align:center; font-size: 20px">Area of Operation</th>@endif
            @if($taget_name != 0)<th class="ao taget_name" colspan="2" style="white-space: nowrap;  text-align:center; font-size: 20px">Target</th>@endif
            @if($ot_name != 0)<th class="ao ot_name" colspan="3" style="white-space: nowrap; text-align:center;  font-size: 20px">Operating Team</th>@endif
            @if($prepared_by != 0)<th class="ao prepared_by" rowspan="2" style="white-space: nowrap; text-align:center;  font-size: 20px; vertical-align : middle;text-align:center;">Prepared By</th>@endif
            @if($ao_result != 0)<th class="ao ao_result" rowspan="2" style="white-space: nowrap; text-align:center;  font-size: 20px; vertical-align : middle;text-align:center;">Operation Result</th>@endif
            @if($ao_negative_reason != 0)<th class="ao ao_negative_reason" rowspan="2" style="white-space: nowrap; text-align:center;  font-size: 20px; vertical-align : middle;text-align:center;">Negative Reason</th>@endif
            @if($ao_illegal_drug != 0)<th class="ao ao_illegal_drug" rowspan="2" style="white-space: nowrap; text-align:center;  font-size: 20px; vertical-align : middle;text-align:center;">Illegal Drug</th>@endif
            @if($ao_quantity != 0)<th class="ao ao_quantity" rowspan="2" style="white-space: nowrap; text-align:center;  font-size: 20px; vertical-align : middle;text-align:center;">Quantity</th>@endif
            @if($ao_unit_measure != 0)<th class="ao ao_unit_measure" rowspan="2" style="white-space: nowrap; text-align:center;  font-size: 20px; vertical-align : middle;text-align:center;">Unit Measure</th>@endif
            @if($ao_crn != 0)<th class="ao ao_crn" rowspan="2" style="white-space: nowrap; text-align:center;  font-size: 20px; vertical-align : middle;text-align:center;">Chemistry Report Number</th>@endif
            @if($ao_date_received != 0)<th class="ao ao_date_received" rowspan="2" style="white-space: nowrap; text-align:center;  font-size: 20px; vertical-align : middle;text-align:center;">Date Received</th>@endif
            @if($sp_hio != 0)<th class="sp sp_hio" rowspan="2" style="white-space: nowrap; text-align:center;  font-size: 20px; vertical-align : middle;text-align:center;">High Impact Operation</th>@endif
            <th class="sp suspect" id="SP_suspect" colspan="30" style="white-space: nowrap;  text-align:center; font-size: 20px">Suspect</th>
            @if($item_seized != 0)<th class="sp item_seized" id="SP_item_seized" colspan="7" style="white-space: nowrap;  text-align:center; font-size: 20px">Item Seized</th>@endif
            @if($sp_case_type != 0)<th class="sp case_filed" id="SP_CF" colspan="2" style="white-space: nowrap;  text-align:center; font-size: 20px">Case Filed</th>@endif
            @if($sp_summary != 0)<th class="sp sp_summary" colspan="2" style="white-space: nowrap;  text-align:center; font-size: 20px">Summary</th>@endif
            @if($sp_prepared_by != 0)<th class="sp sp_prepared_by" rowspan="2" style="white-space: nowrap; text-align:center;  font-size: 20px; vertical-align : middle;text-align:center;">Prepared By</th>@endif
            @if($pr_suspect != 0)<th class="pr pr_suspect" id="PR_suspect" colspan="6" style="white-space: nowrap;  text-align:center; font-size: 20px">Suspect</th>@endif
            @if($pr_evidence != 0)<th class="pr pr_evidence" id="PR_IS" colspan="7" style="white-space: nowrap;  text-align:center; font-size: 20px">Item Seized</th>@endif
            @if($pr_case != 0)<th class="pr pr_case" id="PR_CASE" colspan="4" style="white-space: nowrap;  text-align:center; font-size: 20px">Case Filed</th>@endif
            @if($pr_inquest != 0)<th class="pr pr_inquest" id="PR_INQUEST" colspan="5" style="white-space: nowrap;  text-align:center; font-size: 20px">Inquest</th>@endif
            @if($pr_prelim != 0)<th class="pr pr_prelim" id="PR_PRELIM" colspan="5" style="white-space: nowrap;  text-align:center; font-size: 20px">Preliminary Investigation</th>@endif
            @if($dv_hio != 0)<th class="dv dv_hio" id="DV_HIO" colspan="4" style="white-space: nowrap;  text-align:center; font-size: 20px">High Impact Operation</th>@endif
        </tr>
        <tr>
            @if($a_area != 0)<th class="ao a_area" style="white-space: nowrap">Area</th>@endif
            @if($a_area != 0)<th class="ao a_area" style="white-space: nowrap">Barangay</th>@endif
            @if($a_area != 0)<th class="ao a_area" style="white-space: nowrap">City</th>@endif
            @if($a_area != 0)<th class="ao a_area" style="white-space: nowrap">Province</th>@endif
            @if($a_area != 0)<th class="ao a_area" style="white-space: nowrap">Region</th>@endif
            @if($taget_name != 0)<th class="ao taget_name" style="white-space: nowrap">Name</th>@endif
            @if($taget_name != 0)<th class="ao taget_name" style="white-space: nowrap">Nationality</th>@endif
            @if($ot_name != 0)<th class="ao ot_name" style="white-space: nowrap">Name</th>@endif
            @if($ot_name != 0)<th class="ao ot_name" style="white-space: nowrap">Position</th>@endif
            @if($ot_name != 0)<th class="ao ot_name" style="white-space: nowrap">Contact</th>@endif
            @if($sp_suspect_number != 0)<th class="sp sp_suspect_number" style="white-space: nowrap">Suspect Number</th>@endif
            @if($sp_status != 0)<th class="sp sp_status" style="white-space: nowrap">Suspect Status</th>@endif
            @if($sp_lastname != 0)<th class="sp sp_lastname" style="white-space: nowrap">Last Name</th>@endif
            @if($sp_firstname != 0)<th class="sp sp_firstname" style="white-space: nowrap">First Name</th>@endif
            @if($sp_middlename != 0)<th class="sp sp_middlename" style="white-space: nowrap">Middle Name</th>@endif
            @if($sp_alias != 0)<th class="sp sp_alias" style="white-space: nowrap">Alias</th>@endif
            @if($sp_birthdate != 0)<th class="sp sp_birthdate" style="white-space: nowrap">Birthdate</th>@endif
            @if($sp_est_birthdate != 0)<th class="sp sp_est_birthdate" style="white-space: nowrap">Estimated Birthdate</th>@endif
            @if($sp_birthplace != 0)<th class="sp sp_birthplace" style="white-space: nowrap">Birth Place</th>@endif
            @if($sp_region != 0)<th class="sp sp_region" style="white-space: nowrap">Region</th>@endif
            @if($sp_province != 0)<th class="sp sp_province" style="white-space: nowrap">Province</th>@endif
            @if($sp_city != 0)<th class="sp sp_city" style="white-space: nowrap">City</th>@endif
            @if($sp_barangay != 0)<th class="sp sp_barangay" style="white-space: nowrap">Barangay</th>@endif
            @if($sp_street != 0)<th class="sp sp_street" style="white-space: nowrap">Street</th>@endif
            @if($sp_p_region != 0)<th class="sp sp_p_region" style="white-space: nowrap">Permanent Region</th>@endif
            @if($sp_p_province != 0)<th class="sp sp_p_province" style="white-space: nowrap">Permanent Province</th>@endif
            @if($sp_p_city != 0)<th class="sp sp_p_city" style="white-space: nowrap">Permanent City</th>@endif
            @if($sp_p_barangay != 0)<th class="sp sp_p_barangay" style="white-space: nowrap">Permanent Barangay</th>@endif
            @if($sp_p_street != 0)<th class="sp sp_p_street" style="white-space: nowrap">Permanent Street</th>@endif
            @if($sp_sex != 0)<th class="sp sp_sex" style="white-space: nowrap">Sex</th>@endif
            @if($sp_civil_status != 0)<th class="sp sp_civil_status" style="white-space: nowrap">Civil Status</th>@endif
            @if($sp_nationality != 0)<th class="sp sp_nationality" style="white-space: nowrap">Nationality</th>@endif
            @if($sp_ethnic_group != 0)<th class="sp sp_ethnic_group" style="white-space: nowrap">Ethnic Group</th>@endif
            @if($sp_religion != 0)<th class="sp sp_religion" style="white-space: nowrap">Religion</th>@endif
            @if($sp_educational_attainment != 0)<th class="sp sp_educational_attainment" style="white-space: nowrap">Educational Attainment</th>@endif
            @if($sp_occupation != 0)<th class="sp sp_occupation" style="white-space: nowrap">Occupation</th>@endif
            @if($sp_classification != 0)<th class="sp sp_classification" style="white-space: nowrap">Suspect Classification</th>@endif
            @if($sp_category != 0)<th class="sp sp_category" style="white-space: nowrap">Suspect Category</th>@endif
            @if($sp_whereabouts != 0)<th class="sp sp_whereabouts" style="white-space: nowrap">Whereabouts</th>@endif
            @if($sp_remarks != 0)<th class="sp sp_remarks" style="white-space: nowrap">Remarks</th>@endif
            @if($sp_seized_from != 0)<th class="sp sp_seized_from" style="white-space: nowrap">Seized From (Suspect)</th>@endif
            @if($sp_drug != 0)<th class="sp sp_drug" style="white-space: nowrap">Drug/Non-Drug</th>@endif
            @if($sp_evidence != 0)<th class="sp sp_evidence" style="white-space: nowrap">Type of Evidence</th>@endif
            @if($sp_quantity != 0)<th class="sp sp_quantity" style="white-space: nowrap">Quantity/Weight</th>@endif
            @if($sp_unit != 0)<th class="sp sp_unit" style="white-space: nowrap">Unit of Measure</th>@endif
            @if($sp_packaging != 0)<th class="sp sp_packaging" style="white-space: nowrap">Packaging</th>@endif
            @if($sp_markings != 0)<th class="sp sp_markings" style="white-space: nowrap">Markings</th>@endif
            @if($sp_case_type != 0)<th class="sp sp_case_type" style="white-space: nowrap">Suspect Name</th>@endif
            @if($sp_case_type != 0)<th class="sp sp_case_type" style="white-space: nowrap">Case(s) Filed</th>@endif
            @if($sp_summary != 0)<th class="sp sp_summary" style="white-space: nowrap">Report Header</th>@endif
            @if($sp_summary != 0)<th class="sp sp_summary" style="white-space: nowrap">Summary</th>@endif

            @if($pr_suspect_name != 0)<th class="pr pr_suspect_name" style="white-space: nowrap">Suspect Name</th>@endif
            @if($pr_suspect_classification != 0)<th class="pr pr_suspect_classification" style="white-space: nowrap">Suspect Classification</th>@endif
            @if($pr_suspect_status != 0)<th class="pr pr_suspect_status" style="white-space: nowrap">Suspect Status</th>@endif
            @if($pr_drug_test_result != 0)<th class="pr pr_drug_test_result" style="white-space: nowrap">Drug Test Result</th>@endif
            @if($pr_drug_type != 0)<th class="pr pr_drug_type" style="white-space: nowrap">Drug Type</th>@endif
            @if($pr_remarks != 0)<th class="pr pr_remarks" style="white-space: nowrap">Remarks</th>@endif
            @if($pr_drug_seized != 0)<th class="pr pr_drug_seized" style="white-space: nowrap">Drug Seized</th>@endif
            @if($pr_qty_onsite != 0)<th class="pr pr_qty_onsite" style="white-space: nowrap">Qty. Onsite</th>@endif
            @if($pr_actual_qty != 0)<th class="pr pr_actual_qty" style="white-space: nowrap">Actual Qty</th>@endif
            @if($pr_unit != 0)<th class="pr pr_unit" style="white-space: nowrap">Unit Measurement</th>@endif
            @if($pr_id_drug_test_result != 0)<th class="pr pr_id_drug_test_result" style="white-space: nowrap">Drug Test Result</th>@endif
            @if($pr_id_cr_number != 0)<th class="pr pr_id_cr_number" style="white-space: nowrap">Chemistry Report Number</th>@endif
            @if($pr_id_laboratory != 0)<th class="pr pr_is_laboratory" style="white-space: nowrap">Laboratory Facility</th>@endif
            @if($pr_cf_suspect_name != 0)<th class="pr pr_cf_suspect_name" style="white-space: nowrap">Suspect Name</th>@endif
            @if($pr_cf_case != 0)<th class="pr pr_cf_case" style="white-space: nowrap">Case Filed</th>@endif
            @if($pr_cf_docket_number != 0)<th class="pr pr_cf_docket_number" style="white-space: nowrap">Docket Number</th>@endif
            @if($pr_cf_status != 0)<th class="pr pr_cf_status" style="white-space: nowrap">Case Status</th>@endif

            @if($pr_inquest_status != 0)<th class="pr pr_inquest_status" style="white-space: nowrap">Case Status</th>@endif
            @if($pr_inquest_date != 0)<th class="pr pr_inquest_date" style="white-space: nowrap">Date</th>@endif
            @if($pr_inquest_nps != 0)<th class="pr pr_inquest_nps" style="white-space: nowrap">IS/NPS Number</th>@endif
            @if($pr_inquest_prosecutor != 0)<th class="pr pr_inquest_prosecutor" style="white-space: nowrap">Name of Prosecutor</th>@endif
            @if($pr_inquest_office != 0)<th class="pr pr_inquest_office" style="white-space: nowrap">Prosecutor Office</th>@endif

            @if($pr_prelim_status != 0)<th class="pr pr_prelim_status" style="white-space: nowrap">Case Status</th>@endif
            @if($pr_prelim_date != 0)<th class="pr pr_prelim_date" style="white-space: nowrap">Date Filed in Court</th>@endif
            @if($pr_prelim_nps != 0)<th class="pr pr_prelim_nps" style="white-space: nowrap">IS/NPS Number</th>@endif
            @if($pr_prelim_prosecutor != 0)<th class="pr pr_prelim_prosecutor" style="white-space: nowrap">Name of Prosecutor</th>@endif
            @if($pr_prelim_office != 0)<th class="pr pr_prelim_office" style="white-space: nowrap">Prosecutor Office</th>@endif

            @if($dv_suspect_name != 0)<th class="dv dv_suspect_name" style="white-space: nowrap">Suspect Name</th>@endif
            @if($dv_listed != 0)<th class="dv dv_listed" style="white-space: nowrap">Listed</th>@endif
            @if($dv_ndis != 0)<th class="dv dv_ndis" style="white-space: nowrap">NDIS ID</th>@endif
            @if($dv_remarks != 0)<th class="dv dv_remarks" style="white-space: nowrap">Remarks</th>@endif

        </tr>
    </thead>
    <tbody id="myTable">
        @foreach($issuance_of_preops as $pr_data)
        <tr class='details'>
            @if($region1 != 0)<td class="po region" style="white-space: nowrap">{{ $pr_data->region }}</td>@endif
            @if($preops_number != 0)<td class="po preops_number pr_number" style="white-space: nowrap">{{ $pr_data->preops_number }}</td>@endif
            @if($province != 0)<td class="po province" style="white-space: nowrap">{{ $pr_data->province_m }}</td>@endif
            @if($type_operation != 0)<td class="po type_operation" style="white-space: nowrap">{{ $pr_data->operation_type }}</td>@endif
            @if($operating_unit != 0)<td class="po operating_unit" style="white-space: nowrap">{{ $pr_data->operating_unit }}</td>@endif
            @if($support_unit != 0)<td class="po support_unit">
                @foreach($preops_support_unit as $psu_data)
                @if($psu_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $psu_data->description }}</span>
                <br>
                @else
                @endif
                @endforeach
            </td>
            @endif
            @if($datetime_coordinate != 0)<td class="po datetime_coordinate" style="white-space: nowrap">{{ $pr_data->coordinated_datetime }}</td> @endif
            @if($datetime_operation != 0)<td class="po datetime_operation" style="white-space: nowrap">{{ $pr_data->operation_datetime }}</td> @endif
            @if($valid_until != 0)<td class="po valid_until" style="white-space: nowrap">{{ $pr_data->validity }}</td> @endif
            @if($a_area != 0)<td class="ao a_area" style="white-space: nowrap;">
                @foreach($preops_area as $pa_data)
                @if($pa_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $pa_data->area }}</span>
                <br>
                @else
                @endif
                @endforeach
            </td>
            @endif
            @if($a_area != 0) <td class="ao a_area" style="white-space: nowrap;">
                @foreach($preops_area as $pa_data)
                @if($pa_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap"> {{ $pa_data->barangay_m }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($a_area != 0)
            <td class="ao a_area" style="white-space: nowrap;">
                @foreach($preops_area as $pa_data)
                @if($pa_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $pa_data->city_m }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($a_area != 0)
            <td class="ao a_area" style="white-space: nowrap;">
                @foreach($preops_area as $pa_data)
                @if($pa_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $pa_data->province_m }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($a_area != 0)
            <td class="ao a_area" style="white-space: nowrap;">
                @foreach($preops_area as $pa_data)
                @if($pa_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap"> {{ $pa_data->region_m }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($taget_name != 0)
            <td class="ao taget_name" style="white-space: nowrap;">
                @foreach($preops_target as $pt_data)
                @if($pt_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $pt_data->name }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($taget_name != 0)
            <td class="ao taget_name" style="white-space: nowrap;">
                @foreach($preops_target as $pt_data)
                @if($pt_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $pt_data->nationality }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($ot_name != 0)
            <td class="ao ot_name" style="white-space: nowrap;">
                @foreach($preops_team as $pteam_data)
                @if($pteam_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $pteam_data->name }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($ot_name != 0)
            <td class="ao ot_name" style="white-space: nowrap;">
                @foreach($preops_team as $pteam_data)
                @if($pteam_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $pteam_data->position }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($ot_name != 0)
            <td class="ao ot_name" style="white-space: nowrap;">
                @foreach($preops_team as $pteam_data)
                @if($pteam_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $pteam_data->contact }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif

            @if($prepared_by != 0) <td class="ao prepared_by" style="white-space: nowrap">{{ $pr_data->prepared_by }}</td>@endif
            @if($ao_result != 0)<td class="ao ao_result" style="white-space: nowrap">{{ $pr_data->result }}</td>@endif
            @if($ao_negative_reason != 0)<td class="ao ao_negative_reason" style="white-space: nowrap">{{ $pr_data->negative_reason }}</td>@endif
            @if($ao_illegal_drug != 0)<td class="ao ao_illegal_drug" style="white-space: nowrap">
                @foreach($after_operation_evidence as $ao_data)
                @if($ao_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $ao_data->evidence }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($ao_quantity != 0)<td class="ao ao_quantity" style="white-space: nowrap">
                @foreach($after_operation_evidence as $ao_data)
                @if($ao_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $ao_data->quantity }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($ao_unit_measure != 0)<td class="ao ao_unit_measure" style="white-space: nowrap">
                @foreach($after_operation_evidence as $ao_data)
                @if($ao_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $ao_data->unit }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($ao_crn != 0)<td class="ao ao_crn" style="white-space: nowrap">
                @foreach($after_operation_evidence as $ao_data)
                @if($ao_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $ao_data->chemist_report_number }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($ao_date_received != 0)<td class="ao ao_date_received" style="white-space: nowrap">
                {{ $pr_data->received_date }}
            </td>
            @endif
            @if($sp_hio != 0)<td class="sp sp_hio" style="white-space: nowrap">
                @foreach($spot_report_header as $srh_data)
                @if($srh_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">
                    @if($srh_data->operation_lvl == 1)
                    Yes
                    @else
                    No
                    @endif
                    <br>
                </span>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_suspect_number != 0)<td class="sp sp_suspect_number" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->suspect_number }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_status != 0)<td class="sp sp_status" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->suspect_status }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_lastname != 0) <td class="sp sp_lastname" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->lastname }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_firstname != 0)<td class="sp sp_firstname" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->firstname }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_middlename != 0)<td class="sp sp_middlename" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->middlename }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_alias != 0) <td class="sp sp_alias" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->alias }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_birthdate != 0) <td class="sp sp_birthdate" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->birthdate }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_est_birthdate != 0) <td class="sp sp_est_birthdate" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">
                    @if($srs_data->est_birthdate == 1)
                    Yes
                    @else
                    No
                    @endif
                    <br>
                </span>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_birthplace != 0) <td class="sp sp_birthplace" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->birthplace }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_region != 0)<td class="sp sp_region" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->s_region }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_province != 0)<td class="sp sp_province" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->s_province }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_city != 0)<td class="sp sp_city" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->s_city }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_barangay != 0)<td class="sp sp_barangay" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->s_barangay }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_street != 0)<td class="sp sp_street" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->street }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_p_region != 0)<td class="sp sp_p_region" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->p_region }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_p_province != 0)<td class="sp sp_p_province" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->p_province }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_p_city != 0)<td class="sp sp_p_city" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->p_city }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_p_barangay != 0)<td class="sp sp_p_barangay" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->p_barangay }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_p_street != 0)<td class="sp sp_p_street" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->permanent_street }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_sex != 0)<td class="sp sp_gender" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->gender }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_civil_status != 0)<td class="sp sp_civil_status" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->civil_status }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_nationality != 0)<td class="sp sp_nationality" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->nationality }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_ethnic_group != 0)<td class="sp sp_ethnic_group" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->ethnic_group }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_religion != 0)<td class="sp sp_religion" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->religion }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_educational_attainment != 0)<td class="sp sp_educational_attainment" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->educational_attainment }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_occupation != 0)<td class="sp sp_occupation" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->occupation }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_classification != 0)<td class="sp sp_classification" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->suspect_classification }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_category != 0)<td class="sp sp_category" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->suspect_category }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_whereabouts != 0)<td class="sp sp_whereabouts" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->whereabouts }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_remarks != 0)<td class="sp sp_remarks" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->remarks }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_seized_from != 0)<td class="sp sp_seized_from" style="white-space: nowrap">
                @foreach($spot_report_evidence as $sre_data)
                @if($sre_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $sre_data->lastname }}, {{ $sre_data->firstname }} {{ $sre_data->middlename }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_remarks != 0)<td class="sp sp_remarks" style="white-space: nowrap">
                @foreach($spot_report_evidence as $sre_data)
                @if($sre_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $sre_data->drug }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_drug != 0)<td class="sp sp_drug" style="white-space: nowrap">
                @foreach($spot_report_evidence as $sre_data)
                @if($sre_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $sre_data->evidence }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_quantity != 0)<td class="sp sp_quantity" style="white-space: nowrap">
                @foreach($spot_report_evidence as $sre_data)
                @if($sre_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $sre_data->quantity }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_unit_measure != 0)<td class="sp sp_unit_measure" style="white-space: nowrap">
                @foreach($spot_report_evidence as $sre_data)
                @if($sre_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $sre_data->unit_measure }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_packaging != 0)<td class="sp sp_packaging" style="white-space: nowrap">
                @foreach($spot_report_evidence as $sre_data)
                @if($sre_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $sre_data->packaging }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_markings != 0)<td class="sp sp_markings" style="white-space: nowrap">
                @foreach($spot_report_evidence as $sre_data)
                @if($sre_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $sre_data->markings }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_case_type != 0)<td class="sp sp_case_type" style="white-space: nowrap">
                @foreach($spot_report_case as $src_data)
                @if($src_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $src_data->lastname }}, {{ $src_data->firstname }} {{ $src_data->middlename }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_case_type != 0)<td class="sp sp_case_type" style="white-space: nowrap">
                @foreach($spot_report_case as $src_data)
                @if($src_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $src_data->case }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_summary != 0)<td class="sp sp_summary" style="white-space: nowrap">
                @foreach($spot_report_header as $srh_data)
                @if($srh_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srh_data->report_header }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_summary != 0)<td class="sp sp_summary" style="white-space: nowrap">
                @foreach($spot_report_header as $srh_data)
                @if($srh_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srh_data->summary }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($sp_prepared_by != 0)<td class="sp sp_prepared_by" style="white-space: nowrap">
                @foreach($spot_report_header as $srh_data)
                @if($srh_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srh_data->prepared_by }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($pr_suspect_name != 0)<td class="pr pr_suspect_name" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->lastname }}, {{ $srs_data->firstname }} {{ $srs_data->middlename }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($pr_suspect_classification != 0)<td class="pr pr_suspect_classification" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->suspect_classification }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($pr_suspect_status != 0)<td class="pr pr_suspect_status" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->suspect_status }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($pr_drug_test_result != 0)<td class="pr pr_drug_test_result" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->drug_test_result }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($pr_drug_type != 0)<td class="pr pr_drug_type" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->drug_type }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($pr_remarks != 0)<td class="pr pr_remarks" style="white-space: nowrap">
                @foreach($spot_report_suspect as $srs_data)
                @if($srs_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs_data->remarks }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($pr_evidence != 0)<td class="pr pr_evidence" style="white-space: nowrap">
                @foreach($spot_report_evidence as $sre_data)
                @if($sre_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $sre_data->evidence }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($pr_quantity_on_site != 0)<td class="pr pr_quantity_on_site" style="white-space: nowrap">
                @foreach($spot_report_evidence as $sre_data)
                @if($sre_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $sre_data->qty_onsite }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($pr_quantity_on_site != 0)<td class="pr pr_quantity_on_site" style="white-space: nowrap">
                @foreach($spot_report_evidence as $sre_data)
                @if($sre_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $sre_data->actual_qty }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($pr_quantity_on_site != 0)<td class="pr pr_quantity_on_site" style="white-space: nowrap">
                @foreach($spot_report_evidence as $sre_data)
                @if($sre_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $sre_data->unit_measure }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($pr_quantity_on_site != 0)<td class="pr pr_quantity_on_site" style="white-space: nowrap">
                @foreach($spot_report_evidence as $sre_data)
                @if($sre_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $sre_data->drug_test_result }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($pr_quantity_on_site != 0)<td class="pr pr_quantity_on_site" style="white-space: nowrap">
                @foreach($spot_report_evidence as $sre_data)
                @if($sre_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $sre_data->chemist_report_number }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($pr_quantity_on_site != 0)<td class="pr pr_quantity_on_site" style="white-space: nowrap">
                @foreach($spot_report_evidence as $sre_data)
                @if($sre_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $sre_data->laboratory_facility }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($pr_cs_name != 0)<td class="pr pr_cs_name" style="white-space: nowrap">
                @foreach($spot_report_case as $src_data)
                @if($src_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $src_data->lastname }}, {{ $src_data->firstname }} {{ $src_data->middlename }}</span>
                <br>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($pr_case != 0)<td class="pr pr_case" style="white-space: nowrap">
                @foreach($spot_report_case as $src_data)
                @if($src_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $src_data->case }}</span>
                <br>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($pr_docket_number != 0)<td class="pr pr_docket_number" style="white-space: nowrap">
                @foreach($spot_report_case as $src_data)
                @if($src_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $src_data->docket_number }}</span>
                <br>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($pr_case_status != 0)<td class="pr pr_case_status" style="white-space: nowrap">
                @foreach($spot_report_case as $src_data)
                @if($src_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $src_data->case_status }}</span>
                <br>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($pr_case_status != 0)<td class="pr pr_case_status" style="white-space: nowrap">
                @foreach($spot_report_header as $srh_data)
                @if($srh_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srh_data->case_status }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($pr_case_status_date != 0)<td class="pr pr_case_status_date" style="white-space: nowrap">
                @foreach($spot_report_header as $srh_data)
                @if($srh_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srh_data->case_status_date }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($pr_is_number != 0)<td class="pr pr_is_number" style="white-space: nowrap">
                @foreach($spot_report_header as $srh_data)
                @if($srh_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srh_data->is_number }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($pr_procecutor_name != 0)<td class="pr pr_procecutor_name" style="white-space: nowrap">
                @foreach($spot_report_header as $srh_data)
                @if($srh_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srh_data->procecutor_name }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($pr_procecutor_office != 0)<td class="pr pr_procecutor_office" style="white-space: nowrap">
                @foreach($spot_report_header as $srh_data)
                @if($srh_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srh_data->procecutor_office }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($pr_prelim_case_status != 0)<td class="pr pr_prelim_case_status" style="white-space: nowrap">
                @foreach($spot_report_header as $srh_data)
                @if($srh_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srh_data->prelim_case_status }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($pr_prelim_case_date != 0)<td class="pr pr_prelim_case_date" style="white-space: nowrap">
                @foreach($spot_report_header as $srh_data)
                @if($srh_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srh_data->prelim_case_date }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($pr_prelim_is_number != 0)<td class="pr pr_prelim_is_number" style="white-space: nowrap">
                @foreach($spot_report_header as $srh_data)
                @if($srh_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srh_data->prelim_is_number }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($pr_prelim_prosecutor != 0)<td class="pr pr_prelim_prosecutor" style="white-space: nowrap">
                @foreach($spot_report_header as $srh_data)
                @if($srh_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srh_data->prelim_prosecutor }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($pr_prelim_prosecutor_office != 0)<td class="pr pr_prelim_prosecutor_office" style="white-space: nowrap">
                @foreach($spot_report_header as $srh_data)
                @if($srh_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srh_data->prelim_prosecutor_office }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($dv_suspect_name != 0)<td class="dv dv_suspect_name" style="white-space: nowrap">
                @foreach($spot_report_suspect2 as $srs2_data)
                @if($srs2_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs2_data->lastname }}, {{ $srs2_data->firstname }} {{ $srs2_data->middlename }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($dv_listed != 0)<td class="dv dv_listed" style="white-space: nowrap"></td>@endif
            @if($dv_ndis != 0)<td class="dv dv_ndis" style="white-space: nowrap">
                @foreach($spot_report_suspect2 as $srs2_data)
                @if($srs2_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs2_data->ndis_id }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
            @if($dv_remarks != 0)<td class="dv dv_remarks" style="white-space: nowrap">
                @foreach($spot_report_suspect2 as $srs2_data)
                @if($srs2_data->preops_number == $pr_data->preops_number)
                <span style="white-space: nowrap">{{ $srs2_data->remarks }}</span>
                <br>
                @endif
                @endforeach
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>

</table>