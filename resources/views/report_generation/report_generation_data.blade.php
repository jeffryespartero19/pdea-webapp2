@php ($current_preops_number = "")
@foreach($issuance_of_preops as $pr_data)

@if ($pr_data->preops_number != $current_preops_number)
@php ($preops_number = $pr_data->preops_number)
@php ($current_preops_number = $preops_number)
@else
@php ($preops_number = "")
@endif

<tr class='details'>
    <td class="po region" style="white-space: nowrap">{{ $pr_data->region }}</td>
    <td class="po preops_number pr_number" style="white-space: nowrap">{{ $preops_number }}</td>
    <td class="po province" style="white-space: nowrap">{{ $pr_data->province_m }}</td>
    <td class="po type_operation" style="white-space: nowrap">{{ $pr_data->operation_type }}</td>
    <td class="po operating_unit" style="white-space: nowrap">{{ $pr_data->operating_unit }}</td>
    <td class="po support_unit" style="white-space: nowrap;"></td>
    <td class="po datetime_coordinate" style="white-space: nowrap">{{ $pr_data->coordinated_datetime }}</td>
    <td class="po datetime_operation" style="white-space: nowrap">{{ $pr_data->operation_datetime }}</td>
    <td class="po valid_until" style="white-space: nowrap">{{ $pr_data->validity }}</td>
    <td class="ao a_area" style="white-space: nowrap;"></td>
    <td class="ao a_area" style="white-space: nowrap;"></td>
    <td class="ao a_area" style="white-space: nowrap;"></td>
    <td class="ao a_area" style="white-space: nowrap;"></td>
    <td class="ao a_area" style="white-space: nowrap;"></td>
    <td class="ao taget_name" style="white-space: nowrap;"> </td>
    <td class="ao taget_name" style="white-space: nowrap;"> </td>
    <td class="ao ot_name" style="white-space: nowrap;"> </td>
    <td class="ao ot_name" style="white-space: nowrap;"> </td>
    <td class="ao ot_name" style="white-space: nowrap;"> </td>
    <td class="ao prepared_by" style="white-space: nowrap">{{ $pr_data->prepared_by }}</td>
    <td class="ao ao_result" style="white-space: nowrap">{{ $pr_data->result }}</td>
    <td class="ao ao_negative_reason" style="white-space: nowrap">{{ $pr_data->negative_reason }}</td>
    <td class="ao ao_illegal_drug" style="white-space: nowrap"></td>
    <td class="ao ao_quantity" style="white-space: nowrap"></td>
    <td class="ao ao_unit_measure" style="white-space: nowrap"></td>
    <td class="ao ao_crn" style="white-space: nowrap"></td>
    <td class="ao ao_date_received" style="white-space: nowrap">
        {{ $pr_data->negative_reason }}
    </td>
    <td class="sp sp_hio" style="white-space: nowrap">
    </td>
    <td class="sp sp_suspect_number" style="white-space: nowrap"></td>
    <td class="sp sp_suspect_status" style="white-space: nowrap"></td>
    <td class="sp sp_lastname" style="white-space: nowrap"></td>
    <td class="sp sp_firstname" style="white-space: nowrap"></td>
    <td class="sp sp_middlename" style="white-space: nowrap"></td>
    <td class="sp sp_alias" style="white-space: nowrap"></td>
    <td class="sp sp_birthdate" style="white-space: nowrap"></td>
    <td class="sp sp_est_birthdate" style="white-space: nowrap"></td>
    <td class="sp sp_birthplace" style="white-space: nowrap"></td>
    <td class="sp sp_region" style="white-space: nowrap"></td>
    <td class="sp sp_province" style="white-space: nowrap"></td>
    <td class="sp sp_city" style="white-space: nowrap"></td>
    <td class="sp sp_barangay" style="white-space: nowrap"></td>
    <td class="sp sp_street" style="white-space: nowrap"></td>
    <td class="sp sp_p_region" style="white-space: nowrap"></td>
    <td class="sp sp_p_province" style="white-space: nowrap"></td>
    <td class="sp sp_p_city" style="white-space: nowrap"></td>
    <td class="sp sp_p_barangay" style="white-space: nowrap"></td>
    <td class="sp sp_p_street" style="white-space: nowrap"></td>
    <td class="sp sp_gender" style="white-space: nowrap"></td>
    <td class="sp sp_civil_status" style="white-space: nowrap"></td>
    <td class="sp sp_nationality" style="white-space: nowrap"></td>
    <td class="sp sp_ethnic_group" style="white-space: nowrap"></td>
    <td class="sp sp_religion" style="white-space: nowrap"></td>
    <td class="sp sp_educational_attainment" style="white-space: nowrap"></td>
    <td class="sp sp_occupation" style="white-space: nowrap"></td>
    <td class="sp sp_classification" style="white-space: nowrap"></td>
    <td class="sp sp_category" style="white-space: nowrap"></td>
    <td class="sp sp_whereabouts" style="white-space: nowrap"></td>
    <td class="sp sp_remarks" style="white-space: nowrap"></td>
    <td class="sp sp_seized_from" style="white-space: nowrap"></td>
    <td class="sp sp_remarks" style="white-space: nowrap"></td>
    <td class="sp sp_drug" style="white-space: nowrap"></td>
    <td class="sp sp_quantity" style="white-space: nowrap"></td>
    <td class="sp sp_unit_measure" style="white-space: nowrap"></td>
    <td class="sp sp_packaging" style="white-space: nowrap"></td>
    <td class="sp sp_markings" style="white-space: nowrap"></td>
    <td class="sp sp_case_type" style="white-space: nowrap"></td>
    <td class="sp sp_case_type" style="white-space: nowrap"></td>
    <td class="sp sp_summary" style="white-space: nowrap"></td>
    <td class="sp sp_summary" style="white-space: nowrap"></td>
    <td class="sp sp_prepared_by" style="white-space: nowrap"></td>
    <td class="pr pr_suspect_name" style="white-space: nowrap"></td>
    <td class="pr pr_suspect_classification" style="white-space: nowrap"></td>
    <td class="pr pr_suspect_status" style="white-space: nowrap"></td>
    <td class="pr pr_drug_test_result" style="white-space: nowrap"></td>
    <td class="pr pr_drug_type" style="white-space: nowrap"></td>
    <td class="pr pr_remarks" style="white-space: nowrap"></td>
    <td class="pr pr_evidence" style="white-space: nowrap"></td>
    <td class="pr pr_quantity_on_site" style="white-space: nowrap"></td>
    <td class="pr pr_quantity_on_site" style="white-space: nowrap"></td>
    <td class="pr pr_quantity_on_site" style="white-space: nowrap"></td>
    <td class="pr pr_quantity_on_site" style="white-space: nowrap"></td>
    <td class="pr pr_quantity_on_site" style="white-space: nowrap"></td>
    <td class="pr pr_quantity_on_site" style="white-space: nowrap"></td>
    <td class="pr pr_cs_name" style="white-space: nowrap"></td>
    <td class="pr pr_case" style="white-space: nowrap"></td>
    <td class="pr pr_docket_number" style="white-space: nowrap"></td>
    <td class="pr pr_case_status" style="white-space: nowrap"></td>
    <td class="pr pr_case_status" style="white-space: nowrap"></td>
    <td class="pr pr_case_status_date" style="white-space: nowrap"></td>
    <td class="pr pr_is_number" style="white-space: nowrap"></td>
    <td class="pr pr_procecutor_name" style="white-space: nowrap"></td>
    <td class="pr pr_procecutor_office" style="white-space: nowrap"></td>
    <td class="pr pr_prelim_case_status" style="white-space: nowrap"></td>
    <td class="pr pr_prelim_case_date" style="white-space: nowrap"></td>
    <td class="pr pr_prelim_is_number" style="white-space: nowrap"></td>
    <td class="pr pr_prelim_prosecutor" style="white-space: nowrap"></td>
    <td class="pr pr_prelim_prosecutor_office" style="white-space: nowrap"></td>
    <td class="dv dv_suspect_name" style="white-space: nowrap"></td>
    <td class="dv dv_listed" style="white-space: nowrap"></td>
    <td class="dv dv_ndis" style="white-space: nowrap"></td>
    <td class="dv dv_remarks" style="white-space: nowrap"></td>
</tr>
@endforeach