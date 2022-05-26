@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add Operation Type</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="removeCokie();">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('operation_type_list') }}">Operation Type List</a></li>
                    <li class="breadcrumb-item active">Add Operation Type</li>
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
            <h3 class="card-title">Add Operation Type Information</h3>
        </div>
        <div class="card-body">
            <form action="/operation_type_add" role="form" method="post">
                @csrf
                <div class="form-group">
                    <div>
                        <label for="">Operation Classification</label>
                    </div>
                    <div class="input-group mb-3">
                        <select id="operation_classification_id" name="operation_classification_id" class="form-control" style="width: 200px;" required>
                            <option value='' disabled selected>Select Option</option>
                            @foreach($operation_classification as $oc)
                            <option value="{{ $oc->id }}">{{ $oc->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label for="">Operation Category</label>
                    </div>
                    <div class="input-group mb-3">
                        <select id="operation_category_id" name="operation_category_id" class="form-control" style="width: 200px;" required>
                            <option value='' disabled selected>Select Option</option>

                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label for="">Name</label>
                    </div>
                    <div class="input-group mb-3">
                        <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Operation Type Name" autocomplete="off" required>
                    </div>
                </div>
                <div class="custom-control custom-checkbox mb-2">
                    <input name="is_warrant" class="custom-control-input" type="checkbox" id="customCheckbox1">
                    <label for="customCheckbox1" class="custom-control-label">Is Warrant</label>
                </div>
                <div class="custom-control custom-checkbox mb-2">
                    <input name="is_testbuy" class="custom-control-input" type="checkbox" id="customCheckbox2">
                    <label for="customCheckbox2" class="custom-control-label">Is Test-Buy</label>
                </div>
                <div class="custom-control custom-checkbox mb-2">
                    <input name="show_preops" class="custom-control-input" type="checkbox" id="show_preops">
                    <label for="show_preops" class="custom-control-label">Show in Pre-ops</label>
                </div>
                <div class="custom-control custom-checkbox mb-2">
                    <input name="show_spot_report" class="custom-control-input" type="checkbox" id="show_spot_report">
                    <label for="show_spot_report" class="custom-control-label">Show in Spot Report</label>
                </div>
                <div class="custom-control custom-checkbox mb-2">
                    <input name="status" class="custom-control-input" type="checkbox" id="customCheckbox9">
                    <label for="customCheckbox9" class="custom-control-label">Set as Active</label>
                </div>
                <div class="form-group mt-5">
                    <button type="submit" class="btn btn-primary">Save Operation Type</button>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <h6>Create Operation Type maintenance data.</h6>
        </div>
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

<!-- Set menu to collapse and active -->
@endsection


@section('scripts')

<script>
    $(document).on("change", "#operation_classification_id", function() {

   

        $operation_classification_id = $('#operation_classification_id').val();

        $.ajax({
            type: "GET",
            url: "/get_operation_category/" + $operation_classification_id,
            fail: function() {
                alert("request failed");
            },
            success: function(data) {
                var data = JSON.parse(data);

                $("#operation_category_id").empty();
                var option1 = " <option value='' disabled selected>Select Option</option>";
                $("#operation_category_id").append(option1);

                data.forEach(element => {
                    var option = " <option value='" +
                        element["id"] +
                        "'>" +
                        element["name"] +
                        "</option>";
                    $("#operation_category_id").append(option);
                });

            }
        });
    });
</script>

@endsection