@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Progress Report</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="removeCokie();">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('progress_report_list') }}">Progress Report List</a></li>
                    <li class="breadcrumb-item active">Edit Spot Report</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
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
    <!-- Default box -->
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Edit Progress Report</h3>
        </div>
        <div class="card-body">
            <form action="/progress_report_edit/{{ $spot_report_header[0]->id }}" role="form" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <a href="{{ url('/view_ProgressReport/'.$spot_report_header[0]->id) }}" target="_blank" class="btn btn-warning" style="float: right;">Print Report</a>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Spot Report No.</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="spot_report_number" name="spot_report_number" type="text" class="form-control" style="pointer-events: none; background-color : #e9ecef; " value="{{$spot_report_header[0]->spot_report_number}}">
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Date/Time of Operation</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="operation_datetime" name="operation_datetime" type="text" class="form-control" style="pointer-events: none; background-color : #e9ecef; " value="{{$spot_report_header[0]->operation_datetime}}">
                        </div>
                    </div>

                </div>
                <div class="row">

                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Operating Unit</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="operating_unit" type="text" class="form-control" style="pointer-events: none; background-color : #e9ecef; " value="{{$operating_unit[0]->description}}">
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Type of Operation</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="operation_type" type="text" class="form-control" style="pointer-events: none; background-color : #e9ecef; " value="{{$operation_type[0]->name}}">
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Region</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="region_m" type="text" class="form-control" style="pointer-events: none; background-color : #e9ecef; " value="{{$region[0]->region_m}}">
                            <input hidden id="region_c" type="text" class="form-control" style="pointer-events: none; background-color : #e9ecef; ">
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Province</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="province_m" type="text" class="form-control" style="pointer-events: none; background-color : #e9ecef; " value="{{$province[0]->province_m}}">
                            <input hidden id="province_c" type="text" class="form-control" style="pointer-events: none; background-color : #e9ecef; ">
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">City</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="city_m" type="text" class="form-control" style="pointer-events: none; background-color : #e9ecef; " value="{{$city[0]->city_m}}">
                            <input hidden id="city_c" type="text" class="form-control" style="pointer-events: none; background-color : #e9ecef; ">
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Barangay</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="barangay_m" type="text" class="form-control" style="pointer-events: none; background-color : #e9ecef; " value="{{$barangay[0]->barangay_m}}">
                            <input hidden id="barangay_c" type="text" class="form-control" style="pointer-events: none; background-color : #e9ecef; ">
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Street</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="street" type="text" class="form-control" style="pointer-events: none; background-color : #e9ecef; " value="{{$spot_report_header[0]->street}}">
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Area</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="area" type="text" class="form-control" style="pointer-events: none; background-color : #e9ecef; " value="{{$spot_report_header[0]->area}}">
                        </div>
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-12 col-sm-12">
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-four-suspect-tab" data-toggle="pill" href="#custom-tabs-four-suspect" role="tab" aria-controls="custom-tabs-four-suspect" aria-selected="true">Suspect</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-four-drugseized-tab" data-toggle="pill" href="#custom-tabs-four-drugseized" role="tab" aria-controls="custom-tabs-four-drugseized" aria-selected="false">Item Seized</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-four-casefiled-tab" data-toggle="pill" href="#custom-tabs-four-casefiled" role="tab" aria-controls="custom-tabs-four-casefiled" aria-selected="false">Case Filed</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-four-status-tab" data-toggle="pill" href="#custom-tabs-four-status" role="tab" aria-controls="custom-tabs-four-status" aria-selected="false">Status</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-four-summary-tab" data-toggle="pill" href="#custom-tabs-four-summary" role="tab" aria-controls="custom-tabs-four-summary" aria-selected="false">Summary</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-four-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-four-suspect" role="tabpanel" aria-labelledby="custom-tabs-four-suspect-tab">
                                        <div class="form-group col-12" style="padding: 0 5px;" id="siblingTBL">
                                            <div class="card table-responsive p-0">
                                                <table id="suspect" class="table table-hover text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="12" style="background-color: lightgreen; text-align:center">Operational Details</th>
                                                            <th colspan="12" style="background-color: pink; text-align:center">Personal Background</th>
                                                            <th colspan="10" style="background-color: lightyellow; text-align:center">Other Information</th>
                                                        </tr>
                                                        <tr>
                                                            <th style="color: gray;">Suspect Number</th>
                                                            <th style="color: gray;">Last Name</th>
                                                            <th style="color: gray;">First Name</th>
                                                            <th style="color: gray;">Middle Name</th>
                                                            <th style="color: gray;">Alias</th>
                                                            <th style="color: gray;">Birthdate</th>
                                                            <th style="color: gray;">Birth Place</th>
                                                            <th style="color: gray;">Region</th>
                                                            <th style="color: gray;">Province</th>
                                                            <th style="color: gray;">City</th>
                                                            <th style="color: gray;">Barangay</th>
                                                            <th style="color: gray;">Street</th>
                                                            <th style="color: gray;">Permanent Region</th>
                                                            <th style="color: gray;">Permanent Province</th>
                                                            <th style="color: gray;">Permanent City</th>
                                                            <th style="color: gray;">Permanent Barangay</th>
                                                            <th style="color: gray;">Permanent Street</th>
                                                            <th style="color: gray;">Sex</th>
                                                            <th style="color: gray;">Civil Status</th>
                                                            <th style="color: gray;">Nationality</th>
                                                            <th style="color: gray;">Ethnic Group</th>
                                                            <th style="color: gray;">Religion</th>
                                                            <th style="color: gray;">Educational Attainment</th>
                                                            <th style="color: gray;">Occupation</th>
                                                            <th style="color: gray;">Suspect Identifier</th>
                                                            <th style="color: gray;">Suspect Classification</th>
                                                            <th style="color: gray;">Suspect Category</th>
                                                            <th style="color: gray;">Suspect Sub Category</th>
                                                            <th style="color: gray;">Suspect Status</th>
                                                            <th style="color: gray;">Drug Test Result</th>
                                                            <th style="color: gray;">Drug Type</th>
                                                            <th style="color: gray;">Remarks</th>
                                                            <th style="color: gray;">Listed</th>
                                                            <th style="color: gray;">Listed By</th>

                                                            <!-- <th style="color: gray;">Action</th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody id="suspect_details">
                                                        @foreach($spot_report_suspect as $srs)
                                                        <tr>
                                                            <td><input type="text" name="suspect_number[]" style="width: 200px; pointer-events:none; background-color : #e9ecef; " class="form-control" value="{{ $srs->suspect_number }}"></td>
                                                            <td><input type="text" name="lastname[]" style="width: 200px; pointer-events:none; background-color : #e9ecef; " class="form-control" value="{{ $srs->lastname }}"></td>
                                                            <td><input type="text" name="firstname[]" style="width: 200px; pointer-events:none; background-color : #e9ecef; " class="form-control" value="{{ $srs->firstname }}"></td>
                                                            <td><input type="text" name="middlename[]" style="width: 200px; pointer-events:none; background-color : #e9ecef; " class="form-control" value="{{ $srs->middlename }}"></td>
                                                            <td><input type="text" name="alias[]" style="width: 200px; pointer-events:none; background-color : #e9ecef; " class="form-control" value="{{ $srs->alias }}"> </td>
                                                            <td><input type="text" name="birthdate" style="width: 200px; pointer-events:none; background-color : #e9ecef; " class="form-control" value="{{ $srs->birthdate }}"></td>
                                                            <td><input type="text" name="birthplace" style="width: 200px; pointer-events:none; background-color : #e9ecef; " class="form-control" value="{{ $srs->birthplace }}"></td>
                                                            <td>
                                                                <select name="present_region_c[]" class="form-control present_region_c" style="width: 200px; pointer-events:none; background-color : #e9ecef; ">
                                                                    <option value='' disabled selected>Select Option</option>
                                                                    @foreach($region as $rg)
                                                                    <option value="{{ $rg->region_c }}" {{ $rg->region_c == $srs->region_c ? 'selected' : '' }}>{{ $rg->abbreviation }} - {{ $rg->region_m }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="present_province_c[]" class="form-control" style="width: 200px; pointer-events:none; background-color : #e9ecef; ">
                                                                    <option value='' disabled selected>Select Option</option>
                                                                    @foreach($province as $pr)
                                                                    <option value="{{ $pr->province_c }}" {{ $pr->province_c == $srs->province_c ? 'selected' : '' }}>{{ $pr->province_m }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="present_city_c[]" class="form-control" style="width: 200px; pointer-events:none; background-color : #e9ecef; ">
                                                                    <option value='' disabled selected>Select Option</option>
                                                                    @foreach($city as $ct)
                                                                    <option value="{{ $ct->city_c }}" {{ $ct->city_c == $srs->city_c ? 'selected' : '' }}>{{ $ct->city_m }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="present_barangay_c[]" class="form-control" style="width: 200px; pointer-events:none; background-color : #e9ecef; ">
                                                                    <option value='' disabled selected>Select Option</option>
                                                                    @foreach($barangay as $br)
                                                                    <option value="{{ $br->barangay_c }}" {{ $br->barangay_c == $srs->barangay_c ? 'selected' : '' }}>{{ $br->barangay_m }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="present_street[]" style="width: 200px; pointer-events:none; background-color : #e9ecef; " class="form-control" value="{{$srs->street}}"></td>
                                                            <td>
                                                                <select name="permanent_region_c[]" class="form-control" style="width: 200px; pointer-events:none; background-color : #e9ecef; ">
                                                                    <option value='' disabled selected>Select Option</option>
                                                                    @foreach($region as $rg)
                                                                    <option value="{{ $rg->region_c }}" {{ $rg->region_c == $srs->permanent_region_c ? 'selected' : '' }}>{{ $rg->abbreviation }} - {{ $rg->region_m }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="permanent_province_c[]" class="form-control" style="width: 200px; pointer-events:none; background-color : #e9ecef; ">
                                                                    <option value='' disabled selected>Select Option</option>
                                                                    @foreach($province as $pr)
                                                                    <option value="{{ $pr->province_c }}" {{ $pr->province_c == $srs->permanent_province_c ? 'selected' : '' }}>{{ $pr->province_m }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="permanent_city_c[]" class="form-control" style="width: 200px; pointer-events:none; background-color : #e9ecef; ">
                                                                    <option value='' disabled selected>Select Option</option>
                                                                    @foreach($city as $ct)
                                                                    <option value="{{ $ct->city_c }}" {{ $ct->city_c == $srs->permanent_city_c ? 'selected' : '' }}>{{ $ct->city_m }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="permanent_barangay_c[]" class="form-control" style="width: 200px; pointer-events:none; background-color : #e9ecef; ">
                                                                    <option value='' disabled selected>Select Option</option>
                                                                    @foreach($barangay as $br)
                                                                    <option value="{{ $br->barangay_c }}" {{ $br->barangay_c == $srs->permanent_barangay_c ? 'selected' : '' }}>{{ $br->barangay_m }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="permanent_street[]" style="width: 200px; pointer-events:none; background-color : #e9ecef; " class="form-control" value="{{$srs->permanent_street}}"></td>
                                                            <td>
                                                                <select name="gender[]" class="form-control" style="width: 200px; pointer-events:none; background-color : #e9ecef; ">
                                                                    <option value='' disabled selected>Select Option</option>
                                                                    <option value="male" {{ 'male' == $srs->gender ? 'selected' : '' }}>Male</option>
                                                                    <option value="female" {{ 'female' == $srs->gender ? 'selected' : '' }}>Female</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="civil_status_id[]" class="form-control" style="width: 200px; pointer-events:none; background-color : #e9ecef; ">
                                                                    <option value='' disabled selected>Select Option</option>
                                                                    @foreach($civil_status as $cs)
                                                                    <option value="{{ $cs->id }}" {{ $cs->id == $srs->civil_status_id ? 'selected' : '' }}>{{ $cs->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="nationality_id[]" class="form-control" style="width: 200px; pointer-events:none; background-color : #e9ecef; ">
                                                                    <option value='' disabled selected>Select Option</option>
                                                                    @foreach($nationality as $na)
                                                                    <option value="{{ $na->id }}" {{ $cs->id == $srs->nationality_id ? 'selected' : '' }}>{{ $na->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="ethnic_group_id[]" class="form-control" style="width: 200px; pointer-events:none; background-color : #e9ecef; ">
                                                                    <option value='' disabled selected>Select Option</option>
                                                                    @foreach($ethnic_group as $eg)
                                                                    <option value="{{ $eg->id }}" {{ $cs->id == $srs->ethnic_group_id ? 'selected' : '' }}>{{ $eg->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="religion_id[]" class="form-control" style="width: 200px; pointer-events:none; background-color : #e9ecef; ">
                                                                    <option value='' disabled selected>Select Option</option>
                                                                    @foreach($religion as $rl)
                                                                    <option value="{{ $rl->id }}" {{ $cs->id == $srs->religion_id ? 'selected' : '' }}>{{ $rl->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="educational_attainment_id[]" class="form-control" style="width: 200px; pointer-events:none; background-color : #e9ecef; ">
                                                                    <option value='' disabled selected>Select Option</option>
                                                                    @foreach($education as $ed)
                                                                    <option value="{{ $ed->id }}" {{ $cs->id == $srs->educational_attainment_id ? 'selected' : '' }}>{{ $ed->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="occupation_id[]" class="form-control" style="width: 200px; pointer-events:none; background-color : #e9ecef; ">
                                                                    <option value='' disabled selected>Select Option</option>
                                                                    @foreach($occupation as $occ)
                                                                    <option value="{{ $occ->id }}" {{ $cs->id == $srs->occupation_id ? 'selected' : '' }}>{{ $occ->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="identifier_id[]" class="form-control" style="width: 200px; pointer-events:none; background-color : #e9ecef; ">
                                                                    <option value='' disabled selected>Select Option</option>
                                                                    @foreach($identifier as $identify)
                                                                    <option value="{{ $identify->id }}" {{ $cs->id == $srs->identifier_id ? 'selected' : '' }}>{{ $identify->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="suspect_classification_id[]" class="form-control" style="width: 200px; pointer-events:none; background-color : #e9ecef; ">
                                                                    <option value='' disabled selected>Select Option</option>
                                                                    @foreach($suspect_classification as $sc)
                                                                    <option value="{{ $sc->id }}" {{ $sc->id == $srs->suspect_classification_id ? 'selected' : '' }}>{{ $sc->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="suspect_category_id[]" class="form-control" style="width: 200px; pointer-events:none; background-color : #e9ecef; ">
                                                                    <option value='' disabled selected>Select Option</option>
                                                                    @foreach($suspect_category as $sccat)
                                                                    <option value="{{ $sccat->id }}" {{ $sccat->id == $srs->suspect_category_id ? 'selected' : '' }}>{{ $sccat->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="suspect_sub_category_id[]" class="form-control" style="width: 200px; pointer-events:none; background-color : #e9ecef; ">
                                                                    <option value='' disabled selected>Select Option</option>
                                                                    @foreach($suspect_sub_category as $sscat)
                                                                    <option value="{{ $sscat->id }}" {{ $sscat->id == $srs->suspect_sub_category_id ? 'selected' : '' }}>{{ $sscat->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="suspect_status_id[]" class="form-control" style="width: 200px; pointer-events:none; background-color : #e9ecef; ">
                                                                    <option value='' disabled selected>Select Option</option>
                                                                    @foreach($suspect_status as $sstat)
                                                                    <option value="{{ $sstat->id }}" {{ $sstat->id == $srs->suspect_status_id ? 'selected' : '' }}>{{ $sstat->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="drug_test_result[]" class="form-control" style="width: 200px;">
                                                                    <option value='positive' {{ 'positive' == $srs->drug_test_result ? 'selected' : '' }}>Positive</option>
                                                                    <option value='negative' {{ 'negative' == $srs->drug_test_result ? 'selected' : '' }}>Negative</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="drug_type_id[]" class="form-control" style="width: 200px;">
                                                                    <option value='0' selected>Select Option</option>
                                                                    @foreach($drug_type as $dt)
                                                                    <option value="{{ $dt->id }}" {{ $dt->id == $srs->drug_type_id ? 'selected' : '' }}>{{ $dt->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="remarks[]" style="width: 200px; pointer-events:none; background-color : #e9ecef; " class="form-control" value="{{ $srs->remarks }}"></td>
                                                            <td style="text-align: center; padding: 10px"><input name="active" type="checkbox" style="pointer-events: none;" {{ $srs->listed == 1 ? 'checked' : ''}}></td>
                                                            <td><input type="text" style="width: 200px;" class="form-control" value="{{ $srs->uname }} - {{ $srs->ulvl }}" disabled></td>

                                                            <!-- <td class="mt-10"><button class="badge badge-danger"><i class="fa fa-trash"></i> Delete</button></td> -->
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- <div class="text-center"><button type="button" onclick="addSuspect();" class="badge badge-success"><i class="fa fa-plus"></i> ADD NEW</button></div> -->

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-four-drugseized" role="tabpanel" aria-labelledby="custom-tabs-four-drugseized-tab">
                                        <div class="form-group col-12" style="padding: 0 5px;" id="siblingTBL">
                                            <div class="card table-responsive p-0">
                                                <table id="drug_seized" class="table table-hover text-nowrap">
                                                    <thead>

                                                        <tr>
                                                            <th style="color: gray;" hidden>ID</th>
                                                            <th style="color: gray;">Suspect Name</th>
                                                            <th style="color: gray;">Drug Seized</th>
                                                            <th style="color: gray;">Qty. Onsite</th>
                                                            <th style="color: gray;">Actual Qty.</th>
                                                            <th style="color: gray;">Unit Measurement</th>
                                                            <th style="color: gray;">Lab Result</th>
                                                            <th style="color: gray;">Chemistry Report Number</th>
                                                            <th style="color: gray;">Laboratory Facility</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="evidence_details">
                                                        @foreach($spot_report_evidence as $srv)
                                                        <tr class="dtd">
                                                            <td hidden><input type="text" name="spot_report_evidence_id[]" class="form-control" value="{{$srv->id}}"></td>
                                                            <td><input type="text" name="" style="width: 300px; pointer-events:none; background-color : #e9ecef; " class="form-control" value="{{$srv->lastname}}, {{$srv->firstname}} {{$srv->middlename}} -- Alias: {{$srv->alias}}"></td>
                                                            <td><input type="text" name="" style="width: 200px; pointer-events:none; background-color : #e9ecef; " class="form-control" value="{{$srv->evidence}}"></td>
                                                            <td><input type="text" name="qty_onsite[]" style="width: 200px; pointer-events:none; background-color : #e9ecef; " class="form-control" value="{{$srv->quantity}}"></td>
                                                            <td><input type="text" name="actual_qty[]" style="width: 200px;" class="form-control" value="{{$srv->actual_qty}}"></td>
                                                            <td><input type="text" name="unit_measurement[]" style="width: 200px;" class="form-control disabled_field" value="{{$srv->unit_measurement}}"></td>
                                                            <td><select name="e_drug_test_result[]" class="form-control e_drug_test_result" style="width: 200px;">
                                                                    <option value="positive" {{'positive' == $srv->drug_test_result ? 'selected' : ''}}>Positive</option>
                                                                    <option value="negative" {{'negative' == $srv->drug_test_result ? 'selected' : ''}}>Negative</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="chemist_report_number[]" @if ($srv->drug_test_result == 'negative')
                                                                style="width: 200px; pointer-events:none; background-color : #e9ecef; "
                                                                @else
                                                                style="width: 200px;"
                                                                @endif class="form-control" value="{{$srv->chemist_report_number}}">
                                                            </td>
                                                            <td>
                                                                <select name="laboratory_facility_id[]" class="form-control" style="width: 200px;">
                                                                    <option value='' selected>Select Option</option>
                                                                    @foreach($laboratory_facility as $lf)
                                                                    <option value="{{ $lf->id }}" {{ $lf->id == $srv->laboratory_facility_id ? 'selected' : '' }}>{{ $lf->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- <div class="text-center"><button type="button" onclick="addItems();" class="badge badge-success"><i class="fa fa-plus"></i> ADD NEW</button></div> -->

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-four-casefiled" role="tabpanel" aria-labelledby="custom-tabs-four-casefiled-tab">
                                        <div class="form-group col-12" style="padding: 0 5px;" id="siblingTBL">
                                            <div class="card table-responsive p-0">
                                                <table id="case" class="table table-hover text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th style="color: gray;" hidden>ID</th>
                                                            <th style="color: gray;" hidden>ID</th>
                                                            <th style="color: gray;">Name of Suspect</th>
                                                            <th style="color: gray;">Case(s) Filed</th>
                                                            <th style="color: gray;">Docket Number</th>
                                                            <th style="color: gray;">Case Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="case_details">
                                                        @foreach($spot_report_case as $src)
                                                        <tr>
                                                            <td hidden><input type="text" name="spot_report_case_id[]" class="form-control" value="{{$src->spot_report_case_id}}"></td>
                                                            <td hidden><input type="text" name="suspect_number_case[]" class="form-control" value="{{$src->suspect_number}}"></td>
                                                            <td><input type="text" name="suspect_no[]" style="pointer-events:none; background-color : #e9ecef; " class="form-control" value="{{$src->lastname}}, {{$src->firstname}} {{$src->middlename}} -- Alias: {{$src->alias}}"></td>
                                                            <td><input type="text" name="case_id[]" style="pointer-events:none; background-color : #e9ecef; " class="form-control" value="{{$src->description}}"></td>
                                                            <td><input name="docket_number[]" type="text" class="form-control" value="{{$src->docket_number}}"></td>
                                                            <td><input name="c_case_status[]" type="text" class="form-control" value="{{$src->case_status}}"></td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="text-center"><button type="button" onclick="addCase();" class="badge badge-success"><i class="fa fa-plus"></i> ADD NEW</button></div>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-four-status" role="tabpanel" aria-labelledby="custom-tabs-four-status-tab">
                                        <div class="row">
                                            <div class="input-group mb-3 col-6">
                                                <select name="status_type" id="status_type" class="form-control">
                                                    <option value='' disabled selected>Select Option</option>
                                                    <option value="1">Inquest</option>
                                                    <option value="2">Preliminary Investigation</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="inquest" hidden>
                                            <h4>Inquest</h4>
                                            <div class="row">
                                                <div class="form-group col-6" style="margin: 0px;">
                                                    <div>
                                                        <label for="">Case Status</label>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input id="case_status" name="case_status" type="text" class="form-control @error('case status') is-invalid @enderror" value="{{$spot_report_header[0]->case_status}}" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="form-group col-3" style="margin: 0px;">
                                                    <div>
                                                        <label for="">Date</label>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input id="case_status_date" name="case_status_date" type="date" class="form-control @error('case status date') is-invalid @enderror" value="{{$spot_report_header[0]->case_status_date}}" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="form-group col-3" style="margin: 0px;">
                                                    <div>
                                                        <label for="">IS/NPS NUMBER</label>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input id="is_number" name="is_number" type="text" class="form-control @error('IS/NPS number') is-invalid @enderror" value="{{$spot_report_header[0]->is_number}}" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="form-group col-6" style="margin: 0px;">
                                                    <div>
                                                        <label for="">Name of Prosecutor</label>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input id="procecutor_name" name="procecutor_name" type="text" class="form-control @error('prosecutor name') is-invalid @enderror" value="{{$spot_report_header[0]->procecutor_name}}" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="form-group col-6" style="margin: 0px;">
                                                    <div>
                                                        <label for="">Prosecutor Office</label>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input id="procecutor_office" name="procecutor_office" type="text" class="form-control @error('prosecutor office') is-invalid @enderror" value="{{$spot_report_header[0]->procecutor_office}}" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prelim" hidden>
                                            <h4>Preliminary Investigation</h4>
                                            <div class="row">
                                                <div class="form-group col-6" style="margin: 0px;">
                                                    <div>
                                                        <label for="">Case Status</label>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input id="prelim_case_status" name="prelim_case_status" type="text" class="form-control @error('case status') is-invalid @enderror" value="{{$spot_report_header[0]->prelim_case_status}}" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="form-group col-3" style="margin: 0px;">
                                                    <div>
                                                        <label for="">Date Filed in Court</label>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input id="prelim_case_date" name="prelim_case_date" type="date" class="form-control @error('case date') is-invalid @enderror" value="{{$spot_report_header[0]->prelim_case_date}}" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="form-group col-3" style="margin: 0px;">
                                                    <div>
                                                        <label for="">IS/NPS NUMBER</label>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input id="prelim_is_number" name="prelim_is_number" type="text" class="form-control @error('IS/NPS number') is-invalid @enderror" value="{{$spot_report_header[0]->prelim_is_number}}" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="form-group col-6" style="margin: 0px;">
                                                    <div>
                                                        <label for="">Name of Prosecutor</label>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input id="prelim_prosecutor" name="prelim_prosecutor" type="text" class="form-control @error('prosecutor name') is-invalid @enderror" value="{{$spot_report_header[0]->prelim_prosecutor}}" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="form-group col-6" style="margin: 0px;">
                                                    <div>
                                                        <label for="">Prosecutor Office</label>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input id="prelim_prosecutor_office" name="prelim_prosecutor_office" type="text" class="form-control @error('prosecutor office') is-invalid @enderror" value="{{$spot_report_header[0]->prelim_prosecutor_office}}" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-four-summary" role="tabpanel" aria-labelledby="custom-tabs-four-summary-tab">
                                        <div class="form-group col-7" style="margin: 0px;">
                                            <div>
                                                <label for="">Report Header</label>
                                            </div>
                                            <div class="input-group mb-3">
                                                <input id="report_header" name="report_header" type="text" class="form-control @error('report header') is-invalid @enderror" value="{{$spot_report_header[0]->report_header}}" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group col-12" style="margin: 0px;">
                                            <div>
                                                <label for="">Summary</label>
                                            </div>
                                            <div class="input-group mb-3">
                                                <textarea id="summary" name="summary" class="form-control" autocomplete="off">{{$spot_report_header[0]->summary}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
                <hr>
                <br>
                <div class="row">
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Add Reference File</label>
                        </div>
                        <div class="custom-file">
                            <input type="file" name="fileattach[]" class="custom-file-input" id="fileattach" multiple />
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="form-group col-12" style="margin: 0px;">
                        <div>
                            <label for="">Reference Files:</label>
                        </div>
                        @foreach($progress_report_files as $prf)

                        <div class="row progress_report_files">
                            <a style="margin-right: 40px; padding-left: 20px" src="{{ asset('/files/uploads/progress_reports/' . $prf->filenames) }}" width="100%" height="600">File name: {{ $prf->filenames}}
                            </a>
                            <a href="{{ asset('/files/uploads/progress_reports/' . $prf->filenames) }}">View </a>
                        </div>

                        @endforeach
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="form-group col-7" style="margin: 0px;">
                        <div>
                            <label for="">Document Reference No.</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="reference_number" name="reference_number" type="text" class="form-control @error('reference number') is-invalid @enderror" value="{{$spot_report_header[0]->reference_number}}" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group col-7" style="margin: 0px;">
                        <div>
                            <label for="">Prepared By</label>
                        </div>
                        <div class="input-group mb-3">
                            @if(Auth::user()->user_level_id == 1 || Auth::user()->user_level_id == 2)
                            <select name="prepared_by" class="form-control" required>
                                <option value='' selected>Select Option</option>
                                @foreach($regional_user as $reg_u)
                                <option value="{{ $reg_u->name }}" {{ $reg_u->name == $spot_report_header[0]->prepared_by ? 'selected' : '' }}>{{ $reg_u->name }}</option>
                                @endforeach
                            </select>
                            @else
                            <input id="prepared_by" name="prepared_by" type="text" class="form-control" style="pointer-events: none;" value="{{ Auth::user()->name }}">
                            @endif
                        </div>
                    </div>
                    <div class="form-group col-7" style="margin: 0px;">
                        <div>
                            <label for="">Reviewed By</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="approved_by" name="approved_by" type="text" class="form-control @error('approved by') is-invalid @enderror" value="{{$spot_report_header[0]->approved_by}}" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="form-group mt-5">
                    <button type="submit" class="btn btn-primary">Save Progress Report</button>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <h6>Create Progress Report maintenance data.</h6>
        </div>
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

<!-- Set menu to collapse and active -->
@endsection

@section('scripts')

<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>

<script>
    $(".present_region_c").on("change", function() {

        var region_c = $(this).val();

        alert(region_c);

        // var $row = $(this).closest(".deptDetails");
        // var did = parseInt($row.find("td:eq(0)").text());
        // var dname = $.trim($row.find("td:eq(1)").text());
        // var ddesc = $.trim($row.find("td:eq(2)").text());
        // var dactive = $row.find("td:eq(3) input").val();

        // $("#dept_id").val(did);
        // $("#department_name").val(dname);
        // $("#dept_desc").val(ddesc);
        // if (dactive == 1) {
        //     $("#dept_active").prop("checked", true);
        // } else {
        //     $("#dept_active").prop("checked", false);
        // }

        $.ajax({
            type: "GET",
            url: "/get_province/" + region_c,
            fail: function() {
                alert("request failed");
            },
            success: function(data) {
                var data = JSON.parse(data);

                $("#province_c").empty();
                $("#city_c").empty();

                data.forEach(element => {
                    var option = " <option value='" +
                        element["province_c"] +
                        "'>" +
                        element["province_m"] +
                        "</option>";
                    $("#province_c").append(option);
                });
            }
        });
    });

    $("#province_c").on("change", function() {

        var region_c = $(this).val();

        $.ajax({
            type: "GET",
            url: "/get_city/" + region_c,
            fail: function() {
                alert("request failed");
            },
            success: function(data) {
                var data = JSON.parse(data);

                $("#city_c").empty();

                data.forEach(element => {
                    var option = " <option value='" +
                        element["city_c"] +
                        "'>" +
                        element["city_m"] +
                        "</option>";
                    $("#city_c").append(option);
                });
            }
        });
    });

    var suspect_row = 0;

    function addSuspect() {
        html = '<tr id="suspect_row' + suspect_row + '">';
        html += '<td><input type="text" name="suspect_number[]" style="width: 200px;" class="form-control"></td>';
        html += '<td><input type="text" name="lastname[]" style="width: 200px;" class="form-control"></td>';
        html += '<td><input type="text" name="firstname" style="width: 200px;" class="form-control"></td>';
        html += '<td><input type="text" name="middlename[]" style="width: 200px;" class="form-control"></td>';
        html += '<td><input type="text" name="alias[]" style="width: 200px;" class="form-control"></td>';
        html += '<td><input type="text" name="birthdate" style="width: 200px;" class="form-control"></td>';
        html += '<td><input type="text" name="birthplace" style="width: 200px;" class="form-control"></td>';
        html += '<td><select name="present_region_c[]" class="form-control" style="width: 200px;"><option value="0" disabled selected>Select Option</option>@foreach($region as $rg)<option value="{{ $rg->region_c }}">{{ $rg->abbreviation }} - {{ $rg->region_m }}</option>@endforeach</select></td>';
        html += '<td><select name="present_province_c[]" class="form-control" style="width: 200px;"></select></td>';
        html += '<td><select name="present_city_c[]" class="form-control" style="width: 200px;"></select></td>';
        html += '<td><select name="present_barangay_c[]" class="form-control" style="width: 200px;"></select></td>';
        html += '<td><input type="text" name="present_street[]" style="width: 200px;" class="form-control"></td>';
        html += '<td><select name="permanent_region_c[]" class="form-control" style="width: 200px;"><option value="0" disabled selected>Select Option</option>@foreach($region as $rg)<option value="{{ $rg->region_c }}">{{ $rg->abbreviation }} - {{ $rg->region_m }}</option>@endforeach</select></td>';
        html += '<td><select name="permanent_province_c[]" class="form-control" style="width: 200px;"></select></td>';
        html += '<td><select name="permanent_city_c[]" class="form-control" style="width: 200px;"></select></td>';
        html += '<td><select name="permanent_barangay_c[]" class="form-control" style="width: 200px;"></select></td>';
        html += '<td><input type="text" name="permanent_street[]" style="width: 200px;" class="form-control"></td>';
        html += '<td><select name="gender[]" class="form-control" style="width: 200px;"><option value="0" disabled selected>Select Option</option><option value="male">Male</option><option value="female">Female</option></select></td>';
        html += '<td><select name="civil_status_id[]" class="form-control" style="width: 200px;"><option value="0" disabled selected>Select Option</option>@foreach($civil_status as $cs)<option value="{{ $cs->id }}">{{ $cs->name }}</option>@endforeach</select></td>';
        html += '<td><select name="nationality_id[]" class="form-control" style="width: 200px;"><option value="0" disabled selected>Select Option</option>@foreach($nationality as $na)<option value="{{ $na->id }}">{{ $na->name }}</option>@endforeach</select></td>';
        html += '<td><select name="ethnic_group_id[]" class="form-control" style="width: 200px;"><option value="0" disabled selected>Select Option</option>@foreach($ethnic_group as $eg)<option value="{{ $eg->id }}">{{ $eg->name }}</option>@endforeach</select></td>';
        html += '<td><select name="religion_id[]" class="form-control" style="width: 200px;"><option value="0" disabled selected>Select Option</option>@foreach($religion as $rl)<option value="{{ $rl->id }}">{{ $rl->name }}</option>@endforeach</select></td>';
        html += '<td><select name="educational_attainment_id[]" class="form-control" style="width: 200px;"><option value="0" disabled selected>Select Option</option>@foreach($education as $ed)<option value="{{ $ed->id }}">{{ $ed->name }}</option>@endforeach</select></td>';
        html += '<td><select name="occupation_id[]" class="form-control" style="width: 200px;"><option value="0" disabled selected>Select Option</option>@foreach($occupation as $occ)<option value="{{ $occ->id }}">{{ $occ->name }}</option>@endforeach</select></td>';
        html += '<td class="mt-10"><button class="badge badge-danger" onclick="$(\'#suspect_row' + suspect_row + '\').remove();"><i class="fa fa-trash"></i> Delete</button></td>';
        html += '</tr>';

        $('#suspect tbody').append(html);

        suspect_row++;
    }

    var items_row = 0;

    function addItems() {
        html = '<tr id="items-row' + items_row + '">';
        html += '<td><input type="text" class="form-control" ></td>';
        html += '<td><input type="text" class="form-control" ></td>';
        html += '<td><input type="text" class="form-control" ></td>';
        html += '<td><input type="text" class="form-control"></td>';
        html += '<td><input type="text" class="form-control"></td>';
        html += '<td><input type="text" class="form-control"></td>';
        html += '<td class="mt-10"><button class="badge badge-danger" onclick="$(\'#items-row' + items_row + '\').remove();"><i class="fa fa-trash"></i> Delete</button></td>';

        html += '</tr>';

        $('#items tbody').append(html);

        items_row++;
    }

    var case_row = 0;

    function addCase() {

        var spot_report_number = $('#spot_report_number').val();
        var class_count = case_row;

        var details =
            '<tr>' +
            '<td hidden><input type="text" name="spot_report_case_id[]" style="pointer-events: none; background-color : #e9ecef; width: 00px;" class="form-control" value="0"></td>' +
            '<td hidden><input type="text" name="suspect_number_case[]" style="pointer-events: none; background-color : #e9ecef; width: 00px;" class="form-control" value="0"></td>' +
            '<td><select name="suspect_no[]" class="form-control caserow' + case_row + '"><option value="">Select Option</option></select></td>' +
            '<td><select name="case_id[]" class="form-control"><option value="" selected>Select Option</option>@foreach($case as $cs)<option value="{{ $cs->id }}">{{ $cs->description }}</option>@endforeach</select></td>' +
            '<td><input name="docket_number[]" type="text" class="form-control"></td>' +
            '<td><input name="c_case_status[]" type="text" class="form-control"></td>' +
            '</tr>';
        $("#case_details").append(details);

        $.ajax({
            type: "GET",
            url: "/get_spot_report_suspect/" + spot_report_number,
            fail: function() {
                alert("request failed");
            },
            success: function(data) {
                var data = JSON.parse(data);
                var classname = ".caserow" + class_count;
                // alert(class_count);
                if (data.length > 0) {
                    data.forEach(element => {
                        var option = "<option value='" +
                            element["suspect_number"] +
                            "'>" +
                            element["lastname"] + ", " + element["firstname"] + " " + element["middlename"] +
                            "</option>";
                        $(".caserow" + class_count).append(option);
                    });
                } else {
                    var option1 = " <option value='0' selected>Select Option</option>";
                    $(".caserow" + class_count).append(option1);
                }
            }
        });

        case_row++;
    }

    var opteam_row = 0;

    function addOpteam() {
        html = '<tr id="opteam-row' + opteam_row + '">';
        html += '<td><input type="text" class="form-control"></td>';
        html += '<td><input type="text" class="form-control"></td>';
        html += '<td class="mt-10"><button class="badge badge-danger" onclick="$(\'#opteam-row' + opteam_row + '\').remove();"><i class="fa fa-trash"></i> Delete</button></td>';

        html += '</tr>';

        $('#opteam tbody').append(html);

        opteam_row++;
    }

    // Populate Fields per Spot Report
    $("#spot_report_number").on("change", function() {

        var spot_report_number = $(this).val();

        $.ajax({
            type: "GET",
            url: "/get_spot_report_header/" + spot_report_number,
            fail: function() {
                alert("request failed");
            },
            success: function(data) {
                var data = JSON.parse(data);

                data.forEach(element => {

                    $("#operating_unit").val(element["operating_unit_name"]);
                    $("#operation_type").val(element["operation_type_name"]);
                    $("#operation_datetime").val(element["operation_datetime"]);
                    $("#region_m").val(element["region_m"]);
                    $("#region_c").val(element["region_m"]);
                    $("#province_m").val(element["province_m"]);
                    $("#province_c").val(element["province_m"]);
                    $("#city_m").val(element["city_m"]);
                    $("#city_c").val(element["city_m"]);
                    $("#barangay_m").val(element["barangay_m"]);
                    $("#barangay_c").val(element["barangay_m"]);
                });
            }
        });

        // Populate Suspect Info
        $("#suspect_details").empty();

        $.ajax({
            type: "GET",
            url: "/get_spot_report_suspect/" + spot_report_number,
            fail: function() {
                alert("request failed");
            },
            success: function(data) {
                var data = JSON.parse(data);

                if (data.length > 0) {
                    data.forEach(element => {
                        var details =
                            '<tr>' +
                            '<td><input type="text" name="suspect_number[]" style="pointer-events: none; background-color : #e9ecef;  width: 200px;" class="form-control" value="' + element["suspect_number"] + '"></td>' +
                            '<td><input type="text" name="lastname[]" style="pointer-events: none; background-color : #e9ecef;  width: 200px;" class="form-control" value="' + element["lastname"] + '"></td>' +
                            '<td><input type="text" name="firstname" style="pointer-events: none; background-color : #e9ecef;  width: 200px;" class="form-control" value="' + element["firstname"] + '"></td>' +
                            '<td><input type="text" name="middlename[]" style="pointer-events: none; background-color : #e9ecef;  width: 200px;" class="form-control" value="' + element["middlename"] + '"></td>' +
                            '<td><input type="text" name="alias[]" style="pointer-events: none; background-color : #e9ecef;  width: 200px;" class="form-control" value="' + element["alias"] + '"></td>' +
                            '<td><input type="text" name="birthdate[]" style="pointer-events: none; background-color : #e9ecef;  width: 200px;" class="form-control" value="' + element["birthdate"] + '"></td>' +
                            '<td><input type="text" name="birthplace[]" style="pointer-events: none; background-color : #e9ecef;  width: 200px;" class="form-control" value="' + element["birthplace"] + '"></td>' +
                            '<td><input type="text" name="region[]" style="pointer-events: none; background-color : #e9ecef;  width: 200px;" class="form-control" value="' + element["region_m"] + '"></td>' +
                            '<td><input type="text" name="province[]" style="pointer-events: none; background-color : #e9ecef;  width: 200px;" class="form-control" value="' + element["province_m"] + '"></td>' +
                            '<td><input type="text" name="city[]" style="pointer-events: none; background-color : #e9ecef;  width: 200px;" class="form-control" value="' + element["city_m"] + '"></td>' +
                            '<td><input type="text" name="barangay[]" style="pointer-events: none; background-color : #e9ecef;  width: 200px;" class="form-control" value="' + element["barangay_m"] + '"></td>' +
                            '<td><input type="text" name="street[]" style="pointer-events: none; background-color : #e9ecef;  width: 200px;" class="form-control" value="' + element["street"] + '"></td>' +
                            '<td><input type="text" name="permanent_region[]" style="pointer-events: none; background-color : #e9ecef;  width: 200px;" class="form-control" value="' + element["permanent_region_m"] + '"></td>' +
                            '<td><input type="text" name="permanent_province[]" style="pointer-events: none; background-color : #e9ecef;  width: 200px;" class="form-control" value="' + element["permanent_province_m"] + '"></td>' +
                            '<td><input type="text" name="permanent_city[]" style="pointer-events: none; background-color : #e9ecef;  width: 200px;" class="form-control" value="' + element["permanent_city_m"] + '"></td>' +
                            '<td><input type="text" name="permanent_barangay[]" style="pointer-events: none; background-color : #e9ecef;  width: 200px;" class="form-control" value="' + element["permanent_barangay_m"] + '"></td>' +
                            '<td><input type="text" name="permanent_street[]" style="pointer-events: none; background-color : #e9ecef;  width: 200px;" class="form-control" value="' + element["permanent_street"] + '"></td>' +
                            '<td><input type="text" name="gender[]" style="pointer-events: none; background-color : #e9ecef;  width: 200px;" class="form-control" value="' + element["gender"] + '"></td>' +
                            '<td><input type="text" name="civil_status[]" style="pointer-events: none; background-color : #e9ecef;  width: 200px;" class="form-control" value="' + element["civil_status"] + '"></td>' +
                            '<td><input type="text" name="nationality[]" style="pointer-events: none; background-color : #e9ecef;  width: 200px;" class="form-control" value="' + element["nationality"] + '"></td>' +
                            '<td><input type="text" name="ethnic_group[]" style="pointer-events: none; background-color : #e9ecef;  width: 200px;" class="form-control" value="' + element["ethnic_group"] + '"></td>' +
                            '<td><input type="text" name="religion[]" style="pointer-events: none; background-color : #e9ecef;  width: 200px;" class="form-control" value="' + element["religion"] + '"></td>' +
                            '<td><input type="text" name="educational_attainment[]" style="pointer-events: none; background-color : #e9ecef;  width: 200px;" class="form-control" value="' + element["birthplace"] + '"></td>' +
                            '<td><input type="text" name="occupation[]" style="pointer-events: none; background-color : #e9ecef;  width: 200px;" class="form-control" value="' + element["occupation"] + '"></td>' +
                            '</tr>';
                        $("#suspect_details").append(details);
                    });
                } else {
                    var details =
                        '<tr>' +
                        '<td><input type="text" name="suspect_number[]" style="width: 200px;" class="form-control"></td>' +
                        '<td><input type="text" name="lastname[]" style="width: 200px;" class="form-control"></td>' +
                        '<td><input type="text" name="firstname" style="width: 200px;" class="form-control"></td>' +
                        '<td><input type="text" name="middlename[]" style="width: 200px;" class="form-control"></td>' +
                        '<td><input type="text" name="alias[]" style="width: 200px;" class="form-control"></td>' +
                        '<td><input type="text" name="birthdate[]" style="width: 200px;" class="form-control"></td>' +
                        '<td><input type="text" name="birthplace[]" style="width: 200px;" class="form-control"></td>' +
                        '<td><input type="text" name="region[]" style="width: 200px;" class="form-control"></td>' +
                        '<td><input type="text" name="province[]" style="width: 200px;" class="form-control"></td>' +
                        '<td><input type="text" name="city[]" style="width: 200px;" class="form-control"></td>' +
                        '<td><input type="text" name="barangay[]" style="width: 200px;" class="form-control"></td>' +
                        '<td><input type="text" name="street[]" style="width: 200px;" class="form-control"></td>' +
                        '<td><input type="text" name="permanent_region[]" style="width: 200px;" class="form-control"></td>' +
                        '<td><input type="text" name="permanent_province[]" style="width: 200px;" class="form-control"></td>' +
                        '<td><input type="text" name="permanent_city[]" style="width: 200px;" class="form-control"></td>' +
                        '<td><input type="text" name="permanent_barangay[]" style="width: 200px;" class="form-control"></td>' +
                        '<td><input type="text" name="permanent_street[]" style="width: 200px;" class="form-control"></td>' +
                        '<td><input type="text" name="gender[]" style="width: 200px;" class="form-control"></td>' +
                        '<td><input type="text" name="civil_status[]" style="width: 200px;" class="form-control"></td>' +
                        '<td><input type="text" name="nationality[]" style="width: 200px;" class="form-control"></td>' +
                        '<td><input type="text" name="ethnic_group[]" style="width: 200px;" class="form-control"></td>' +
                        '<td><input type="text" name="religion[]" style="width: 200px;" class="form-control"></td>' +
                        '<td><input type="text" name="educational_attainment[]" style="width: 200px;" class="form-control"></td>' +
                        '<td><input type="text" name="occupation[]" style="width: 200px;" class="form-control"></td>' +
                        '</tr>';
                    $("#suspect_details").append(details);
                }

            }
        });

        // Populate Item Seized
        $("#evidence_details").empty();

        $.ajax({
            type: "GET",
            url: "/get_spot_report_evidence_drug/" + spot_report_number,
            fail: function() {
                alert("request failed");
            },
            success: function(data) {
                var data = JSON.parse(data);

                if (data.length > 0) {
                    data.forEach(element => {
                        var details =
                            '<tr>' +
                            '<td hidden><input type="text" name="spot_report_evidence_id[]" style="pointer-events: none; background-color : #e9ecef;  width: 00px;" class="form-control" value="' + element["spot_report_evidence_id"] + '"></td>' +
                            '<td><input type="text" style="pointer-events: none; background-color : #e9ecef;  width: 300px;" class="form-control" value="' + element["lastname"] + ', ' + element["firstname"] + ' ' + element["middlename"] + '-- Alias: ' + element["alias"] + '"></td>' +
                            '<td><input type="text" name="evidence" style="pointer-events: none; background-color : #e9ecef;  width: 200px;" class="form-control" value="' + element["evidence"] + '"></td>' +
                            '<td><input type="text" name="initial_weight[]" style="width: 200px;" class="form-control" value=""></td>' +
                            '<td><input type="text" name="breakdown[]" style="width: 200px;" class="form-control" value=""></td>' +
                            '<td><input type="text" name="lab_test_weight[]" style="width: 200px;" class="form-control" value=""></td>' +
                            '<td><input type="text" name="lab_test_result[]" style="width: 200px;" class="form-control" value=""></td>' +
                            '<td><input type="text" name="value[]" style="width: 200px;" class="form-control" value=""></td>' +
                            '<td><input type="text" name="chemist[]" style="width: 200px;" class="form-control" value=""></td>' +
                            '<td><input type="text" name="chemist_report_number[]" style="width: 200px;" class="form-control" value=""></td>' +
                            '</tr>';
                        $("#evidence_details").append(details);
                    });
                } else {
                    var details =
                        '<tr>' +
                        '<td hidden><input type="text" name="spot_report_evidence_id[]" style="pointer-events: none; background-color : #e9ecef;  width: 00px;" class="form-control" value=""></td>' +
                        '<td><input type="text" style="pointer-events: none; background-color : #e9ecef;  width: 300px;" class="form-control" value=""></td>' +
                        '<td><input type="text"  name="evidence" style="pointer-events: none; background-color : #e9ecef;  width: 200px;" class="form-control" value=""></td>' +
                        '<td><input type="text" name="initial_weight[]" style="pointer-events: none; background-color : #e9ecef; width: 200px;" class="form-control" value=""></td>' +
                        '<td><input type="text" name="breakdown[]" style="pointer-events: none; background-color : #e9ecef; width: 200px;" class="form-control" value=""></td>' +
                        '<td><input type="text" name="lab_test_weight[]" style="pointer-events: none; background-color : #e9ecef; width: 200px;" class="form-control" value=""></td>' +
                        '<td><input type="text" name="lab_test_result[]" style="pointer-events: none; background-color : #e9ecef; width: 200px;" class="form-control" value=""></td>' +
                        '<td><input type="text" name="value[]" style="pointer-events: none; background-color : #e9ecef; width: 200px;" class="form-control" value=""></td>' +
                        '<td><input type="text" name="chemist[]" style="pointer-events: none; background-color : #e9ecef; width: 200px;" class="form-control" value=""></td>' +
                        '<td><input type="text" name="chemist_report_number[]" style="pointer-events: none; background-color : #e9ecef; width: 200px;" class="form-control" value=""></td>' +
                        '</tr>';
                    $("#evidence_details").append(details);
                }

            }
        });

        // Populate Case Filed
        $("#case_details").empty();

        $.ajax({
            type: "GET",
            url: "/get_spot_report_case/" + spot_report_number,
            fail: function() {
                alert("request failed");
            },
            success: function(data) {
                var data = JSON.parse(data);

                if (data.length > 0) {
                    data.forEach(element => {
                        var details =
                            '<tr>' +
                            '<td hidden><input type="text" name="spot_report_case_id[]" style="pointer-events: none; background-color : #e9ecef;  width: 00px;" class="form-control" value="' + element["spot_report_case_id"] + '"></td>' +
                            '<td><input type="text" style="pointer-events: none; background-color : #e9ecef; " class="form-control" value="' + element["lastname"] + ', ' + element["firstname"] + ' ' + element["middlename"] + '-- Alias: ' + element["alias"] + '"></td>' +
                            '<td><input type="text" style="pointer-events: none; background-color : #e9ecef; " class="form-control" value="' + element["description"] + '"></td>' +
                            '<td><input type="text" name="docket_number[]" class="form-control" value=""></td>' +
                            '<td><input type="text" name="c_case_status[]" class="form-control" value=""></td>' +
                            '</tr>';
                        $("#case_details").append(details);
                    });
                } else {
                    var details =
                        '<tr>' +
                        '<td hidden><input type="text" name="spot_report_case_id[]" style="pointer-events: none; background-color : #e9ecef;  width: 00px;" class="form-control" value=""></td>' +
                        '<td><input type="text" style="pointer-events: none; background-color : #e9ecef;  width: 300px;" class="form-control" value="Null"></td>' +
                        '<td><input type="text" style="pointer-events: none; background-color : #e9ecef;  width: 200px;" class="form-control" value="Null"></td>' +
                        '<td><input type="text" style="pointer-events: none; background-color : #e9ecef; width: 200px;" class="form-control" value="Null"></td>' +
                        '<td><input type="text" style="pointer-events: none; background-color : #e9ecef; width: 200px;" class="form-control" value="Null"></td>' +
                        '</tr>';
                    $("#case_details").append(details);
                }

            }
        });
    });


    $("#status_type").on("change", function() {

        var status_type = $(this).val();

        if (status_type == 1) {
            $(".inquest").attr('hidden', false);
            $(".prelim").attr('hidden', true);
            $(".court").attr('hidden', true);
        } else if (status_type == 2) {
            $(".inquest").attr('hidden', true);
            $(".prelim").attr('hidden', false);
            $(".court").attr('hidden', true);
        } else if (status_type == 3) {
            $(".inquest").attr('hidden', true);
            $(".prelim").attr('hidden', true);
            $(".court").attr('hidden', false);
        }

    });

    $(".fileDelete").on("click", function() {
        var file_id = $(this).closest(".progress_report_files").find('.file_id').val();
        var file_name = $(this).closest(".progress_report_files").find('.file_name').val();

        swal({
                title: "Are you sure you want to remove " + file_name + "?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                closeOnConfirm: false,
                closeOnCancel: false,
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                    });
                    $.ajax({
                        type: "get",
                        url: "/progress_report_file_delete/" +
                            file_id,
                        fail: function() {
                            alert("request failed");
                        },
                        success: function(data) {
                            swal({
                                    title: "Success",
                                    text: file_name + " Removed!",
                                    type: "success",
                                },
                                function() {
                                    location.reload();
                                }
                            );
                        },
                    });
                } else {
                    swal("Cancelled", "Remove cancelled", "error");
                }
            }
        );
    });

    //Disable-Enable Chemistry Report Number
    $(document).on("change", ".e_drug_test_result", function() {
        var e_drug_test_result = $(this).val();
        var $row = $(this).closest(".dtd");

        if (e_drug_test_result == 'negative') {
            $($row.find("td:eq(7) input")).val('');
            $($row.find("td:eq(7) input")).addClass('disabled_field');
        } else {
            $($row.find("td:eq(7) input")).removeClass('disabled_field');
        }


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