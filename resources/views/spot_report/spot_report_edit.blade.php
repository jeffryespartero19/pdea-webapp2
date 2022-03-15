@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Spot Report</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="removeCokie();">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('spot_report_list') }}">Spot Report List</a></li>
                    <li class="breadcrumb-item active">Edit Spot Report</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-ban"></i> Error!</h5>
        {{ $error }}
    </div>
    @endforeach
    @endif

    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-check"></i> Success!</h5>
        {{ session()->get('success') }}
    </div>
    @endif
    <!-- Default box -->
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Edit Spot Report</h3>
        </div>
        <div class="card-body">
            <form action="/spot_report_edit/{{ $spot_report_header[0]->id }}" role="form" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <a href="{{ url('spot_report/pdf/'.$spot_report_header[0]->id) }}" class="btn btn-warning" style="float: right;">Print Report</a>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Pre-ops No.<code> *</code></label>
                        </div>
                        <div class="input-group mb-3">
                            <select name="preops_number" class="form-control @error('region') is-invalid @enderror" style="pointer-events: none; background-color : #e9ecef;">
                                <option value='' disabled selected>Select Option</option>
                                <option value='1' {{ 1 == $spot_report_header[0]->preops_number ? 'selected' : '' }}>Uncoordinated</option>
                                @foreach ($preops_header as $ph)
                                <option value="{{ $ph->preops_number }}" {{ $ph->preops_number == $spot_report_header[0]->preops_number ? 'selected' : '' }}>
                                    {{ $ph->preops_number }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Date Reported<code> *</code></label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="reported_date" name="reported_date" type="date" class="form-control @error('reported date') is-invalid @enderror" value="{{ $spot_report_header[0]->reported_date }}" autocomplete="off" required>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">

                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Spot Report No.<code> *</code></label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="spot_report_number" name="spot_report_number" type="text" class="form-control @error('spot report number') is-invalid @enderror disabled_field" autocomplete="off" required value="{{ $spot_report_header[0]->spot_report_number }}" style="pointer-events: none; background-color : #e9ecef;">
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Type of Operation<code> *</code></label>
                        </div>
                        <div class="input-group mb-3">
                            <select name="operation_type_id" class="form-control @error('operation type') is-invalid @enderror" required style="pointer-events: none; background-color : #e9ecef;">
                                <option value='' disabled selected>Select Option</option>
                                @foreach ($operation_type as $ot)
                                <option value="{{ $ot->id }}" {{ $ot->id == $spot_report_header[0]->operation_type_id ? 'selected' : '' }}>
                                    {{ $ot->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-12" style="margin: 0px; padding:20px 10px">
                        <div class="custom-control custom-checkbox mb-2">
                            <input name="operation_lvl" class="custom-control-input" type="checkbox" id="customCheckbox9" {{ $spot_report_header[0]->operation_lvl == true ? 'checked' : '' }}>
                            <label for="customCheckbox9" class="custom-control-label">High Impact Operation</label>
                        </div>
                    </div>

                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Region<code> *</code></label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="region_c" name="region_c" class="form-control @error('region') is-invalid @enderror" style="pointer-events: none; background-color : #e9ecef;">
                                <option value='' disabled selected>Select Option</option>
                                @foreach ($region as $rg)
                                <option value="{{ $rg->region_c }}" {{ $rg->region_c == $spot_report_header[0]->region_c ? 'selected' : '' }}>
                                    {{ $rg->abbreviation }} - {{ $rg->region_m }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Province<code> *</code></label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="province_c" name="province_c" class="form-control @error('province') is-invalid @enderror" style="pointer-events: none; background-color : #e9ecef;">
                                <option value='' disabled selected>Select Option</option>
                                @foreach ($province as $pr)
                                <option value="{{ $pr->province_c }}" {{ $pr->province_c == $spot_report_header[0]->province_c ? 'selected' : '' }}>
                                    {{ $pr->province_m }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">City<code> *</code></label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="city_c" name="city_c" class="form-control @error('city') is-invalid @enderror">
                                <option value='' disabled selected>Select Option</option>
                                @foreach ($city as $pr)
                                <option value="{{ $pr->city_c }}" {{ $pr->city_c == $spot_report_header[0]->city_c ? 'selected' : '' }}>
                                    {{ $pr->city_m }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Barangay<code> *</code></label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="barangay_c" name="barangay_c" class="form-control @error('barangay') is-invalid @enderror">
                                <option value='' disabled selected>Select Option</option>
                                @foreach ($barangay as $pr)
                                <option value="{{ $pr->barangay_c }}" {{ $pr->barangay_c == $spot_report_header[0]->barangay_c ? 'selected' : '' }}>
                                    {{ $pr->barangay_m }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Street</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="street" name="street" type="text" class="form-control" autocomplete="off" value="{{ $spot_report_header[0]->street }}">
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Date/Time of Operation<code> *</code></label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="operation_datetime" name="operation_datetime" type="datetime-local" class="form-control @error('operation date') is-invalid @enderror" value="{{ date('Y-m-d\TH:i:s', strtotime($spot_report_header[0]->operation_datetime)) }}" autocomplete="off" style="pointer-events: none; background-color : #e9ecef;">
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Operating Unit<code> *</code></label>
                        </div>
                        <div class="input-group mb-3">
                            <select name="operating_unit_id" class="form-control @error('region') is-invalid @enderror" style="pointer-events: none; background-color : #e9ecef;">
                                <option value='' disabled selected>Select Option</option>
                                @foreach ($operating_unit as $ou)
                                <option value="{{ $ou->id }}" {{ $ou->id == $spot_report_header[0]->operating_unit_id ? 'selected' : '' }}>
                                    {{ $ou->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Supporting Unit<code> *</code></label>
                        </div>
                        @foreach ($preops_support_unit as $psu)
                        <div class="input-group mb-3">
                            <select name="support_unit_id[]" class="form-control @error('region') is-invalid @enderror" style="pointer-events: none; background-color : #e9ecef;" required>
                                <option value='' disabled selected>Select Option</option>
                                @foreach ($support_unit as $su)
                                <option value="{{ $su->id }}" {{ $su->id == $psu->support_unit_id ? 'selected' : '' }}>
                                    {{ $su->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @endforeach
                    </div>

                </div>

                <div class="row" id="warrant_Details" {{ 1 == $is_warrant[0]->is_warrant ? '' : 'hidden' }}>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Warrant No.</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="warrant_number" name="warrant_number" type="text" class="form-control @error('warrant number') is-invalid @enderror" value="{{ $spot_report_header[0]->warrant_number }}" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Issuing Judge</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="judge_name" name="judge_name" type="text" class="form-control @error('judge name') is-invalid @enderror" value="{{ $spot_report_header[0]->judge_name }}" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Branch</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="branch" name="branch" type="text" class="form-control @error('branch') is-invalid @enderror" value="{{ $spot_report_header[0]->branch }}" autocomplete="off">
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-12 col-sm-12">
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Suspect</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-four-evidence-tab" data-toggle="pill" href="#custom-tabs-four-evidence" role="tab" aria-controls="custom-tabs-four-evidence" aria-selected="false">Item
                                            Seized</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-four-case-tab" data-toggle="pill" href="#custom-tabs-four-case" role="tab" aria-controls="custom-tabs-four-case" aria-selected="false">Case
                                            Filed</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-four-operatingteam-tab" data-toggle="pill" href="#custom-tabs-four-operatingteam" role="tab" aria-controls="custom-tabs-four-operatingteam" aria-selected="false">Operating Team</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-four-summary-tab" data-toggle="pill" href="#custom-tabs-four-summary" role="tab" aria-controls="custom-tabs-four-summary" aria-selected="false">Summary</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-four-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                        <div class="form-group col-12" style="padding: 0 5px;" id="siblingTBL">
                                            <div class="card table-responsive p-0">
                                                <table id="suspect" class="table table-hover text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th hidden>ID</th>
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
                                                            <th style="color: gray;">Suspect Classification</th>
                                                            <th style="color: gray;">Suspect Category</th>
                                                            <th style="color: gray;">Suspect Status</th>
                                                            <th style="color: gray;">Remarks</th>
                                                            <th style="color: gray;">Listed</th>
                                                            <th style="color: gray;">Listed By</th>
                                                            <th style="color: gray;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="suspect_informations">
                                                        @forelse($spot_report_suspect as $srs)
                                                        <tr class="suspect_details">
                                                            <td hidden><input type="number" name="spot_suspect_id[]" class="form-control" value="{{ $srs->id }}"></td>
                                                            <td><input required type="text" name="suspect_number[]" style="width: 200px; pointer-events:none; background-color : #e9ecef;" class="form-control" value="{{ $srs->suspect_number }}"></td>
                                                            <td><input required type="text" name="lastname[]" style="width: 200px;" class="form-control" value="{{ $srs->lastname }}"></td>
                                                            <td><input required type="text" name="firstname[]" style="width: 200px;" class="form-control" value="{{ $srs->firstname }}"></td>
                                                            <td><input required type="text" name="middlename[]" style="width: 200px;" class="form-control" value="{{ $srs->middlename }}"></td>
                                                            <td><input required type="text" name="alias[]" style="width: 200px;" class="form-control" value="{{ $srs->alias }}"></td>
                                                            <td><input required type="date" name="birthdate[]" style="width: 200px;" class="form-control" value="{{ $srs->birthdate }}"></td>
                                                            <td><input type="text" name="birthplace[]" style="width: 200px;" class="form-control" value="{{ $srs->birthplace }}"></td>
                                                            <td>
                                                                <select name="present_region_c[]" class="form-control present_region_c" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                    @foreach ($region as $rg)
                                                                    <option value="{{ $rg->region_c }}" {{ $rg->region_c == $srs->region_c ? 'selected' : '' }}>
                                                                        {{ $rg->abbreviation }} -
                                                                        {{ $rg->region_m }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="present_province_c[]" class="form-control present_province_c" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                    @foreach ($province as $pr)
                                                                    <option value="{{ $pr->province_c }}" {{ $pr->province_c == $srs->province_c ? 'selected' : '' }}>
                                                                        {{ $pr->province_m }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="present_city_c[]" class="form-control present_city_c" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                    @foreach ($city as $ct)
                                                                    <option value="{{ $ct->city_c }}" {{ $ct->city_c == $srs->city_c ? 'selected' : '' }}>
                                                                        {{ $ct->city_m }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="present_barangay_c[]" class="form-control present_barangay_c" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                    @foreach ($barangay as $br)
                                                                    <option value="{{ $br->barangay_c }}" {{ $br->barangay_c == $srs->barangay_c ? 'selected' : '' }}>
                                                                        {{ $br->barangay_m }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="present_street[]" style="width: 200px;" class="form-control" value="{{ $srs->street }}"></td>
                                                            <td>
                                                                <select name="permanent_region_c[]" class="form-control permanent_region_c" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                    @foreach ($region as $rg)
                                                                    <option value="{{ $rg->region_c }}" {{ $rg->region_c == $srs->permanent_region_c ? 'selected' : '' }}>
                                                                        {{ $rg->abbreviation }} -
                                                                        {{ $rg->region_m }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="permanent_province_c[]" class="form-control permanent_province_c" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                    @foreach ($province as $pr)
                                                                    <option value="{{ $pr->province_c }}" {{ $pr->province_c == $srs->permanent_province_c ? 'selected' : '' }}>
                                                                        {{ $pr->province_m }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="permanent_city_c[]" class="form-control permanent_city_c" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                    @foreach ($city as $ct)
                                                                    <option value="{{ $ct->city_c }}" {{ $ct->city_c == $srs->permanent_city_c ? 'selected' : '' }}>
                                                                        {{ $ct->city_m }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="permanent_barangay_c[]" class="form-control permanent_barangay_c" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                    @foreach ($barangay as $br)
                                                                    <option value="{{ $br->barangay_c }}" {{ $br->barangay_c == $srs->permanent_barangay_c ? 'selected' : '' }}>
                                                                        {{ $br->barangay_m }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="permanent_street[]" style="width: 200px;" class="form-control" value="{{ $srs->permanent_street }}"></td>
                                                            <td>
                                                                <select name="gender[]" class="form-control" style="width: 200px;">
                                                                    <option value="male" {{ 'male' == $srs->gender ? 'selected' : '' }}>
                                                                        Male</option>
                                                                    <option value="female" {{ 'female' == $srs->gender ? 'selected' : '' }}>
                                                                        Female</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="civil_status_id[]" class="form-control" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                    @foreach ($civil_status as $cs)
                                                                    <option value="{{ $cs->id }}" {{ $cs->id == $srs->civil_status_id ? 'selected' : '' }}>
                                                                        {{ $cs->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="nationality_id[]" class="form-control" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                    @foreach ($nationality as $na)
                                                                    <option value="{{ $na->id }}" {{ $na->id == $srs->nationality_id ? 'selected' : '' }}>
                                                                        {{ $na->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="ethnic_group_id[]" class="form-control" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                    @foreach ($ethnic_group as $eg)
                                                                    <option value="{{ $eg->id }}" {{ $eg->id == $srs->ethnic_group_id ? 'selected' : '' }}>
                                                                        {{ $eg->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="religion_id[]" class="form-control" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                    @foreach ($religion as $rl)
                                                                    <option value="{{ $rl->id }}" {{ $rl->id == $srs->religion_id ? 'selected' : '' }}>
                                                                        {{ $rl->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="educational_attainment_id[]" class="form-control" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                    @foreach ($education as $ed)
                                                                    <option value="{{ $ed->id }}" {{ $ed->id == $srs->educational_attainment_id ? 'selected' : '' }}>
                                                                        {{ $ed->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="occupation_id[]" class="form-control" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                    @foreach ($occupation as $occ)
                                                                    <option value="{{ $occ->id }}" {{ $occ->id == $srs->occupation_id ? 'selected' : '' }}>
                                                                        {{ $occ->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="suspect_classification_id[]" class="form-control" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                    @foreach ($suspect_classification as $sclass)
                                                                    <option value="{{ $sclass->id }}" {{ $sclass->id == $srs->suspect_classification_id ? 'selected' : '' }}>
                                                                        {{ $sclass->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="suspect_category_id[]" class="form-control" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                    @foreach ($suspect_category as $scat)
                                                                    <option value="{{ $scat->id }}" {{ $scat->id == $srs->suspect_category_id ? 'selected' : '' }}>
                                                                        {{ $scat->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="suspect_status_id[]" class="form-control" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                    @foreach ($suspect_status as $sstat)
                                                                    <option value="{{ $sstat->id }}" {{ $sstat->id == $srs->suspect_status_id ? 'selected' : '' }}>
                                                                        {{ $sstat->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="remarks[]" style="width: 200px;" class="form-control" value="{{ $srs->remarks }}"></td>
                                                            <td style="text-align: center; padding: 10px"><input name="active" type="checkbox" style="pointer-events: none;" {{ $srs->listed == 1 ? 'checked' : ''}}></td>
                                                            <td><input type="text" style="width: 200px;" class="form-control" value="{{ $srs->uname }} - {{ $srs->ulvl }}" disabled></td>
                                                            <td class="mt-10"><button type="button" class="badge badge-danger" onclick="SomeDeleteRowFunction(this)"><i class="fa fa-trash"></i> Delete</button>
                                                            </td>
                                                        </tr>
                                                        @empty
                                                        <tr class="suspect_details">
                                                            <td hidden><input type="number" name="spot_suspect_id[]" class="form-control"></td>
                                                            <td><input type="text" name="suspect_number[]" style="width: 200px;" class="form-control" value="1" hidden>
                                                                <div type="text" style="width: 200px;" class="form-control disabled_field">Auto Generated</div>
                                                            </td>
                                                            <td><input type="text" name="lastname[]" style="width: 200px;" class="form-control change_control cc1">
                                                            </td>
                                                            <td><input type="text" name="firstname[]" style="width: 200px;" class="form-control change_control cc2">
                                                            </td>
                                                            <td><input type="text" name="middlename[]" style="width: 200px;" class="form-control change_control cc3">
                                                            </td>
                                                            <td><input type="text" name="alias[]" style="width: 200px;" class="form-control change_control cc4">
                                                            </td>
                                                            <td><input type="date" name="birthdate[]" style="width: 200px;" class="form-control change_control cc5">
                                                            </td>
                                                            <td><input type="text" name="birthplace[]" style="width: 200px;" class="form-control">
                                                            </td>
                                                            <td>
                                                                <select name="present_region_c[]" class="form-control present_region_c" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                    @foreach ($region as $rg)
                                                                    <option value="{{ $rg->region_c }}">
                                                                        {{ $rg->abbreviation }} -
                                                                        {{ $rg->region_m }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="present_province_c[]" class="form-control present_province_c" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="present_city_c[]" class="form-control present_city_c" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="present_barangay_c[]" class="form-control present_barangay_c" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="present_street[]" style="width: 200px;" class="form-control">
                                                            </td>
                                                            <td>
                                                                <select name="permanent_region_c[]" class="form-control permanent_region_c" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                    @foreach ($region as $rg)
                                                                    <option value="{{ $rg->region_c }}">
                                                                        {{ $rg->abbreviation }} -
                                                                        {{ $rg->region_m }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="permanent_province_c[]" class="form-control permanent_province_c" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="permanent_city_c[]" class="form-control permanent_city_c" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="permanent_barangay_c[]" class="form-control permanent_barangay_c" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="permanent_street[]" style="width: 200px;" class="form-control">
                                                            </td>
                                                            <td>
                                                                <select name="gender[]" class="form-control" style="width: 200px;">
                                                                    <option value="male">Male</option>
                                                                    <option value="female">Female</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="civil_status_id[]" class="form-control" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                    @foreach ($civil_status as $cs)
                                                                    <option value="{{ $cs->id }}">
                                                                        {{ $cs->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="nationality_id[]" class="form-control" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                    @foreach ($nationality as $na)
                                                                    <option value="{{ $na->id }}">
                                                                        {{ $na->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="ethnic_group_id[]" class="form-control" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                    @foreach ($ethnic_group as $eg)
                                                                    <option value="{{ $eg->id }}">
                                                                        {{ $eg->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="religion_id[]" class="form-control" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                    @foreach ($religion as $rl)
                                                                    <option value="{{ $rl->id }}">
                                                                        {{ $rl->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="educational_attainment_id[]" class="form-control" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                    @foreach ($education as $ed)
                                                                    <option value="{{ $ed->id }}">
                                                                        {{ $ed->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="occupation_id[]" class="form-control" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                    @foreach ($occupation as $occ)
                                                                    <option value="{{ $occ->id }}">
                                                                        {{ $occ->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="suspect_classification_id[]" class="form-control" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                    @foreach ($suspect_classification as $sclass)
                                                                    <option value="{{ $sclass->id }}">
                                                                        {{ $sclass->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="suspect_category_id[]" class="form-control" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                    @foreach ($suspect_category as $scat)
                                                                    <option value="{{ $scat->id }}">
                                                                        {{ $scat->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="suspect_status_id[]" class="form-control" style="width: 200px;">
                                                                    <option value='' selected>None</option>
                                                                    @foreach ($suspect_status as $sstat)
                                                                    <option value="{{ $sstat->id }}">
                                                                        {{ $sstat->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="remarks[]" style="width: 200px;" class="form-control"></td>
                                                            <td style="text-align: center; padding: 10px"><input name="active" type="checkbox" style="pointer-events: none;"></td>
                                                            <td><input type="text" style="width: 200px;" class="form-control" value="" disabled></td>
                                                            <td class="mt-10"><button type="button" class="badge badge-danger"><i class="fa fa-trash"></i> Delete</button>
                                                            </td>
                                                        </tr>
                                                        @endforelse

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="text-center"><button type="button" class="badge badge-success addSuspect"><i class="fa fa-plus"></i> ADD NEW</button>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-four-evidence" role="tabpanel" aria-labelledby="custom-tabs-four-evidence-tab">
                                        <div class="form-group col-12" style="padding: 0 5px;" id="siblingTBL">
                                            <div class="card table-responsive p-0">
                                                <table id="items" class="table table-hover text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th hidden>ID</th>
                                                            <th style="color: gray; width:35%">Seized From/Alias</th>
                                                            <th style="color: gray;">Drug/Non-Drug</th>
                                                            <th style="color: gray;">Type of Evidence</th>
                                                            <th style="color: gray;">Quantity/ Weight</th>
                                                            <th style="color: gray;">Unit of Measure</th>
                                                            <th style="color: gray;">Packaging</th>
                                                            <th style="color: gray;">Markings</th>
                                                            <th style="color: gray;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($spot_report_evidence as $ev)
                                                        <tr class="suspect_item_details">
                                                            <td hidden><input type="number" name="spot_evidence_id[]" class="form-control" value="{{ $ev->id }}"></td>
                                                            <td>
                                                                <select style="width: 300px;" name="suspect_number_item[]" class="form-control @error('region') is-invalid @enderror suspect_number_item">
                                                                    <option value='0' {{ 0 == $ev->suspect_number ? 'selected' : '' }}>None</option>
                                                                    @foreach ($suspect_information as $si)
                                                                    <option value="{{ $si->suspect_number }}" {{ $si->suspect_number == $ev->suspect_number ? 'selected' : '' }}>
                                                                        {{ $si->lastname }},
                                                                        {{ $si->firstname }}
                                                                        {{ $si->middlename }} -- Alias:
                                                                        '{{ $si->alias }}'
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select style="width: 200px;" name="drug[]" class="form-control drugSLCT">
                                                                    <option value='' selected>None
                                                                    </option>
                                                                    <option value="drug" {{ 'drug' == $ev->drug ? 'selected' : '' }}>
                                                                        Drug</option>
                                                                    <option value="non-drug" {{ 'non-drug' == $ev->drug ? 'selected' : '' }}>
                                                                        Non-Drug</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select style="width: 200px;" name="evidence_id[]" class="form-control evidenceSLCT">
                                                                    <option value='' selected>Select Option
                                                                    </option>
                                                                    @foreach ($evidence as $et)
                                                                    <option value="{{ $et->id }}" {{ $et->id == $ev->evidence_id ? 'selected' : '' }}>
                                                                        {{ $et->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td><input style="width: 200px;" type="text" name="quantity[]" class="form-control" value="{{ $ev->quantity }}"></td>
                                                            <td>
                                                                <select style="width: 200px;" name="unit_measurement_id[]" class="form-control disabled_field">
                                                                    <option value='' selected>Select Option
                                                                    </option>
                                                                    @foreach ($unit_measurement as $um)
                                                                    <option value="{{ $um->id }}" {{ $um->id == $ev->unit ? 'selected' : '' }}>
                                                                        {{ $um->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select style="width: 200px;" name="packaging_id[]" class="form-control">
                                                                    <option value='' selected>Select Option
                                                                    </option>
                                                                    @foreach ($packaging as $pk)
                                                                    <option value="{{ $pk->id }}" {{ $pk->id == $ev->packaging_id ? 'selected' : '' }}>
                                                                        {{ $pk->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td><input style="width: 200px;" type="text" name="markings[]" class="form-control" value="{{ $ev->markings }}"></td>
                                                            <td class="mt-10"><button type="button" class="badge badge-danger" onclick="SomeDeleteRowFunction(this)"><i class="fa fa-trash"></i> Delete</button>
                                                            </td>
                                                        </tr>
                                                        @empty
                                                        <tr class="suspect_item_details">
                                                            <td hidden><input type="number" name="spot_evidence_id[]" class="form-control"></td>
                                                            <td>
                                                                <select style="width: 300px;" name="suspect_number_item[]" class="form-control @error('region') is-invalid @enderror suspect_number_item">
                                                                    <option value='0'>None</option>
                                                                    @foreach ($suspect_information as $si)
                                                                    <option value="{{ $si->suspect_number }}">
                                                                        {{ $si->lastname }},
                                                                        {{ $si->firstname }}
                                                                        {{ $si->middlename }} -- Alias:
                                                                        '{{ $si->alias }}'
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select style="width: 200px;" name="drug[]" class="form-control drugSLCT">
                                                                    <option value='' selected>None
                                                                    </option>
                                                                    <option value="drug">Drug</option>
                                                                    <option value="non-drug">Non-Drug</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select style="width: 200px;" name="evidence_id[]" class="form-control evidenceSLCT">
                                                                    <option value='' selected>Select Option
                                                                    </option>

                                                                </select>
                                                            </td>
                                                            </td>
                                                            <td><input style="width: 200px;" type="text" name="quantity[]" class="form-control"></td>
                                                            <td>
                                                                <select style="width: 200px;" name="unit_measurement_id[]" class="form-control disabled_field">
                                                                    <option value='' selected>Select Option
                                                                    </option>
                                                                    @foreach ($unit_measurement as $um)
                                                                    <option value="{{ $um->id }}">
                                                                        {{ $um->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select style="width: 200px;" name="packaging_id[]" class="form-control">
                                                                    <option value='' selected>Select Option
                                                                    </option>
                                                                    @foreach ($packaging as $pk)
                                                                    <option value="{{ $pk->id }}">
                                                                        {{ $pk->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td><input style="width: 200px;" type="text" name="markings[]" class="form-control"></td>
                                                            <td class="mt-10"><button type="button" class="badge badge-danger"><i class="fa fa-trash"></i> Delete</button>
                                                            </td>
                                                        </tr>
                                                        @endforelse

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="text-center"><button type="button" onclick="addItems();" class="badge badge-success"><i class="fa fa-plus"></i> ADD
                                                    NEW</button></div>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-four-case" role="tabpanel" aria-labelledby="custom-tabs-four-case-tab">
                                        <div class="form-group col-12" style="padding: 0 5px;" id="siblingTBL">
                                            <div class="card table-responsive p-0">
                                                <table id="case" class="table table-hover text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th hidden>ID</th>
                                                            <th style="color: gray;">Name of Suspect</th>
                                                            <th style="color: gray;">Case(s) Filed</th>
                                                            <th style="color: gray;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($spot_report_case as $cs)
                                                        <tr>
                                                            <td hidden><input type="number" name="spot_case_id[]" class="form-control" value="{{ $cs->id }}"></td>
                                                            <td>
                                                                <select name="suspect_number_case[]" style="width: 400px;" class="form-control @error('region') is-invalid @enderror suspect_number_case">
                                                                    <option value=''>None</option>
                                                                    @foreach ($suspect_information as $si)
                                                                    <option value="{{ $si->suspect_number }}" {{ $si->suspect_number == $cs->suspect_number ? 'selected' : '' }}>
                                                                        {{ $si->lastname }},
                                                                        {{ $si->firstname }}
                                                                        {{ $si->middlename }} -- Alias:
                                                                        "{{ $si->alias }}"
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="case_id[]" style="width: 400px;" class="form-control @error('region') is-invalid @enderror">
                                                                    <option value="0" selected>None</option>
                                                                    @foreach ($case as $c)
                                                                    <option value="{{ $c->id }}" {{ $c->id == $cs->case_id ? 'selected' : '' }}>
                                                                        {{ $c->description }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td class="mt-10"><button type="button" class="badge badge-danger" onclick="SomeDeleteRowFunction(this)"><i class="fa fa-trash"></i> Delete</button>
                                                            </td>
                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td hidden><input type="number" name="spot_case_id[]" class="form-control"></td>
                                                            <td>
                                                                <select name="suspect_number_case[]" style="width: 400px;" class="form-control @error('region') is-invalid @enderror suspect_number_case">
                                                                    @foreach ($suspect_information as $si)
                                                                    <option value="{{ $si->suspect_number }}">
                                                                        {{ $si->lastname }},
                                                                        {{ $si->firstname }}
                                                                        {{ $si->middlename }} -- Alias:
                                                                        "{{ $si->alias }}"
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="case_id[]" style="width: 400px;" class="form-control @error('region') is-invalid @enderror">
                                                                    <option value='' selected>None</option>
                                                                    @foreach ($case as $c)
                                                                    <option value="{{ $c->id }}">
                                                                        {{ $c->description }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td class="mt-10"><button type="button" class="badge badge-danger"><i class="fa fa-trash"></i> Delete</button>
                                                            </td>
                                                        </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="text-center"><button type="button" onclick="addCase();" class="badge badge-success"><i class="fa fa-plus"></i> ADD
                                                    NEW</button></div>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-four-operatingteam" role="tabpanel" aria-labelledby="custom-tabs-four-operatingteam-tab">
                                        <div class="form-group col-12" style="padding: 0 5px;" id="siblingTBL">
                                            <div class="card table-responsive p-0">
                                                <table id="opteam" class="table table-hover text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th hidden>ID</th>
                                                            <th style="color: gray;">Name of Arresting Officer(s)</th>
                                                            <th style="color: gray;">Position</th>
                                                            <th style="color: gray;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($spot_report_team as $tm)
                                                        <tr>
                                                            <td hidden><input type="number" name="spot_team_id[]" class="form-control" value="{{ $tm->id }}"></td>
                                                            <td><input type="text" name="officer_name[]" class="form-control" value="{{ $tm->officer_name }}"></td>
                                                            <td><input type="text" name="officer_position[]" class="form-control" value="{{ $tm->officer_position }}"></td>
                                                            <td class="mt-10"><button class="badge badge-danger" onclick="SomeDeleteRowFunction(this)"><i class="fa fa-trash"></i> Delete</button>
                                                            </td>
                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td hidden><input type="number" name="spot_team_id[]" class="form-control"></td>
                                                            <td><input type="text" name="officer_name[]" class="form-control"></td>
                                                            <td><input type="text" name="officer_position[]" class="form-control"></td>
                                                            <td class="mt-10"><button type="button" class="badge badge-danger"><i class="fa fa-trash"></i> Delete</button>
                                                            </td>
                                                        </tr>
                                                        @endforelse
                                                        <tr hidden>
                                                            <td hidden><input type="number" name="spot_team_id[]" class="form-control"></td>
                                                            <td><input type="text" name="officer_name[]" class="form-control"></td>
                                                            <td><input type="text" name="officer_position[]" class="form-control"></td>
                                                            <td class="mt-10"><button type="button" class="badge badge-danger"><i class="fa fa-trash"></i> Delete</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="text-center"><button type="button" onclick="addOpteam();" class="badge badge-success"><i class="fa fa-plus"></i> ADD
                                                    NEW</button></div>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-four-summary" role="tabpanel" aria-labelledby="custom-tabs-four-summary-tab">
                                        <div class="form-group col-7" style="margin: 0px;">
                                            <div>
                                                <label for="">Report Header</label>
                                            </div>
                                            <div class="input-group mb-3">
                                                <input id="report_header" name="report_header" type="text" class="form-control @error('report header') is-invalid @enderror" value="{{ $spot_report_header[0]->report_header }}" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group col-12" style="margin: 0px;">
                                            <div>
                                                <label for="">Summary</label>
                                            </div>
                                            <div class="input-group mb-3">
                                                <textarea id="summary" name="summary" class="form-control" autocomplete="off">{{ $spot_report_header[0]->summary }}</textarea>
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
                    <div class="form-group col-7" style="margin: 0px;">
                        <div>
                            <label for="">Document Reference No.</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="reference_number" name="reference_number" type="text" class="form-control" value="{{ $spot_report_header[0]->reference_number }}" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group col-7" style="margin: 0px;">
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
                    <div class="form-group col-7" style="margin: 0px;">
                        <div>
                            <label for="">Reference Files:</label>
                        </div>
                        @foreach($spot_report_files as $srf)

                        <div class="row spot_report_files">
                            <a style="margin-right: 40px; padding-left: 20px" src="{{ asset('/files/uploads/spot_reports/' . $srf->filenames) }}" width="100%" height="600">File name: {{ $srf->filenames}}
                            </a>
                            <a href="{{ asset('/files/uploads/spot_reports/' . $srf->filenames) }}">View </a>
                            <!-- <span style="padding: 0 5px"> | </span>
                            <input type="text" class="file_id" value="{{$srf->id}}" hidden>
                            <input type="text" class="file_name" value="{{$srf->filenames}}" hidden>
                            <a href="#" class="fileDelete" style="color:red"> Delete</a> -->
                        </div>

                        @endforeach
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="form-group col-7" style="margin: 0px;">
                        <div>
                            <label for="">Prepared By<code> *</code></label>
                        </div>
                        <div class="input-group mb-3">
                            @if(Auth::user()->user_level_id == 1 || Auth::user()->user_level_id == 2)
                            <select name="prepared_by" class="form-control" required>
                                <option value='' selected>Select Option</option>
                                @foreach($regional_user as $reg_u)
                                <option value="{{ $reg_u->name }}">{{ $reg_u->name }}</option>
                                @endforeach
                            </select>
                            @else
                            <input id="prepared_by" name="prepared_by" type="text" class="form-control" style="pointer-events: none;" value="{{ Auth::user()->name }}">
                            @endif
                        </div>
                    </div>
                    <div class="form-group col-7" style="margin: 0px;">
                        <div>
                            <label for="">Reviewed By<code> *</code></label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="approved by" name="approved by" type="text" class="form-control @error('approved by') is-invalid @enderror" value="{{ $spot_report_header[0]->approved_by }}" autocomplete="off" required>
                        </div>
                    </div>
                    <!-- <div class="form-group col-7" style="margin: 0px;">
                        <div class="custom-control custom-checkbox mb-2">
                            <input name="status" class="custom-control-input" type="checkbox" id="customCheckbox9" {{ $spot_report_header[0]->status == true ? 'checked' : '' }}>
                            <label for="customCheckbox9" class="custom-control-label">Set as Active</label>
                        </div>
                    </div> -->
                </div>
                <div class="form-group mt-5">
                    <button type="submit" class="btn btn-primary">Save Spot Report</button>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <h6>Create Spot Report maintenance data.</h6>
        </div>
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

<!-- Set menu to collapse and active -->
@endsection

@section('scripts')

<script>
    $("#region_c").on("change", function() {

        var region_c = $(this).val();

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
                $("#barangay_c").empty();

                var option1 = " <option value='' selected>None</option>";
                $("#province_c").append(option1);
                var option2 = " <option value='' selected>None</option>";
                $("#city_c").append(option2);
                var option3 = " <option value='' selected>None</option>";
                $("#barangay_c").append(option3);

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
                $("#barangay_c").empty();

                var option2 = " <option value='' selected>None</option>";
                $("#city_c").append(option2);
                var option3 = " <option value='' selected>None</option>";
                $("#barangay_c").append(option3);


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

    $("#city_c").on("change", function() {

        var city_c = $(this).val();

        $.ajax({
            type: "GET",
            url: "/get_barangay/" + city_c,
            fail: function() {
                alert("request failed");
            },
            success: function(data) {
                var data = JSON.parse(data);

                $("#barangay_c").empty();

                var option1 = " <option value='' selected>None</option>";
                $("#barangay_c").append(option1);

                data.forEach(element => {
                    var option = " <option value='" +
                        element["barangay_c"] +
                        "'>" +
                        element["barangay_m"] +
                        "</option>";
                    $("#barangay_c").append(option);
                });
            }
        });
    });

    var suspect_row = 0;

    $(document).ready(function() {
        $(document).on("click", ".addSuspect", function() {
            html = '<tr class="suspect_details" id="suspect_row' + suspect_row + '">';
            html +=
                '<td hidden><input type="number" name="spot_suspect_id[]" class="form-control" value="0"></td>';
            html +=
                '<td><input required type="text" name="suspect_number[]" style="width: 200px;" class="form-control disabled_field" value="1" hidden><div type="text" style="width: 200px;" class="form-control disabled_field">Auto Generated</div></td>';
            html +=
                '<td><input required type="text" name="lastname[]" style="width: 200px;" class="form-control"></td>';
            html +=
                '<td><input required type="text" name="firstname[]" style="width: 200px;" class="form-control"></td>';
            html +=
                '<td><input required type="text" name="middlename[]" style="width: 200px;" class="form-control"></td>';
            html +=
                '<td><input required type="text" name="alias[]" style="width: 200px;" class="form-control"></td>';
            html +=
                '<td><input type="date" name="birthdate[]" style="width: 200px;" class="form-control"></td>';
            html +=
                '<td><input type="text" name="birthplace[]" style="width: 200px;" class="form-control"></td>';
            html +=
                '<td><select name="present_region_c[]" class="form-control present_region_c" style="width: 200px;"><option value="" selected>None</option>@foreach ($region as $rg)<option value="{{ $rg->region_c }}">{{ $rg->abbreviation }} - {{ $rg->region_m }}</option>@endforeach</select></td>';
            html +=
                '<td><select name="present_province_c[]" class="form-control present_province_c" style="width: 200px;"><option value="" selected>None</option></select></td>';
            html +=
                '<td><select name="present_city_c[]" class="form-control present_city_c" style="width: 200px;"><option value="" selected>None</option></select></td>';
            html +=
                '<td><select name="present_barangay_c[]" class="form-control present_barangay_c" style="width: 200px;"><option value="" selected>None</option></select></td>';
            html +=
                '<td><input type="text" name="present_street[]" style="width: 200px;" class="form-control"></td>';
            html +=
                '<td><select name="permanent_region_c[]" class="form-control permanent_region_c" style="width: 200px;"><option value="" selected>None</option>@foreach ($region as $rg)<option value="{{ $rg->region_c }}">{{ $rg->abbreviation }} - {{ $rg->region_m }}</option>@endforeach</select></td>';
            html +=
                '<td><select name="permanent_province_c[]" class="form-control permanent_province_c" style="width: 200px;"><option value="" selected>None</option></select></td>';
            html +=
                '<td><select name="permanent_city_c[]" class="form-control permanent_city_c" style="width: 200px;"><option value="" selected>None</option></select></td>';
            html +=
                '<td><select name="permanent_barangay_c[]" class="form-control permanent_barangay_c" style="width: 200px;"><option value="" selected>None</option></select></td>';
            html +=
                '<td><input type="text" name="permanent_street[]" style="width: 200px;" class="form-control"></td>';
            html +=
                '<td><select name="gender[]" class="form-control" style="width: 200px;"><option value="male">Male</option><option value="female">Female</option></select></td>';
            html +=
                '<td><select name="civil_status_id[]" class="form-control" style="width: 200px;"><option value="" selected>None</option>@foreach ($civil_status as $cs)<option value="{{ $cs->id }}">{{ $cs->name }}</option>@endforeach</select></td>';
            html +=
                '<td><select name="nationality_id[]" class="form-control" style="width: 200px;"><option value="" selected>None</option>@foreach ($nationality as $na)<option value="{{ $na->id }}">{{ $na->name }}</option>@endforeach</select></td>';
            html +=
                '<td><select name="ethnic_group_id[]" class="form-control" style="width: 200px;"><option value="" selected>None</option>@foreach ($ethnic_group as $eg)<option value="{{ $eg->id }}">{{ $eg->name }}</option>@endforeach</select></td>';
            html +=
                '<td><select name="religion_id[]" class="form-control" style="width: 200px;"><option value="" selected>None</option>@foreach ($religion as $rl)<option value="{{ $rl->id }}">{{ $rl->name }}</option>@endforeach</select></td>';
            html +=
                '<td><select name="educational_attainment_id[]" class="form-control" style="width: 200px;"><option value="" selected>None</option>@foreach ($education as $ed)<option value="{{ $ed->id }}">{{ $ed->name }}</option>@endforeach</select></td>';
            html +=
                '<td><select name="occupation_id[]" class="form-control" style="width: 200px;"><option value="" selected>None</option>@foreach ($occupation as $occ)<option value="{{ $occ->id }}">{{ $occ->name }}</option>@endforeach</select></td>';
            html +=
                '<td><select name="suspect_classification_id[]" class="form-control" style="width: 200px;"><option value="" selected>None</option>@foreach ($suspect_classification as $sclass)<option value="{{ $sclass->id }}">{{ $sclass->name }}</option>@endforeach</select></td>';
            html +=
                '<td><select name="suspect_category[]" class="form-control" style="width: 200px;"><option value="" selected>None</option>@foreach ($suspect_category as $scat)<option value="{{ $scat->id }}">{{ $scat->name }}</option>@endforeach</select></td>';
            html +=
                '<td><select name="suspect_status_id[]" class="form-control" style="width: 200px;"><option value="" selected>None</option>@foreach ($suspect_status as $sstat)<option value="{{ $sstat->id }}">{{ $sstat->name }}</option>@endforeach</select></td>';
            html +=
                '<td><input type="text" name="remarks[]" style="width: 200px;" class="form-control"></td>';
            html +=
                '<td style="text-align: center; padding: 10px"><input name="active" type="checkbox" style="pointer-events: none;"></td>';
            html +=
                '<td><input type="text" style="width: 200px;" class="form-control" value="" disabled></td>';
            html += '<td class="mt-10"><button class="badge badge-danger" onclick="$(\'#suspect_row' +
                suspect_row + '\').remove();"><i class="fa fa-trash"></i> Delete</button></td>';
            html += '</tr>';




            $('#suspect tbody').append(html);

            suspect_row++;
        });
    });

    var items_row = 0;

    function addItems() {
        html = '<tr class="suspect_item_details" id="items-row' + items_row + '">';
        html += '<td hidden><input type="number" name="spot_evidence_id[]" class="form-control" value="0"></td>';
        html +=
            '<td><select style="width: 300px;" name="suspect_number_item[]" class="form-control @error("suspect name") is-invalid @enderror suspect_number_item"><option value="0" selected>None</option></select></td>';
        html +=
            '<td><select style="width: 200px;" name="drug[]" class="form-control drugSLCT"><option value="" selected>Select Option</option><option value="drug">Drug</option><option value="non-drug">Non-Drug</option></select></td>';
        html += '<td><select style="width: 200px;" name="evidence_id[]" class="form-control evidenceSLCT"><option value="" selected>Select Option</option></select></td>';
        html += '<td><input style="width: 200px;" type="text" name="quantity[]" class="form-control" ></td>';
        html +=
            '<td><select style="width: 200px;" name="unit_measurement_id[]" class="form-control disabled_field"><option value="" selected>Select Option</option>@foreach ($unit_measurement as $um)<option value="{{ $um->id }}">{{ $um->name }}</option>@endforeach</select></td>';
        html += '<td><select style="width: 200px;" name="packaging_id[]" class="form-control"><option value="" selected>Select Option</option>@foreach ($packaging as $pk)<option value="{{ $pk->id }}">{{ $pk->name }}</option>@endforeach</select></td>';
        html += '<td><input style="width: 200px;" type="text" name="markings[]" class="form-control"></td>';
        html += '<td class="mt-10"><button class="badge badge-danger" onclick="$(\'#items-row' + items_row +
            '\').remove();"><i class="fa fa-trash"></i> Delete</button></td>';

        html += '</tr>';

        $('#items tbody').append(html);

        items_row++;

        var table = $("#suspect_informations");
        $(".suspect_number_item").find('option').not(':selected').remove();
        // $(".suspect_number_item").find(':selected').attr('hidden', 'true');


        table.find('tr').each(function(i) {
            var $tds = $(this).find('td input');
            var suspect_number = $tds.eq(1).val();
            var lastname = $tds.eq(2).val();
            var firstname = $tds.eq(3).val();
            var middlename = $tds.eq(4).val();
            var alias = $tds.eq(5).val();
            var birthdate = $tds.eq(6).val();

            if (lastname == null || lastname == '' && firstname == null || firstname == '' && middlename == null || middlename == '' && alias == null || alias == '' && birthdate == null || birthdate == '') {

            } else {
                $(".suspect_number_item").append("<option value=" +
                    lastname + "," + firstname + "," + middlename + "," + alias + "," + birthdate + ">" +
                    lastname + ", " + firstname + " " +
                    middlename + " -- Alias: '" + alias +
                    "'</option>");
            }
        });
    }

    var case_row = 0;

    function addCase() {
        html = '<tr id="case-row' + case_row + '">';
        html += '<td hidden><input type="number" name="spot_case_id[]" class="form-control" value="0"></td>';
        html += '<td><select style="width: 400px;" name="suspect_number_case[]" class="form-control @error("suspect name") is-invalid @enderror suspect_number_case"><option value="0" selected>None</option>@foreach ($suspect_information as $si)<option value="{{ $si->suspect_number }}">{{ $si->lastname }}, {{ $si->firstname }} {{ $si->middlename }} -- Alias: "{{ $si->alias }}"</option>@endforeach </select></td>';
        html +=
            '<td><select style="width: 400px;" name="case_id[]" class="form-control"><option value="0" selected>None</option>@foreach ($case as $c)<option value="{{ $c->id }}">{{ $c->description }}</option>@endforeach </select></td>';
        html += '<td class="mt-10"><button class="badge badge-danger" onclick="$(\'#case-row' + case_row +
            '\').remove();"><i class="fa fa-trash"></i> Delete</button></td>';

        html += '</tr>';

        $('#case tbody').append(html);

        case_row++;

        var table = $("#suspect_informations");

        $(".suspect_number_case").find('option').not(':selected').remove();
        // $(".suspect_number_case").find(':selected').attr('hidden', 'true');

        table.find('tr').each(function(i) {
            var $tds = $(this).find('td input');
            var suspect_number = $tds.eq(1).val();
            var lastname = $tds.eq(2).val();
            var firstname = $tds.eq(3).val();
            var middlename = $tds.eq(4).val();
            var alias = $tds.eq(5).val();
            var birthdate = $tds.eq(6).val();

            if (lastname != null) {
                $(".suspect_number_case").append("<option value=" +
                    lastname + "," + firstname + "," + middlename + "," + alias + "," + birthdate + ">" +
                    lastname + ", " + firstname + " " +
                    middlename + " -- Alias: '" + alias +
                    "'</option>");
            }
        });
    }

    var opteam_row = 0;

    function addOpteam() {
        html = '<tr id="opteam-row' + opteam_row + '">';
        html += '<td hidden><input type="number" name="spot_team_id[]" class="form-control"></td>';
        html += '<td><input type="text" name="officer_name[]" class="form-control"></td>';
        html += '<td><input type="text" name="officer_position[]" class="form-control"></td>';
        html += '<td class="mt-10"><button class="badge badge-danger" onclick="$(\'#opteam-row' + opteam_row +
            '\').remove();"><i class="fa fa-trash"></i> Delete</button></td>';

        html += '</tr>';

        $('#opteam tbody').append(html);

        opteam_row++;
    }

    function SomeDeleteRowFunction(o) {
        //no clue what to put here?
        var p = o.parentNode.parentNode;
        p.parentNode.removeChild(p);
    }
</script>

<script>
    //Populate Present Province
    $(document).on("change", ".present_region_c", function() {
        var region_c = $(this).val();
        var $row = $(this).closest(".suspect_details");

        $.ajax({
            type: "GET",
            url: "/get_province/" + region_c,
            fail: function() {
                alert("request failed");
            },
            success: function(data) {
                var data = JSON.parse(data);

                $($row.find("td:eq(9) select")).empty();
                $($row.find("td:eq(10) select")).empty();
                $($row.find("td:eq(11) select")).empty();
                var option1 = " <option value='' selected>None</option>";
                $($row.find("td:eq(9) select")).append(option1);
                var option2 = " <option value='' selected>None</option>";
                $($row.find("td:eq(10) select")).append(option2);

                var option3 = " <option value='' selected>None</option>";
                $($row.find("td:eq(11) select")).append(option3);


                data.forEach(element => {
                    var option = " <option value='" +
                        element["province_c"] +
                        "'>" +
                        element["province_m"] +
                        "</option>";
                    $($row.find("td:eq(9) select")).append(option);
                });
            }
        });
    });

    //Populate Present City
    $(document).on("change", ".present_province_c", function() {
        var province_c = $(this).val();
        var $row = $(this).closest(".suspect_details");

        $.ajax({
            type: "GET",
            url: "/get_city/" + province_c,
            fail: function() {
                alert("request failed");
            },
            success: function(data) {
                var data = JSON.parse(data);

                $($row.find("td:eq(10) select")).empty();
                $($row.find("td:eq(11) select")).empty();
                var option1 = " <option value='' selected>None</option>";
                $($row.find("td:eq(10) select")).append(option1);
                var option3 = " <option value='' selected>None</option>";
                $($row.find("td:eq(11) select")).append(option3);

                data.forEach(element => {
                    var option = " <option value='" +
                        element["city_c"] +
                        "'>" +
                        element["city_m"] +
                        "</option>";
                    $($row.find("td:eq(10) select")).append(option);
                });
            }
        });
    });

    //Populate Present Barangay
    $(document).on("change", ".present_city_c", function() {
        var city_c = $(this).val();
        var $row = $(this).closest(".suspect_details");

        $.ajax({
            type: "GET",
            url: "/get_barangay/" + city_c,
            fail: function() {
                alert("request failed");
            },
            success: function(data) {
                var data = JSON.parse(data);

                $($row.find("td:eq(11) select")).empty();
                var option1 = " <option value='' selected>None</option>";
                $($row.find("td:eq(11) select")).append(option1);

                data.forEach(element => {
                    var option = " <option value='" +
                        element["barangay_c"] +
                        "'>" +
                        element["barangay_m"] +
                        "</option>";
                    $($row.find("td:eq(11) select")).append(option);
                });
            }
        });
    });

    //Populate Permamnent Province
    $(document).on("change", ".permanent_region_c", function() {
        var region_c = $(this).val();
        var $row = $(this).closest(".suspect_details");

        $.ajax({
            type: "GET",
            url: "/get_province/" + region_c,
            fail: function() {
                alert("request failed");
            },
            success: function(data) {
                var data = JSON.parse(data);

                $($row.find("td:eq(14) select")).empty();
                $($row.find("td:eq(15) select")).empty();
                $($row.find("td:eq(16) select")).empty();
                var option1 = " <option value='' selected>None</option>";
                $($row.find("td:eq(14) select")).append(option1);
                var option2 = " <option value='' selected>None</option>";
                $($row.find("td:eq(15) select")).append(option2);
                var option3 = " <option value='' selected>None</option>";
                $($row.find("td:eq(16) select")).append(option3);

                data.forEach(element => {
                    var option = " <option value='" +
                        element["province_c"] +
                        "'>" +
                        element["province_m"] +
                        "</option>";
                    $($row.find("td:eq(14) select")).append(option);
                });
            }
        });
    });

    //Populate Permamnent City
    $(document).on("change", ".permanent_province_c", function() {
        var province_c = $(this).val();
        var $row = $(this).closest(".suspect_details");

        $.ajax({
            type: "GET",
            url: "/get_city/" + province_c,
            fail: function() {
                alert("request failed");
            },
            success: function(data) {
                var data = JSON.parse(data);

                $($row.find("td:eq(15) select")).empty();
                $($row.find("td:eq(16) select")).empty();
                var option1 = " <option value='' selected>None</option>";
                $($row.find("td:eq(15) select")).append(option1);
                var option3 = " <option value='' selected>None</option>";
                $($row.find("td:eq(16) select")).append(option3);

                data.forEach(element => {
                    var option = " <option value='" +
                        element["city_c"] +
                        "'>" +
                        element["city_m"] +
                        "</option>";
                    $($row.find("td:eq(15) select")).append(option);
                });
            }
        });
    });

    //Populate Permamnent Barangay
    $(document).on("change", ".permanent_city_c", function() {
        var city_c = $(this).val();
        var $row = $(this).closest(".suspect_details");

        $.ajax({
            type: "GET",
            url: "/get_barangay/" + city_c,
            fail: function() {
                alert("request failed");
            },
            success: function(data) {
                var data = JSON.parse(data);

                $($row.find("td:eq(16) select")).empty();
                var option1 = " <option value='' selected>None</option>";
                $($row.find("td:eq(16) select")).append(option1);

                data.forEach(element => {
                    var option = " <option value='" +
                        element["barangay_c"] +
                        "'>" +
                        element["barangay_m"] +
                        "</option>";
                    $($row.find("td:eq(16) select")).append(option);
                });
            }
        });
    });

    //Populate Item Seized Suspect Name
    $(document).on("click", "#custom-tabs-four-evidence-tab", function() {
        var table = $("#suspect_informations");
        var spot_report_number = $("#spot_report_number").val();

        $(".suspect_number_item").find('option').not(':selected').remove();
        $(".suspect_number_item").find(':selected').attr('hidden', 'true');

        table.find('tr').each(function(i) {
            var $tds = $(this).find('td input');
            var suspect_number = $tds.eq(1).val();
            var lastname = $tds.eq(2).val();
            var firstname = $tds.eq(3).val();
            var middlename = $tds.eq(4).val();
            var alias = $tds.eq(5).val();
            var birthdate = $tds.eq(6).val();

            if (suspect_number == 1) {

                $(".suspect_number_item").append("<option value=" +
                    lastname + "," + firstname + "," + middlename + "," + alias + "," + birthdate + ">" +
                    lastname + ", " + firstname + " " +
                    middlename + " -- Alias: '" + alias +
                    "'</option>");
            } else if (suspect_number == 0) {

            } else {
                $(".suspect_number_item").append("<option value=" +
                    suspect_number + ">" +
                    lastname + ", " + firstname + " " +
                    middlename + " -- Alias: '" + alias +
                    "'</option>");
            }
        });
    });

    //Populate Case Suspect Name
    $(document).on("click", "#custom-tabs-four-case-tab", function() {

        var table = $("#suspect_informations");

        $(".suspect_number_case").find('option').not(':selected').remove();
        $(".suspect_number_case").find(':selected').attr('hidden', 'true');

        table.find('tr').each(function(i) {
            var $tds = $(this).find('td input');
            var suspect_number = $tds.eq(1).val();
            var lastname = $tds.eq(2).val();
            var firstname = $tds.eq(3).val();
            var middlename = $tds.eq(4).val();
            var alias = $tds.eq(5).val();
            var birthdate = $tds.eq(6).val();

            if (suspect_number == 1) {

                $(".suspect_number_case").append("<option value=" +
                    lastname + "," + firstname + "," + middlename + "," + alias + "," + birthdate + ">" +
                    lastname + ", " + firstname + " " +
                    middlename + " -- Alias: '" + alias +
                    "'</option>");
            } else if (suspect_number == 0) {

            } else {
                $(".suspect_number_case").append("<option value=" +
                    suspect_number + ">" +
                    lastname + ", " + firstname + " " +
                    middlename + " -- Alias: '" + alias +
                    "'</option>");
            }
        });
    });

    $(document).on("change", ".change_control", function() {
        $cc1 = $('.cc1').val();
        $cc2 = $('.cc2').val();
        $cc3 = $('.cc3').val();
        $cc4 = $('.cc4').val();
        $cc5 = $('.cc5').val();
        if ($cc1 == '' || $cc1 == null && $cc2 == '' || $cc2 == null && $cc3 == '' || $cc3 == null && $cc4 == '' || $cc4 == null && $cc5 == '' || $cc5 == null) {
            $('.change_control').attr('required', false)
        } else {
            $('.change_control').attr('required', true)
        }

    });

    $(".fileDelete").on("click", function() {
        var file_id = $(this).closest(".spot_report_files").find('.file_id').val();
        var file_name = $(this).closest(".spot_report_files").find('.file_name').val();

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
                        url: "/spot_report_file_delete/" +
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

    //Populate Evidence Type
    $(document).on("change", ".drugSLCT", function() {
        var drugT = $(this).val();
        var $row = $(this).closest(".suspect_item_details");

        if (drugT == 'drug') {
            category = 'drug';
        } else {
            category = 'nondrug';
        }


        $.ajax({
            type: "GET",
            url: "/get_evidence_type/" + category,
            fail: function() {
                alert("request failed");
            },
            success: function(data) {
                var data = JSON.parse(data);

                $($row.find("td:eq(3) select")).empty();
                var option1 =
                    " <option value='' selected>None</option>";
                $($row.find("td:eq(3) select")).append(option1);

                data.forEach(element => {
                    var option = " <option value='" +
                        element["id"] +
                        "'>" +
                        element["evidence"] +
                        "</option>";
                    $($row.find("td:eq(3) select")).append(option);
                });
            }
        });
    });

    //Populate Unit Measure
    $(document).on("change", ".evidenceSLCT", function() {


        var evidence_id = $(this).val();
        var $row = $(this).closest(".suspect_item_details");

        $.ajax({
            type: "GET",
            url: "/get_unit_measure/" + evidence_id,
            fail: function() {
                alert("request failed");
            },
            success: function(data) {
                var data = JSON.parse(data);

                $($row.find('td:eq(5) option')).removeAttr('selected');

                data.forEach(element => {
                    $($row.find('td:eq(5) option[value=' + element["id"] + ']')).attr('selected', 'selected');
                });
            }
        });
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
        $('#spot_report').addClass('active');
    });
</script>


@endsection