@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Memo List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="removeCokie();">Home</a></li>
                    <li class="breadcrumb-item active">Memo List</li>
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
        <div class="ml-4 mt-4" @if(Auth::user()->user_level_id == 1 || Auth::user()->user_level_id == 2)
            @else
            hidden
            @endif>
            <a href="{{ route('memo_add') }}" class="btn btn-info">Add Memo</a>
        </div>
        <div class="card-body">
            <div class="card">
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Memo</th>
                                @if(Auth::user()->user_level_id == 1 || Auth::user()->user_level_id == 2)
                                <th>Active</th>
                                @else
                                @endif

                                <th> @if(Auth::user()->user_level_id == 1 || Auth::user()->user_level_id == 2)Edit
                                    @else
                                    View
                                    @endif
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $memo)
                            <tr>
                                <th>{{ $memo->filenames }}</th>
                                @if(Auth::user()->user_level_id == 1 || Auth::user()->user_level_id == 2)
                                <td><b>{{ $memo->status == 1 ? 'YES' : 'NO' }}</b></td>
                                @else
                                @endif
                                <td>
                                    @if(Auth::user()->user_level_id == 1 || Auth::user()->user_level_id == 2)
                                    <center>
                                        <a href="{{ url('memo_edit/'.$memo->id) }}" class="btn btn-info">Edit</a>
                                    </center>
                                    @else
                                    <a href="{{ asset('/files/uploads/memo/' . $memo->filenames) }}">{{$memo->filenames}}</a>
                                    @endif

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
            <h6>List of all Memo maintenance data sorted by name.</h6>
        </div>
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

<!-- Set menu to collapse and active -->
@endsection