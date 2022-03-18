@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Users List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="removeCokie();">Home</a></li>
                    <li class="breadcrumb-item active">Users List</li>
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

        <div class="card-body">
            <button type="button" style="float: right; width:150px" class="btn btn-info" data-toggle="modal" data-target="#modal-lg">
                Add User
            </button>
            <br>
            <br>
            <div class="card-body pb-0">

                <div class="row">
                    @foreach ($users as $user)
                    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                        <div class="card bg-light d-flex flex-fill">
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-2 mt-3">
                                        <img src="data:image/jpeg;base64,{{ $user->photo }}" onerror=this.src="../../dist/img/profile.png" alt="user-avatar" class="img-circle img-fluid" width="60px" height="60px">
                                    </div>
                                    <div class="col-8 mt-3">
                                        <h2 class="lead" style="color: #00b686;"><b>{{ $user->name }}</b></h2>
                                        <p class="text-muted text-sm"><b>Email: </b> {{ $user->email }} </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right user_details">
                                    <input type="text" class="user_id" value="{{$user->id}}" hidden>
                                    <button class="btn btn-sm btn-info btnEdit" data-toggle="modal" data-target="#modal-lg">
                                        <i class="fas fa-cog pr-2"></i> Edit
                                    </button>
                                    <a href="{{ url('access_rights/'.$user->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-lock pr-2"></i> Access Rights
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card-footer">
            <h6>List of all system users sorted by Name.</h6>
        </div>
    </div>
    <!-- /.card -->

    <!-- Modal -->
    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="/list_add" role="form" method="post">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Add User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" hidden>
                            <label>ID</label>
                            <input type="text" class="form-control" id="user_id" name="user_id">
                        </div>
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Full Name" required autocomplete="none">
                        </div>
                        <div class="form-group">
                            <label>User Level</label>
                            <select id="user_level_id" name="user_level_id" class="form-control" required autocomplete="none">
                                <option value='' disabled selected>Select Option</option>
                                @foreach($user_level as $ul)
                                <option value="{{ $ul->id }}">{{ $ul->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Email" required autocomplete="none">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" class="form-control" id="password" name="password" placeholder="Password" autocomplete="none">
                        </div>
                        <div class="form-group">
                            <label>Position</label>
                            <select id="position_id" name="position_id" class="form-control" required autocomplete="none">
                                <option value='' disabled selected>Select Option</option>
                                @foreach($position as $ps)
                                <option value="{{ $ps->id }}">{{ $ps->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Regional Office</label>
                            <select id="regional_office_id" name="regional_office_id" class="form-control" required autocomplete="none">
                                <option value='' disabled selected>Select Option</option>
                                @foreach($regional_office as $ro)
                                <option value="{{ $ro->id }}">{{ $ro->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="active" name="active" checked>
                            <label for="active" class="custom-control-label">Active</label>
                        </div>
                        <!-- <div class="form-group">
                        <label>Region Head</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    </div> -->
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

</section>
<!-- /.content -->

<!-- Set menu to collapse and active -->
@endsection

@section('scripts')
<script>
    $(".btnEdit").on("click", function() {

        var user_id = $(this).closest(".user_details").find('.user_id').val();

        $.ajax({
            type: "GET",
            url: "/get_user/" + user_id,
            fail: function() {
                alert("request failed");
            },
            success: function(data) {
                var data = JSON.parse(data);

                data.forEach(element => {

                    $user_level_id = element["user_level_id"];
                    $position_id = element["position_id"];
                    $regional_office_id = element["regional_office_id"];
                    $active = element["active"];

                    $("#user_id").val(element["id"]);
                    $("#name").val(element["name"]);
                    $("#email").val(element["email"]);
                    $('#user_level_id option[value=' + $user_level_id + ']').attr('selected', 'selected');
                    $('#position_id option[value=' + $position_id + ']').attr('selected', 'selected');
                    $('#regional_office_id option[value=' + $regional_office_id + ']').attr('selected', 'selected');
                    $("#user_level_id").val(element["user_level_id"]);
                    $("#position_id").val(element["position_id"]);
                    $("#regional_office_id").val(element["regional_office_id"]);

                    if ($active == 1) {
                        $("#active").attr('checked', true);
                    } else {
                        $("#active").attr('checked', false);
                    }
                });
            }
        });
    });

    $('#modal-lg').on('hidden.bs.modal', function() {
        $(this).find('form').trigger('reset');
    });
</script>

@endsection