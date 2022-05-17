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

<!-- Main content -->
<section class="content row">
    <!-- Default box -->
    <div class="card card-info col-2">
        <div class="card-header">
            <h3 class="card-title">Filter</h3>
        </div>
        <div class="card-body" style="overflow-y: scroll; height: 800px">
            <h4>COC</h4>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="region" checked value="option1">
                <label for="region" class="custom-control-label">Region</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" checked id="preops_number" value="option1">
                <label for="preops_number" class="custom-control-label">Preops Number</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" checked id="province" value="option1">
                <label for="province" class="custom-control-label">Province</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" checked id="type_operation" value="option1">
                <label for="type_operation" class="custom-control-label">Type of Operation</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" checked id="operating_unit" value="option1">
                <label for="operating_unit" class="custom-control-label">Operating Unit</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" checked id="support_unit" value="option1">
                <label for="support_unit" class="custom-control-label">Support Unit</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" checked id="datetime_coordinate" value="option1">
                <label for="datetime_coordinate" class="custom-control-label">Date/Time Coordinate</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" checked id="datetime_operation" value="option1">
                <label for="datetime_operation" class="custom-control-label">Date/Time Operation</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" checked id="valid_until" value="option1">
                <label for="valid_until" class="custom-control-label">Valid Until</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" checked id="a_area" value="option1">
                <label for="a_area" class="custom-control-label">Area Operation</label>
            </div>
            <!-- <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" checked id="a_region" value="option1">
                <label for="a_region" class="custom-control-label">Region</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" checked id="a_province" value="option1">
                <label for="a_province" class="custom-control-label">Province</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" checked id="a_city" value="option1">
                <label for="a_city" class="custom-control-label">City</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" checked id="a_barangay" value="option1">
                <label for="a_barangay" class="custom-control-label">Barangay</label>
            </div> -->
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" checked id="taget_name" value="option1">
                <label for="taget_name" class="custom-control-label">Target</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" checked id="ot_name" value="option1">
                <label for="ot_name" class="custom-control-label">Operating Team</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" checked id="prepared_by" value="option1">
                <label for="prepared_by" class="custom-control-label">Prepared By</label>
            </div>
            <hr>
            <h4>After Operations</h4>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="ao_result" checked>
                <label for="ao_result" class="custom-control-label">Operation Result</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="ao_negative_reason" checked>
                <label for="ao_negative_reason" class="custom-control-label">Negative Reason</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="ao_illegal_drug" checked>
                <label for="ao_illegal_drug" class="custom-control-label">Illegal Drug</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="ao_quantity" checked>
                <label for="ao_quantity" class="custom-control-label">Quantity</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="ao_unit_measure" checked>
                <label for="ao_unit_measure" class="custom-control-label">Unit Measure</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="ao_crn" checked>
                <label for="ao_crn" class="custom-control-label">Chemistry Report Number</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="ao_date_received" checked>
                <label for="ao_date_received" class="custom-control-label">Date Received</label>
            </div>

        </div>
    </div>
    <!-- /.card -->

    <div class="card card-info col-10">

        <div class="card-body" style="overflow-x:auto; height: 300px">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th id="IOP" colspan="20" style="white-space: nowrap;  text-align:center; font-size: 30px">Issuance of Pre-Ops</th>
                        <th id="AO" colspan="7" style="white-space: nowrap;  text-align:center; font-size: 30px">After Operations</th>
                        <th id="SR" colspan="43" style="white-space: nowrap;  text-align:center; font-size: 30px">Spot Report</th>
                        <!-- <th class="a_area" rowspan="2" style="white-space: nowrap">Area</th>
                        <th class="a_region" rowspan="2" style="white-space: nowrap">Region</th>
                        <th class="a_province" rowspan="2" style="white-space: nowrap">Province</th>
                        <th class="a_city" rowspan="2" style="white-space: nowrap">City</th>
                        <th class="a_barangay" rowspan="2" style="white-space: nowrap">Barangay</th> -->

                        <!-- <th class="sample">Sample</th>
                        <th class="sample">Sample</th>
                        <th class="sample">Sample</th>
                        <th class="sample">Sample</th>
                        <th class="sample">Sample</th>
                        <th class="sample">Sample</th>
                        <th class="sample">Sample</th>
                        <th class="sample">Sample</th>
                        <th class="sample">Sample</th>
                        <th class="sample">Sample</th>
                        <th class="sample">Sample</th>
                        <th class="sample">Sample</th>
                        <th class="sample">Sample</th>
                        <th class="sample">Sample</th>
                        <th class="sample">Sample</th> -->
                    </tr>
                    <tr>
                        <th class="region" rowspan="2" style="white-space: nowrap; text-align:center; font-size: 20px; vertical-align : middle;text-align:center;">Region</th>
                        <th class="preops_number" rowspan="2" style="white-space: nowrap; text-align:center; font-size: 20px; vertical-align : middle;text-align:center;">Preops Number</th>
                        <th class="province" rowspan="2" style="white-space: nowrap; text-align:center; font-size: 20px; vertical-align : middle;text-align:center;">Province</th>
                        <th class="type_operation" rowspan="2" style="white-space: nowrap; text-align:center; font-size: 20px; vertical-align : middle;text-align:center;">Type Of Operation</th>
                        <th class="operating_unit" rowspan="2" style="white-space: nowrap; text-align:center; font-size: 20px; vertical-align : middle;text-align:center;">Operating Unit</th>
                        <th class="support_unit" rowspan="2" style="white-space: nowrap; text-align:center; font-size: 20px; vertical-align : middle;text-align:center;">Support Unit</th>
                        <th class="datetime_coordinate" rowspan="2" style="white-space: nowrap; text-align:center; font-size: 20px; vertical-align : middle;text-align:center;">Date/Time Coordinate</th>
                        <th class="datetime_operation" rowspan="2" style="white-space: nowrap; text-align:center; font-size: 20px; vertical-align : middle;text-align:center;">Date/Time Operation</th>
                        <th class="valid_until" rowspan="2" style="white-space: nowrap; text-align:center; font-size: 20px; vertical-align : middle;text-align:center;">Valid Until</th>
                        <th class="a_area" colspan="5" style="white-space: nowrap; text-align:center; font-size: 20px">Area of Operation</th>
                        <th class="taget_name" colspan="2" style="white-space: nowrap;  text-align:center; font-size: 20px">Target</th>
                        <th class="ot_name" colspan="3" style="white-space: nowrap; text-align:center;  font-size: 20px">Operating Team</th>
                        <th class="prepared_by" rowspan="2" style="white-space: nowrap; text-align:center;  font-size: 20px; vertical-align : middle;text-align:center;">Prepared By</th>
                        <th class="ao_result" rowspan="2" style="white-space: nowrap; text-align:center;  font-size: 20px; vertical-align : middle;text-align:center;">Operation Result</th>
                        <th class="ao_negative_reason" rowspan="2" style="white-space: nowrap; text-align:center;  font-size: 20px; vertical-align : middle;text-align:center;">Negative Reason</th>
                        <th class="ao_illegal_drug" rowspan="2" style="white-space: nowrap; text-align:center;  font-size: 20px; vertical-align : middle;text-align:center;">Illegal Drug</th>
                        <th class="ao_quantity" rowspan="2" style="white-space: nowrap; text-align:center;  font-size: 20px; vertical-align : middle;text-align:center;">Quantity</th>
                        <th class="ao_unit_measure" rowspan="2" style="white-space: nowrap; text-align:center;  font-size: 20px; vertical-align : middle;text-align:center;">Unit Measure</th>
                        <th class="ao_crn" rowspan="2" style="white-space: nowrap; text-align:center;  font-size: 20px; vertical-align : middle;text-align:center;">Chemistry Report Number</th>
                        <th class="ao_date_received" rowspan="2" style="white-space: nowrap; text-align:center;  font-size: 20px; vertical-align : middle;text-align:center;">Date Received</th>
                        <th class="high_impact_operation" rowspan="2" style="white-space: nowrap; text-align:center;  font-size: 20px; vertical-align : middle;text-align:center;">High Impact Operation</th>
                        <th class="suspect" colspan="30" style="white-space: nowrap;  text-align:center; font-size: 20px">Suspect</th>
                        <th class="item_seized" colspan="7" style="white-space: nowrap;  text-align:center; font-size: 20px">Item Seized</th>
                        <th class="case_filed" colspan="2" style="white-space: nowrap;  text-align:center; font-size: 20px">Case Filed</th>
                        <th class="summary" colspan="2" style="white-space: nowrap;  text-align:center; font-size: 20px">Summary</th>
                        <th class="prepared_by" rowspan="2" style="white-space: nowrap; text-align:center;  font-size: 20px; vertical-align : middle;text-align:center;">Prepared By</th>
                        <!-- <th class="sample">Sample</th>
                        <th class="sample">Sample</th>
                        <th class="sample">Sample</th>
                        <th class="sample">Sample</th>
                        <th class="sample">Sample</th>
                        <th class="sample">Sample</th>
                        <th class="sample">Sample</th>
                        <th class="sample">Sample</th>
                        <th class="sample">Sample</th>
                        <th class="sample">Sample</th>
                        <th class="sample">Sample</th>
                        <th class="sample">Sample</th>
                        <th class="sample">Sample</th>
                        <th class="sample">Sample</th>
                        <th class="sample">Sample</th> -->
                    </tr>
                    <tr>
                        <th class="a_area" style="white-space: nowrap">Area</th>
                        <th class="a_area" style="white-space: nowrap">Region</th>
                        <th class="a_area" style="white-space: nowrap">Province</th>
                        <th class="a_area" style="white-space: nowrap">City</th>
                        <th class="a_area" style="white-space: nowrap">Barangay</th>
                        <th class="taget_name" style="white-space: nowrap">Name</th>
                        <th class="taget_name" style="white-space: nowrap">Nationality</th>
                        <th class="ot_name" style="white-space: nowrap">Name</th>
                        <th class="ot_name" style="white-space: nowrap">Position</th>
                        <th class="ot_name" style="white-space: nowrap">Contact</th>

                        <th class="ot_name" style="white-space: nowrap">Suspect Number</th>
                        <th class="ot_name" style="white-space: nowrap">Suspect Status</th>
                        <th class="ot_name" style="white-space: nowrap">Last Name</th>
                        <th class="ot_name" style="white-space: nowrap">First Name</th>
                        <th class="ot_name" style="white-space: nowrap">Middle Name</th>
                        <th class="ot_name" style="white-space: nowrap">Alias</th>
                        <th class="ot_name" style="white-space: nowrap">Birthdate</th>
                        <th class="ot_name" style="white-space: nowrap">Estimated Birthdate</th>
                        <th class="ot_name" style="white-space: nowrap">Birth Place</th>
                        <th class="ot_name" style="white-space: nowrap">Region</th>
                        <th class="ot_name" style="white-space: nowrap">Province</th>
                        <th class="ot_name" style="white-space: nowrap">City</th>
                        <th class="ot_name" style="white-space: nowrap">Barangay</th>
                        <th class="ot_name" style="white-space: nowrap">Street</th>
                        <th class="ot_name" style="white-space: nowrap">Permanent Region</th>
                        <th class="ot_name" style="white-space: nowrap">Permanent Province</th>
                        <th class="ot_name" style="white-space: nowrap">Permanent City</th>
                        <th class="ot_name" style="white-space: nowrap">Permanent Barangay</th>
                        <th class="ot_name" style="white-space: nowrap">Permanent Street</th>
                        <th class="ot_name" style="white-space: nowrap">Sex</th>
                        <th class="ot_name" style="white-space: nowrap">Civil Status</th>
                        <th class="ot_name" style="white-space: nowrap">Nationality</th>
                        <th class="ot_name" style="white-space: nowrap">Ethnic Group</th>
                        <th class="ot_name" style="white-space: nowrap">Religion</th>
                        <th class="ot_name" style="white-space: nowrap">Educational Attainment</th>
                        <th class="ot_name" style="white-space: nowrap">Occupation</th>
                        <th class="ot_name" style="white-space: nowrap">Suspect Classification</th>
                        <th class="ot_name" style="white-space: nowrap">Suspect Category</th>
                        <th class="ot_name" style="white-space: nowrap">Whereabouts</th>
                        <th class="ot_name" style="white-space: nowrap">Remarks</th>
                        <th class="ot_name" style="white-space: nowrap">Seized From (Suspect)</th>
                        <th class="ot_name" style="white-space: nowrap">Drug/Non-Drug</th>
                        <th class="ot_name" style="white-space: nowrap">Type of Evidence</th>
                        <th class="ot_name" style="white-space: nowrap">Quantity/Weight</th>
                        <th class="ot_name" style="white-space: nowrap">Unit of Measure</th>
                        <th class="ot_name" style="white-space: nowrap">Packaging</th>
                        <th class="ot_name" style="white-space: nowrap">Markings</th>
                        <th class="ot_name" style="white-space: nowrap">Name of Suspect</th>
                        <th class="ot_name" style="white-space: nowrap">Case(s) Filed</th>
                        <th class="ot_name" style="white-space: nowrap">Report Header</th>
                        <th class="ot_name" style="white-space: nowrap">Summary</th>

                    </tr>
                </thead>
                <tbody id="spot_report_list">
                    @php ($current_preops_number = "")
                    @foreach($issuance_of_preops as $issuance_of_preops)

                    @if ($issuance_of_preops->preops_number != $current_preops_number)
                    @php ($preops_number = $issuance_of_preops->preops_number)
                    @php ($current_preops_number = $preops_number)
                    @php ($region = $issuance_of_preops->region)
                    @else
                    @php ($preops_number = "")
                    @php ($region = "")
                    @endif

                    <tr>
                        <td class="region" style="white-space: nowrap">{{ $region }}</td>
                        <td class="preops_number" style="white-space: nowrap">{{ $preops_number }}</td>
                        <td class="province" style="white-space: nowrap">{{ $issuance_of_preops->province_m }}</td>
                        <td class="type_operation" style="white-space: nowrap">{{ $issuance_of_preops->operation_type }}</td>
                        <td class="operating_unit" style="white-space: nowrap">{{ $issuance_of_preops->operating_unit }}</td>
                        <td class="support_unit" style="white-space: nowrap">{{ $issuance_of_preops->support_unit }}</td>
                        <td class="datetime_coordinate" style="white-space: nowrap">{{ $issuance_of_preops->coordinated_datetime }}</td>
                        <td class="datetime_operation" style="white-space: nowrap">{{ $issuance_of_preops->operation_datetime }}</td>
                        <td class="valid_until" style="white-space: nowrap">{{ $issuance_of_preops->validity }}</td>
                        <td class="a_area" style="white-space: nowrap">
                            @foreach($preops_area as $pa)
                            @if ($pa->preops_number == $issuance_of_preops->preops_number)
                            {{ $pa->a_area }}
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="a_area" style="white-space: nowrap"> @foreach($preops_area as $pa)
                            @if ($pa->preops_number == $issuance_of_preops->preops_number)
                            {{ $pa->a_region_m}}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="a_area" style="white-space: nowrap"> @foreach($preops_area as $pa)
                            @if ($pa->preops_number == $issuance_of_preops->preops_number)
                            {{ $pa->a_province_m }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="a_area" style="white-space: nowrap"> @foreach($preops_area as $pa)
                            @if ($pa->preops_number == $issuance_of_preops->preops_number)
                            {{ $pa->a_city_m }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="a_area" style="white-space: nowrap"> @foreach($preops_area as $pa)
                            @if ($pa->preops_number == $issuance_of_preops->preops_number)
                            {{ $pa->a_barangay_m }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="taget_name" style="white-space: nowrap"> @foreach($preops_target as $pt)
                            @if ($pt->preops_number == $issuance_of_preops->preops_number)
                            {{ $pt->name }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="taget_name" style="white-space: nowrap">@foreach($preops_target as $pt)
                            @if ($pt->preops_number == $issuance_of_preops->preops_number)
                            {{ $pt->nationality }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="ot_name" style="white-space: nowrap">@foreach($preops_team as $ptm)
                            @if ($ptm->preops_number == $issuance_of_preops->preops_number)
                            {{ $ptm->name }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="ot_name" style="white-space: nowrap">@foreach($preops_team as $ptm)
                            @if ($ptm->preops_number == $issuance_of_preops->preops_number)
                            {{ $ptm->position }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="ot_name" style="white-space: nowrap">@foreach($preops_team as $ptm)
                            @if ($ptm->preops_number == $issuance_of_preops->preops_number)
                            {{ $ptm->contact }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="prepared_by" style="white-space: nowrap">{{ $issuance_of_preops->prepared_by }}</td>
                        <td class="ao_result" style="white-space: nowrap">{{ $issuance_of_preops->result }}</td>
                        <td class="ao_negative_reason" style="white-space: nowrap">{{ $issuance_of_preops->negative_reason }}</td>
                        <td class="ao_illegal_drug" style="white-space: nowrap">@foreach($after_operations_evidence as $aoe)
                            @if ($aoe->preops_number == $issuance_of_preops->preops_number)
                            {{ $aoe->evidence }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="ao_quantity" style="white-space: nowrap">@foreach($after_operations_evidence as $aoe)
                            @if ($aoe->preops_number == $issuance_of_preops->preops_number)
                            {{ $aoe->quantity }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="ao_unit_measure" style="white-space: nowrap">@foreach($after_operations_evidence as $aoe)
                            @if ($aoe->preops_number == $issuance_of_preops->preops_number)
                            {{ $aoe->unit }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="ao_crn" style="white-space: nowrap">@foreach($after_operations_evidence as $aoe)
                            @if ($aoe->preops_number == $issuance_of_preops->preops_number)
                            {{ $aoe->chemist_report_number }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="ao_date_received" style="white-space: nowrap">{{ $issuance_of_preops->received_date }}</td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_header as $sph)
                            @if ($sph->preops_number == $issuance_of_preops->preops_number)
                            @if ($sph->operation_lvl == 1)
                            Yes&nbsp;
                            <br> <br>
                            @else
                            No&nbsp;
                            <br> <br>
                            @endif
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_suspect as $sps)
                            @if ($sps->preops_number == $issuance_of_preops->preops_number)
                            {{ $sps->suspect_number }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_suspect as $sps)
                            @if ($sps->preops_number == $issuance_of_preops->preops_number)
                            {{ $sps->suspect_status }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_suspect as $sps)
                            @if ($sps->preops_number == $issuance_of_preops->preops_number)
                            {{ $sps->lastname }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_suspect as $sps)
                            @if ($sps->preops_number == $issuance_of_preops->preops_number)
                            {{ $sps->firstname }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_suspect as $sps)
                            @if ($sps->preops_number == $issuance_of_preops->preops_number)
                            {{ $sps->middlename }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_suspect as $sps)
                            @if ($sps->preops_number == $issuance_of_preops->preops_number)
                            {{ $sps->alias }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_suspect as $sps)
                            @if ($sps->preops_number == $issuance_of_preops->preops_number)
                            {{ $sps->birthdate }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_suspect as $sps)
                            @if ($sps->preops_number == $issuance_of_preops->preops_number)
                            @if ($sps->est_birthdate == 1)
                            Yes&nbsp;
                            <br> <br>
                            @else
                            No&nbsp;
                            <br> <br>
                            @endif
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_suspect as $sps)
                            @if ($sps->preops_number == $issuance_of_preops->preops_number)
                            {{ $sps->birthplace }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_suspect as $sps)
                            @if ($sps->preops_number == $issuance_of_preops->preops_number)
                            {{ $sps->s_region }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_suspect as $sps)
                            @if ($sps->preops_number == $issuance_of_preops->preops_number)
                            {{ $sps->s_province }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_suspect as $sps)
                            @if ($sps->preops_number == $issuance_of_preops->preops_number)
                            {{ $sps->s_city }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_suspect as $sps)
                            @if ($sps->preops_number == $issuance_of_preops->preops_number)
                            {{ $sps->s_barangay }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_suspect as $sps)
                            @if ($sps->preops_number == $issuance_of_preops->preops_number)
                            {{ $sps->street }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_suspect as $sps)
                            @if ($sps->preops_number == $issuance_of_preops->preops_number)
                            {{ $sps->p_region }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_suspect as $sps)
                            @if ($sps->preops_number == $issuance_of_preops->preops_number)
                            {{ $sps->p_province }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_suspect as $sps)
                            @if ($sps->preops_number == $issuance_of_preops->preops_number)
                            {{ $sps->p_city }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_suspect as $sps)
                            @if ($sps->preops_number == $issuance_of_preops->preops_number)
                            {{ $sps->p_barangay }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_suspect as $sps)
                            @if ($sps->preops_number == $issuance_of_preops->preops_number)
                            {{ $sps->permanent_street }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_suspect as $sps)
                            @if ($sps->preops_number == $issuance_of_preops->preops_number)
                            {{ $sps->gender }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_suspect as $sps)
                            @if ($sps->preops_number == $issuance_of_preops->preops_number)
                            {{ $sps->civil_status }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_suspect as $sps)
                            @if ($sps->preops_number == $issuance_of_preops->preops_number)
                            {{ $sps->nationality }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_suspect as $sps)
                            @if ($sps->preops_number == $issuance_of_preops->preops_number)
                            {{ $sps->ethnic_group }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_suspect as $sps)
                            @if ($sps->preops_number == $issuance_of_preops->preops_number)
                            {{ $sps->religion }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_suspect as $sps)
                            @if ($sps->preops_number == $issuance_of_preops->preops_number)
                            {{ $sps->educational_attainment }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_suspect as $sps)
                            @if ($sps->preops_number == $issuance_of_preops->preops_number)
                            {{ $sps->occupation }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_suspect as $sps)
                            @if ($sps->preops_number == $issuance_of_preops->preops_number)
                            {{ $sps->suspect_classification }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_suspect as $sps)
                            @if ($sps->preops_number == $issuance_of_preops->preops_number)
                            {{ $sps->suspect_category }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_suspect as $sps)
                            @if ($sps->preops_number == $issuance_of_preops->preops_number)
                            {{ $sps->whereabouts }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        <td class="hio" style="white-space: nowrap">@foreach($spot_report_suspect as $sps)
                            @if ($sps->preops_number == $issuance_of_preops->preops_number)
                            {{ $sps->remarks }}&nbsp;
                            <br> <br>
                            @else
                            @endif
                            @endforeach
                        </td>
                        
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <h6>List of all Spot Report maintenance data sorted by name.</h6>
        </div>
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

<!-- Set menu to collapse and active -->
@endsection

@section('scripts')

<script>
    $(document).on('click', '#region', function() {
        if ($(this).is(":checked")) {
            $('.region').attr('hidden', false);
            $iop = $('#IOP').prop("colspan") + 1;
            $('#IOP').prop("colspan", $iop)
        } else {
            $('.region').attr('hidden', true);
            $iop = $('#IOP').prop("colspan") - 1;
            $('#IOP').prop("colspan", $iop)
        }
    });
    $(document).on('click', '#preops_number', function() {
        if ($(this).is(":checked")) {
            $('.preops_number').attr('hidden', false);
            $iop = $('#IOP').prop("colspan") + 1;
            $('#IOP').prop("colspan", $iop)
        } else {
            $('.preops_number').attr('hidden', true);
            $iop = $('#IOP').prop("colspan") - 1;
            $('#IOP').prop("colspan", $iop)
        }
    });
    $(document).on('click', '#province', function() {
        if ($(this).is(":checked")) {
            $('.province').attr('hidden', false);
            $iop = $('#IOP').prop("colspan") + 1;
            $('#IOP').prop("colspan", $iop)
        } else {
            $('.province').attr('hidden', true);
            $iop = $('#IOP').prop("colspan") - 1;
            $('#IOP').prop("colspan", $iop)
        }
    });
    $(document).on('click', '#type_operation', function() {
        if ($(this).is(":checked")) {
            $('.type_operation').attr('hidden', false);
            $iop = $('#IOP').prop("colspan") + 1;
            $('#IOP').prop("colspan", $iop)
        } else {
            $('.type_operation').attr('hidden', true);
            $iop = $('#IOP').prop("colspan") - 1;
            $('#IOP').prop("colspan", $iop)
        }
    });
    $(document).on('click', '#operating_unit', function() {
        if ($(this).is(":checked")) {
            $('.operating_unit').attr('hidden', false);
            $iop = $('#IOP').prop("colspan") + 1;
            $('#IOP').prop("colspan", $iop)
        } else {
            $('.operating_unit').attr('hidden', true);
            $iop = $('#IOP').prop("colspan") - 1;
            $('#IOP').prop("colspan", $iop)
        }
    });
    $(document).on('click', '#support_unit', function() {
        if ($(this).is(":checked")) {
            $('.support_unit').attr('hidden', false);
            $iop = $('#IOP').prop("colspan") + 1;
            $('#IOP').prop("colspan", $iop)
        } else {
            $('.support_unit').attr('hidden', true);
            $iop = $('#IOP').prop("colspan") - 1;
            $('#IOP').prop("colspan", $iop)
        }
    });
    $(document).on('click', '#datetime_coordinate', function() {
        if ($(this).is(":checked")) {
            $('.datetime_coordinate').attr('hidden', false);
            $iop = $('#IOP').prop("colspan") + 1;
            $('#IOP').prop("colspan", $iop)
        } else {
            $('.datetime_coordinate').attr('hidden', true);
            $iop = $('#IOP').prop("colspan") - 1;
            $('#IOP').prop("colspan", $iop)
        }
    });
    $(document).on('click', '#datetime_operation', function() {
        if ($(this).is(":checked")) {
            $('.datetime_operation').attr('hidden', false);
            $iop = $('#IOP').prop("colspan") + 1;
            $('#IOP').prop("colspan", $iop)
        } else {
            $('.datetime_operation').attr('hidden', true);
            $iop = $('#IOP').prop("colspan") - 1;
            $('#IOP').prop("colspan", $iop)
        }
    });
    $(document).on('click', '#valid_until', function() {
        if ($(this).is(":checked")) {
            $('.valid_until').attr('hidden', false);
            $iop = $('#IOP').prop("colspan") + 1;
            $('#IOP').prop("colspan", $iop)
        } else {
            $('.valid_until').attr('hidden', true);
            $iop = $('#IOP').prop("colspan") - 1;
            $('#IOP').prop("colspan", $iop)
        }
    });
    $(document).on('click', '#a_area', function() {
        if ($(this).is(":checked")) {
            $('.a_area').attr('hidden', false);
            $iop = $('#IOP').prop("colspan") + 5;
            $('#IOP').prop("colspan", $iop)
        } else {
            $('.a_area').attr('hidden', true);
            $iop = $('#IOP').prop("colspan") - 5;
            $('#IOP').prop("colspan", $iop)
        }
    });
    // $(document).on('click', '#a_region', function() {
    //     if ($(this).is(":checked")) {
    //         $('.a_region').attr('hidden', false);
    //     } else {
    //         $('.a_region').attr('hidden', true);
    //     }
    // });
    // $(document).on('click', '#a_province', function() {
    //     if ($(this).is(":checked")) {
    //         $('.a_province').attr('hidden', false);
    //     } else {
    //         $('.a_province').attr('hidden', true);
    //     }
    // });
    // $(document).on('click', '#a_city', function() {
    //     if ($(this).is(":checked")) {
    //         $('.a_city').attr('hidden', false);
    //     } else {
    //         $('.a_city').attr('hidden', true);
    //     }
    // });
    // $(document).on('click', '#a_barangay', function() {
    //     if ($(this).is(":checked")) {
    //         $('.a_barangay').attr('hidden', false);
    //     } else {
    //         $('.a_barangay').attr('hidden', true);
    //     }
    // });
    $(document).on('click', '#taget_name', function() {
        if ($(this).is(":checked")) {
            $('.taget_name').attr('hidden', false);
            $iop = $('#IOP').prop("colspan") + 1;
            $('#IOP').prop("colspan", $iop)
        } else {
            $('.taget_name').attr('hidden', true);
            $iop = $('#IOP').prop("colspan") - 1;
            $('#IOP').prop("colspan", $iop)
        }
    });
    $(document).on('click', '#target_nationality', function() {
        if ($(this).is(":checked")) {
            $('.target_nationality').attr('hidden', false);
            $iop = $('#IOP').prop("colspan") + 1;
            $('#IOP').prop("colspan", $iop)
        } else {
            $('.target_nationality').attr('hidden', true);
            $iop = $('#IOP').prop("colspan") - 1;
            $('#IOP').prop("colspan", $iop)
        }
    });
    $(document).on('click', '#ot_name', function() {
        if ($(this).is(":checked")) {
            $('.ot_name').attr('hidden', false);
            $iop = $('#IOP').prop("colspan") + 1;
            $('#IOP').prop("colspan", $iop)
        } else {
            $('.ot_name').attr('hidden', true);
            $iop = $('#IOP').prop("colspan") - 1;
            $('#IOP').prop("colspan", $iop)
        }
    });
    $(document).on('click', '#prepared_by', function() {
        if ($(this).is(":checked")) {
            $('.prepared_by').attr('hidden', false);
            $iop = $('#IOP').prop("colspan") + 1;
            $('#IOP').prop("colspan", $iop)
        } else {
            $('.prepared_by').attr('hidden', true);
            $iop = $('#IOP').prop("colspan") - 1;
            $('#IOP').prop("colspan", $iop)
        }
    });
    $(document).on('click', '#ao_result', function() {
        if ($(this).is(":checked")) {
            $('.ao_result').attr('hidden', false);
            $iop = $('#AO').prop("colspan") + 1;
            $('#AO').prop("colspan", $iop)
        } else {
            $('.ao_result').attr('hidden', true);
            $iop = $('#AO').prop("colspan") - 1;
            $('#AO').prop("colspan", $iop)
        }
    });
    $(document).on('click', '#ao_negative_reason', function() {
        if ($(this).is(":checked")) {
            $('.ao_negative_reason').attr('hidden', false);
            $iop = $('#AO').prop("colspan") + 1;
            $('#AO').prop("colspan", $iop)
        } else {
            $('.ao_negative_reason').attr('hidden', true);
            $iop = $('#AO').prop("colspan") - 1;
            $('#AO').prop("colspan", $iop)
        }
    });
    $(document).on('click', '#ao_illegal_drug', function() {
        if ($(this).is(":checked")) {
            $('.ao_illegal_drug').attr('hidden', false);
            $iop = $('#AO').prop("colspan") + 1;
            $('#AO').prop("colspan", $iop)
        } else {
            $('.ao_illegal_drug').attr('hidden', true);
            $iop = $('#AO').prop("colspan") - 1;
            $('#AO').prop("colspan", $iop)
        }
    });
    $(document).on('click', '#ao_quantity', function() {
        if ($(this).is(":checked")) {
            $('.ao_quantity').attr('hidden', false);
            $iop = $('#AO').prop("colspan") + 1;
            $('#AO').prop("colspan", $iop)
        } else {
            $('.ao_quantity').attr('hidden', true);
            $iop = $('#AO').prop("colspan") - 1;
            $('#AO').prop("colspan", $iop)
        }
    });
    $(document).on('click', '#ao_unit_measure', function() {
        if ($(this).is(":checked")) {
            $('.ao_unit_measure').attr('hidden', false);
            $iop = $('#AO').prop("colspan") + 1;
            $('#AO').prop("colspan", $iop)
        } else {
            $('.ao_unit_measure').attr('hidden', true);
            $iop = $('#AO').prop("colspan") - 1;
            $('#AO').prop("colspan", $iop)
        }
    });
    $(document).on('click', '#ao_crn', function() {
        if ($(this).is(":checked")) {
            $('.ao_crn').attr('hidden', false);
            $iop = $('#AO').prop("colspan") + 1;
            $('#AO').prop("colspan", $iop)
        } else {
            $('.ao_crn').attr('hidden', true);
            $iop = $('#AO').prop("colspan") - 1;
            $('#AO').prop("colspan", $iop)
        }
    });
    $(document).on('click', '#ao_date_received', function() {
        if ($(this).is(":checked")) {
            $('.ao_date_received').attr('hidden', false);
            $iop = $('#AO').prop("colspan") + 1;
            $('#AO').prop("colspan", $iop)
        } else {
            $('.ao_date_received').attr('hidden', true);
            $iop = $('#AO').prop("colspan") - 1;
            $('#AO').prop("colspan", $iop)
        }
    });
</script>

<script>
    $(function() {
        $('#sap').addClass('menu-open');
    });
    $(function() {
        $('#sap_link').addClass('active');
    });
    $(function() {
        $('#spot_report').addClass('active');
    });
</script>


@endsection