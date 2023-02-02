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
                    <label for="">Lead Unit</label>
                </div>
                <div class="input-group mb-3">
                    <select id="operating_unit_id" name="operating_unit_id" class="form-control OPUnitSearch">
                    </select>
                </div>
            </div>
            <div class="form-group col-4" style="margin: 0px;">
                <div>
                    <label for="">Type of OPN</label>
                </div>
                <div class="input-group mb-3">
                    <select id="operation_type_id" name="operation_type_id" class="form-control OPTypeSearch">
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
            <!-- <form action="/search_preops" method="GET" role="search" id="SearchForm">
                {{ csrf_field() }} -->
            <div class="row">
                <div class="input-group col-4">
                    <input type="text" class="form-control SearchPreops" name="q" placeholder="Search Preops Number"> <span class="input-group-btn">
                        <button type="button" class="btn btn-default submit_search">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </div>

            <!-- </form> -->
            <br>
            <div id="tag_container">
                <table id="example_info" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th hidden>ID</th>
                            <th>Pre-Ops Number</th>
                            <th>Lead Unit</th>
                            <th>Operation Type</th>
                            <th>Operation Date</th>
                            <th>Active</th>
                            <th>Expire COC</th>
                            <th>With AOR</th>
                            <th>Spot Only</th>
                            <th>With Progress</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody id="preops_list">
                        @include('issuance_of_preops.preops_data')
                    </tbody>
                </table>
                <input type="hidden" name="hidden_page" id="hidden_page" value="1">
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

</script>

<script>
    $(document).ready(function() {
        function PreopsFilter() {
            var table = $('#example2').DataTable();
            var page = $('#hidden_page').val();
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

            $.ajax({
                url: "/issuance_of_preops_list/fetch_data?page=" + page + "&ro_code=" + ro_code + "&operating_unit_id=" + operating_unit_id + "&operation_type_id=" + operation_type_id + "&operation_date=" + operation_date + "&operation_date_to=" + operation_date_to,
                success: function(data) {
                    $('tbody').html('');
                    $('tbody').html(data);
                }
            });
        }

        $('#ro_code').change(function() {
            $('#hidden_page').val(1);
            PreopsFilter();
        });
        $('#operating_unit_id').change(function() {
            $('#hidden_page').val(1);
            PreopsFilter();
        });
        $('#operation_type_id').change(function() {
            $('#hidden_page').val(1);
            PreopsFilter();
        });
        $('#operation_date').change(function() {
            $('#hidden_page').val(1);
            PreopsFilter();
        });
        $('#operation_date_to').change(function() {
            $('#hidden_page').val(1);
            PreopsFilter();
        });

        $(document).on('click', ".pagination a", function(event) {
            event.preventDefault();

            var page = $(this).attr('href').split('page=')[1];
            $('#hidden_page').val(page);
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
            PreopsFilter();
        });


        $(function() {
            $('#coc').addClass('menu-open');
        });
        $(function() {
            $('#coc_link').addClass('active');
        });
        $(function() {
            $('#issuance_of_preops').addClass('active');
        });

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

        $(".submit_search").on("click", function() {
            var param = $('.SearchPreops').val();
            var page = $('#hidden_page').val();
            $.ajax({
                url: "/issuance_of_preops_list/search_preops_list?page=" + page + "&param=" + param,
                success: function(data) {
                    $('tbody').html('');
                    $('tbody').html(data);
                }
            });
        });

        //Select2 Lazy Loading Spot
        $(".OPUnitSearch").select2({
            minimumInputLength: 2,
            ajax: {
                url: '/search_operating_unit',
                dataType: "json",
            }
        });

        $(".OPTypeSearch").select2({
            minimumInputLength: 2,
            ajax: {
                url: '/search_operation_type',
                dataType: "json",
            }
        });
    });
</script>



@endsection