@extends('layouts.template')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Drug Management List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="removeCokie();">Home</a></li>
                    <li class="breadcrumb-item active">Drug Management List</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>

@if($errors->any())
@foreach ($errors->all() as $error)
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-ban"></i> Error!</h5>
    {{ $error }}
</div>
@endforeach
@endif

@if(session()->has('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Success!</h5>
    {{ session()->get('success') }}
</div>
@endif
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="card card-success">
        <div class="card-body">
            <div class="card table-responsive" style="padding: 20px;">
                <table id="example_info" class="table table-bordered table-striped table-hover" style="width: max-content;">
                    <thead>
                        <tr>
                            <th hidden>Suspect ID</th>
                            <th>Pre-Ops #</th>
                            <th>Spot Report #</th>
                            <th>Region</th>
                            <th>Area Of Operation</th>
                            <th>OPN Type</th>
                            <th>OPN Unit</th>
                            <th>Date of OPN</th>
                            <th>Suspect</th>
                            <th>Suspect Classification</th>
                            <th>Suspect Category</th>
                            <th>Status</th>
                            <th>Case Filed</th>
                            <th>Case Status</th>
                            <th>Case Docket Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data1 as $dt)
                        <tr class="suspect_info">
                            <td hidden><input type="text" class="suspect_id" value="{{ $dt->id }}"></td>
                            <td style="width: 150px;">{{$dt->preops_number}}</td>
                            <td style="width: 150px;">{{$dt->spot_report_number}}</td>
                            <td style="width: 150px;">{{$dt->region_m}}</td>
                            <td style="width: 150px;">{{$dt->province_m}}</td>
                            <td style="width: 150px;">{{$dt->operation_type}}</td>
                            <td style="width: 150px;">{{$dt->operating_unit}}</td>
                            <td style="width: 150px;">{{$dt->operation_datetime}}</td>
                            <td class="s_name" style="width: 150px;">{{$dt->lastname}}, {{$dt->firstname}} {{$dt->middlename}}</td>
                            <td style="width: 150px;">{{$dt->suspect_classification}}</td>
                            <td style="width: 150px;">{{$dt->suspect_category}}</td>
                            <td style="width: 150px;">{{$dt->status}}</td>
                            <td style="width: 150px;">{{$dt->case}}</td>
                            <td style="width: 150px;">{{$dt->docket_number}}</td>
                            <td style="width: 150px;">{{$dt->case_status}}</td>
                        </tr>
                        @endforeach
                        <tr>
                                <td colspan="17" align="center">
                                    {!! $data1->links() !!}
                                </td>
                            </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <div class="card-footer">
            <h6>List of all Drug Management maintenance data sorted by name.</h6>
        </div>
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

<!-- Set menu to collapse and active -->
@endsection