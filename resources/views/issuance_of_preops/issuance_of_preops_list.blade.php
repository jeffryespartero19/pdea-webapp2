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
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Filter</h3>
        </div>
        <div class="card-body row">
            <div class="form-group col-4" style="margin: 0px;">
                <div>
                    <label for="">Region</label>
                </div>
                <div class="input-group mb-3">
                    <select id="ro_code" name="ro_code" class="form-control @error('region') is-invalid @enderror">
                        <option value='' disabled selected>Select Option</option>
                        @foreach($regional_office as $rg)
                        <option value="{{ $rg->ro_code }}" @isset($ro_code) {{ $rg->ro_code == $ro_code ? 'selected' : '' }} @endisset>{{ $rg->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group col-4" style="margin: 0px;">
                <div>
                    <label for="">Operating Unit</label>
                </div>
                <div class="input-group mb-3">
                    <select id="operating_unit_id" name="operating_unit_id" class="form-control OPUnitSearch">
                        <!-- <option value='' disabled selected>Select Option</option>
                        @foreach($operating_unit as $ou)
                        <option value="{{ $ou->id }}">{{ $ou->description }}</option>
                        @endforeach -->
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
                    <label for="">Operation Date From</label>
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
                <a href="{{ route('issuance_of_preops_add') }}" class="btn btn-info" style="float: right;">ADD Issuance of Pre-Ops</a>
                <button class="btn btn-danger" onClick="window.location.reload();" style="float: right; margin-right:10px">Reset Filter</button>
            </div>
            <input type="text" id="datepicker" hidden>
        </div>
    </div>
    <!-- /.card -->

    <div class="card card-success">


        <div class="card-body">
            <form action="/search_preops" method="GET" role="search" id="SearchForm">
                {{ csrf_field() }}
                <div class="input-group">
                    <input type="text" class="form-control" name="q" placeholder="Search Preops"> <span class="input-group-btn">
                        <button type="button" class="btn btn-default submit_search">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </form>
            <br>
            <div id="tag_container">
                @include('issuance_of_preops.preops_data')
            </div>
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

    $('#operation_date_to').change(function() {
        PreopsFilter();
    });

    function PreopsFilter() {
        var ro_code = $('#ro_code').val();
        var operating_unit_id = $('#operating_unit_id').val();
        var operation_type_id = $('#operation_type_id').val();
        var operation_date = $('#operation_date').val();
        var operation_date_to = $('#operation_date_to').val();


        if (ro_code == '' || ro_code == null) {
            ro_code = 0;
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

        var table = $('#example2').DataTable();

        var myData = {
            ro_code: ro_code,
            operating_unit_id: operating_unit_id,
            operation_type_id: operation_type_id,
            operation_date: operation_date,
            operation_date_to: operation_date_to,

        };

        $.ajax({
            type: "GET",
            url: "/issuance_of_preops_list",
            fail: function() {
                alert("request failed");
            },
            data: myData,

            success: function(data) {
                // console.log(response.datas.data); //get data
                // console.log(data.links); //get links
                // $('.pagination').load(data.links);

                alert('test');

                $("#tag_container").empty().html(data);



                // var data2 = response.datas.data;

                // // alert(data2.length);

                // $("#preops_list").empty();


                // if (data2.length > 0) {
                //     data2.forEach(element => {

                //         if (element["status"] == 1) {
                //             status = 'Yes';
                //         } else {
                //             status = 'No';
                //         }
                //         var details =
                //             '<tr>' +
                //             '<td>' + element["preops_number"] + '</td>' +
                //             '<td>' + element["operating_unit_name"] + '</td>' +
                //             '<td>' + element["operation_type_name"] + '</td>' +
                //             '<td>' + element["operation_datetime"] + '</td>' +
                //             '<td>' + status + '</td>' +
                //             '<td>' + element["validity"] + '</td>' +
                //             '<td>' + element["with_aor"] + '</td>' +
                //             '<td>' + element["with_sr"] + '</td>' +
                //             '<td>' + element["report_status"] + '</td>' +
                //             '<td>' +
                //             '<center>' +
                //             '<a href="/issuance_of_preops_edit/' + element["id"] + '" class="btn btn-info">Edit</a>' +
                //             '</center>' +
                //             '</td>' +
                //             '</tr>';
                //         $("#preops_list").append(details);
                //     });
                // }
            }
        });

        table
            .clear()
            .draw();
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

    // Table Sort Data
    $(document).ready(function() {
        $(function() {
            $("#example2").DataTable({
                "responsive": false,
                order: [
                    [0, 'desc']
                ],
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
        });

    });

    $(".submit_search").on("click", function() {
        $('#SearchForm').submit();
    });

    //Select2 Lazy Loading Spot
    $(".OPUnitSearch").select2({
        minimumInputLength: 2,
        ajax: {
            url: '/search_operating_unit',
            dataType: "json",
        }
    });
</script>



@endsection