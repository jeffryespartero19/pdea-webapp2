@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Issuance of Pre-Ops List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="removeCokie();">Home</a></li>
                    <li class="breadcrumb-item active">Issuance of Pre-Ops List</li>
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
            <div class="form-group col-3" style="margin: 0px;">
                <div>
                    <label for="">Region</label>
                </div>
                <div class="input-group mb-3">
                    <select id="ro_code" name="ro_code" class="form-control @error('region') is-invalid @enderror">
                        <option value='' disabled selected>Select Option</option>
                        @foreach($regional_office as $rg)
                        <option value="{{ $rg->ro_code }}">{{ $rg->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group col-3" style="margin: 0px;">
                <div>
                    <label for="">Operating Unit</label>
                </div>
                <div class="input-group mb-3">
                    <select id="operating_unit_id" name="operating_unit_id" class="form-control @error('operating_unit') is-invalid @enderror">
                        <option value='' disabled selected>Select Option</option>
                        @foreach($operating_unit as $ou)
                        <option value="{{ $ou->id }}">{{ $ou->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group col-3" style="margin: 0px;">
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
            <div class="form-group col-3" style="margin: 0px;">
                <div>
                    <label for="">Operation Date</label>
                </div>
                <div class="input-group mb-3">
                    <input id="operation_date" name="operation_date" type="date" class="form-control @error('operation') is-invalid @enderror" value="{{ old('operation_date') }}" autocomplete="off">
                </div>
            </div>
            <div class="mr-2" style="width: 100%;">
                <a href="{{ route('issuance_of_preops_add') }}" class="btn btn-info" style="float: right;">ADD Issuance of Pre-Ops</a>
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
                        <th>Pre-Ops Number</th>
                        <th>Operating Unit</th>
                        <th>Operation Type</th>
                        <th>Operation Date</th>
                        <th>Active</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody id="preops_list">
                    @foreach($data as $preops_header)
                    <tr>
                        <td>{{ $preops_header->preops_number }}</td>
                        <td>{{ $preops_header->operating_unit }}</td>
                        <td>{{ $preops_header->operation_type }}</td>
                        <td>{{ $preops_header->operation_datetime }}</td>
                        <td>{{ $preops_header->status == 1 ? 'Yes' : 'No' }}</td>
                        <td>
                            <center>
                                <a href="{{ url('issuance_of_preops_edit/'.$preops_header->id) }}" class="btn btn-info">Edit</a>
                            </center>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <h6>List of all Issuance of Pre-Ops maintenance data sorted by name.</h6>
        </div>
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

<!-- Set menu to collapse and active -->
@endsection


@section('scripts')

<script>
    $('#ro_code').change(function() {
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

    function PreopsFilter() {
        var ro_code = $('#ro_code').val();
        var operating_unit_id = $('#operating_unit_id').val();
        var operation_type_id = $('#operation_type_id').val();
        var operation_date = $('#operation_date').val();

        

        if (ro_code == '' || ro_code == null) {
            ro_code = 0;
        }
        if (operation_date == '' || operation_date == null) {
            operation_date = 0;
        }
        if (operating_unit_id == '' || operating_unit_id == null) {
            operating_unit_id = 0;
        }
        if (operation_type_id == '' || operation_type_id == null) {
            operation_type_id = 0;
        }


        $.ajax({
            type: "GET",
            url: "/get_preops_list/" + ro_code +
                "/" + operating_unit_id +
                "/" + operation_type_id +
                "/" + operation_date,
            fail: function() {
                alert("request failed");
            },
            success: function(data) {
                var data = JSON.parse(data);

                $("#preops_list").empty();


                if (data.length > 0) {
                    data.forEach(element => {

                        if(element["status"] == 1) {
                            status = 'Yes';
                        } else {
                            status = 'No';
                        }

                        var details =
                            '<tr>' +
                            '<td>' + element["preops_number"] + '</td>' +
                            '<td>' + element["operating_unit_name"] + '</td>' +
                            '<td>' + element["operation_type_name"] + '</td>' +
                            '<td>' + element["operation_datetime"] + '</td>' +
                            '<td>' + status + '</td>' +
                            '<td>' +
                            '<center>' +
                            '<a href="/issuance_of_preops_edit/' + element["id"] + '" class="btn btn-info">Edit</a>' +
                            '</center>' +
                            '</td>' +
                            '</tr>';

                        $("#preops_list").append(details);

                    });
                }

            }
        });

    }
</script>

<script>
    $(function() {
        $('#coc').addClass('menu-open');
    });
    $(function() {
        $('#coc_link').addClass('active');
    });
    $(function() {
        $('#issuance_of_preops').addClass('active');
    });
</script>


@endsection