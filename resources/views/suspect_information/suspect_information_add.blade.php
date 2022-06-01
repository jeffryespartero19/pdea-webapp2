@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add Suspect Information</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="removeCokie();">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('suspect_information_list') }}">Suspect Information List</a></li>
                    <li class="breadcrumb-item active">Add Suspect Information</li>
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
            <h3 class="card-title">Add Suspect Information</h3>
        </div>
        <div class="card-body">
            <form action="/suspect_information_add" role="form" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Suspect No.</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="suspect_number" name="suspect_number" type="number" class="form-control @error('Reference Number') is-invalid @enderror" value="{{ old('suspect_number') }}" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Operation</label>
                        </div>
                        <div class="input-group mb-3">
                            <select name="operation_classification_id" class="form-control @error('operation') is-invalid @enderror" required>
                                <option value='' disabled selected>Select Option</option>
                                @foreach($operation_classification as $oc)
                                <option value="{{ $oc->id }}">{{ $oc->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Date of OPN</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="operation_date" name="operation_date" type="date" class="form-control @error('date of OPN') is-invalid @enderror" value="{{ old('operation_date') }}" autocomplete="off" required>
                        </div>
                    </div>

                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Region</label>
                        </div>
                        <div class="input-group mb-3">
                            <select name="operation_region" class="form-control @error('region') is-invalid @enderror" required>
                                <option value='' disabled selected>Select Option</option>
                                @foreach($region as $rg)
                                <option value="{{ $rg->region_c }}">{{ $rg->abbreviation }} - {{ $rg->region_m }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Operating Unit</label>
                        </div>
                        <div class="input-group mb-3">
                            <select name="operating_unit_id" class="form-control @error('operating unit') is-invalid @enderror" required>
                                <option value='' disabled selected>Select Option</option>
                                @foreach($operating_unit as $ou)
                                <option value="{{ $ou->id }}">{{ $ou->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                <br>
                <div>
                    <div class="text-center empty-text">
                        <img class="profile-user-img img-fluid" style="height: 200px; width:200px;" src="data:image/jpeg;base64,{{ Auth::user()->photo }}" onerror=this.src="../../dist/img/profile.png" alt="User profile picture">
                    </div>
                    <div class="text-center pt-2">
                        <label class="btn-bs-file btn btn-info btn-sm">
                            Browse Photo
                            <input id="photo" name="photo" type="file" accept="image/jpeg, image/png, image/jpg, image/gif" hidden>
                        </label>
                    </div>
                </div>
                <br>
                <div class="row">

                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">First Name</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="firstname" name="firstname" type="text" class="form-control @error('first name') is-invalid @enderror" value="{{ old('firstname') }}" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Middle Name</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="middlename" name="middlename" type="text" class="form-control @error('middle name') is-invalid @enderror" value="{{ old('middlename') }}" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Last Name</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="lastname" name="lastname" type="text" class="form-control @error('last name') is-invalid @enderror" value="{{ old('lastname') }}" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group col-3" style="margin: 0px;">
                        <div>
                            <label for="">Alias</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="alias" name="alias" type="text" class="form-control @error('alias') is-invalid @enderror" value="{{ old('alias') }}" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group col-2" style="margin: 0px;">
                        <div>
                            <label for="">Gender</label>
                        </div>
                        <div class="input-group mb-3">
                            <select name="gender" class="form-control @error('gender') is-invalid @enderror" required>
                                <option value='' disabled selected>Select Option</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-3" style="margin: 0px;">
                        <div>
                            <label for="">Date of Birth</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="birthdate" name="birthdate" type="date" class="form-control @error('birthdate') is-invalid @enderror" value="{{ old('birthdate') }}" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group col-1" style="margin: 0px;">
                        <div>
                            <label for="">Age</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="age" name="age" type="number" class="form-control @error('age') is-invalid @enderror" value="{{ old('age') }}" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group col-3" style="margin: 0px;">
                        <div>
                            <label for="">Place of Birth</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="birthplace" name="birthplace" type="text" class="form-control @error('Place of Birth') is-invalid @enderror" value="{{ old('birthplace') }}" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group col-3" style="margin: 0px;">
                        <div>
                            <label for="">Nationality</label>
                        </div>
                        <div class="input-group mb-3">
                            <select name="nationality_id" class="form-control @error('nationality') is-invalid @enderror">
                                <option value='' disabled selected>Select Option</option>
                                @foreach($nationality as $nat)
                                <option value="{{ $nat->id }}">{{ $nat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-3" style="margin: 0px;">
                        <div>
                            <label for="">Civil Status</label>
                        </div>
                        <div class="input-group mb-3">
                            <select name="civil_status_id" class="form-control @error('civil status') is-invalid @enderror">
                                <option value='' disabled selected>Select Option</option>
                                @foreach($civil_status as $cv)
                                <option value="{{ $cv->id }}">{{ $cv->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-3" style="margin: 0px;">
                        <div>
                            <label for="">Religion</label>
                        </div>
                        <div class="input-group mb-3">
                            <select name="religion_id" class="form-control @error('religion') is-invalid @enderror">
                                <option value='' disabled selected>Select Option</option>
                                @foreach($religion as $rel)
                                <option value="{{ $rel->id }}">{{ $rel->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-3" style="margin: 0px;">
                        <div>
                            <label for="">Educational Attainment</label>
                        </div>
                        <div class="input-group mb-3">
                            <select name="educational_attainment_id" class="form-control @error('educational attainment') is-invalid @enderror">
                                <option value='' disabled selected>Select Option</option>
                                @foreach($education as $ed)
                                <option value="{{ $ed->id }}">{{ $ed->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Ethnic Group</label>
                        </div>
                        <div class="input-group mb-3">
                            <select name="ethnic_group_id" class="form-control @error('ethnic group') is-invalid @enderror">
                                <option value='' disabled selected>Select Option</option>
                                @foreach($ethnic_group as $eg)
                                <option value="{{ $eg->id }}">{{ $eg->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Occupation</label>
                        </div>
                        <div class="input-group mb-3">
                            <select name="occupation_id" class="form-control @error('occupation') is-invalid @enderror">
                                <option value='' disabled selected>Select Option</option>
                                @foreach($occupation as $occ)
                                <option value="{{ $occ->id }}">{{ $occ->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Monthly Income from Drug Related Activity</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="monthly_income" name="monthly_income" type="number" class="form-control @error('monthly income') is-invalid @enderror" value="{{ old('monthly_income') }}" autocomplete="off">
                        </div>
                    </div>
                </div>
                <hr>
                <br>
                <h3>Present Address</h3>
                <div class="row">
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Region</label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="region_c" name="region_c" class="form-control @error('region') is-invalid @enderror">
                                <option value='' disabled selected>Select Option</option>
                                @foreach($region as $rg)
                                <option value="{{ $rg->region_c }}">{{ $rg->abbreviation }} - {{ $rg->region_m }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Province</label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="province_c" name="province_c" class="form-control @error('province') is-invalid @enderror">
                                <option value='' disabled selected>Select Option</option>

                            </select>
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">City/Municipality</label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="city_c" name="city_c" class="form-control @error('city') is-invalid @enderror">
                                <option value='' disabled selected>Select Option</option>

                            </select>
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Barangay</label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="barangay_c" name="barangay_c" class="form-control @error('present barangay') is-invalid @enderror">
                                <option value='' disabled selected>Select Option</option>

                            </select>
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Street</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="street" name="street" type="text" class="form-control @error('street') is-invalid @enderror" value="{{ old('street') }}" autocomplete="off">
                        </div>
                    </div>
                </div>
                <hr>
                <br>
                <h3>Permanent Address</h3>
                <div class="row">
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Region</label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="permanent_region_c" name="permanent_region_c" class="form-control @error('region') is-invalid @enderror">
                                <option value='' disabled selected>Select Option</option>
                                @foreach($region as $rg)
                                <option value="{{ $rg->region_c }}">{{ $rg->abbreviation }} - {{ $rg->region_m }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Province</label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="permanent_province_c" name="permanent_province_c" class="form-control @error('province') is-invalid @enderror">
                                <option value='' disabled selected>Select Option</option>

                            </select>
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">City/Municipality</label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="permanent_city_c" name="permanent_city_c" class="form-control @error('city') is-invalid @enderror">
                                <option value='' disabled selected>Select Option</option>

                            </select>
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Barangay</label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="permanent_barangay_c" name="permanent_barangay_c" class="form-control @error('present barangay') is-invalid @enderror">
                                <option value='' disabled selected>Select Option</option>

                            </select>
                        </div>
                    </div>
                    <div class="form-group col-4" style="margin: 0px;">
                        <div>
                            <label for="">Street</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="permanent_street" name="permanent_street" type="text" class="form-control @error('street') is-invalid @enderror" value="{{ old('street') }}" autocomplete="off">
                        </div>
                    </div>
                </div>
                <hr>
                <br>
                <div class="row">
                    <div class="form-group col-3" style="margin: 0px;">
                        <div>
                            <label for="">Identifier</label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="identifier_id" name="identifier_id" class="form-control @error('suspect classification') is-invalid @enderror">
                                <option value='' disabled selected>Select Option</option>
                                @foreach($identifier as $if)
                                <option value="{{ $if->id }}">{{ $if->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-3" style="margin: 0px;">
                        <div>
                            <label for="">Classification</label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="suspect_classification_id" name="suspect_classification_id" class="form-control @error('suspect classification') is-invalid @enderror">
                                <option value='' disabled selected>Select Option</option>
                                @foreach($suspect_classification as $sc)
                                <option value="{{ $sc->id }}">{{ $sc->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-3" style="margin: 0px;">
                        <div>
                            <label for="">Group Affiliation</label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="group_affiliation_id" name="group_affiliation_id" class="form-control @error('suspect classification') is-invalid @enderror">
                                <option value='' disabled selected>Select Option</option>
                                @foreach($group_affiliation as $ga)
                                <option value="{{ $ga->id }}">{{ $ga->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-3" style="margin: 0px;">
                        <div>
                            <label for="">Drug Group</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="drug_group" name="drug_group" type="text" class="form-control @error('drug group') is-invalid @enderror" value="{{ old('drug_group') }}" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group col-12" style="margin: 0px;">
                        <div>
                            <label for="">Remarks</label>
                        </div>
                        <div class="input-group mb-3">
                            <textarea id="remarks" name="remarks" class="form-control @error('remarks') is-invalid @enderror" value="{{ old('remarks') }}" autocomplete="off"></textarea>
                        </div>
                    </div>

                </div>
                <div class="custom-control custom-checkbox mb-2">
                    <input name="status" class="custom-control-input" type="checkbox" id="customCheckbox9">
                    <label for="customCheckbox9" class="custom-control-label">Set as Active</label>
                </div>
                <div class="form-group mt-5">
                    <button type="submit" class="btn btn-primary">Save Suspect Information</button>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <h6>Create Suspect Information maintenance data.</h6>
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

                var option1 = " <option value='' disabled selected>Select Option</option>";
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

                var option1 = " <option value='' disabled selected>Select Option</option>";
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

                var option1 = " <option value='' disabled selected>Select Option</option>";
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

    $("#permanent_region_c").on("change", function() {

        var region_c = $(this).val();

        $.ajax({
            type: "GET",
            url: "/get_province/" + region_c,
            fail: function() {
                alert("request failed");
            },
            success: function(data) {
                var data = JSON.parse(data);

                $("#permanent_province_c").empty();
                $("#permanent_city_c").empty();
                $("#permanent_barangay_c").empty();

                var option1 = " <option value='' disabled selected>Select Option</option>";
                $("#permanent_province_c").append(option1);

                data.forEach(element => {
                    var option = " <option value='" +
                        element["province_c"] +
                        "'>" +
                        element["province_m"] +
                        "</option>";
                    $("#permanent_province_c").append(option);
                });
            }
        });
    });

    $("#permanent_province_c").on("change", function() {

        var region_c = $(this).val();

        $.ajax({
            type: "GET",
            url: "/get_city/" + region_c,
            fail: function() {
                alert("request failed");
            },
            success: function(data) {
                var data = JSON.parse(data);

                $("#permanent_city_c").empty();
                $("#permanent_barangay_c").empty();

                var option1 = " <option value='' disabled selected>Select Option</option>";
                $("#permanent_city_c").append(option1);

                data.forEach(element => {
                    var option = " <option value='" +
                        element["city_c"] +
                        "'>" +
                        element["city_m"] +
                        "</option>";
                    $("#permanent_city_c").append(option);
                });
            }
        });
    });

    $("#permanent_city_c").on("change", function() {

        var city_c = $(this).val();

        $.ajax({
            type: "GET",
            url: "/get_barangay/" + city_c,
            fail: function() {
                alert("request failed");
            },
            success: function(data) {
                var data = JSON.parse(data);

                $("#permanent_barangay_c").empty();

                var option1 = " <option value='' disabled selected>Select Option</option>";
                $("#permanent_barangay_c").append(option1);

                data.forEach(element => {
                    var option = " <option value='" +
                        element["barangay_c"] +
                        "'>" +
                        element["barangay_m"] +
                        "</option>";
                    $("#permanent_barangay_c").append(option);
                });
            }
        });
    });
</script>

@endsection