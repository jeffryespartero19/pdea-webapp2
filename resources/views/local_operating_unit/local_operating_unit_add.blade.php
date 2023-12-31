@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add Local Operating Unit</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="removeCokie();">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('local_operating_unit_list') }}">Local Operating Unit List</a></li>
                    <li class="breadcrumb-item active">Add Local Operating Unit</li>
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
            <h3 class="card-title">Add Local Operating Unit Information</h3>
        </div>
        <div class="card-body">
            <form action="/local_operating_unit_add" role="form" method="post">
                @csrf
                <div class="form-group">
                    <div>
                        <label for="">Name</label>
                    </div>
                    <div class="input-group mb-3">
                        <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Local Operating Unit Name" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label for="">Unit</label>
                    </div>
                    <div class="input-group mb-3">
                        <select id="operating_unit_id" name="operating_unit_id" class="form-control @error('unit') is-invalid @enderror">
                            <option value='' disabled selected>Select Option</option>
                            @foreach($operating_unit as $ou)
                            <option value="{{ $ou->id }}">{{ $ou->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
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
                <div class="form-group">
                    <div>
                        <label for="">Province</label>
                    </div>
                    <div class="input-group mb-3">
                        <select id="province_c" name="province_c" class="form-control @error('province') is-invalid @enderror">
                            <option value='' disabled selected>Select Option</option>

                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label for="">City/Municipality</label>
                    </div>
                    <div class="input-group mb-3">
                        <select id="city_c" name="city_c" class="form-control @error('city') is-invalid @enderror">
                            <option value='' disabled selected>Select Option</option>

                        </select>
                    </div>
                </div>
                <div class="custom-control custom-checkbox mb-2">
                    <input name="status" class="custom-control-input" type="checkbox" id="customCheckbox9">
                    <label for="customCheckbox9" class="custom-control-label">Set as Active</label>
                </div>
                <div class="form-group mt-5">
                    <button type="submit" class="btn btn-primary">Save Local Operating Unit</button>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <h6>Create Local Operating Unit maintenance data.</h6>
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
                $("#province_c").append("<option value='' disabled selected>Select Option</option>");
                $("#city_c").append("<option value='' disabled selected>Select Option</option>");

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
                $("#city_c").append("<option value='' disabled selected>Select Option</option>");

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
</script>

@endsection