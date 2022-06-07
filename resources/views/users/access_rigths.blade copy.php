@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Access Rights</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="removeCokie();">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('list') }}">User List</a></li>
                    <li class="breadcrumb-item active">Access Rights</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
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
            <h3 class="card-title">User Access Rights Informations</h3>
        </div>
        <div class="card-body">
            <form action="{{ url('access_rights/'.$info[0]->id) }}" role="form" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-12 d-flex align-items-stretch flex-column">
                            <div class="card bg-light d-flex flex-fill">
                                <div class="row">
                                    <div class="pl-4 mt-3">
                                        <img src="data:image/jpeg;base64,{{ $info[0]->photo }}" onerror=this.src="../../dist/img/profile.png" alt="user-avatar" class="img-circle img-fluid" width="60px" height="60px">
                                    </div>
                                    <div class="col-8 mt-3">
                                        <h1 class="lead" style="color: #00b686;"><b>{{ $info[0]->name }}<b></h1>
                                        <p class="text-muted text-sm">{{ $info[0]->email }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="pl-3 mt-3">
                                    <label for="employee_no">Employee No.</label>
                                    <input id="employee_no" name="employee_no" type="text" value="{{ $info[0]->employee_no }}" class="form-control p-2 col-6 mb-2">
                                    <div class="custom-control custom-checkbox mb-4" {{ Auth::user()->is_admin == true ? '' : 'hidden'}}>
                                        @if($info[0]->is_admin == true)
                                        <input name="is_admin" class="custom-control-input" type="checkbox" checked id="customCheckbox1">
                                        @else
                                        <input name="is_admin" class="custom-control-input" type="checkbox" id="customCheckbox1" hidden>
                                        @endif
                                        <label for="customCheckbox1" class="custom-control-label">Assign as Administrator</label>
                                    </div>
                                    <div class="custom-control custom-checkbox mb-4" {{ Auth::user()->is_admin == true ? '' : 'hidden' }}>
                                        @if($info[0]->locked == true)
                                        <input name="locked" class="custom-control-input" type="checkbox" checked id="customCheckbox2">
                                        @else
                                        <input name="locked" class="custom-control-input" type="checkbox" id="customCheckbox2">
                                        @endif
                                        <label for="customCheckbox2" class="custom-control-label">Lock Account</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-info card-outline card-outline-tabs">
                                <div class="card-header p-0 border-bottom-0">
                                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                        <!-- <li class="nav-item">
                                            <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Geo Mapping</a>
                                        </li> -->
                                        <li class="nav-item">
                                            <a class="nav-link active" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">COC</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Spot & Progress</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill" href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="false">Control Panel</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-four-om-tab" data-toggle="pill" href="#custom-tabs-four-om" role="tab" aria-controls="custom-tabs-four-om" aria-selected="false">Other Modules</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-four-tabContent">
                                        <div class="tab-pane fade show active" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                                            <div class="custom-control custom-checkbox mb-2">
                                                @if($info[0]->with_coc_access == true)
                                                <input name="with_coc_access" class="custom-control-input" type="checkbox" checked id="customCheckbox4">
                                                @else
                                                <input name="with_coc_access" class="custom-control-input" type="checkbox" id="customCheckbox4">
                                                @endif
                                                <label for="customCheckbox4" class="custom-control-label">Give access to COC</label>
                                            </div>
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">Menu Table</h3>
                                                </div>
                                                <!-- /.card-header -->
                                                <div class="card-body table-responsive p-0" style="height: 300px;">
                                                    <table id="hrt_table" class="table table-head-fixed text-nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th width="15px">Select</th>
                                                                <th>Menu</th>
                                                                <th>Description</th>
                                                                <th hidden>ID</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($hrt_menu as $hrt)
                                                            <tr>
                                                                <td>
                                                                    @if($hrt->status == true)
                                                                    <center><input name="status[]" type="checkbox" value="{{ $hrt->id }}" checked></center>
                                                                    @else
                                                                    <center><input name="status[]" type="checkbox" value="{{ $hrt->id }}"></center>
                                                                    @endif
                                                                </td>
                                                                <td name="menu">{{ $hrt->menu }}</td>
                                                                <td name="description">{{ $hrt->description }}</td>
                                                                <td hidden><input name="menu_id[]" type="text" value="{{ $hrt->id }}"></td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
                                            <div class="custom-control custom-checkbox mb-2">
                                                @if($info[0]->with_sap_access == true)
                                                <input name="with_sap_access" class="custom-control-input" type="checkbox" checked id="customCheckbox5">
                                                @else
                                                <input name="with_sap_access" class="custom-control-input" type="checkbox" id="customCheckbox5">
                                                @endif
                                                <label for="customCheckbox5" class="custom-control-label">Give access to Spot and Progress</label>
                                            </div>
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">Menu Table</h3>
                                                </div>
                                                <!-- /.card-header -->
                                                <div class="card-body table-responsive p-0" style="height: 300px;">
                                                    <table id="hrp_table" class="table table-head-fixed text-nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th width="15px">Select</th>
                                                                <th>Menu</th>
                                                                <th>Description</th>
                                                                <th hidden>ID</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($hrp_menu as $hrp)
                                                            <tr>
                                                                <td>
                                                                    @if($hrp->status == true)
                                                                    <center><input name="status[]" type="checkbox" value="{{ $hrp->id }}" checked></center>
                                                                    @else
                                                                    <center><input name="status[]" type="checkbox" value="{{ $hrp->id }}"></center>
                                                                    @endif
                                                                </td>
                                                                <td name="menu">{{ $hrp->menu }}</td>
                                                                <td name="description">{{ $hrp->description }}</td>
                                                                <td hidden><input name="menu_id[]" type="text" value="{{ $hrp->id }}"></td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel" aria-labelledby="custom-tabs-four-settings-tab">
                                            <div class="custom-control custom-checkbox mb-2">
                                                @if($info[0]->with_settings_access == true)
                                                <input name="with_settings_access" class="custom-control-input" type="checkbox" checked id="customCheckbox6">
                                                @else
                                                <input name="with_settings_access" class="custom-control-input" type="checkbox" id="customCheckbox6">
                                                @endif
                                                <label for="customCheckbox6" class="custom-control-label">Give access to Control Panel</label>
                                            </div>
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">Menu Table</h3>
                                                </div>
                                                <!-- /.card-header -->
                                                <div class="card-body table-responsive p-0" style="height: 300px;">
                                                    <table id="cpm_table" class="table table-head-fixed text-nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th width="15px">Select</th>
                                                                <th>Menu</th>
                                                                <th>Description</th>
                                                                <th hidden>ID</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($cpm_menu as $cpm)
                                                            <tr>
                                                                <td>
                                                                    @if($cpm->status == true)
                                                                    <center><input name="status[]" type="checkbox" value="{{ $cpm->id }}" checked></center>
                                                                    @else
                                                                    <center><input name="status[]" type="checkbox" value="{{ $cpm->id }}"></center>
                                                                    @endif
                                                                </td>
                                                                <td name="menu">{{ $cpm->menu }}</td>
                                                                <td name="description">{{ $cpm->description }}</td>
                                                                <td hidden><input name="menu_id[]" type="text" value="{{ $cpm->id }}"></td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="custom-tabs-four-om" role="tabpanel" aria-labelledby="custom-tabs-four-om-tab-tab">
                                            <div class="custom-control custom-checkbox mb-2">
                                                @if($info[0]->with_geomapping_access == true)
                                                <input name="with_geomapping_access" class="custom-control-input" type="checkbox" checked id="customCheckbox9">
                                                @else
                                                <input name="with_geomapping_access" class="custom-control-input" type="checkbox" id="customCheckbox9">
                                                @endif
                                                <label for="customCheckbox9" class="custom-control-label">Give access to Geomapping</label>
                                            </div>
                                            <div class="custom-control custom-checkbox mb-2">
                                                @if($info[0]->with_file_upload_access == true)
                                                <input name="with_file_upload_access" class="custom-control-input" type="checkbox" checked id="customCheckbox10">
                                                @else
                                                <input name="with_file_upload_access" class="custom-control-input" type="checkbox" id="customCheckbox10">
                                                @endif
                                                <label for="customCheckbox10" class="custom-control-label">Give access to File Uploads</label>
                                            </div>
                                            <div class="custom-control custom-checkbox mb-2">
                                                @if($info[0]->with_drug_management_access == true)
                                                <input name="with_drug_management_access" class="custom-control-input" type="checkbox" checked id="customCheckbox11">
                                                @else
                                                <input name="with_drug_management_access" class="custom-control-input" type="checkbox" id="customCheckbox11">
                                                @endif
                                                <label for="customCheckbox11" class="custom-control-label">Give access to Drug Management</label>
                                            </div>
                                            <div class="custom-control custom-checkbox mb-2">
                                                @if($info[0]->with_drug_verification_access == true)
                                                <input name="with_drug_verification_access" class="custom-control-input" type="checkbox" checked id="customCheckbox12">
                                                @else
                                                <input name="with_drug_verification_access" class="custom-control-input" type="checkbox" id="customCheckbox12">
                                                @endif
                                                <label for="customCheckbox12" class="custom-control-label">Give access to Drug Verification</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-info">Save Access Rights</button>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <h6>Update user system access informations.</h6>
        </div>
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

<!-- Set menu to collapse and active -->
@endsection