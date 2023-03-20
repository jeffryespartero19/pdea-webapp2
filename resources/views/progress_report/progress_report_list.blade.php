@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Progress Report List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="removeCokie();">Home</a></li>
                    <li class="breadcrumb-item active">Progress Report List</li>
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
            <div class="form-group col-lg-3" style="margin: 0px;">
                <div>
                    <label for="">Spot Report/Pre-ops Number</label>
                </div>
                <div class="input-group mb-3">
                    <input id="tnumber" name="tnumber" type="text" class="listFilter form-control @error('operation') is-invalid @enderror" value="{{ old('tnumber') }}" autocomplete="off">
                </div>
            </div>
            <div class="form-group col-lg-3" style="margin: 0px;">
                <div>
                    <label for="">Area of Operation</label>
                </div>
                <div class="input-group mb-3">
                    <input id="area" name="area" type="text" class="listFilter form-control @error('operation') is-invalid @enderror" value="{{ old('area') }}" autocomplete="off">
                </div>
            </div>
            <div class="form-group col-lg-3" style="margin: 0px;">
                <div>
                    <label for="">Region</label>
                </div>
                <div class="input-group mb-3">
                    <select id="region_c" name="region_c" class="listFilter form-control @error('region') is-invalid @enderror">
                        <option value='' disabled selected>Select Option</option>
                        @foreach($region as $rg)
                        <option value="{{ $rg->region_c }}">{{ $rg->abbreviation }} - {{ $rg->region_m }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group col-lg-3" style="margin: 0px;">
                <div>
                    <label for="">Lead Unit</label>
                </div>
                <div class="input-group mb-3">
                    <select id="operating_unit_id" name="operating_unit_id" class="listFilter form-control OPUnitSearch">
                    </select>
                </div>
            </div>
            <div class="form-group col-lg-3" style="margin: 0px;">
                <div>
                    <label for="">Type of OPN</label>
                </div>
                <div class="input-group mb-3">
                    <select id="operation_type_id" name="operation_type_id" class="listFilter form-control OPTypeSearch">
                    </select>
                </div>
            </div>
            <div class="form-group col-lg-3" style="margin: 0px;">
                <div>
                    <label for="">Operation Date</label>
                </div>
                <div class="input-group mb-3">
                    <input id="operation_date" name="operation_date" type="date" class="listFilter form-control @error('operation') is-invalid @enderror" value="{{ old('operation_date') }}" autocomplete="off">
                </div>
            </div>
            <div class="form-group col-lg-3" style="margin: 0px;">
                <div>
                    <label for="">Operation Date To</label>
                </div>
                <div class="input-group mb-3">
                    <input id="operation_date_to" name="operation_date_to" type="date" class="listFilter form-control @error('operation') is-invalid @enderror" value="{{ old('operation_date_to') }}" autocomplete="off">
                </div>
            </div>
            <div class="form-group col-lg-3" style="margin: 0px;">
                <div>
                    <label for="">Suspect Name</label>
                </div>
                <div class="input-group mb-3">
                    <input id="suspect" name="suspect" type="text" class="listFilter form-control @error('operation') is-invalid @enderror" value="{{ old('suspect') }}" autocomplete="off">
                </div>
            </div>
            <div class="mr-2" style="width: 100%;">
                <a href="{{ route('progress_report_add') }}" class="btn btn-info" style="float: right;">ADD Progress Report</a>
                <button class="btn btn-danger" onClick="window.location.reload();" style="float: right; margin-right:10px">Reset Filter</button>
            </div>
        </div>
    </div>
    <!-- /.card -->

    <div class="card card-success">

        <div class="card-body">
            <!-- <div class="row">
                <div class="input-group col-4">
                    <input type="text" class="form-control SearchSpot" name="q" placeholder="Search Spot Report Number"> <span class="input-group-btn">
                        <button type="button" class="btn btn-default submit_search">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </div>
            <br> -->
            <table id="example1" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Spot Report Number</th>
                        <th>Preops Number</th>
                        <th>Operating Unit</th>
                        <th>Operation Type</th>
                        <th>Operation Date</th>
                        <th>Active</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody id="spot_report_list">
                    @include('progress_report.progress_report_data')
                </tbody>

            </table>
            <input type="hidden" name="hidden_page" id="hidden_page" value="1">
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <h6>List of all Progress Report maintenance data sorted by name.</h6>
        </div>
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

<!-- Set menu to collapse and active -->
@endsection

@section('scripts')

<script>
    $(document).ready(function() {
        $('.listFilter').change(function() {
            $('#hidden_page').val(1);
            ProgressReportFilter();
        });

        $(document).on('click', ".pagination a", function(event) {
            event.preventDefault();

            var page = $(this).attr('href').split('page=')[1];
            $('#hidden_page').val(page);
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
            ProgressReportFilter();
        });

        function ProgressReportFilter() {
            var page = $('#hidden_page').val();
            var region_c = $('#region_c').val();
            var operating_unit_id = $('#operating_unit_id').val();
            var operation_type_id = $('#operation_type_id').val();
            var operation_date = $('#operation_date').val();
            var operation_date_to = $('#operation_date_to').val();
            var area = $('#area').val();
            var tnumber = $('#tnumber').val();
            var suspect = $('#suspect').val();

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

            var table = $('#example2').DataTable();

            $.ajax({
                url: "/progress_report_list/fetch_data?page=" + page + "&region_c=" + region_c + "&operating_unit_id=" + operating_unit_id + "&operation_type_id=" + operation_type_id + "&operation_date=" + operation_date + "&operation_date_to=" + operation_date_to + "&area=" + area + "&tnumber=" + tnumber + "&suspect=" + suspect,
                success: function(data) {
                    // alert('test')
                    $('tbody').html('');
                    $('tbody').html(data);
                }
            });

        }

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

        $(".submit_search").on("click", function() {
            var param = $('.SearchSpot').val();
            var page = $('#hidden_page').val();
            $.ajax({
                url: "/progress_report_list/search_spot_report_list?page=" + page + "&param=" + param,
                success: function(data) {
                    $('tbody').html('');
                    $('tbody').html(data);
                }
            });
        });

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
        $('#progress_report').addClass('active');
    });
</script>
@endsection