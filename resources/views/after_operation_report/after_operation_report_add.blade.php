@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add After Operation Report</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="removeCokie();">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('after_operation_report_list') }}">After Operation
                            Report List</a></li>
                    <li class="breadcrumb-item active">Add After Operation Report</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    @if($errors->any())
    @foreach ($errors->all() as $error)
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-ban"></i> Error!</h5>
        {{ $error }}
    </div>
    @endforeach
    @endif

    @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-check"></i> Success!</h5>
        {{ session()->get('success') }}
    </div>
    @endif
    <!-- Default box -->
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Add After Operation Report</h3>
        </div>
        <div class="card-body">
            <form action="/after_operation_report_add" role="form" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-5" style="margin: 0px;">
                        <div>
                            <label for="">Pre-Ops Control Number</label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="preops_number" name="preops_number" class="form-control PreopsSearch"
                                style="width: 100%;" required>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-5" style="margin: 0px;">
                        <div>
                            <label for="">Region</label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="ro_code" name="ro_code" class="form-control"
                                style="pointer-events: none; background-color : #e9ecef;" required>
                                <option value='' disabled selected>Select Option</option>
                                @foreach($regional_office as $rg)
                                <option value="{{$rg->ro_code}}">{{ $rg->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-5" style="margin: 0px;">
                        <div>
                            <label for="">Date Reported</label>
                        </div>
                        <div class="input-group mb-3">
                            <?php date_default_timezone_set('Asia/Manila'); ?>
                            <input id="date_reported" name="date_reported" type="date" class="form-control"
                                value="<?php echo date('Y-m-d'); ?>"
                                style="pointer-events: none; background-color : #e9ecef;" required>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="form-group col-5" style="margin: 0px;">
                        <div>
                            <label for="">Operating Unit</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="operating_unit" type="text" class="form-control"
                                style="pointer-events: none; background-color : #e9ecef;">
                        </div>
                    </div>
                    <div class="form-group col-5" style="margin: 0px;">
                        <div>
                            <label for="">Type of OPN</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="operation_type_id" type="text" class="form-control"
                                style="pointer-events: none; background-color : #e9ecef;" hidden>
                            <input id="operation_type" type="text" class="form-control"
                                style="pointer-events: none; background-color : #e9ecef;">
                        </div>
                    </div>
                    <div class="form-group col-5" style="margin: 0px;">
                        <div>
                            <label for="">Duration From</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="duration_from" name="duration_from" type="text" class="form-control"
                                style="pointer-events: none; background-color : #e9ecef;">
                        </div>
                    </div>
                    <div class="form-group col-5" style="margin: 0px;">
                        <div>
                            <label for="">Duration To</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="duration_to" name="duration_to" type="text" class="form-control"
                                style="pointer-events: none; background-color : #e9ecef;">
                        </div>
                    </div>
                    <div class="form-group col-5" style="margin: 0px;">
                        <div>
                            <label for="">Result</label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="result" name="result" class="form-control @error('result') is-invalid @enderror"
                                value="{{ old('result') }}" required>
                                <option value='' selected>Select Option
                                </option>
                                <option value="positive">
                                    Positive
                                </option>
                                <option value="negative">
                                    Negative
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row ISdetails" hidden>
                    <div class="col-12 col-sm-12">
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                    <a class="nav-link active" id="custom-tabs-four-drugseized-tab" data-toggle="pill"
                                        href="#custom-tabs-four-drugseized" role="tab"
                                        aria-controls="custom-tabs-four-drugseized" aria-selected="false">Item
                                        Seized</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-four-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-four-drugseized"
                                        role="tabpanel" aria-labelledby="custom-tabs-four-drugseized-tab">
                                        <div class="form-group col-12" style="padding: 0 5px;" id="siblingTBL">
                                            <div class="card table-responsive p-0">
                                                <table id="drug_seized" class="table table-hover text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th style="color: gray;">Illegal Drug</th>
                                                            <th style="color: gray;">Quantity</th>
                                                            <th style="color: gray;">Unit Measure</th>
                                                            <th style="color: gray;">Chemistry Report Number</th>
                                                            <th style="color: gray;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="evidence_details">
                                                        <tr class="evidence_info">
                                                            <td style="width: 300px;">
                                                                <select name="evidence_id[]"
                                                                    class="form-control evidence_id">
                                                                    <option value='' selected>None
                                                                    </option>
                                                                    @foreach ($evidence as $ev)
                                                                    <option value="{{ $ev->id }}">
                                                                        {{ $ev->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td style="width: 200px;"><input type="text"
                                                                    class="form-control" name="quantity[]"></td>
                                                            <td>
                                                                <select name="unit_measurement_id[]"
                                                                    class="form-control"
                                                                    style="pointer-events: none; background-color : #e9ecef;">
                                                                    <option value='' selected>None
                                                                    </option>
                                                                    @foreach ($unit_measurement as $um)
                                                                    <option value="{{ $um->id }}">
                                                                        {{ $um->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    name="chemist_report_number[]"></td>
                                                            <td class="mt-10"><button type="button"
                                                                    class="badge badge-danger"><i
                                                                        class="fa fa-trash"></i> Delete</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="text-center"><button type="button"
                                                    class="badge badge-success addItems"><i class="fa fa-plus"></i> ADD
                                                    NEW</button></div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="form-group col-7 NReason" style="margin: 0px;" hidden>
                        <div>
                            <label for="">Reason</label>
                        </div>
                        <div class="input-group mb-3">
                            <select name="negative_reason_id" class="form-control">
                                <option value='' selected>None
                                </option>
                                @foreach ($negative_reason as $um)
                                <option value="{{ $um->id }}">
                                    {{ $um->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-7" style="margin: 0px;">
                        <div>
                            <label for="">Date Received</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="received_date" name="received_date" type="datetime-local"
                                class="form-control @error('date received') is-invalid @enderror"
                                value="{{ old('received_date') }}" required>
                        </div>
                    </div>
                    <div class="form-group col-7" style="margin: 0px;">
                        <div>
                            <label for="">Reference File</label>
                        </div>
                        <div class="custom-file">
                            <input type="file" name="fileattach[]" class="custom-file-input" id="fileattach" multiple />
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-5">
                    <button type="submit" class="btn btn-primary">Save After Operation Report</button>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <h6>Create After Operation Report maintenance data.</h6>
        </div>
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

<!-- Set menu to collapse and active -->
@endsection

@section('scripts')
<script>
    $("#preops_number").on("change", function() {

        var preops_number = $(this).val();

        $.ajax({
            type: "GET",
            url: "/get_preops_header/" + preops_number,
            fail: function() {
                alert("request failed");
            },
            success: function(data) {
                var data = JSON.parse(data);

                data.forEach(element => {
                    $("#ro_code option[value=" + element["ro_code"] + "]").attr("selected", "selected");
                    $("#operating_unit").val(element["operating_unit_name"]);
                    $("#operation_type").val(element["operation_type_name"]);
                    $("#operation_type_id").val(element["operation_type_id"]);
                    $("#duration_from").val(element["operation_datetime"]);
                    $("#duration_to").val(element["validity"]);
                });
            }
        });
    });

    var items_row = 0;

    $(document).ready(function() {
        $(document).on("click", ".addItems", function() {
            html = '<tr class="evidence_info" id="items-row' + items_row + '">';
            html += '<td><select required name="evidence_id[]" class="form-control evidence_id"><option value="0" selected>None</option>@foreach ($evidence as $ev)<option value="{{ $ev->id }}">{{ $ev->name }}</option>@endforeach</select></td>';
            html += '<td><input type="text" class="form-control" name="quantity"[]></td>';
            html += '<td><select required name="unit_measurement_id[]" class="form-control" style="pointer-events: none; background-color : #e9ecef;"><option value="0" selected>None</option>@foreach ($unit_measurement as $um)<option value="{{ $um->id }}">{{ $um->name }}</option>@endforeach</select></td>';
            html += '<td><input type="text" class="form-control" name="chemist_report_number[]"></td>';
            html += '<td class="mt-10"><button class="badge badge-danger" onclick="$(\'#items-row' + items_row + '\').remove();"><i class="fa fa-trash"></i> Delete</button></td>';

            html += '</tr>';

            $('#drug_seized tbody').append(html);

            items_row++;
        });

        $(".PreopsSearch").select2({
            minimumInputLength: 2,
            ajax: {
                url: '/ao_search_preops_number',
                dataType: "json",
            }
        })
    });

    $("#result").on("change", function() {

        var result = $(this).val();
        var operation_type_id = $("#operation_type_id").val();

        $.ajax({
            type: "GET",
            url: "/get_operation_type/" + operation_type_id,
            fail: function() {
                alert("request failed");
            },
            success: function(data) {
                var data = JSON.parse(data);

                data.forEach(element => {
                    var is_testbuy = element["is_testbuy"];
                    if (result == 'positive' && is_testbuy == '1') {
                        $(".ISdetails").attr('hidden', false);
                        $(".NReason").attr('hidden', true);
                    } else if (result == 'positive' && is_testbuy == '0') {
                        $(".ISdetails").attr('hidden', true);
                        $(".NReason").attr('hidden', true);
                    } else {
                        $(".ISdetails").attr('hidden', true);
                        $(".NReason").attr('hidden', false);
                    }
                });

            }
        });


    });

    //Populate Unit Measurement
    $(document).on("change", ".evidence_id", function() {
        var evidence_id = $(this).val();
        var $row = $(this).closest(".evidence_info");

        $.ajax({
            type: "GET",
            url: "/get_unit_measure/" + evidence_id,
            fail: function() {
                alert("request failed");
            },
            success: function(data) {
                var data = JSON.parse(data);

                $($row.find('td:eq(2) option')).removeAttr('selected');

                data.forEach(element => {
                    $($row.find('td:eq(2) option[value=' + element["id"] + ']')).attr('selected', 'selected');
                });
            }
        });
    });
</script>

<script>
    $(function() {
        $('#coc').addClass('menu-open');
    });
    $(function() {
        $('#coc_link').addClass('active');
    });
    $(function() {
        $('#after_operation_report').addClass('active');
    });
</script>
@endsection