@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>User Activities</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="removeCokie();">Home</a></li>
                    <li class="breadcrumb-item active">User Activities</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="card card-info">
        <div class="card-body">
            <div class="card">
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Module</th>
                                <th>Menu</th>
                                <th>Activity</th>
                                <th>Description</th>
                                <th>Date Stamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $audit)
                            <tr>
                                <td>
                                    <center>
                                        <img src="data:image/jpeg;base64,{{ $audit->photo }}" onerror=this.src="../../dist/img/profile.png" class="img-circle elevation-2 mt-1" width="30px" height="30px" alt="User Image">
                                    </center>
                                </td>
                                <td>{{ $audit->name }}</td>
                                <td>{{ $audit->module }}</td>
                                <td>{{ $audit->menu }}</td>
                                <td>{{ $audit->activity }}</td>
                                <td>{{ $audit->description }}</td>
                                <td>{{ $audit->created_at }}</td>
                            </tr>
                            @endforeach
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="card-footer">
            <h6>List of all system user activities sorted by date and time.</h6>
        </div>
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

<!-- Set menu to collapse and active -->
@endsection