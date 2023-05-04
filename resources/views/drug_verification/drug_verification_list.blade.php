@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Drug Verification List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="removeCokie();">Home</a></li>
                    <li class="breadcrumb-item active">Drug Verification List</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
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
            <h3 class="card-title">High Impact Operation</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="input-group col-md-4">
                    <input type="text" class="form-control SearchData" name="q" placeholder="Search Preops/Spot Report Number"> <span class="input-group-btn">
                        <button type="button" class="btn btn-default submit_search">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </div>

            <br>
            <div class="table-responsive" style="padding: 20px;">
                <table id="example_info" class="table table-bordered table-striped table-hover" style="width: max-content;">
                    <thead>
                        <tr>
                            <th hidden>Suspect ID</th>
                            <th>Pre-Ops #</th>
                            <th>Spot Report #</th>
                            <th>Region</th>
                            <th>Area Of Operation</th>
                            <th>OPN Type</th>
                            <th>OPN Unit</th>
                            <th>Date of OPN</th>
                            <th>Suspect</th>
                            <th>Identifier</th>
                            <th>Suspect Classification</th>
                            <th>Suspect Category</th>
                            <th>Suspect Sub Category</th>
                            <th>Listed</th>
                            <th>NDIS</th>
                            <th>Remarks</th>
                            <th>Status</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @include('drug_verification.drug_verification_list_data')
                    </tbody>
                </table>
                <input type="hidden" name="hidden_page" id="hidden_page" value="1">
            </div>
        </div>
        <div class="card-footer">
            <h6>List of all Drug Verification maintenance data sorted by name.</h6>
        </div>
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

