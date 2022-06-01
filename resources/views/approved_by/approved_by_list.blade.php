@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Approved By List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="removeCokie();">Home</a></li>
                    <li class="breadcrumb-item active">Approved By List</li>
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
            <a href="{{ route('approved_by_add') }}" class="btn btn-info">Add Approved By</a>
        </div>
        <div class="card-body">
            <div class="card">
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Regional Office</th>
                                <th>Position</th>
                                <th>Active</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $approved_by)
                            <tr>
                                <th>{{ $approved_by->name }}</th>
                                <th>{{ $approved_by->regional_office }}</th>
                                <th>{{ $approved_by->officer_position }}</th>
                                <td><b>{{ $approved_by->status == 1 ? 'YES' : 'NO' }}</b></td>
                                <td>
                                    <center>
                                        <a href="{{ url('approved_by_edit/'.$approved_by->id) }}" class="btn btn-info">Edit</a>
                                    </center>
                                </td>
                            </tr>
                            @endforeach
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="card-footer">
            <h6>List of all Approved By maintenance data sorted by name.</h6>
        </div>
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

<!-- Set menu to collapse and active -->
@endsection

