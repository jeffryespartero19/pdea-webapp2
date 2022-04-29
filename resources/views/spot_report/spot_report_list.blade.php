@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Spot Report List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="removeCokie();">Home</a></li>
                    <li class="breadcrumb-item active">Spot Report List</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Filter</h3>
        </div>
        <div class="card-body row">
            <div class="form-group col-4" style="margin: 0px;">
                <div>
                    <label for="">Region</label>
                </div>
                <div class="input-group mb-3">
                    <select id="region_c" name="region_c" class="form-control @error('region') is-invalid @enderror">
                        <option value='' disabled selected>Select Option</option>
                        @foreach($region as $rg)
                        <option value="{{ $rg->region_c }}">{{ $rg->abbreviation }} - {{ $rg->region_m }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group col-4" style="margin: 0px;">
                <div>
                    <label for="">Operating Unit</label>
                </div>
                <div class="input-group mb-3">
                    <select id="operating_unit_id" name="operating_unit_id" class="form-control @error('region') is-invalid @enderror">
                        <option value='' disabled selected>Select Option</option>
                        @foreach($operating_unit as $ou)
                        <option value="{{ $ou->id }}">{{ $ou->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group col-4" style="margin: 0px;">
                <div>
                    <label for="">Type of OPN</label>
                </div>
                <div class="input-group mb-3">
                    <select id="operation_type_id" name="operation_type_id" class="form-control @error('region') is-invalid @enderror">
                        <option value='' disabled selected>Select Option</option>
                        @foreach($operation_type as $ot)
                        <option value="{{ $ot->id }}">{{ $ot->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group col-4" style="margin: 0px;">
                <div>
                    <label for="">Operation Date</label>
                </div>
                <div class="input-group mb-3">
                    <input id="operation_date" name="operation_date" type="date" class="form-control @error('operation') is-invalid @enderror" value="{{ old('operation_date') }}" autocomplete="off">
                </div>
            </div>
            <div class="form-group col-4" style="margin: 0px;">
                <div>
                    <label for="">Operation Date To</label>
                </div>
                <div class="input-group mb-3">
                    <input id="operation_date_to" name="operation_date_to" type="date" class="form-control @error('operation') is-invalid @enderror" value="{{ old('operation_date_to') }}" autocomplete="off">
                </div>
            </div>
            <div class="mr-2" style="width: 100%;">
                <a href="{{ route('spot_report_add') }}" class="btn btn-info" style="float: right;">ADD Spot Report</a>
                <button class="btn btn-danger" onClick="window.location.reload();" style="float: right; margin-right:10px">Reset Filter</button>
            </div>
        </div>
    </div>
    <!-- /.card -->

    <div class="card card-info">

        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Spot Report Number</th>
                        <th>Operating Unit</th>
                        <th>Operation Type</th>
                        <th>Operation Date</th>
                        <th>Encoded Date</th>
                        <th>Active</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody id="spot_report_list">
                    @foreach($data as $spot_report)
                    <tr>
                        <td>{{ $spot_report->spot_report_number }}</td>
                        <td>{{ $spot_report->operating_unit }}</td>
                        <td>{{ $spot_report->operation_type }}</td>
                        <td>{{ $spot_report->operation_datetime }}</td>
                        <td>{{ $spot_report->created_at }}</td>
                        <td>{{ $spot_report->status == 1 ? 'Yes' : 'No' }}</td>
                        <td>
                            <center>
                                <a href="{{ url('spot_report_edit/'.$spot_report->id) }}" class="btn btn-info">Edit</a>
                            </center>
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
    $('#region_c').change(function() {
        PreopsFilter();
    });
    $('#operating_unit_id').change(function() {
        PreopsFilter();
    });
    $('#operation_type_id').change(function() {
        PreopsFilter();
    });

    $('#operation_date').change(function() {
        PreopsFilter();
    });

    $('#operation_date_to').change(function() {
        PreopsFilter();
    });

    function PreopsFilter() {
        var region_c = $('#region_c').val();
        var operating_unit_id = $('#operating_unit_id').val();
        var operation_type_id = $('#operation_type_id').val();
        var operation_date = $('#operation_date').val();
        var operation_date_to = $('#operation_date_to').val();



        if (region_c == '' || region_c == null) {
            region_c = 0;
        }
        if (operation_date == '' || operation_date == null) {
            operation_date = 0;
        }
        if (operation_date_to == '' || operation_date_to == null) {
            operation_date_to = 0;
        }
        if (operating_unit_id == '' || operating_unit_id == null) {
            operating_unit_id = 0;
        }
        if (operation_type_id == '' || operation_type_id == null) {
            operation_type_id = 0;
        }
        
        var table = $('#example1').DataTable();

        $.ajax({
            type: "GET",
            url: "/get_spot_report_list/" + region_c +
                "/" + operating_unit_id +
                "/" + operation_type_id +
                "/" + operation_date +
                "/" + operation_date_to,
            fail: function() {
                alert("request failed");
            },
            success: function(data) {
                var data = JSON.parse(data);

                $("#spot_report_list").empty();


                if (data.length > 0) {
                    data.forEach(element => {

                        if (element["status"] == 1) {
                            status = 'Yes';
                        } else {
                            status = 'No';
                        }

                        var details =
                            '<tr>' +
                            '<td>' + element["spot_report_number"] + '</td>' +
                            '<td>' + element["operating_unit_name"] + '</td>' +
                            '<td>' + element["operation_type_name"] + '</td>' +
                            '<td>' + element["operation_datetime"] + '</td>' +
                            '<td>' + element["created_at"] + '</td>' +
                            '<td>' + status + '</td>' +
                            '<td>' +
                            '<center>' +
                            '<a href="/after_operation_report_edit/' + element["id"] + '" class="btn btn-info">Edit</a>' +
                            '</center>' +
                            '</td>' +
                            '</tr>';

                        $("#spot_report_list").append(details);

                    });
                }

            }
        });

        table
            .clear()
            .draw();


    }
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