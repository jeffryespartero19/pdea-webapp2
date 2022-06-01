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
    <!-- Default box -->
    <div class="card card-success">
        <div class="card-body">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">High Impact Operation</h3>
                </div>
                <div class="card table-responsive" style="padding: 20px;">
                    <table id="example1" class="table table-bordered table-striped table-hover" style="width: max-content;">
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
                                <th>Suspect Classification</th>
                                <th>Suspect Category</th>
                                <th>Listed</th>
                                <th>NDIS</th>
                                <th>Remarks</th>
                                <th>Status</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data1 as $dt)
                            <tr class="suspect_info">
                                <td hidden><input type="text" class="suspect_id" value="{{ $dt->id }}"></td>
                                <td style="width: 150px;">{{$dt->preops_number}}</td>
                                <td style="width: 150px;">{{$dt->spot_report_number}}</td>
                                <td style="width: 150px;">{{$dt->region_m}}</td>
                                <td style="width: 150px;">{{$dt->province_m}}</td>
                                <td style="width: 150px;">{{$dt->operation_type}}</td>
                                <td style="width: 150px;">{{$dt->operating_unit}}</td>
                                <td style="width: 150px;">{{$dt->operation_datetime}}</td>
                                <td class="s_name" style="width: 150px;">{{$dt->lastname}}, {{$dt->firstname}} {{$dt->middlename}}</td>
                                <td style="width: 150px;">{{$dt->suspect_classification}}</td>
                                <td style="width: 150px;">{{$dt->suspect_category}}</td>
                                <td>@if($dt->listed == 1)
                                    Yes
                                    @else
                                    No
                                    @endif</td>
                                <td style="width: 150px;">{{$dt->ndis_id}}</td>
                                <td style="width: 150px;">{{$dt->remarks}}</td>
                                <td style="width: 150px;">{{$dt->status}}</td>
                                <td style="width: 150px;">
                                    <center>
                                        <a href="#" class="btn btn-info btnEdit" data-toggle="modal" data-target="#modal-lg">Edit</a>
                                    </center>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
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
            <form action="/drug_verification_add" role="form" method="post">
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
                            <label for="">Listed</label>
                        </div>
                        <div class="input-group mb-3">
                            <select id="listed" name="listed" class="form-control" required>
                                <option value='' disabled selected>Select Option</option>
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
                        $("#dv_id").val(element['id']);
                        $("#suspect_id").val(suspect_id);
                        $("#name").val(s_name);
                        $("#ndis_id").val(element['ndis_id']);
                        $("#remarks").text(element['remarks']);
                        $('#listed option[value=' + element['listed'] + ']').attr('selected', 'selected');
                    });
                } else {
                    $("#suspect_id").val(suspect_id);
                    $("#name").val(s_name);
                }
            }
        });
    });


    $('#modal-lg').on('hidden.bs.modal', function() {
        $(this).find("input,textarea,select").val('').end();

    });
</script>

@endsection