<!-- Modal -->
<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form id="EditForm" action="/drug_verification_add" role="form" method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title">Edit</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input hidden id="dv_id" name="dv_id" type="text" class="form-control" style="pointer-events: none;">
                    <input hidden id="suspect_id" name="suspect_id" type="text" class="form-control" style="pointer-events: none;">
                    <div class="form-group" style="margin: 0px;">
                        <div>
                            <label for="">Name</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="name" name="name" type="text" class="form-control" style="pointer-events: none;">
                        </div>
                    </div>
                    <div class="form-group" style="margin: 0px;">
                        <div>
                            <label for="">Suspect Classification</label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="suspect_classification_id" name="suspect_classification_id" class="form-control suspect_classification_id" style="width: 200px;" disabled>
                                <option value='0' selected>Select Option
                                </option>
                                @foreach ($suspect_classification as $scl)
                                <option value="{{ $scl->id }}">
                                    {{ $scl->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="form-group" style="margin: 0px;">
                        <div>
                            <label for="">Suspect Category</label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="suspect_category_id" name="suspect_category_id" class="form-control suspect_category_id" style="width: 200px;" disabled>
                                <option value='0' selected>Select Option
                                </option>
                                @foreach ($suspect_category as $sc)
                                <option value="{{ $sc->id }}">
                                    {{ $sc->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="form-group" style="margin: 0px;">
                        <div>
                            <label for="">Suspect Sub-category</label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="suspect_sub_category_id" name="suspect_sub_category_id" class="form-control" style="width: 200px;" disabled>
                                <option value='0' selected>Select Option
                                </option>
                                @foreach ($suspect_sub_category as $ssc)
                                <option value="{{ $ssc->id }}">
                                    {{ $ssc->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="form-group" style="margin: 0px;">
                        <div>
                            <label for="">Identifier</label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="identifier_id" name="identifier_id" class="form-control identifier_id" style="width: 200px;" disabled>
                                <option value='0' selected>Select Option
                                </option>
                                @foreach ($identifier as $idn)
                                <option value="{{ $idn->id }}">
                                    {{ $idn->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="form-group" style="margin: 0px;">
                        <div>
                            <label for="">Listed</label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="listed" name="listed" class="form-control" required>
                                <option value='0' selected>Select Option</option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </div>

                    </div>
                    <div class="form-group" style="margin: 0px;">
                        <div>
                            <label for="">NDIS ID</label>
                        </div>
                        <div class="input-group mb-3">
                            <input id="ndis_id" name="ndis_id" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group" style="margin: 0px;">
                        <div>
                            <label for="">Remarks</label>
                        </div>
                        <div class="input-group mb-3">
                            <textarea name="remarks" id="remarks" class="form-control" rows="5"></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Set menu to collapse and active -->
@endsection

@section('scripts')
<script>
    $('#modal-lg').on('hidden.bs.modal', function() {
        $(this).find('form').trigger('reset');
    });
    
    $(".btnEdit").on("click", function() {

        var suspect_id = $(this).closest(".suspect_info").find('.suspect_id').val();
        var s_name = $(this).closest(".suspect_info").find('.s_name').text();

        $.ajax({
            type: "GET",
            url: "/get_drug_management/" + suspect_id,
            fail: function() {
                alert("request failed");
            },
            success: function(data) {
                var data = JSON.parse(data);

                if (data.length != 0) {
                    data.forEach(element => {
                        // alert('meron');
                        $("#dv_id").val(element['id']);
                        $("#suspect_id").val(suspect_id);
                        $("#name").val(s_name);
                        $("#ndis_id").val(element['ndis_id']);
                        $("#remarks").text(element['remarks']);
                        if (element['suspect_classification_id'] == null || element['suspect_classification_id'] == 0) {
                            $('#suspect_classification_id').val(0);
                        } else {
                            $('#suspect_classification_id').val(element['suspect_classification_id']);
                        }
                        if (element['suspect_category_id'] == null || element['suspect_category_id'] == 0) {
                            $('#suspect_category_id').val(0);
                        } else {
                            $('#suspect_category_id').val(element['suspect_category_id']);
                        }
                        if (element['suspect_sub_category_id'] == null || element['suspect_sub_category_id'] == 0) {
                            $('#suspect_sub_category_id').val(0);
                        } else {
                            $('#suspect_sub_category_id').val(element['suspect_sub_category_id']);
                        }
                        if (element['listed'] == null || element['listed'] == 0) {
                            $('#listed').val(0);
                        } else {
                            $('#listed').val(element['listed']);
                        }
                        if (element['identifier_id'] == null || element['identifier_id'] == 0) {
                            $('#identifier_id').val(0);
                        } else {
                            $('#identifier_id').val(element['identifier_id']);
                        }
                        // $('#suspect_classification_id option[value=' + element['suspect_classification_id'] + ']').attr('selected', 'selected');
                        // $('#suspect_category_id option[value=' + element['suspect_category_id'] + ']').attr('selected', 'selected');
                        // $('#suspect_sub_category_id option[value=' + element['suspect_sub_category_id'] + ']').attr('selected', 'selected');
                        // $('#listed option[value=' + element['listed'] + ']').attr('selected', 'selected');
                        // $('#identifier_id option[value=' + element['identifier_id'] + ']').attr('selected', 'selected');
                    });
                } else {
                    // alert('wala');
                    $("#suspect_id").val(suspect_id);
                    $("#name").val(s_name);
                }
            }
        });
    });




    //Populate Suspect Category
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
                $('#suspect_sub_category_id').empty();
                var option1 =
                    " <option value='' selected>Select Option</option>";
                $('#suspect_sub_category_id').append(option1);

                data.forEach(element => {
                    var option = " <option value='" +
                        element["id"] +
                        "'>" +
                        element["name"] +
                        "</option>";
                    $('#suspect_sub_category_id').append(option);
                });
            }
        });
    });

    $(".submit_search").on("click", function() {
        DataFilter();
    });

    $(document).on('click', ".pagination a", function(event) {
        event.preventDefault();

        var page = $(this).attr('href').split('page=')[1];
        $('#hidden_page').val(page);
        DataFilter();
    });

    function DataFilter() {
        var param = $('.SearchData').val();
        var page = $('#hidden_page').val();
        $.ajax({
            url: "/drug_verification_list/search_drug_verification_list?page=" + page + "&param=" + param,
            success: function(data) {
                $('tbody').html('');
                $('tbody').html(data);
            }
        });

    }
</script>

@endsection