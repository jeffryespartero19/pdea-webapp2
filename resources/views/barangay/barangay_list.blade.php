@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Barangay List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="removeCokie();">Home</a></li>
                    <li class="breadcrumb-item active">Barangay List</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="card card-success">
        <div class="card-body">
            <div class="row">
                <div class="input-group col-md-4">
                    <input type="text" class="form-control SearchData" name="q" placeholder="Search Barangay"> <span class="input-group-btn">
                        <button type="button" class="btn btn-default submit_search">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
                <div class="col-md-8">
                    <a href="{{ route('barangay_add') }}" class="btn btn-info" style="float: right;">Add Barangay</a>
                    <!-- <button class="btn btn-danger" onClick="window.location.reload();" style="float: right; margin-right:10px">Reset Filter</button> -->
                </div>
            </div>

            <br>
            <table id="example1" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Barangay</th>
                        <th>Province</th>
                        <th>Active</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody id="brgy_list">
                    @include('barangay.barangay_list_data')
                </tbody>
            </table>
            <input type="hidden" name="hidden_page" id="hidden_page" value="1">
        </div>
        <div class="card-footer">
            <h6>List of all Barangay maintenance data sorted by name.</h6>
        </div>
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

<!-- Set menu to collapse and active -->
@endsection


@section('scripts')
<script>
    $(".submit_search").on("click", function() {
        DataFilter();
    });

    $(document).on('click', ".pagination a", function(event) {
        event.preventDefault();

        var page = $(this).attr('href').split('page=')[1];
        $('#hidden_page').val(page);
        DataFilter();
    });

    function DataFilter() {
        var param = $('.SearchData').val();
        var page = $('#hidden_page').val();
        $.ajax({
            url: "/barangay_list/search_barangay_list?page=" + page + "&param=" + param,
            success: function(data) {
                $('tbody').html('');
                $('tbody').html(data);
            }
        });

    }
</script>
@endsection