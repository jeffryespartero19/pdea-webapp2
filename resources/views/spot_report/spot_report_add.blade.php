@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add Spot Report</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="removeCokie();">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('spot_report_list') }}">Spot Report List</a></li>
                    <li class="breadcrumb-item active">Add Spot Report</li>
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

    @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-check"></i> Success!</h5>
        <input hidden id="print_id" type="number" value="{{session('sr_id')}}">
        {{ session()->get('success') }}

    </div>
    @endif
    <!-- Default box -->
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Add Spot Report</h3>
        </div>
        <div class="card-body">
            <form action="/spot_report_add" role="form" method="post" enctype="multipart/form-data" enctype="multipart/form-data" id="spot_report_form">
                @csrf
                <div class="row">
                    <input id="prc_date" type="text" hidden value="{{$date}}">
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Pre-ops No.</label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="preops_number" name="preops_number" class="form-control PreopsNumberSearch " required>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Date Reported</label>
                        </div>
                        <div class="input-group mb-3">
                            <?php date_default_timezone_set('Asia/Manila'); ?>
                            <input id="reported_date" name="reported_date" type="date" class="form-control @error('reported date') is-invalid @enderror disabled_field" value="<?php echo date('Y-m-d'); ?>" autocomplete="off" required readonly>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Spot Report No.</label>
                            <span id="spot_report_error" hidden style="float: right; color:red" for="">Spot Report Number Exist</span>
                        </div>
                        <div class="input-group mb-3">
                            <input id="spot_report_number" name="spot_report_number" type="text" class="form-control @error('spot report number') is-invalid @enderror disabled_field" value="Auto Generate" autocomplete="off" required readonly>
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Type of Operation</label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="operation_type_id" name="operation_type_id" class="form-control OPTypeSearch" required>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-12 row" style="margin: 0px; padding:20px 10px">
                        <div class="col-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input id="operation_lvl" name="operation_lvl" class="custom-control-input" type="checkbox">
                                <label for="operation_lvl" class="custom-control-label">High Impact Operation</label>

                                <select id="hio_type_id" name="hio_type_id" class="form-control" disabled>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Region</label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="region_c" name="region_c" class="form-control @error('region') is-invalid @enderror " required>
                                <option value='' disabled selected>Select Option</option>
                                @foreach ($sregion as $rg)
                                <option value="{{ $rg->region_c }}">{{ $rg->abbreviation }} -
                                    {{ $rg->region_m }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Province</label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="province_c" name="province_c" class="form-control">
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">City/Municipality</label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="city_c" name="city_c" class="form-control @error('city') is-invalid @enderror" required>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Barangay</label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="barangay_c" name="barangay_c" class="form-control @error('barangay') is-invalid @enderror" required>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Street/Purok</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="street" name="street" type="text" class="form-control" autocomplete="off">
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Date/Time of Operation</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="operation_datetime" name="operation_datetime" type="datetime-local" class="form-control @error('operation date') is-invalid @enderror" value="{{ old('operation_date') }}" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Operating Unit</label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="operating_unit_id" name="operating_unit_id" class="form-control OPUnitSearch" required>
                            </select>
                        </div>
                    </div>
                    <div id="sp_list" class="form-group col-4 " style="margin: 0px;">
                        <div>
                            <label for="">Supporting Unit</label>
                            <a onclick="addrow();" style="float: right;"><i class="fas fa-plus pr-2"></i></a>
                        </div>
                        <div class="SUdetails">
                            <div class="input-group mb-3 su_options">
                                <select name="support_unit_id[]" class="form-control SUPPUnitSearch support_unit_id">
                                </select>
                                <a href="#" class="su_remove" style="float:right; margin-left:5px; padding: 5px"><i class="fas fa-minus pr-2 " style="color:red"></i></a>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row" id="warrant_Details" hidden>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Warrant No.</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="warrant_number" name="warrant_number" type="text" class="form-control @error('warrant number') is-invalid @enderror" value="{{ old('warrant_number') }}" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Issuing Judge</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="judge_name" name="judge_name" type="text" class="form-control @error('judge name') is-invalid @enderror" value="{{ old('judge_name') }}" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Branch</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="branch" name="branch" type="text" class="form-control @error('branch') is-invalid @enderror" value="{{ old('branch') }}" autocomplete="off">
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
                                        <div class="form-group col-12" style="padding: 0 5px;">
                                            <div class="card table-responsive p-0">
                                                <table id="suspect" class="table table-hover text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="14" style="background-color: lightgreen; text-align:center">Operational Details</th>
                                                            <th colspan="13" style="background-color: pink; text-align:center">Personal Background</th>
                                                            <th colspan="6" style="background-color: lightyellow; text-align:center">Other Information</th>
                                                        </tr>
                                                        <tr>
                                                            <th style="color: gray;">Suspect Number</th>
                                                            <th style="color: gray;">Suspect Status</th>
                                                            <th style="color: gray;">Last Name</th>
                                                            <th style="color: gray;">First Name</th>
                                                            <th style="color: gray;">Middle Name</th>
                                                            <th style="color: gray;">Alias</th>
                                                            <th style="color: gray;">Birthdate</th>
                                                            <th style="color: gray;">Estimated Birthdate</th>
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
                                                            <th style="color: gray;">Whereabouts</th>
                                                            <th style="color: gray;">Remarks</th>
                                                            <th style="color: gray;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="suspect_informations">
                                                        <tr class="suspect_details">
                                                            <td><input type="text" name="suspect_number[]" style="width: 200px;" class="form-control cc1 disabled_field" value="Auto Generated"></td>
                                                            <td>
                                                                <select name="suspect_status_id[]" class="form-control suspect_status_id" style="width: 200px;">
                                                                    <option value='' selected>Select Option
                                                                    </option>
                                                                    @foreach ($suspect_status as $sstat)
                                                                    <option value="{{ $sstat->id }}">
                                                                        {{ $sstat->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="lastname[]" style="width: 200px;" class="form-control change_control cc2"></td>
                                                            <td><input type="text" name="firstname[]" style="width: 200px;" class="form-control change_control cc3"></td>
                                                            <td><input type="text" name="middlename[]" style="width: 200px;" class="form-control change_control cc4"></td>
                                                            <td><input type="text" name="alias[]" style="width: 200px;" class="form-control change_control cc5"></td>
                                                            <td><input type="date" name="birthdate[]" style="width: 200px;" class="form-control change_control"></td>
                                                            <td>
                                                                <select name="est_birthdate[]" class="form-control" style="width: 200px;">
                                                                    <option value="0">No
                                                                    </option>
                                                                    <option value="1">Yes
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="birthplace[]" style="width: 200px;" class="form-control"></td>
                                                            <td>
                                                                <select name="present_region_c[]" class="form-control present_region_c" style="width: 200px;">
                                                                    <option value='' selected>Select Option
                                                                    </option>
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
                                                                    <option value='' selected>Select Option
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="present_city_c[]" class="form-control present_city_c" style="width: 200px;">
                                                                    <option value='' selected>Select Option
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="present_barangay_c[]" class="form-control present_barangay_c" style="width: 200px;">
                                                                    <option value='' selected>Select Option
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="present_street[]" style="width: 200px;" class="form-control"></td>
                                                            <td>
                                                                <select name="permanent_region_c[]" class="form-control permanent_region_c" style="width: 200px;">
                                                                    <option value='' selected>Select Option
                                                                    </option>
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
                                                                    <option value='' selected>Select Option
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="permanent_city_c[]" class="form-control permanent_city_c" style="width: 200px;">
                                                                    <option value='' selected>Select Option
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="permanent_barangay_c[]" class="form-control permanent_barangay_c" style="width: 200px;">
                                                                    <option value='' selected>Select Option
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="permanent_street[]" style="width: 200px;" class="form-control"></td>
                                                            <td>
                                                                <select name="gender[]" class="form-control" style="width: 200px;">
                                                                    <option value="male">Male</option>
                                                                    <option value="female">Female</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="civil_status_id[]" class="form-control CivilStatusSearch" style="width: 200px;">
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="nationality_id[]" class="form-control NationalitySearch" style="width: 200px;">
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="ethnic_group_id[]" class="form-control EthnicGroupSearch" style="width: 200px;">
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="religion_id[]" class="form-control ReligionSearch" style="width: 200px;">
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="educational_attainment_id[]" class="form-control EducationSearch" style="width: 200px;">
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="occupation_id[]" class="form-control OccupationSearch" style="width: 200px;">
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="identifier_id[]" class="form-control IdentifierSearch" style="width: 200px;">
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="suspect_classification_id[]" class="form-control suspect_classification_id SuspectClassificationSearch" style="width: 200px;">
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="suspect_category_id[]" class="form-control suspect_category_id SuspectCategorySearch" style="width: 200px;">
                                                                    <option value='' selected>Select Option
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="suspect_sub_category_id[]" class="form-control SuspectSubCategorySearch" style="width: 200px;">
                                                                    <option value='' selected>Select Option
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="whereabouts[]" style="width: 200px;" class="form-control"></td>
                                                            <td><input type="text" name="remarks[]" style="width: 200px;" class="form-control"></td>
                                                            <td class="mt-10"><button class="badge badge-danger delRow"><i class="fa fa-trash"></i> Delete</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="text-center"><button type="button" class="badge badge-success" onclick="addSuspect();"><i class="fa fa-plus"></i> ADD NEW</button>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-four-evidence" role="tabpanel" aria-labelledby="custom-tabs-four-evidence-tab">
                                        <div class="form-group col-12" style="padding: 0 5px;">
                                            <div class="card table-responsive p-0">
                                                <table id="items" class="table table-hover text-nowrap">
                                                    <thead>
                                                        <tr>
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
                                                        <tr class="suspect_item_details">
                                                            <td>
                                                                <select style="width: 300px;" name="suspect_number_item[]" class="form-control @error('region') is-invalid @enderror suspect_number_item">
                                                                    <option value=''>Select Option
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select style="width: 200px;" name="drug[]" class="form-control drugSLCT">
                                                                    <option value=''>Select Option
                                                                    </option>
                                                                    <option value="drug">Drug</option>
                                                                    <option value="non-drug">Non-Drug</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select style="width: 200px;" name="evidence_id[]" class="form-control evidenceSLCT">
                                                                    <option value=''>Select Option
                                                                    </option>
                                                                    <!-- @foreach ($evidence_type as $et)
                                                                    <option value="{{ $et->id }}">
                                                                        {{ $et->name }}
                                                                    </option>
                                                                    @endforeach -->
                                                                </select>
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
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="text-center"><button type="button" onclick="addItems();" class="badge badge-success"><i class="fa fa-plus"></i> ADD
                                                    NEW</button></div>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-four-case" role="tabpanel" aria-labelledby="custom-tabs-four-case-tab">
                                        <div class="form-group col-12" style="padding: 0 5px;">
                                            <div class="card table-responsive p-0">
                                                <table id="case" class="table table-hover text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th style="color: gray;">Name of Suspect</th>
                                                            <th style="color: gray;">Case(s) Filed</th>
                                                            <th style="color: gray;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <select name="suspect_number_case[]" style="width: 400px;" class="form-control @error('region') is-invalid @enderror suspect_number_case">
                                                                    <option value='' selected>Select Option
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td class="row">
                                                                <div class="col-10">
                                                                    <select name="case_id[]" class="form-control CaseSearch" style="width: 400px" data-placeholder="Select a Case">
                                                                    </select>
                                                                </div>

                                                                <!-- <button class="Cadd  col-2" type="button" style="border: none; background-color:inherit; color:blue"><i class="fas fa-plus pr-2" style="font-size: 15px;"></i></button> -->
                                                            </td>
                                                            <td class="mt-10"><button type="button" class="badge badge-danger"><i class="fa fa-trash"></i> Delete</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="text-center"><button type="button" onclick="addCase();" class="badge badge-success"><i class="fa fa-plus"></i> ADD
                                                    NEW</button></div>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-four-operatingteam" role="tabpanel" aria-labelledby="custom-tabs-four-operatingteam-tab">
                                        <div class="form-group col-12" style="padding: 0 5px;">
                                            <div class="card table-responsive p-0">
                                                <table id="opteam" class="table table-hover text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th style="color: gray;">Name of Arresting Officer(s)</th>
                                                            <th style="color: gray;">Position</th>
                                                            <th style="color: gray;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="opsteamlist">
                                                        <tr>
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
                                                <input id="report_header" name="report_header" type="text" class="form-control @error('report header') is-invalid @enderror" list="suggestions">
                                            </div>
                                        </div>
                                        <div class="form-group col-12" style="margin: 0px;">
                                            <div>
                                                <label for="">Summary</label>
                                            </div>
                                            <div class="input-group mb-3">
                                                <textarea id="summary" name="summary" class="form-control" value="{{ old('summary') }}" autocomplete="off"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>

                </div>
                <br>
                <div class="row">
                    <div class="form-group col-7" style="margin: 0px;">
                        <div>
                            <label for="">Document Reference No.</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="reference_number" name="reference_number" type="text" class="form-control @error('present street') is-invalid @enderror" value="{{ old('reference_number') }}" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group col-7" style="margin: 0px;">
                        <div>
                            <label for="">Reference File</label>
                        </div>
                        <div class="custom-file">
                            <input type="file" name="fileattach[]" class="custom-file-input" id="fileattach" accept="application/pdf" multiple />
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                </div>
                <br>

                <div class="row">

                    <div class="form-group col-7" style="margin: 0px;">
                        <div>
                            <label for="">Prepared By</label>
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
                            <label for="">Reviewed By</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="approved by" name="approved by" type="text" class="form-control @error('approved by') is-invalid @enderror" value="{{ old('approved by') }}" autocomplete="off">
                        </div>
                    </div>
                    <!-- <div class="form-group col-7" style="margin: 0px;">
                        <div class="custom-control custom-checkbox mb-2">
                            <input name="status" class="custom-control-input" type="checkbox" id="customCheckbox9">
                            <label for="customCheckbox9" class="custom-control-label">Set as Active</label>
                        </div>
                    </div> -->
                </div>
                <div class="form-group mt-5">
                    <button id="saveBTN" type="submit" class="btn btn-primary">Save Spot Report</button>
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

<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>

<script>
    $(document).ready(function() {
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

                    var option1 = " <option value='' selected>Select Option</option>";
                    $("#province_c").append(option1);

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

            $(".OPUnitSearch").empty();
            $(".SUPPUnitSearch").empty();
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

                    var option1 = " <option value='' selected>Select Option</option>";
                    $("#city_c").append(option1);

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

                    var option1 = " <option value='' selected>Select Option</option>";
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

        $('#spot_report_number').keyup(function() {
            var spot_report_number = $(this).val();

            $.ajax({
                type: "GET",
                url: "/get_spot_report_header/" + spot_report_number,
                fail: function() {
                    alert("request failed");
                },
                success: function(data) {
                    var data = JSON.parse(data);

                    if (data.length > 0) {
                        $("#spot_report_error").attr('hidden', false);
                        $("#spot_report_number").addClass('error');
                        $("#saveBTN").attr('disabled', true);

                    } else {
                        $("#spot_report_error").attr('hidden', true);
                        $("#spot_report_number").removeClass('error');
                        $("#saveBTN").attr('disabled', false);
                    }
                }
            });
        });

        //Delete Suspect Row
        $("#suspect").on("click", ".delRow", function() {
            $(this).closest("tr").remove();
        });

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

                    $($row.find("td:eq(10) select")).empty();
                    $($row.find("td:eq(11) select")).empty();
                    $($row.find("td:eq(12) select")).empty();
                    var option1 =
                        " <option value='' selected>Select Option</option>";
                    $($row.find("td:eq(10) select")).append(option1);
                    var option2 =
                        " <option value='' selected>Select Option</option>";
                    $($row.find("td:eq(11) select")).append(option2);
                    var option3 =
                        " <option value='' selected>Select Option</option>";
                    $($row.find("td:eq(12) select")).append(option3);

                    data.forEach(element => {
                        var option = " <option value='" +
                            element["province_c"] +
                            "'>" +
                            element["province_m"] +
                            "</option>";
                        $($row.find("td:eq(10) select")).append(option);
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

                    $($row.find("td:eq(11) select")).empty();
                    $($row.find("td:eq(12) select")).empty();
                    var option1 =
                        " <option value='' selected>Select Option</option>";
                    $($row.find("td:eq(11) select")).append(option1);
                    var option3 =
                        " <option value='' selected>Select Option</option>";
                    $($row.find("td:eq(12) select")).append(option3);

                    data.forEach(element => {
                        var option = " <option value='" +
                            element["city_c"] +
                            "'>" +
                            element["city_m"] +
                            "</option>";
                        $($row.find("td:eq(11) select")).append(option);
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

                    $($row.find("td:eq(12) select")).empty();
                    var option1 =
                        " <option value='' selected>Select Option</option>";
                    $($row.find("td:eq(12) select")).append(option1);

                    data.forEach(element => {
                        var option = " <option value='" +
                            element["barangay_c"] +
                            "'>" +
                            element["barangay_m"] +
                            "</option>";
                        $($row.find("td:eq(12) select")).append(option);
                    });
                }
            });
        });

        //Populate Permanent Province
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

                    $($row.find("td:eq(15) select")).empty();
                    $($row.find("td:eq(16) select")).empty();
                    $($row.find("td:eq(17) select")).empty();
                    var option1 =
                        " <option value='' selected>Select Option</option>";
                    $($row.find("td:eq(15) select")).append(option1);
                    var option2 =
                        " <option value='' selected>Select Option</option>";
                    $($row.find("td:eq(16) select")).append(option1);
                    var option3 =
                        " <option value='' selected>Select Option</option>";
                    $($row.find("td:eq(17) select")).append(option3);

                    data.forEach(element => {
                        var option = " <option value='" +
                            element["province_c"] +
                            "'>" +
                            element["province_m"] +
                            "</option>";
                        $($row.find("td:eq(15) select")).append(option);
                    });
                }
            });
        });

        //Populate Permanent City
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

                    $($row.find("td:eq(16) select")).empty();
                    $($row.find("td:eq(17) select")).empty();
                    var option1 =
                        " <option value='' selected>Select Option</option>";
                    $($row.find("td:eq(16) select")).append(option1);
                    var option3 =
                        " <option value='' selected>Select Option</option>";
                    $($row.find("td:eq(17) select")).append(option3);

                    data.forEach(element => {
                        var option = " <option value='" +
                            element["city_c"] +
                            "'>" +
                            element["city_m"] +
                            "</option>";
                        $($row.find("td:eq(16) select")).append(option);
                    });
                }
            });
        });

        //Populate Permanent Barangay
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

                    $($row.find("td:eq(17) select")).empty();
                    var option1 =
                        " <option value='' selected>Select Option</option>";
                    $($row.find("td:eq(17) select")).append(option1);

                    data.forEach(element => {
                        var option = " <option value='" +
                            element["barangay_c"] +
                            "'>" +
                            element["barangay_m"] +
                            "</option>";
                        $($row.find("td:eq(17) select")).append(option);
                    });
                }
            });
        });

        //Populate Item Seized Suspect Name
        $(document).on("click", "#custom-tabs-four-evidence-tab", function() {

            var table = $("#suspect_informations");

            $(".suspect_number_item").find('option').not(':selected').remove();
            // $(".suspect_number_item").find(':selected').attr('hidden', 'true');

            table.find('tr').each(function(i) {
                var $tds = $(this).find('td input');
                var lastname = $tds.eq(1).val();
                var firstname = $tds.eq(2).val();
                var middlename = $tds.eq(3).val();
                var alias = $tds.eq(4).val();
                var birthdate = $tds.eq(5).val();

                if (lastname != null || firstname != null || middlename != null || alias != null) {
                    $(".suspect_number_item").append("<option value=" +
                        lastname + "," + firstname + "," + middlename + "," + alias + "," + birthdate + ">" +
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
            // $(".suspect_number_case").find(':selected').attr('hidden', 'true');

            table.find('tr').each(function(i) {
                var $tds = $(this).find('td input');
                var lastname = $tds.eq(1).val();
                var firstname = $tds.eq(2).val();
                var middlename = $tds.eq(3).val();
                var alias = $tds.eq(4).val();
                var birthdate = $tds.eq(5).val();


                if (lastname != null || firstname != null || middlename != null || alias != null) {
                    $(".suspect_number_case").append("<option value=" +
                        lastname + "," + firstname + "," + middlename + "," + alias + "," + birthdate + ">" +
                        lastname + ", " + firstname + " " +
                        middlename + " -- Alias: '" + alias +
                        "'</option>");
                }
            });
        });

        $(document).on("change", ".change_control", function() {

            var $row = $(this).closest(".suspect_details");
            var suspect_status_id = $row.find("td:eq(1) select").val();


            if (suspect_status_id != 2) {
                $cc2 = $('.cc2').val();
                $cc3 = $('.cc3').val();
                $cc4 = $('.cc4').val();
                $cc5 = $('.cc5').val();
                if ($cc2 == '' || $cc2 == null && $cc3 == '' || $cc3 == null && $cc4 == '' || $cc4 == null && $cc5 == '' || $cc5 == null) {
                    $('.change_control').attr('required', false)
                } else {
                    $('.change_control').attr('required', true)
                }
            } else {
                $row.find("td:eq(3) input").attr('required', false);
                $row.find("td:eq(4) input").attr('required', false);
                $row.find("td:eq(5) input").attr('required', false);
                $row.find("td:eq(6) input").attr('required', false);
                $row.find("td:eq(2) input").attr('required', false);
            }

        });

        $(document).on("change", "#operation_datetime", function() {
            var operation_datetime = $(this).val();
        });

        // Add Case
        // $('#case').on("click", ".Cadd", function() {
        //     var ro_code = $('.ro_code').val();

        //     html = '<div class="input-group mb-3 su_options">';
        //     html += '<select name="support_unit_id[]" class="form-control">';
        //     html += '<option value="" disabled selected>Select Option</option>@foreach($support_unit as $su)<option value="{{ $su->id }}">{{ $su->name }}</option>@endforeach';
        //     html += '</select>';
        //     html += '<a href="#" class="su_remove" style="float:right; margin-left:5px; padding: 5px"><i class="fas fa-minus pr-2 " style="color:red"></i></a>';
        //     html += '</div>';

        //     $('#sp_list').append(html);

        // });

        $(document).on('click', '.su_remove', function() {
            $(this).closest(".su_options").remove();
        });

        //Populate Evidence Type
        $(document).on("change", ".drugSLCT", function() {
            var drugT = $(this).val();
            var $row = $(this).closest(".suspect_item_details");

            if (drugT == 'drug') {
                category = 'drug';
                // $($row.find("td:eq(3) input")).css('pointer-events', '').css('background-color', '');
                // $($row.find("td:eq(4) select")).css('pointer-events', '').css('background-color', '');
            } else {
                category = 'nondrug';
                // $($row.find("td:eq(3) input")).css('pointer-events', 'none').css('background-color', '#e9ecef');
                // $($row.find("td:eq(4) select")).css('pointer-events', 'none').css('background-color', '#e9ecef');
            }


            $.ajax({
                type: "GET",
                url: "/get_evidence_type/" + category,
                fail: function() {
                    alert("request failed");
                },
                success: function(data) {
                    var data = JSON.parse(data);

                    $($row.find("td:eq(2) select")).empty();
                    var option1 =
                        " <option value='' selected>Select Option</option>";
                    $($row.find("td:eq(2) select")).append(option1);

                    data.forEach(element => {
                        var option = " <option value='" +
                            element["id"] +
                            "'>" +
                            element["evidence"] +
                            "</option>";
                        $($row.find("td:eq(2) select")).append(option);
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

                    $($row.find('td:eq(4) option')).removeAttr('selected');

                    data.forEach(element => {
                        $($row.find('td:eq(4) option[value=' + element["id"] + ']')).attr('selected', 'selected');
                    });
                }
            });
        });

        //Populate Suspect Category
        $(document).on("change", ".suspect_classification_id", function() {
            var suspect_classification_id = $(this).val();
            var $row = $(this).closest(".suspect_details");

            $.ajax({
                type: "GET",
                url: "/get_suspect_category/" + suspect_classification_id,
                fail: function() {
                    alert("request failed");
                },
                success: function(data) {
                    var data = JSON.parse(data);

                    $($row.find("td:eq(28) select")).empty();
                    var option1 =
                        " <option value='' selected>Select Option</option>";
                    $($row.find("td:eq(28) select")).append(option1);

                    data.forEach(element => {
                        var option = " <option value='" +
                            element["id"] +
                            "'>" +
                            element["name"] +
                            "</option>";
                        $($row.find("td:eq(28) select")).append(option);
                    });
                }
            });
        });

        $(document).on("change", ".suspect_category_id", function() {
            var suspect_category_id = $(this).val();
            var $row = $(this).closest(".suspect_details");

            $.ajax({
                type: "GET",
                url: "/get_suspect_sub_category/" + suspect_category_id,
                fail: function() {
                    alert("request failed");
                },
                success: function(data) {
                    var data = JSON.parse(data);

                    $($row.find("td:eq(29) select")).empty();
                    var option1 =
                        " <option value='' selected>Select Option</option>";
                    $($row.find("td:eq(29) select")).append(option1);

                    data.forEach(element => {
                        var option = " <option value='" +
                            element["id"] +
                            "'>" +
                            element["name"] +
                            "</option>";
                        $($row.find("td:eq(29) select")).append(option);
                    });
                }
            });
        });

        //Print Report on Load
        var print_id = $('#print_id').val();
        if (print_id > 0) {

            var url = "spot_report/pdf/" + print_id;
            window.open(url, "_blank");
        }

        //Select2 Lazy Loading Spot
        $(".OPUnitSearch").select2({
            minimumInputLength: 2,
            ajax: {
                url: '/search_operating_unit',
                dataType: "json",
            }
        }).prop('disabled', true);


        $(".PreopsNumberSearch").select2({
            minimumInputLength: 2,
            ajax: {
                url: '/search_preops_number',
                dataType: "json",
            }
        });

        $(".SUPPUnitSearch").select2({
            minimumInputLength: 2,
            ajax: {
                url: '/search_operating_unit',
                dataType: "json",
            }
        }).prop('disabled', true);

        $(".OPTypeSearch").select2({
            minimumInputLength: 2,
            ajax: {
                url: '/search_operation_type_show',
                dataType: "json",
                data: function(params) {
                    var show = 'spot';
                    return {
                        term: params.term, // search term
                        show: show,
                    };
                },
            }
        });

        $(".CaseSearch").select2({
            minimumInputLength: 2,
            ajax: {
                url: '/search_case',
                dataType: "json",
            }
        });

        //Get HIO Type
        $.ajax({
            url: '/get_hio_type',
            success: function(data) {
                var data = JSON.parse(data);

                data.forEach(element => {
                    var option1 = " <option value='' selected>Select Option</option>";
                    $("#hio_type_id").append(option1);
                    var option = " <option value='" +
                        element["id"] +
                        "'>" +
                        element["name"] +
                        "</option>";
                    $("#hio_type_id").append(option);
                });
            }
        });

        loadSelect2();
    });

    //Add Support Unit
    function addrow() {
        var ro_code = $('.ro_code').val();
        var row = $(".su_options:last");
        row.find(".SUPPUnitSearch").each(function(index) {
            $(this).select2('destroy');
        });
        var newrow = row.clone();
        $(".SUdetails").append(newrow);

        if (ro_code == null) {
            $(".SUPPUnitSearch").select2({
                minimumInputLength: 2,
                ajax: {
                    url: '/search_operating_unit',
                    dataType: "json",
                }
            });
        } else {
            $(".SUPPUnitSearch").select2({
                minimumInputLength: 2,
                ajax: {
                    url: '/search_operating_unit_ro_code',
                    dataType: "json",
                    data: function(params) {
                        return {
                            q: term, // search term
                            ro_code: ro_code,
                        };
                    },
                }
            });
        }
    }

    //Add Support Unit
    function addSuspect() {
        var row = $(".suspect_details:last");
        row.find(".select2").each(function(index) {
            $("select.select2-hidden-accessible").select2('destroy');
        });

        var newrow = row.clone();
        $("#suspect_informations").append(newrow);

        loadSelect2();
    }

    function loadSelect2() {
        $(".NationalitySearch").select2({
            minimumInputLength: 2,
            ajax: {
                url: '/search_nationality',
                dataType: "json",
            }
        });

        $(".CivilStatusSearch").select2({
            minimumInputLength: 2,
            ajax: {
                url: '/search_civil_status',
                dataType: "json",
            }
        });

        $(".EthnicGroupSearch").select2({
            minimumInputLength: 2,
            ajax: {
                url: '/search_ethnic_group',
                dataType: "json",
            }
        });

        $(".ReligionSearch").select2({
            minimumInputLength: 2,
            ajax: {
                url: '/search_religion',
                dataType: "json",
            }
        });

        $(".EducationSearch").select2({
            minimumInputLength: 2,
            ajax: {
                url: '/search_education',
                dataType: "json",
            }
        });

        $(".OccupationSearch").select2({
            minimumInputLength: 2,
            ajax: {
                url: '/search_occupation',
                dataType: "json",
            }
        });

        $(".IdentifierSearch").select2({
            minimumInputLength: 2,
            ajax: {
                url: '/search_identifier',
                dataType: "json",
            }
        });

        $(".SuspectClassificationSearch").select2({
            minimumInputLength: 2,
            ajax: {
                url: '/search_suspect_classification',
                dataType: "json",
            }
        });

        $(".SuspectCategorySearch").select2({
            minimumInputLength: 2,
            ajax: {
                url: '/search_suspect_category',
                dataType: "json",
            }
        });

        $(".SuspectSubCategorySearch").select2({
            minimumInputLength: 2,
            ajax: {
                url: '/search_suspect_sub_category',
                dataType: "json",
            }
        });
    }


    //Add rows for Item Seized
    var items_row = 0;

    function addItems() {
        html = '<tr class="suspect_item_details" id="items-row' + items_row + '">';
        html +=
            '<td><select style="width: 300px;" name="suspect_number_item[]" class="form-control @error("suspect name") is-invalid @enderror suspect_number_item"><option value="" selected>Select Option</option></select></td>';
        html +=
            '<td><select style="width: 200px;" name="drug[]" class="form-control drugSLCT"><option value="" disabled selected>Select Option</option><option value="drug">Drug</option><option value="non-drug">Non-Drug</option></select></td>';
        html += '<td><select style="width: 200px;" name="evidence_id[]" class="form-control evidenceSLCT"><option value="" disabled selected>Select Option</option></select></td>';
        html += '<td><input style="width: 200px;" type="text" name="quantity[]" class="form-control" ></td>';
        html +=
            '<td><select style="width: 200px;" name="unit_measurement_id[]" class="form-control disabled_field"><option value="" disabled selected>Select Option</option>@foreach ($unit_measurement as $um)<option value="{{ $um->id }}">{{ $um->name }}</option>@endforeach</select></td>';
        html += '<td><select style="width: 200px;" name="packaging_id[]" class="form-control"><option value="" selected>Select Option</option>@foreach ($packaging as $pk)<option value="{{ $pk->id }}"> {{ $pk->name }}</option>@endforeach</td>';
        html += '<td><input style="width: 200px;" type="text" name="markings[]" class="form-control"></td>';
        html += '<td class="mt-10"><button class="badge badge-danger" onclick="$(\'#items-row' + items_row +
            '\').remove();"><i class="fa fa-trash"></i> Delete</button></td>';

        html += '</tr>';

        $('#items tbody').append(html);

        items_row++;

        var table = $("#suspect_informations");

        $(".suspect_number_item").find('option').not(':selected').remove();
        $(".suspect_number_item").find(':selected').addClass('disabled_field');

        table.find('tr').each(function(i) {
            var $tds = $(this).find('td input');
            var lastname = $tds.eq(1).val();
            var firstname = $tds.eq(2).val();
            var middlename = $tds.eq(3).val();
            var alias = $tds.eq(4).val();
            var birthdate = $tds.eq(5).val();

            if (lastname != null || firstname != null || middlename != null || alias != null) {
                $(".suspect_number_item").append("<option value=" +
                    lastname + "," + firstname + "," + middlename + "," + alias + "," + birthdate + ">" +
                    lastname + ", " + firstname + " " +
                    middlename + " -- Alias: '" + alias +
                    "'</option>");
            }
        });
    }

    //Add rows for Case
    var case_row = 0;

    function addCase() {
        html = '<tr id="case-row' + case_row + '">';
        html +=
            '<td><select style="width:400px" name="suspect_number_case[]" class="form-control @error("suspect name") is-invalid @enderror suspect_number_case"><option value="" selected>Select Option</option></select></td>';
        html +=
            '<td><select style="width:400px" name="case_id[]" class="form-control CaseSearch"></select></td>';
        html += '<td class="mt-10"><button class="badge badge-danger" onclick="$(\'#case-row' + case_row +
            '\').remove();"><i class="fa fa-trash"></i> Delete</button></td>';

        html += '</tr>';

        $('#case tbody').append(html);

        $(".CaseSearch").select2({
            minimumInputLength: 2,
            ajax: {
                url: '/search_case',
                dataType: "json",
            }
        });

        case_row++;

        var table = $("#suspect_informations");

        $(".suspect_number_case").find('option').not(':selected').remove();
        $(".suspect_number_case").find(':selected').addClass('disabled_field');

        table.find('tr').each(function(i) {
            var $tds = $(this).find('td input');
            var suspect_number = $tds.eq(0).val();
            var lastname = $tds.eq(1).val();
            var firstname = $tds.eq(2).val();
            var middlename = $tds.eq(3).val();
            var alias = $tds.eq(4).val();
            var birthdate = $tds.eq(5).val();

            if (lastname != null) {
                $(".suspect_number_case").append("<option value=" +
                    lastname + "," + firstname + "," + middlename + "," + alias + "," + birthdate + ">" +
                    lastname + ", " + firstname + " " +
                    middlename + " -- Alias: '" + alias +
                    "'</option>");
            }
        });
    }


    //Add rows for Operation Team
    var opteam_row = 0;

    function addOpteam() {
        html = '<tr id="opteam-row' + opteam_row + '">';
        html += '<td><input type="text" name="officer_name[]" class="form-control"></td>';
        html += '<td><input type="text" name="officer_position[]" class="form-control"></td>';
        html += '<td class="mt-10"><button class="badge badge-danger" onclick="$(\'#opteam-row' + opteam_row +
            '\').remove();"><i class="fa fa-trash"></i> Delete</button></td>';

        html += '</tr>';

        $('#opteam tbody').append(html);

        opteam_row++;
    }


    $("#preops_number").on("change", function() {

        var preops_number = $(this).val();

        if (preops_number == 1) {

            $("#operation_type_id").removeClass("disabled_field");
            $("#region_c").removeClass("disabled_field");
            $("#province_c").removeClass("disabled_field");
            // $("#operation_datetime").removeClass("disabled_field");
            $("#operating_unit_id").prop("disabled", false);
            $("#support_unit_id").prop("disabled", false);
            $("#support_unit_id").prop("required", false);
            $("#SPadd").attr("hidden", false);
            $("#SPadd").css("pointer-events", '');

            $('#operation_type_id').empty();
        } else {

            $("#operation_type_id").addClass("disabled_field");
            $("#region_c").addClass("disabled_field");
            $("#province_c").addClass("disabled_field");
            // $("#operation_datetime").addClass("disabled_field");
            $("#operating_unit_id").addClass("disabled_field");
            $("#support_unit_id").addClass("disabled_field");
            $("#support_unit_id").prop("required", true);
            $("#SPadd").css("pointer-events", 'none');


            // Display Preops Header Info
            $.ajax({
                type: "GET",
                url: "/get_preops_header/" + preops_number,
                fail: function() {
                    alert("request failed");
                },
                success: function(data) {
                    var data = JSON.parse(data);
                    if (data.length != 0) {
                        data.forEach(element => {
                            // alert(element["operation_type_id"]);
                            var operation_type = " <option value='" +
                                element["operation_type_id"] +
                                "' selected>" +
                                element["operation_type_name"] +
                                "</option>";
                            $("#operation_type_id").append(operation_type);

                            var operating_unit = " <option value='" +
                                element["operating_unit_id"] +
                                "' selected>" +
                                element["operating_unit_name"] +
                                "</option>";
                            $("#operating_unit_id").append(operating_unit);



                            $('#region_c option[value=' + element['region_c'] + ']').attr('selected', 'selected');
                            $('#operation_datetime').val(element['operation_datetime']);

                            var date = $("#operation_datetime").val();

                            $('#operation_datetime')[0].min = date;


                            var region_c = element['region_c'];
                            $.ajax({
                                type: "GET",
                                url: "/get_province/" + region_c,
                                fail: function() {
                                    alert("request failed");
                                },
                                success: function(data) {
                                    var data = JSON.parse(data);

                                    $('#province_c').empty();
                                    $('#city_c').empty();
                                    $('#barangay_c').empty();
                                    var option1 = " <option value='' selected>Select Option</option>";
                                    var option1 = " <option value='0000' selected>Regional Coordination</option>";
                                    $("#province_c").append(option1);

                                    data.forEach(element => {
                                        var option = " <option value='" +
                                            element["province_c"] +
                                            "'>" +
                                            element["province_m"] +
                                            "</option>";
                                        $("#province_c").append(option);
                                    });

                                    if (element['province_c'] != '0000' && element['province_c'] != '') {
                                        $('#province_c option[value=' + element['province_c'] + ']').attr('selected', 'selected');
                                    } else if (element['province_c'] == '0000') {
                                        $('#province_c option[value=0000]').attr('selected', 'selected');
                                    } else {
                                        $("#province_c").removeClass("disabled_field");
                                    }
                                }
                            });


                            var province_c = element['province_c'];

                            $.ajax({
                                type: "GET",
                                url: "/get_city/" + province_c,
                                fail: function() {
                                    alert("request failed");
                                },
                                success: function(data) {
                                    var data = JSON.parse(data);

                                    $('#city_c').empty();
                                    $('#barangay_c').empty();
                                    var option1 = " <option value='' selected>Select Option</option>";
                                    $("#city_c").append(option1);

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

                            $.ajax({
                                type: "GET",
                                url: "/get_support_unit/" + preops_number,
                                fail: function() {
                                    alert("request failed");
                                },
                                success: function(data) {
                                    var data = JSON.parse(data);
                                    $('.SUdetails').empty();
                                    $('#SUOptions').empty();

                                    data.forEach(element => {
                                        var option = "<div class='input-group mb-3 '><select id='support_unit_id' name='support_unit_id[]' class='form-control' style='pointer-events: none; background-color : #e9ecef;' required>" +
                                            "<option value='" + element["id"] + "' selected> " + element["description"] + "</option></div>";
                                        $(".SUdetails").append(option);
                                    });
                                }
                            });

                            // Display Warrant Details
                            $.ajax({
                                type: "GET",
                                url: "/get_operation_type/" + element['operation_type_id'],
                                fail: function() {
                                    alert("request failed");
                                },
                                success: function(data) {
                                    var data = JSON.parse(data);

                                    data.forEach(element => {
                                        if (element['is_warrant'] == 1) {
                                            $('#warrant_Details').attr('hidden', false);
                                        } else {
                                            $('#warrant_Details').attr('hidden', true);
                                        }

                                    });

                                }
                            });
                        });
                    }


                }
            });


            // Display Operations Team
            $("#opsteamlist").empty();

            $.ajax({
                type: "GET",
                url: "/get_preops_team/" + preops_number,
                fail: function() {
                    alert("request failed");
                },
                success: function(data) {
                    var data = JSON.parse(data);

                    if (data.length > 0) {
                        data.forEach(element => {
                            var option =
                                "<tr><td ><input type='text' name='officer_name[]' class='form-control' value='" +
                                element["name"] +
                                "'></td><td ><input type='text' name='officer_position[]' class ='form-control' value='" +
                                element["position"] +
                                "'> </td> <td class = 'mt-10' > <button type='button' class='badge badge-danger' onclick='SomeDeleteRowFunction(this)'> <i class ='fa fa-trash'> </i> Delete</button> </td> </tr>";
                            $("#opsteamlist").append(option);
                        });
                    } else {
                        var option =
                            "<tr><td ><input type='text' name='officer_name[]' class='form-control'></td><td ><input type='text' name='officer_position[]' class ='form-control'> </td> <td class = 'mt-10' > <button type='button' class='badge badge-danger' onclick='SomeDeleteRowFunction(this)'> <i class ='fa fa-trash'> </i> Delete</button> </td> </tr>";
                        $("#opsteamlist").append(option);
                    }
                }
            });



        }

        $('#saveBTN').click(function() {
            $('input:invalid').each(function() {
                // Find the tab-pane that this element is inside, and get the id
                var $closest = $(this).closest('.tab-pane');
                var id = $closest.attr('id');

                // Find the link that corresponds to the pane and have it show
                $('.nav a[href="#' + id + '"]').tab('show');
                $(this).css('border-color', 'red');

                // Only want to do it once
                return false;
            });
        });

        $('.form-control').keyup(function() {
            if ($(this).val() != null) {
                $(this).css('border-color', 'green');
            }
        });
        $('.form-control').change(function() {
            if ($(this).val() != null) {
                $(this).css('border-color', 'green');
            }
        });

        // Remove Required On At Large Surpect Status
        $(document).on("change", ".suspect_status_id", function() {

            var suspect_status_id = $(this).val();
            var $row = $(this).closest(".suspect_details");


            if (suspect_status_id == 2) {
                $row.find("td:eq(3) input").attr('required', false);
                $row.find("td:eq(4) input").attr('required', false);
                $row.find("td:eq(5) input").attr('required', false);
                $row.find("td:eq(6) input").attr('required', false);
                $row.find("td:eq(2) input").attr('required', false);
            } else {
                $row.find("td:eq(3) input").attr('required', true);
                $row.find("td:eq(4) input").attr('required', true);
                $row.find("td:eq(5) input").attr('required', true);
                $row.find("td:eq(6) input").attr('required', true);
                $row.find("td:eq(2) input").attr('required', true);
            }


        });

        // Prevent Multiple Click of Save Button
        $("#spot_report_form").on("submit", function() {
            $(this).find(":submit").prop("disabled", true);
        });

        // HIO tick
        $('#operation_lvl').change(function() {
            if (this.checked) {
                $("#hio_type_id").prop('disabled', false)
            } else {
                $("#hio_type_id").prop('disabled', true)
            }

        });

    });
</script>


<style>
    .error {
        border: 1px solid red;
    }

    ;
</style>

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