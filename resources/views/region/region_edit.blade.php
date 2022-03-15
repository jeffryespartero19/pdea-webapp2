@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Region</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="removeCokie();">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('region_list') }}">Region List</a></li>
                    <li class="breadcrumb-item active">Edit Region</li>
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
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Edit Region Information</h3>
        </div>
        <div class="card-body">
            <form action="/region_edit/{{ $region[0]->id }}" role="form" method="post">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <div>
                        <label for="">Code</label>
                    </div>
                    <div class="input-group mb-3">
                        <input id="region_c" name="region_c" type="text" class="form-control @error('code') is-invalid @enderror" value="{{ old('region_c') ?? $region[0]->region_c }}" placeholder="Region Name" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label for="">Name</label>
                    </div>
                    <div class="input-group mb-3">
                        <input id="region_m" name="region_m" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('region_m') ?? $region[0]->region_m }}" placeholder="Region Description" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label for="">Abbreviation</label>
                    </div>
                    <div class="input-group mb-3">
                        <input id="abbreviation" name="abbreviation" type="text" class="form-control @error('abbreviation') is-invalid @enderror" value="{{ old('abbreviation') ?? $region[0]->abbreviation }}" placeholder="Abbreviation" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label for="">Control Number</label>
                    </div>
                    <div class="input-group mb-3">
                        <input id="region_sort" name="region_sort" type="text" class="form-control @error('control number') is-invalid @enderror" value="{{ old('region_sort') ?? $region[0]->region_sort }}" placeholder="Control Number" autocomplete="off">
                    </div>
                </div>
                <div class="custom-control custom-checkbox mb-2">
                    <input name="status" class="custom-control-input" type="checkbox" id="customCheckbox9" {{ $region[0]->status == true ? 'checked' : '' }}>
                    <label for="customCheckbox9" class="custom-control-label">Set as Active</label>
                </div>
                <div class="form-group mt-5">
                    <button type="submit" class="btn btn-primary">Update Region</button>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <h6>Update Region maintenance data.</h6>
        </div>
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

<!-- Set menu to collapse and active -->
@endsection