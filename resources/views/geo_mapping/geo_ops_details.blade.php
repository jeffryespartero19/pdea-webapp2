@extends('layouts.template')

@section('content')
<style>
    .table_body tr td{
        text-align: center;
    }
</style>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Ongoing Operations List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="removeCokie();">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('geo_mapping') }}" onclick="removeCokie();">Geomapping</a></li>
                    <li class="breadcrumb-item active">Ongoing Operations List</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="card card-info">
        <div class="card-body opsTable"> 
            <div class="col-sm-12" style="display: flex">
                <div class="col-sm-2"><h3>Operations</h3></div>
                <div class="col-sm-10">
                    <form id="update_warning" method="POST" action="{{ route('ops_details_Xport') }}" autocomplete="off" enctype="multipart/form-data">@csrf
                        <input id="this_area_ID" name="this_area_ID" value="{{$area_IDx}}" hidden>
                        <button type="submit">Download</button>
                    </form>
                </div>    
            </div>
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th style="text-align: center">Operation #</th>
                        <th style="text-align: center">Date Launched</th>
                        <th style="text-align: center">Operating Unit</th>
                        <th style="text-align: center">Contact</th>
                        <th style="text-align: center">Region</th>
                        <th style="text-align: center">Province</th>
                        <th style="text-align: center">City-Municipality</th>
                        <th style="text-align: center">Barangay</th>
                        <th style="text-align: center">UACS Code</th>
                        <th style="text-align: center">Status</th>
                        <th style="text-align: center">Warning Issuance</th>
                        <th style="text-align: center">Actions</th>
                    </tr>
                </thead>
                <tbody class="table_body">
                    @foreach($ops_details as $opd)
                        <tr>
                            <td>{{$opd->preops_number}}</td>
                            <td>{{$opd->operation_datetime}}</td>
                            <td>
                                @foreach($ops_teams as $op_t)
                                    @if($op_t->preops_number == $opd->preops_number)
                                        {{$op_t->name}}
                                    @endif                       
                                @endforeach
                            </td>
                            <td>
                                @foreach($ops_teams as $op_t)
                                    @if($op_t->preops_number == $opd->preops_number)
                                        {{$op_t->contact}}
                                    @endif                       
                                @endforeach
                            </td>
                            <td>@isset($region[0]){{$region[0]}}@endisset</td>
                            <td>
                                @foreach ($ops_details_area as $opd_a)
                                    @if ($opd->preops_number == $opd_a->preops_number)
                                        @isset($province[0]){{$province[0]}}@endisset
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach ($ops_details_area as $opd_a)
                                    @if ($opd->preops_number == $opd_a->preops_number)
                                        @isset($city[0]){{$city[0]}}@endisset
                                    @endif
                                @endforeach    
                            </td>
                            <td>
                                @foreach ($ops_details_area as $opd_a)
                                    @if ($opd->preops_number == $opd_a->preops_number)
                                        @isset($brgy[0]){{$brgy[0]}}@endisset
                                    @endif
                                @endforeach    
                            </td>
                            <td>
                                @foreach ($ops_details_area as $opd_a)
                                    @if ($opd->preops_number == $opd_a->preops_number)
                                        @if($brgy2!='')
                                            @isset($brgy2){{$brgy2}}@endisset
                                        @else
                                            @isset($city2){{$city2}}@endisset
                                        @endif
                                    @endif
                                @endforeach 
                            </td>
                            <td>{{$opd->status}}</td>
                            <td style="text-align: center">
                                @if($opd->warning_issuance == 1)
                                <span style="background:green; padding:3px;">Issued</span> 
                                @else 
                                <span style="background:salmon; padding:3px;">Not Issued</span>
                                @endif
                            </td>
                            <td style="text-align: center">
                                <form id="update_warning" method="POST" action="{{ route('ops_update_warning') }}" autocomplete="off" enctype="multipart/form-data">@csrf
                                    <input id="opd_ID" name="opd_ID" value="{{$opd->id}}" hidden>

                                    @if($opd->warning_issuance != 1)
                                        <input id="opd_action" name="opd_action" value=1 hidden>
                                        <button type="submit">Warning Sent</button>
                                    @else
                                        <input id="opd_action" name="opd_action" value=0 hidden>
                                        <button type="submit">No Warning Sent</button>
                                    @endif

                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

@if($ops_count > 1)
    <script>
        alert('There multiple Ops in the same area, please make sure all teams have been issued warning');
    </script>
@endif
@endsection

