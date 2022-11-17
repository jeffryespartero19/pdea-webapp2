@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Suspect Information List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="removeCokie();">Home</a></li>
                    <li class="breadcrumb-item active">Suspect Information List</li>
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
        <div class="ml-4 mt-4">
            <a href="{{ route('suspect_information_add') }}" class="btn btn-info">Add Suspect Information</a>
        </div>

        <div class="card-body">
            <div class="card">
                <form action="/search_suspect" method="GET" role="search" id="SearchForm">
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
                                <th>No.</th>
                                <th>Name</th>
                                <th>Active</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $suspect_information)
                            <tr>
                                <th>{{ $suspect_information->suspect_number }}</th>
                                <th>{{ $suspect_information->lastname }}, {{ $suspect_information->firstname }} {{ $suspect_information->middlename }}</th>
                                <td><b>{{ $suspect_information->status == 1 ? 'YES' : 'NO' }}</b></td>
                                <td>
                                    <center>
                                        <a href="{{ url('suspect_information_edit/'.$suspect_information->id) }}" class="btn btn-info">Edit</a>
                                    </center>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                    {{ $data->links() }}
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="card-footer">
            <h6>List of all Suspect Information maintenance data sorted by name.</h6>
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