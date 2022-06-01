@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Regional Office</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="removeCokie();">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('regional_office_list') }}">Regional Office List</a></li>
                    <li class="breadcrumb-item active">Edit Regional Office</li>
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
            <h3 class="card-title">Edit Regional Office Information</h3>
        </div>
        <div class="card-body">
            <form action="/regional_office_edit/{{ $regional_office[0]->id }}" role="form" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <div>
                        <label for="">Region</label>
                    </div>
                    <div class="input-group mb-3">
                        <select name="region_c" class="form-control region_c">
                            <option value='' disabled selected>Select Option
                            </option>
                            @foreach ($region as $rg)
                            <option value="{{ $rg->region_c }}" {{ $rg->region_c == $regional_office[0]->region_c ? 'selected' : '' }}>
                                {{ $rg->abbreviation }} -
                                {{ $rg->region_m }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label for="">Name</label>
                    </div>
                    <div class="input-group mb-3">
                        <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') ?? $regional_office[0]->name }}" placeholder="Regional Office Name" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label for="">Code</label>
                    </div>
                    <div class="input-group mb-3">
                        <input id="ro_code" name="ro_code" type="text" class="form-control @error('code') is-invalid @enderror" value="{{ old('ro_code') ?? $regional_office[0]->ro_code }}" placeholder="Regional Office Code" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label for="">Description</label>
                    </div>
                    <div class="input-group mb-3">
                        <input id="description" name="description" type="text" class="form-control @error('description') is-invalid @enderror" value="{{ old('description') ?? $regional_office[0]->description }}" placeholder="Description" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label for="">Report Output</label>
                    </div>
                    <div class="input-group mb-3">
                        <input id="report_output" name="report_output" type="text" class="form-control @error('report output') is-invalid @enderror" value="{{ old('report_output') ?? $regional_office[0]->report_output }}" placeholder="Report Output" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label for="">Report Header</label>
                    </div>
                    @if($regional_office[0]->report_header != null)
                    <div class="input-group mb-3">
                        <span style="margin-right: 20px;">{{$regional_office[0]->report_header}}</span><a href="{{ asset('/files/uploads/report_header/' . $regional_office[0]->report_header) }}">View </a>
                    </div>
                    @else
                    @endif

                    <div class="custom-file mb-3" style="width: 400px;">
                        <input type="file" name="fileattach[]" class="custom-file-input" id="fileattach" />
                        <label class="custom-file-label" for="customFile">Edit Report Header</label>
                    </div>
                </div>

                <div class="form-group">
                    <div>
                        <label for="">Address</label>
                    </div>
                    <div class="input-group mb-3">
                        <input id="address" name="address" type="text" class="form-control @error('report output') is-invalid @enderror" value="{{ old('address') ?? $regional_office[0]->address }}" placeholder="Address" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label for="">Contact Number</label>
                    </div>
                    <div class="input-group mb-3">
                        <input id="contact_number" name="contact_number" type="text" class="form-control @error('report output') is-invalid @enderror" value="{{ old('contact_number') ?? $regional_office[0]->contact_number }}" placeholder="Contact Number" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label for="">Print Order</label>
                    </div>
                    <div class="input-group mb-3">
                        <input id="print_order" name="print_order" type="number" class="form-control @error('print order') is-invalid @enderror" value="{{ old('print_order') ?? $regional_office[0]->print_order }}" placeholder="Print Order" autocomplete="off">
                    </div>
                </div>
                <div class="custom-control custom-checkbox mb-2">
                    <input name="status" class="custom-control-input" type="checkbox" id="customCheckbox9" {{ $regional_office[0]->status == true ? 'checked' : ''}}>
                    <label for="customCheckbox9" class="custom-control-label">Set as Active</label>
                </div>
                <div class="form-group mt-5">
                    <button type="submit" class="btn btn-primary">Update Regional Office</button>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <h6>Create Regional Office maintenance data.</h6>
        </div>
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

<!-- Set menu to collapse and active -->
@endsection