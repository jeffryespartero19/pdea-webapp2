@extends('layouts.template')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $('.alerter').hide();
</script>
<style>
    .table_body tr td{
        text-align: center;
    }
</style>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-4">
                <h1>
                    @if($Title_Loc > 137400)
                        @isset($city[0]){{$city[0]}}@endisset
                    @else
                        @isset($province[0]){{$province[0]}}@endisset
                    @endif
                    Operations List
                </h1>
            </div>
            <div class="col-sm-4" style="text-align: center">
                <form id="update_warning" method="POST" action="{{ route('ops_details_Xport') }}" autocomplete="off" enctype="multipart/form-data">@csrf
                    <input id="this_area_ID" name="this_area_ID" value="{{$area_IDx}}" hidden>
                    <button type="submit">Download</button>
                </form>
            </div>
            <div class="col-sm-4">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="removeCokie();">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('geo_mapping') }}" onclick="removeCokie();">Geomapping</a></li>
                    <li class="breadcrumb-item active">Operations List</li>
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
        <div class="card-body opsTable"> 
            <div class="col-sm-12" style="display: flex">
                <div class="col-sm-2"><h3> Ongoing Operations</h3></div>
                <div class="col-sm-10">
                    {{-- <form id="update_warning" method="POST" action="{{ route('ops_details_Xport') }}" autocomplete="off" enctype="multipart/form-data">@csrf
                        <input id="this_area_ID" name="this_area_ID" value="{{$area_IDx}}" hidden>
                        <button type="submit">Download</button>
                    </form> --}}
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
                        <th style="text-align: center">Warning Issuance</th>
                        <th style="text-align: center">Actions</th>
                    </tr>
                </thead>
                <tbody class="table_body">
                    @if($ops_details!=[])
                    @foreach($ops_details as $opd)
                        <?php $x=$loop->index ?>
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
                            <td>@isset($region[0]){{$region[$x]}}@endisset</td>
                            <td>
                                @foreach ($ops_details_area as $opd_a)
                                    @if ($opd->preops_number == $opd_a->preops_number)
                                        @isset($province[0]){{$province[$x]}}@endisset
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach ($ops_details_area as $opd_a)
                                    @if ($opd->preops_number == $opd_a->preops_number)
                                        @isset($city[0]){{$city[$x]}}@endisset
                                    @endif
                                @endforeach    
                            </td>
                            <td>
                                @foreach ($ops_details_area as $opd_a)
                                    @if ($opd->preops_number == $opd_a->preops_number)
                                        @isset($brgy[0]){{$brgy[$x]}}@endisset
                                    @endif
                                @endforeach    
                            </td>
                            <td>
                                @foreach ($ops_details_area as $opd_a)
                                    @if ($opd->preops_number == $opd_a->preops_number)
                                        @if($brgy2[$x]!=0)
                                            @isset($brgy2[0]){{$brgy2[$x]}}@endisset
                                        @else
                                            @isset($city2[0]){{$city2[$x]}}@endisset
                                        @endif
                                    @endif
                                @endforeach 
                            </td>
            
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
                                        <input  name="opd_action" value=1 hidden>
                                        <button type="submit">Warning Sent</button>
                                    @else
                                        <input  name="opd_action" value=0 hidden>
                                        <button type="submit">No Warning Sent</button>
                                    @endif

                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card -->

    <!-- Default box -->
    <div class="card card-success">
        <div class="card-body opsTable"> 
            <div class="col-sm-12" style="display: flex">
                <div class="col-sm-2"><h3> Pending Operations</h3></div>
                <div class="col-sm-10">
                    {{-- <form id="update_warning" method="POST" action="{{ route('ops_details_Xport') }}" autocomplete="off" enctype="multipart/form-data">@csrf
                        <input id="this_area_ID" name="this_area_ID" value="{{$area_IDx}}" hidden>
                        <button type="submit">Download</button>
                    </form> --}}
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
                        <th style="text-align: center">Warning Issuance</th>
                        <th style="text-align: center">Actions</th>
                    </tr>
                </thead>
                <tbody class="table_body">
                    @if($ops_details2!=[])
                    @foreach($ops_details2 as $opd2)
                    <?php $x2=$loop->index ?>
                        <tr>
                            <td>{{$opd2->preops_number}}</td>
                            <td>{{$opd2->operation_datetime}}</td>
                            <td>
                                @foreach($ops_teams2 as $op_t2)
                                    @if($op_t2->preops_number == $opd2->preops_number)
                                        {{$op_t2->name}}
                                    @endif                       
                                @endforeach
                            </td>
                            <td>
                                @foreach($ops_teams2 as $op_t2)
                                    @if($op_t2->preops_number == $opd2->preops_number)
                                        {{$op_t2->contact}}
                                    @endif                       
                                @endforeach
                            </td>
                            <td>@isset($regionB[0]){{$regionB[$x2]}}@endisset</td>
                            <td>
                                @foreach ($ops_details_area3 as $opd_a)
                                    @if ($opd2->preops_number == $opd_a->preops_number)
                                        @isset($provinceB[0]){{$provinceB[$x2]}}@endisset
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach ($ops_details_area3 as $opd_a)
                                    @if ($opd2->preops_number == $opd_a->preops_number)
                                        @isset($cityB[0]){{$cityB[$x2]}}@endisset
                                    @endif
                                @endforeach    
                            </td>
                            <td>
                                @foreach ($ops_details_area3 as $opd_a)
                                    @if ($opd2->preops_number == $opd_a->preops_number)
                                        @isset($brgyXB[0]){{$brgyXB[$x2]}}@endisset
                                    @endif
                                @endforeach    
                            </td>
                            <td>
                                @foreach ($ops_details_area3 as $opd_a)
                                    @if ($opd2->preops_number == $opd_a->preops_number)
                                        @if($brgy2B[$x2]!=0)
                                            @isset($brgy2B[0]){{$brgy2B[$x2]}}@endisset
                                        @else
                                            @isset($city2B[0]){{$city2B[$x2]}}@endisset
                                        @endif
                                    @endif
                                @endforeach 
                            </td>
                            <td style="text-align: center">
                                @if($opd2->warning_issuance == 1)
                                <span style="background:green; padding:3px;">Issued</span> 
                                @else 
                                <span style="background:salmon; padding:3px;">Not Issued</span>
                                @endif
                            </td>
                            <td style="text-align: center">
                                <form id="update_warning" method="POST" action="{{ route('ops_update_warning') }}" autocomplete="off" enctype="multipart/form-data">@csrf
                                    <input id="opd_ID" name="opd_ID" value="{{$opd2->id}}" hidden>

                                    @if($opd2->warning_issuance != 1)
                                        <input  name="opd_action" value=1 hidden>
                                        <button type="submit">Warning Sent</button>
                                    @else
                                        <input  name="opd_action" value=0 hidden>
                                        <button type="submit">No Warning Sent</button>
                                    @endif

                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

@if($ops_count > 1)
    <style>
        .alerter{
            position: fixed;
            background-color: rgb(221, 218, 218);
            color:rgb(240, 90, 73);
            width:35vw;
            height:20vh;
            right: 30vw;
            top: 15vh;
            border-radius: 10px;
            padding: 5px;
            border: 1px solid black;
        }
        .fa-window-close:hover{
            transform: scale(1.25);
        }
        
    </style>

    <div class="alerter">
        <div style="text-align: right; font-size:20px;"><i class="fa fa-window-close rx7" aria-hidden="true"></i></div>
        <div style="width: 100%;">
            <h5 style="text-align: center; border-bottom:1px solid black;">WARNING</h5>
        </div>
        <div style="width: 100%;">
            <h4 style="text-align: center">There multiple Ops in the same area, please make sure all teams have been issued warning</h4>
        </div>
    </div>

    <script>
        //alert('There multiple Ops in the same area, please make sure all teams have been issued warning');
        

        $(document).ready(function(){
            $('.alerter').fadeIn();
            $(document).on('click',('.rx7'),function(e) {
                $('.alerter').fadeOut();
            });
        });
    </script>
@endif
@endsection

