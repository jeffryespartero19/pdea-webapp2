@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>File Upload List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="removeCokie();">Home</a></li>
                    <li class="breadcrumb-item active">File Upload List</li>
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
        <div class="card-body">
            <div class="card">
                <form action="/search_files" method="GET" role="search" id="SearchForm">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" placeholder="Search Suspects"> <span class="input-group-btn">
                            <button type="button" class="btn btn-default submit_search">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
                <div class="card-body">
                    <table id="example_info" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>File Upload</th>
                                <th>Transaction</th>
                                <th>Number</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($file_uploads as $fu)
                            <tr>
                                <th>{{ $fu->filename }}</th>
                                <td>@if($fu->transaction_type == 1)
                                    Issuance of Preops
                                    @elseif($fu->transaction_type == 2)
                                    After Operations
                                    @elseif($fu->transaction_type == 3)
                                    Spot Report
                                    @elseif($fu->transaction_type == 4)
                                    Progress Report
                                    @else
                                    @endif
                                </td>
                                <td>@if($fu->transaction_type == 1)
                                    {{$fu->i_preops_number}}
                                    @elseif($fu->transaction_type == 2)
                                    {{$fu->a_preops_number}}
                                    @elseif($fu->transaction_type == 3)
                                    {{$fu->s_spot_report_number}}
                                    @elseif($fu->transaction_type == 4)
                                    {{$fu->p_spot_report_number}}
                                    @else
                                    @endif
                                </td>
                                <td>@if($fu->transaction_type == 1)
                                    <a href="{{ asset('/files/uploads/issuance_of_preops/' . $fu->filename) }}">View </a>
                                    @elseif($fu->transaction_type == 2)
                                    <a href="{{ asset('/files/uploads/after_operations/' . $fu->filename) }}">View </a>
                                    @elseif($fu->transaction_type == 3)
                                    <a href="{{ asset('/files/uploads/spot_reports/' . $fu->filename) }}">View </a>
                                    @elseif($fu->transaction_type == 4)
                                    <a href="{{ asset('/files/uploads/progress_reports/' . $fu->filename) }}">View </a>
                                    @else
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                    </table>
                    {{ $file_uploads->links() }}
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="card-footer">
            <h6>List of all File Upload.</h6>
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
        $('#SearchForm').submit();
    });
</script>
@endsection