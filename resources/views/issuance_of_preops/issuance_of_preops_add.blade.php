@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add Issuance of Pre-Ops</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="removeCokie();">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('issuance_of_preops_list') }}">Issuance of Pre-Ops List</a></li>
                    <li class="breadcrumb-item active">Add Issuance of Pre-Ops</li>
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
        <input hidden id="print_id" type="text" value="{{session('preops_id_c')}}">
    </div>
    @endif
    <!-- Default box -->
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Add Issuance of Pre-Ops</h3>
        </div>
        <div class="card-body">
            <form action="/issuance_of_preops_add" role="form" method="post" enctype="multipart/form-data" id="preops_form">
                @csrf
                <div class="row">
                    <div class="form-group col-6" style="margin: 0px;">
                        <div>
                            <label for="">Region<code> *</code></label>
                        </div>
                        <input type="text" hidden value="{{Auth::user()->user_level_id}}" id="userlvlid">
                        <div class="input-group mb-3">
                            @if(Auth::user()->user_level_id == 1 || Auth::user()->user_level_id == 2)
                            <select name="ro_code" class="form-control ro_code" required>
                                <option value='' disabled selected>Select Option</option>
                                @foreach($regional_office as $rg)
                                <option value="{{ $rg->ro_code }}">{{ $rg->name }}</option>
                                @endforeach
                            </select>
                            @else
                            <select name="ro_code" class="form-control ro_code" required style="pointer-events: none; background-color : #e9ecef;" readonly>
                                <option value='' disabled selected>Select Option</option>
                                @foreach($regional_office as $rg)
                                <option value="{{ $rg->ro_code }}" {{ $rg->ro_code == $roc_regional_office[0]->ro_code ? 'selected' : '' }}>{{ $rg->name }}</option>
                                @endforeach
                            </select>
                            @endif

                        </div>
                    </div>
                    <div class="form-group col-6" style="margin: 0px;">
                        <div>
                            <label for="">Province<code> *</code></label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="province_c" name="hprovince_c" class="form-control" required>
                                @if(Auth::user()->user_level_id == 1 || Auth::user()->user_level_id == 2)
                                <option value='' disabled selected>Select Option</option>
                                @else
                                <option value='' disabled selected>Select Option</option>
                                <option value='0000'>Regional Coordination</option>
                                @foreach($regional_province as $pr)
                                <option value="{{ $pr->province_c }}">{{ $pr->province_m }}</option>
                                @endforeach
                                @endif

                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                <br>
                <h3>Coordinating Unit</h3>
                <div class="row">
                    <div class="form-group col-6" style="margin: 0px;">
                        <div>
                            <label for="">Pre-Ops No.<code> *</code></label>
                            <span id="preops_error" hidden style="float: right; color:red" for="">Preops Number Exist</span>
                        </div>

                        <div class="input-group mb-3">
                            @if(Auth::user()->user_level_id == 1 || Auth::user()->user_level_id == 2)
                            <input id="preops_number" name="preops_number" type="text" class="form-control @error('Preops Number') is-invalid @enderror HPRNumber" value="{{ old('preops_number') }}" autocomplete="off" required>
                            @else
                            <input id="preops_number" name="preops_number" type="text" class="form-control PRNumber" autocomplete="off" required style="pointer-events: none; background-color : #e9ecef;" value="Auto Generate">
                            <input id="prc_date" type="text" hidden value="{{$date}}">
                            <input id="prc_id" type="text" hidden value="{{$preops_id}}">
                            @endif

                        </div>
                    </div>
                    <div class="form-group col-6" style="margin: 0px;">
                        <div>
                            <label for="">Operating Unit<code> *</code></label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="operating_unit_id" name="operating_unit_id" class="form-control OPUnitSearch operating_unit_id" required>
                            </select>
                        </div>

                    </div>
                    <div class="form-group col-6" style="margin: 0px;">
                        <div>
                            <label for="">Type of Operation<code> *</code></label>
                        </div>
                        <div class="input-group mb-3">
                            <select name="operation_type_id" class="form-control @error('operation type') is-invalid @enderror" required>
                                <option value='' disabled selected>Select Option</option>
                                @foreach($operation_type as $ot)
                                <option value="{{ $ot->id }}">{{ $ot->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="sp_list" class="form-group col-6" style="margin: 0px;">
                        <div>
                            <label for="">Support Unit</label>
                            <a onclick="addrow();" href="#" style="float: right;"><i class="fas fa-plus pr-2"></i></a>
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
                <hr>
                <br>
                <h3>Time and Date Details</h3>
                <div class="row">
                    <div class="form-group col-6" style="margin: 0px;">
                        <div>
                            <label for="">Date/Time Coordinate<code> *</code></label>
                        </div>
                        <div class="input-group mb-3">
                            <?php date_default_timezone_set('Asia/Manila'); ?>
                            @if(Auth::user()->user_level_id == 1 || Auth::user()->user_level_id == 2)
                            <input id="coordinated_datetime" name="coordinated_datetime" type="datetime-local" class="form-control coordinated_datetime" autocomplete="off" required>
                            @else
                            <input id="coordinated_datetime" name="coordinated_datetime" type="datetime-local" class="form-control CurrDate" value="<?php echo date('Y-m-d\TH:i:s'); ?>" style="pointer-events: none; background-color : #e9ecef;" autocomplete="off" required readonly>
                            @endif
                        </div>
                    </div>
                    <div class="form-group col-6" style="margin: 0px;">
                        <div>
                            <label for="">Duration (Hours)<code> *</code></label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="duration" name="duration" type="number" class="form-control @error('duration') is-invalid @enderror" value="24" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group col-6" style="margin: 0px;">
                        <div>
                            <label for="">Date/Time Operation<code> *</code></label>
                        </div>
                        <div class="input-group mb-3">
                            @if(Auth::user()->user_level_id == 1 || Auth::user()->user_level_id == 2)
                            <input id="operation_datetime" name="operation_datetime" type="datetime-local" class="form-control @error('operation date and time') is-invalid @enderror" value="{{ old('operation_datetime') }}" required>
                            @else
                            <input id="operation_datetime" name="operation_datetime" type="datetime-local" class="form-control operation_datetime" value="{{ old('operation_datetime') }}" required>
                            @endif

                        </div>
                    </div>
                    <div class="form-group col-6" style="margin: 0px;">
                        <div>
                            <label for="">Valid Until (Expiration)</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="validity" name="validity" type="datetime-local" class="form-control" autocomplete="off" value="{{ old('validity') }}" style="pointer-events: none; background-color : #e9ecef;" readonly>
                        </div>
                    </div>
                    <div class="form-group col-12" style="margin: 0px;">
                        <div>
                            <label for="">Remarks</label>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group mb-3">
                                <textarea id="remarks" name="remarks" class="form-control">{{ old('remarks') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-four-area-tab" data-toggle="pill" href="#custom-tabs-four-area" role="tab" aria-controls="custom-tabs-four-area" aria-selected="true">Area of Operation</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-four-target-tab" data-toggle="pill" href="#custom-tabs-four-target" role="tab" aria-controls="custom-tabs-four-target" aria-selected="false">Target</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-four-opteam-tab" data-toggle="pill" href="#custom-tabs-four-opteam" role="tab" aria-controls="custom-tabs-four-opteam" aria-selected="false">Operating Team</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-four-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-four-area" role="tabpanel" aria-labelledby="custom-tabs-four-area-tab">
                                        <div class="form-group col-12" style="padding: 0 5px;" id="siblingTBL">

                                            <div class="card table-responsive p-0">
                                                <table id="aop" class="table table-hover text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th style="color: gray;">Area</th>
                                                            <th style="color: gray;">Region</th>
                                                            <th style="color: gray;">Province</th>
                                                            <th style="color: gray;">City</th>
                                                            <th style="color: gray;">Barangay</th>
                                                            <!-- <th style="color: gray;">Type</th> -->
                                                            <th style="color: gray;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="area_details">
                                                            <td><input type="text" name="area[]" class="form-control change_control cc1" placeholder="Area" style="width: 200px;"></td>
                                                            <td>
                                                                <select name="area_region_c[]" class="form-control region_c change_control cc2 disabled_field area_region_c" style="width: 300px;">
                                                                    <option value='0' selected>None
                                                                    </option>
                                                                    @if(Auth::user()->user_level_id == 1 || Auth::user()->user_level_id == 2)
                                                                    @foreach ($region as $rg)
                                                                    <option value="{{ $rg->region_c }}">
                                                                        {{ $rg->abbreviation }} -
                                                                        {{ $rg->region_m }}
                                                                    </option>
                                                                    @endforeach
                                                                    @else
                                                                    @foreach($region as $rg)
                                                                    <option value="{{ $rg->region_c }}" {{ $rg->region_c == $roc_regional_office[0]->region_c ? 'selected' : '' }}>{{ $rg->abbreviation }} -
                                                                        {{ $rg->region_m }}
                                                                    </option>
                                                                    @endforeach
                                                                    @endif
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="province_c[]" class="form-control province_c" style="width: 300px;">
                                                                    <option value='0' selected>None
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="city_c[]" class="form-control city_c cc4" style="width: 300px;">
                                                                    <option value='0' selected>None
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="barangay_c[]" class="form-control barangay_c cc5" style="width: 300px;">
                                                                    <option value='0' selected>None
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <!-- <td><input type="text" name="area_type[]" class="form-control change_control cc6" placeholder="Type" style="width: 200px;"></td> -->
                                                            <td class="mt-10"><button type="button" class="badge badge-danger"><i class="fa fa-trash"></i> Delete</button></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="text-center"><button type="button" class="badge badge-success addArea"><i class="fa fa-plus"></i> ADD NEW</button></div>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-four-target" role="tabpanel" aria-labelledby="custom-tabs-four-target-tab">
                                        <div class="form-group col-12" style="padding: 0 5px;" id="siblingTBL">
                                            <div class="card table-responsive">
                                                <table id="target" class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th style="color: gray; width:40%">Name of Target</th>
                                                            <th style="color: gray; width:40%">Nationality</th>
                                                            <th style="color: gray; width:20%">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><input type="text" name="target_name[]" class="form-control target_name" placeholder="Name of Target" required></td>
                                                            <td>
                                                                <select name="nationality_id[]" class="form-control nationality_id" required>
                                                                    @foreach($nationality as $nat)
                                                                    <option value="{{ $nat->id }}" {{ $nat->id == 1 ? 'selected' : '' }}>{{ $nat->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td class="mt-10"><button type="button" class="badge badge-danger"><i class="fa fa-trash"></i> Delete</button></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="text-center"><button type="button" onclick="addtarget();" class="badge badge-success"><i class="fa fa-plus"></i> ADD NEW</button></div>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-four-opteam" role="tabpanel" aria-labelledby="custom-tabs-four-opteam-tab">
                                        <div class="form-group col-12" style="padding: 0 5px;" id="siblingTBL">
                                            <div class="card table-responsive">
                                                <table id="opt" class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th style="color: gray; width:30%">Name</th>
                                                            <th style="color: gray; width:30%">Position</th>
                                                            <th style="color: gray; width:20%">Contact No.</th>
                                                            <th style="color: gray; width:20%">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><input type="text" name="team_name[]" class="form-control tchange_control tcc1 team_name" placeholder="Name" required></td>
                                                            <td><input type="text" name="team_position[]" class="form-control tchange_control tcc2l team_position" placeholder="Position" value="Team Leader" style="pointer-events:none; background-color : #e9ecef;" readonly></td>
                                                            <td><input type="text" name="team_contact[]" class="form-control tchange_control tcc3 team_contact" placeholder="Contact No." required></td>
                                                            <td class="mt-10"><button type="button" class="badge badge-danger"><i class="fa fa-trash"></i> Delete</button></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="text-center"><button type="button" onclick="addopt();" class="badge badge-success"><i class="fa fa-plus"></i> ADD NEW</button></div>

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
                            <input id="reference_number" name="reference_number" type="text" class="form-control @error('present street') is-invalid @enderror" value="{{ old('reference_number') }}" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group col-7" style="margin: 0px;">
                        <div>
                            <label for="">Reference File</label>
                        </div>
                        <div class="custom-file mb-3">
                            <input type="file" name="fileattach[]" class="custom-file-input" id="fileattach" multiple />
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
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
                            <label for="">Approved By<code> *</code></label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="approved_by" name="approved_by" class="form-control" required>
                                <option value='' selected>Select Option</option>
                                @foreach($approved_by as $ab)
                                <option value="{{ $ab->id }}">{{ $ab->name }}</option>
                                @endforeach
                            </select>
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
                    <button id="saveBTN" type="submit" class="btn btn-primary">Save Issuance of Pre-Ops</button>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <h6>Create Issuance of Pre-Ops maintenance data.</h6>
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
    var aop_row = 0;

    $(document).ready(function() {
        $(document).on("click", ".addArea", function() {

            var ro_code = $('.ro_code').val();
            var province_c = $('#province_c').val();
            $(".province_c").addClass('prc_2');
            $(".province_c").removeClass('prc_1');

            html = '<tr class="area_details" id="faqs-row' + aop_row + '">';
            html += '<td><input type="text" name="area[]" class="form-control" placeholder="Area"  style="width: 200px;"></td>';
            html +=
                '<td><select required name="area_region_c[]" }}" class="form-control region_c disabled_field"><option value="0" selected>None</option>@foreach ($region as $rg)<option value="{{ $rg->region_c }}">{{ $rg->abbreviation }} - {{ $rg->region_m }}</option>@endforeach</select></td>';
            html +=
                '<td><select name="province_c[]" class="form-control province_c disabled_field prc_1"><option value="0" selected>None</option>@foreach ($province as $pr)<option value="{{ $pr->province_c }}">{{ $pr->province_m }}</option>@endforeach</select></td>';
            html +=
                '<td><select name="city_c[]" class="form-control city_c" style="width: 300px;"><option value="0" selected>None</option></select></td>';
            html +=
                '<td><select name="barangay_c[]" class="form-control barangay_c" style="width: 300px;"><option value="0" selected>None</option></select></td>';
            // html += '<td><input type="text" name="area_type[]" class="form-control" placeholder="Type"  style="width: 200px;"></td>';
            html += '<td class="mt-10"><button class="badge badge-danger" onclick="$(\'#faqs-row' + aop_row + '\').remove();"><i class="fa fa-trash"></i> Delete</button></td>';

            html += '</tr>';

            $('#aop tbody').append(html);

            aop_row++;


            $.ajax({
                type: "GET",
                url: "/get_ro_details/" + ro_code,
                fail: function() {
                    alert("request failed");
                },
                success: function(data) {
                    var data = JSON.parse(data);

                    data.forEach(element => {
                        $('.region_c option[value=' + element["region_c"] + ']').attr('selected', 'selected');
                    });
                }
            });

            if (province_c == '0000') {
                $('.province_c').removeClass('disabled_field');
                $(".prc_1").empty();

                $.ajax({
                    type: "GET",
                    url: "/get_ro_province/" + ro_code,
                    fail: function() {
                        alert("request failed");
                    },
                    success: function(data) {
                        var data = JSON.parse(data);

                        var option1 = " <option value='0' selected>None</option>";
                        $(".prc_1").append(option1);

                        data.forEach(element => {
                            var option = " <option value='" +
                                element["province_c"] +
                                "'>" +
                                element["province_m"] +
                                "</option>";
                            $(".prc_1").append(option);
                        });
                    }
                });
            } else {
                $('.province_c').addClass('disabled_field');

                $('.province_c option[value=' + province_c + ']').attr('selected', 'selected');
            }



            $.ajax({
                type: "GET",
                url: "/get_city/" + province_c,
                fail: function() {
                    alert("request failed");
                },
                success: function(data) {
                    var data = JSON.parse(data);

                    // var option1 = " <option value='' selected>None</option>";
                    // $(".city_c").append(option1);

                    data.forEach(element => {
                        var option = " <option value='" +
                            element["city_c"] +
                            "'>" +
                            element["city_m"] +
                            "</option>";
                        $(".city_c").append(option);
                    });
                }
            });

        });

        // Remove Not Selected Fields upon Load
        $('.region_c').find('option').not(':selected').remove();


        //Print Report on Load
        var print_id = $('#print_id').val();
        if (print_id > 0) {

            var url = "issuance_report/pdf/" + print_id;
            window.open(url, "_blank");
        }

        $("#preops_form").on("submit", function() {
            $(this).find(":submit").prop("disabled", true);
        });



    });


    var opt_row = 0;

    function addopt() {
        html = '<tr id="faqs-row' + opt_row + '">';
        html += '<td><input required type="text" name="team_name[]" class="form-control" placeholder="Name"></td>';
        html += '<td><input required type="text" name="team_position[]" class="form-control" placeholder="Position" value="Team Leader" style="pointer-events:none; background-color : #e9ecef;" readonly></td>';
        html += '<td><input required type="text" name="team_contact[]" class="form-control" placeholder="Contact No."></td>';
        html += '<td class="mt-10"><button class="badge badge-danger" onclick="$(\'#faqs-row' + opt_row + '\').remove();"><i class="fa fa-trash"></i> Delete</button></td>';

        html += '</tr>';

        $('#opt tbody').append(html);

        opt_row++;
    }

    var target_row = 0;

    function addtarget() {
        html = '<tr id="faqs-row' + target_row + '">';
        html += '<td><input type="text" name="target_name[]" class="form-control" placeholder="Name of Target"></td>';
        html += "<td><select name='nationality_id[]' class='form-control @error('nationality') is-invalid @enderror'>@foreach($nationality as $nat)<option value='{{ $nat->id }}' {{ $nat->id == 1 ? 'selected' : '' }}>{{ $nat->name }}</option>@endforeach</select></td>";
        html += '<td class="mt-10"><button class="badge badge-danger" onclick="$(\'#faqs-row' + target_row + '\').remove();"><i class="fa fa-trash"></i> Delete</button></td>';

        html += '</tr>';

        $('#target tbody').append(html);

        target_row++;
    }
</script>

<script>
    $('#duration').keyup(function() {
        getdurationdate()
    });

    $('#operation_datetime').change(function() {
        getdurationdate()
    });

    function getdurationdate() {
        var datetimeval = $("#operation_datetime").val();
        var str = datetimeval;
        var d = new Date(str);
        var duration = parseInt($("#duration").val());

        // Add 1 hour to datetime
        d.setHours(d.getHours() + duration);
        var validity = d;
        var finaldate = moment(validity).format('YYYY-MM-DDTHH:mm');
        $("#validity").val(finaldate);
    }

    $('#preops_number').keyup(function() {
        var preops_number = $(this).val();

        $.ajax({
            type: "GET",
            url: "/get_preops_header/" + preops_number,
            fail: function() {
                alert("request failed");
            },
            success: function(data) {
                var data = JSON.parse(data);

                if (data.length > 0) {
                    $("#preops_error").attr('hidden', false);
                    $("#preops_number").addClass('error');
                    $("#saveBTN").attr('disabled', true);

                } else {
                    $("#preops_error").attr('hidden', true);
                    $("#preops_number").removeClass('error');
                    $("#saveBTN").attr('disabled', false);
                }
            }
        });
    });
</script>


<script>
    $(document).ready(function() {

        //Populate Header Province
        $(document).on("change", ".ro_code", function() {
            var ro_code = $(this).val();

            $.ajax({
                type: "GET",
                url: "/get_ro_region/" + ro_code,
                fail: function() {
                    alert("request failed");
                },
                success: function(data) {
                    var data = JSON.parse(data);

                    $(".region_c").empty();

                    var option1 = " <option value='0' selected>None</option>";
                    $(".region_c").append(option1);


                    data.forEach(element => {
                        var option = " <option value='" +
                            element["region_c"] +
                            "'>" +
                            element["region_m"] +
                            "</option>";
                        $(".region_c").append(option);
                    });
                }
            });

            $.ajax({
                type: "GET",
                url: "/get_ro_province/" + ro_code,
                fail: function() {
                    alert("request failed");
                },
                success: function(data) {
                    var data = JSON.parse(data);

                    $("#province_c").empty();

                    var option1 = " <option value='0' selected>None</option><option value='0000'>Regional Coordination</option>";
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

            $.ajax({
                type: "GET",
                url: "/get_ro_details/" + ro_code,
                fail: function() {
                    alert("request failed");
                },
                success: function(data) {
                    var data = JSON.parse(data);

                    data.forEach(element => {
                        $('.region_c option[value=' + element["region_c"] + ']').attr('selected', 'selected');
                    });
                }
            });

            $(".OPUnitSearch").empty();
            $(".SUPPUnitSearch").empty();

            $.ajax({
                type: "GET",
                url: "/get_approved_by/" + ro_code,
                fail: function() {
                    alert("request failed");
                },
                success: function(data) {
                    var data = JSON.parse(data);

                    $("#approved_by").empty();

                    var option1 = " <option value='0' selected>Select Option</option>";
                    $("#approved_by").append(option1);


                    data.forEach(element => {
                        var option = " <option value='" +
                            element["id"] +
                            "'>" +
                            element["name"] +
                            "</option>";
                        $("#approved_by").append(option);
                    });
                }
            });
        });

        //Populate Present Province
        $(document).on("change", ".region_c", function() {
            var region_c = $(this).val();
            var $row = $(this).closest(".area_details");

            $.ajax({
                type: "GET",
                url: "/get_province/" + region_c,
                fail: function() {
                    alert("request failed");
                },
                success: function(data) {
                    var data = JSON.parse(data);

                    $($row.find("td:eq(2) select")).empty();
                    $($row.find("td:eq(3) select")).empty();
                    $($row.find("td:eq(4) select")).empty();
                    var option1 =
                        " <option value='0' selected>Select Option</option>";
                    $($row.find("td:eq(2) select")).append(option1);

                    data.forEach(element => {
                        var option = " <option value='" +
                            element["province_c"] +
                            "'>" +
                            element["province_m"] +
                            "</option>";
                        $($row.find("td:eq(2) select")).append(option);
                    });
                }
            });
        });

        //Populate Present City
        $(document).on("change", "#province_c", function() {
            var province_c = $(this).val();
            var ro_code = $('.ro_code').val();

            if (province_c == '0000') {
                $('.province_c').removeClass('disabled_field');
                $(".province_c").empty();
                $(".city_c").empty();

                $.ajax({
                    type: "GET",
                    url: "/get_ro_province/" + ro_code,
                    fail: function() {
                        alert("request failed");
                    },
                    success: function(data) {
                        var data = JSON.parse(data);

                        var option1 = " <option value='0' selected>None</option>";
                        $(".province_c").append(option1);
                        var option2 = " <option value='0' selected>None</option>";
                        $(".city_c").append(option2);

                        data.forEach(element => {
                            var option = " <option value='" +
                                element["province_c"] +
                                "'>" +
                                element["province_m"] +
                                "</option>";
                            $(".province_c").append(option);
                        });
                    }
                });
            } else {
                $('.province_c').empty();
                $('.province_c').addClass('disabled_field');

                $.ajax({
                    type: "GET",
                    url: "/get_province_details/" + province_c,
                    fail: function() {
                        alert("request failed");
                    },
                    success: function(data) {
                        var data = JSON.parse(data);

                        data.forEach(element => {
                            var option = " <option value='" +
                                element["province_c"] +
                                "' selected>" +
                                element["province_m"] +
                                "</option>";
                            $(".province_c").append(option);
                        });
                    }
                });


                $.ajax({
                    type: "GET",
                    url: "/get_city/" + province_c,
                    fail: function() {
                        alert("request failed");
                    },
                    success: function(data) {
                        var data = JSON.parse(data);

                        $('.city_c').empty();
                        $('.barangay_c').empty();
                        var option1 = " <option value='0' selected>None</option>";
                        $(".city_c").append(option1);

                        var option2 =
                            " <option value='' selected>None</option>";
                        $(".barangay_c").append(option2);

                        data.forEach(element => {
                            var option = " <option value='" +
                                element["city_c"] +
                                "'>" +
                                element["city_m"] +
                                "</option>";
                            $(".city_c").append(option);
                        });
                    }
                });
            }


        });

        //Populate City
        $(document).on("change", ".province_c", function() {
            var province_c = $(this).val();
            var $row = $(this).closest(".area_details");

            $.ajax({
                type: "GET",
                url: "/get_city/" + province_c,
                fail: function() {
                    alert("request failed");
                },
                success: function(data) {
                    var data = JSON.parse(data);

                    $($row.find("td:eq(3) select")).empty();
                    $($row.find("td:eq(4) select")).empty();
                    var option1 =
                        " <option value='0' selected>None</option>";
                    $($row.find("td:eq(3) select")).append(option1);
                    var option2 =
                        " <option value='0' selected>None</option>";
                    $($row.find("td:eq(4) select")).append(option2);

                    data.forEach(element => {
                        var option = " <option value='" +
                            element["city_c"] +
                            "'>" +
                            element["city_m"] +
                            "</option>";
                        $($row.find("td:eq(3) select")).append(option);
                    });
                }
            });
        });

        //Populate Barangay
        $(document).on("change", ".city_c", function() {
            var city_c = $(this).val();
            var $row = $(this).closest(".area_details");

            $.ajax({
                type: "GET",
                url: "/get_barangay/" + city_c,
                fail: function() {
                    alert("request failed");
                },
                success: function(data) {
                    var data = JSON.parse(data);

                    $($row.find("td:eq(4) select")).empty();
                    var option1 =
                        " <option value='0' selected>None</option>";
                    $($row.find("td:eq(4) select")).append(option1);

                    data.forEach(element => {
                        var option = " <option value='" +
                            element["barangay_c"] +
                            "'>" +
                            element["barangay_m"] +
                            "</option>";
                        $($row.find("td:eq(4) select")).append(option);
                    });
                }
            });
        });

        // Populate Preops Number
        $(document).on("change", ".region_c", function() {
            var region_c = $(this).val();
            var $row = $(this).closest(".area_details");

            $.ajax({
                type: "GET",
                url: "/get_province/" + region_c,
                fail: function() {
                    alert("request failed");
                },
                success: function(data) {
                    var data = JSON.parse(data);

                    $($row.find("td:eq(2) select")).empty();
                    $($row.find("td:eq(3) select")).empty();
                    $($row.find("td:eq(4) select")).empty();
                    var option1 =
                        " <option value='' selected>None</option>";
                    $($row.find("td:eq(2) select")).append(option1);

                    data.forEach(element => {
                        var option = " <option value='" +
                            element["province_c"] +
                            "'>" +
                            element["province_m"] +
                            "</option>";
                        $($row.find("td:eq(2) select")).append(option);
                    });
                }
            });
        });
    });

    $(document).on("change", ".change_control", function() {
        $cc1 = $('.cc1').val();
        $cc2 = $('.cc2').val();
        $cc3 = $('.cc3').val();
        $cc4 = $('.cc4').val();
        $cc5 = $('.cc5').val();
        $cc6 = $('.cc6').val();
        if ($cc1 == '' && $cc2 == '' && $cc3 == '' && $cc4 == '' && $cc5 == '' && $cc6 == '') {
            $('.change_control').attr('required', false)
        } else {
            $('.change_control').attr('required', true)
        }
    });

    $(document).on("change", ".tchange_control", function() {
        $tcc1 = $('.tcc1').val();
        $tcc2 = $('.tcc2').val();
        $tcc3 = $('.tcc3').val();
        if ($tcc1 == '' && $tcc2 == '' && $tcc3 == '') {
            $('.tchange_control').attr('required', false)
        } else {
            $('.tchange_control').attr('required', true)
        }
    });

    // Remove Selected Operating Unit to Support Unit List
    $(document).on("change", ".operating_unit_id", function() {
        var operating_unit_id = $(this).val();

        $(".support_unit_id option").prop('hidden', false);
        $(".support_unit_id option[value='" + operating_unit_id + "']").prop('hidden', true);
    });

    
    $(document).on('click', '.su_remove', function() {
        $(this).closest(".su_options").remove();
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
        $('#coc').addClass('menu-open');
    });
    $(function() {
        $('#coc_link').addClass('active');
    });
    $(function() {
        $('#issuance_of_preops').addClass('active');
    });
</script>

<!-- Set Date Operation -->
<script>
    $(document).on('change', '#coordinated_datetime', function() {
        var date = $("#coordinated_datetime").val();

        $('#operation_datetime')[0].min = date;

        $('#operation_datetime').val('');
        $('#validity').val('');
    });
    var today = new Date().toISOString().slice(0, 16);

    $('.operation_datetime')[0].min = today;
</script>

<!-- Check EMpty Fields -->
<script>
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

    $(document).ready(function() {
        //Select2 Lazy Loading Spot
        $(".OPUnitSearch").select2({
            minimumInputLength: 2,
            ajax: {
                url: '/search_operating_unit',
                dataType: "json",
            }
        })

        var ro_code = $('.ro_code').val();

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
                        ro_code = $('.ro_code').val() //this is the anotherParm
                        return {
                            q: term, // search term
                            ro_code: ro_code,
                        };
                    },
                }
            });
        }
    });

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
                            term: params.term, // search term
                            ro_code: ro_code,
                        };
                    },
                }
            });
        }
    }
</script>

@endsection