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
    <div class="card card-info col-3">
        <div class="card-header">
            <h3 class="card-title">Filter</h3>
        </div>
        <div class="card-body" style="overflow-y: scroll;">
            <h4>COC</h4>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="region" value="option1">
                <label for="region" class="custom-control-label">Region</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="" value="option1">
                <label for="customCheckbox1" class="custom-control-label">Preops Number</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="" value="option1">
                <label for="customCheckbox1" class="custom-control-label">Province</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="" value="option1">
                <label for="customCheckbox1" class="custom-control-label">Type of Operation</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="" value="option1">
                <label for="customCheckbox1" class="custom-control-label">Operating Unit</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="" value="option1">
                <label for="customCheckbox1" class="custom-control-label">Support Unit</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="" value="option1">
                <label for="customCheckbox1" class="custom-control-label">Date/Time Coordinate</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="" value="option1">
                <label for="customCheckbox1" class="custom-control-label">Date/Time Operation</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="" value="option1">
                <label for="customCheckbox1" class="custom-control-label">Valid Until</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="" value="option1">
                <label for="customCheckbox1" class="custom-control-label">Area</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="" value="option1">
                <label for="customCheckbox1" class="custom-control-label">Region</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="" value="option1">
                <label for="customCheckbox1" class="custom-control-label">Province</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="" value="option1">
                <label for="customCheckbox1" class="custom-control-label">City</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="" value="option1">
                <label for="customCheckbox1" class="custom-control-label">Barangay</label>
            </div>
            <br>
            <h5>Target</h5>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="" value="option1">
                <label for="customCheckbox1" class="custom-control-label">Name of Target</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="" value="option1">
                <label for="customCheckbox1" class="custom-control-label">Nationality</label>
            </div>
            <br>
            <h5>Operating Team</h5>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="" value="option1">
                <label for="customCheckbox1" class="custom-control-label">Name</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="" value="option1">
                <label for="customCheckbox1" class="custom-control-label">Position</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="" value="option1">
                <label for="customCheckbox1" class="custom-control-label">Contact</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="" value="option1">
                <label for="customCheckbox1" class="custom-control-label">Prepared By</label>
            </div>
            <hr>
            <h4>After Operations</h4>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="" value="option1">
                <label for="customCheckbox1" class="custom-control-label">Operation Result</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="" value="option1">
                <label for="customCheckbox1" class="custom-control-label">Negative Reason</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="" value="option1">
                <label for="customCheckbox1" class="custom-control-label">Illegal Drug</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="" value="option1">
                <label for="customCheckbox1" class="custom-control-label">Quantity</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="" value="option1">
                <label for="customCheckbox1" class="custom-control-label">Unit Measure</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="" value="option1">
                <label for="customCheckbox1" class="custom-control-label">Chemistry Report Number</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="" value="option1">
                <label for="customCheckbox1" class="custom-control-label">Date Received</label>
            </div>

        </div>
    </div>
    <!-- /.card -->

    <div class="card card-info col-9">

        <div class="card-body" style="overflow-x:auto;">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th class="region">Region</th>
                        <th class="preops_number">Preops Number</th>
                        <th class="province">Province</th>
                        <th class="type_operation">Type Of Operation</th>
                        <th class="operating_unit">Operating Unit</th>
                        <th class="support_unit">Support Unit</th>
                        <th class="datetime_coordinate">Date/Time Coordinate</th>
                        <th class="datetime_operation">Date/Time Operation</th>
                        <th class="valid_until">Valid Until</th>
                        <th class="a_area">Area</th>
                        <th class="a_region">Region</th>
                        <th class="a_province">Province</th>
                        <th class="a_city">City</th>
                        <th class="a_barangay">Barangay</th>
                        <th class="taget_name">Name</th>
                        <th class="target_nationality">Nationality</th>
                        <th class="ot_name">Name</th>
                        <th class="ot_position">Position</th>
                        <th class="ot_contact">Contact</th>
                        <th class="prepared_by">Prepared By</th>
                        <th class="ao_result">Operation Result</th>
                        <th class="ao_negative_reason">Negative Reason</th>
                        <th class="ao_illegal_drug">Illegal Drug</th>
                        <th class="ao_quantity">Quantity</th>
                        <th class="ao_unit_measure">Unit Measure</th>
                        <th class="ao_crn">Chemistry Report Number</th>
                        <th class="ao_date_received">Date Received</th>
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
                </thead>
                <tbody id="spot_report_list">
                    @foreach($data as $spot_report)
                    <tr>
                        <td class="region">Region</td>
                        <td class="preops_number">Preops Number</td>
                        <td class="province">Province</td>
                        <td class="type_operation">Type Of Operation</td>
                        <td class="operating_unit">Operating Unit</td>
                        <td class="support_unit">Support Unit</td>
                        <td class="datetime_coordinate">Date/Time Coordinate</td>
                        <td class="datetime_operation">Date/Time Operation</td>
                        <td class="valid_until">Valid Until</td>
                        <td class="a_area">Area</td>
                        <td class="a_region">Region</td>
                        <td class="a_province">Province</td>
                        <td class="a_city">City</td>
                        <td class="a_barangay">Barangay</td>
                        <td class="taget_name">Name</td>
                        <td class="target_nationality">Nationality</td>
                        <td class="ot_name">Name</td>
                        <td class="ot_position">Position</td>
                        <td class="ot_contact">Contact</td>
                        <td class="prepared_by">Prepared By</td>
                        <td class="ao_result">Operation Result</td>
                        <td class="ao_negative_reason">Negative Reason</td>
                        <td class="ao_illegal_drug">Illegal Drug</td>
                        <td class="ao_quantity">Quantity</td>
                        <td class="ao_unit_measure">Unit Measure</td>
                        <td class="ao_crn">Chemistry Report Number</td>
                        <td class="ao_date_received">Date Received</td>
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
        var isChecked = $(this).is(':checked');
        alert(isChecked);
    });

    // <td class="region">Region</td>
    // <td class="preops_number">Preops Number</td>
    // <td class="province">Province</td>
    // <td class="type_operation">Type Of Operation</td>
    // <td class="operating_unit">Operating Unit</td>
    // <td class="support_unit">Support Unit</td>
    // <td class="datetime_coordinate">Date/Time Coordinate</td>
    // <td class="datetime_operation">Date/Time Operation</td>
    // <td class="valid_until">Valid Until</td>
    // <td class="a_area">Area</td>
    // <td class="a_region">Region</td>
    // <td class="a_province">Province</td>
    // <td class="a_city">City</td>
    // <td class="a_barangay">Barangay</td>
    // <td class="taget_name">Name</td>
    // <td class="target_nationality">Nationality</td>
    // <td class="ot_name">Name</td>
    // <td class="ot_position">Position</td>
    // <td class="ot_contact">Contact</td>
    // <td class="prepared_by">Prepared By</td>
    // <td class="ao_result">Operation Result</td>
    // <td class="ao_negative_reason">Negative Reason</td>
    // <td class="ao_illegal_drug">Illegal Drug</td>
    // <td class="ao_quantity">Quantity</td>
    // <td class="ao_unit_measure">Unit Measure</td>
    // <td class="ao_crn">Chemistry Report Number</td>
    // <td class="ao_date_received">Date Received</td>
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