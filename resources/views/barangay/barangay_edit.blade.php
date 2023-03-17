@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Baranggay</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="removeCokie();">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('barangay_list') }}">Baranggay List</a></li>
                    <li class="breadcrumb-item active">Edit Baranggay</li>
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
            <h3 class="card-title">Edit Baranggay Information</h3>
        </div>
        <div class="card-body">
            <form action="/barangay_edit/{{ $barangay[0]->id }}" role="form" method="post">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <div>
                        <label for="">Region</label>
                    </div>
                    <div class="input-group mb-3">
                        <select id="region_c" name="region_c" class="form-control @error('region') is-invalid @enderror " required>
                            <option value='' disabled selected>Select Option</option>
                            @foreach ($region as $rg)
                            <option value="{{ $rg->region_c }}" {{ $rg->region_c == $barangay[0]->region_c ? 'selected' : '' }}>{{ $rg->region_m }} -
                                {{ $rg->region_m }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label for="">Province</label>
                    </div>
                    <div class="input-group mb-3">
                        <select id="province_c" name="province_c" class="form-control" required>
                           
                            <option value="{{ $barangay[0]->province_c }}" selected>{{ $barangay[0]->province_m }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label for="">City</label>
                    </div>
                    <div class="input-group mb-3">
                        <select id="city_c" name="city_c" class="form-control @error('city') is-invalid @enderror" required>
                            <option value="{{ $barangay[0]->city_c }}" selected>{{ $barangay[0]->city_m }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label for="">Code</label>
                    </div>
                    <div class="input-group mb-3">
                        <input id="barangay_c" name="barangay_c" type="text" class="form-control @error('code') is-invalid @enderror" value="{{ old('barangay_c') ?? $barangay[0]->barangay_c }}" placeholder="Baranggay Name" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label for="">Name</label>
                    </div>
                    <div class="input-group mb-3">
                        <input id="barangay_m" name="barangay_m" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('barangay_m') ?? $barangay[0]->barangay_m }}" placeholder="Baranggay Description" autocomplete="off">
                    </div>
                </div>
                <div class="custom-control custom-checkbox mb-2">
                    <input name="status" class="custom-control-input" type="checkbox" id="customCheckbox9" {{ $barangay[0]->status == true ? 'checked' : '' }}>
                    <label for="customCheckbox9" class="custom-control-label">Set as Active</label>
                </div>
                <div class="form-group mt-5">
                    <button type="submit" class="btn btn-primary">Update Baranggay</button>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <h6>Update Baranggay maintenance data.</h6>
        </div>
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

<!-- Set menu to collapse and active -->
@endsection


@section('scripts')
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

                    var option1 = " <option value='' selected disabled>Select Option</option>";
                    $("#province_c").append(option1);
                    $("#city_c").append(option1);

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

                    var option1 = " <option value='' selected disabled>Select Option</option>";
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

    });
</script>
@endsection