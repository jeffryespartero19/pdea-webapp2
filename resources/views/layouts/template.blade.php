<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>EPORMIS</title>

    <link rel="shortcut icon" href="../../dist/img/pdea_logo.jpg" />

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <!-- Other styles -->
    <link rel="stylesheet" href="{{ asset('css/c_gl.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/fontawesome.min.css') }}">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->

    <script src="{{ asset('/js/chatX.js') }}" defer></script>

    <style>
        .hide {
            display: none;
        }
    </style>

</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav id="app" class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif
                @else
                <li class="nav-item">
                    <div class="image">
                        <img src="data:image/jpeg;base64,{{ Auth::user()->photo ?? '' }}" onerror=this.src="../../dist/img/profile.png" class="img-circle elevation-2 mt-1" width="30px" height="30px" alt="User Image">
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#" onclick="removeCokie();"><i class="fa fa-user pr-2"></i> My Account</a>
                        <hr class="p-0 m-0">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();removeCokie();"><i class="fas fa-sign-out-alt pr-2"></i>
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest

                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-success elevation-4" style="background-color: darkgreen;">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="brand-link" onclick="removeCokie();">
                <img src="../../dist/img/pdea_logo.jpg" onerror=this.src="../../dist/img/pdea_logo.jpg" alt="Logo" class="brand-image img-circle elevation-6" style="opacity: .8">
                <span class="brand-text font-weight-light">EPORMIS</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                        <li id="geo" class="nav-item" {{ Auth::user()->with_geomapping_access ? '' : 'hidden' }}>
                            <a href="{{ route('geo_mapping') }}" class="nav-link" id="geo_link">
                                <i class="nav-icon fas fa-globe"></i>
                                <p>
                                    Geo Mapping
                                </p>
                            </a>
                        </li>
                        <li id="hrm" class="nav-item" hidden>
                            <a href="{{ route('geo_mapping2') }}" class="nav-link">
                                <i class="nav-icon fas fa-globe"></i>
                                <p>
                                    Geo Mapping2
                                </p>
                            </a>
                        </li>
                        <li id="coc" class="nav-item" {{ Auth::user()->with_coc_access ? '' : 'hidden' }}>
                            <a href="#" class="nav-link" id="coc_link">
                                <i class="nav-icon fas fa-clone"></i>
                                <p>
                                    COC
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @foreach($access_menu as $accessmenu)
                                @if(rtrim($accessmenu->menu_key) == "issuance_of_preops" && $accessmenu->status == true || Auth::user()->is_logged_in != 2)
                                <li class="nav-item">
                                    @break
                                    @else
                                <li class="nav-item" hidden>
                                    @endif
                                    @endforeach
                                    <a id="issuance_of_preops" href="{{ route('issuance_of_preops_list') }}" class="nav-link" onclick="setactive('hrp','issuance_of_preops')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Issuance of Pre-Ops</p>
                                    </a>
                                </li>
                                @foreach($access_menu as $accessmenu)
                                @if(rtrim($accessmenu->menu_key) == "after_operation_report" && $accessmenu->status == true)
                                <li class="nav-item">
                                    @break
                                    @else
                                <li class="nav-item" hidden>
                                    @endif
                                    @endforeach
                                    <a id="after_operation_report" href="{{ route('after_operation_report_list') }}" class="nav-link" onclick="setactive('hrp','after_operation_report')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>After Operation Report</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li id="sap" class="nav-item" {{ Auth::user()->with_sap_access ? '' : 'hidden' }}>
                            <a href="#" class="nav-link" id="sap_link">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>
                                    Spot & Progress Report
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @foreach($access_menu as $accessmenu)
                                @if(rtrim($accessmenu->menu_key) == "spot_report" && $accessmenu->status == true)
                                <li class="nav-item">
                                    @break
                                    @else
                                <li class="nav-item" hidden>
                                    @endif
                                    @endforeach
                                    <a id="spot_report" href="{{ route('spot_report_list') }}" class="nav-link" onclick="setactive('hrp','spot_report')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Spot Report</p>
                                    </a>
                                </li>
                                @foreach($access_menu as $accessmenu)
                                @if(rtrim($accessmenu->menu_key) == "progress_report" && $accessmenu->status == true)
                                <li class="nav-item">
                                    @break
                                    @else
                                <li class="nav-item" hidden>
                                    @endif
                                    @endforeach
                                    <a id="progress_report" href="{{ route('progress_report_list') }}" class="nav-link" onclick="setactive('hrp','progress_report')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Progress Report</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li id="drug_verification" class="nav-item" {{ Auth::user()->with_drug_verification_access ? '' : 'hidden' }}>
                            <a href="{{ route('drug_verification_list') }}" class="nav-link" id="dver_link">
                                <i class="nav-icon fas fa-check"></i>
                                <p>
                                    Drug Verification
                                </p>
                            </a>
                        </li>
                        <li id="drug_management" class="nav-item" {{ Auth::user()->with_drug_management_access ? '' : 'hidden' }}>
                            <a href="{{ route('drug_management_list') }}" class="nav-link" id="dman_link">
                                <i class="nav-icon fas fa-list"></i>
                                <p>
                                    Drug Management
                                </p>
                            </a>
                        </li>
                        <li id="file_uploads" class="nav-item" {{ Auth::user()->with_file_upload_access ? '' : 'hidden' }}>
                            <a href="#" class="nav-link" id="sap_link">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>
                                    File Uploads
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a id="preops_files" href="{{ route('preops_files_list') }}" class="nav-link" onclick="setactive('hrp','preops_files')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Preops</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a id="afteroperation_files" href="{{ route('afteroperation_files_list') }}" class="nav-link" onclick="setactive('hrp','afteroperation_files')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>After Operation</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a id="spotreport_files" href="{{ route('spotreport_files_list') }}" class="nav-link" onclick="setactive('hrp','spotreport_files')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Spot Report</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a id="progressreport_files" href="{{ route('progressreport_files_list') }}" class="nav-link" onclick="setactive('hrp','progressreport_files')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Progress Report</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li id="memo" class="nav-item">
                            <a href="{{ route('memo_list') }}" class="nav-link" id="memo_link">
                                <i class="nav-icon fas fa-list"></i>
                                <p>
                                    Memo
                                </p>
                            </a>
                        </li>
                        <li id="report_generation" class="nav-item">
                            <a href="{{ route('report_generation_list') }}" class="nav-link" id="report_generation_link">
                                <i class="nav-icon fas fa-list"></i>
                                <p>
                                    Report Generation
                                </p>
                            </a>
                        </li>
                        <li id="cpm" class="nav-item" {{ Auth::user()->with_settings_access ? '' : 'hidden' }}>
                            <a href="#" class="nav-link" id="cpm_link">
                                <i class="nav-icon fas fa-tools"></i>
                                <p>
                                    Control Panel
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            Operation Details
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "operation_category" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="operation_category_list_setup" href="{{ route('operation_category_list') }}" class="nav-link" onclick="setactive('cpm','operation_category_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Operation Category</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "operation_classification" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="operation_classification_list_setup" href="{{ route('operation_classification_list') }}" class="nav-link" onclick="setactive('cpm','operation_classification_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Operation Classification</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "operation_type" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="operation_type_list_setup" href="{{ route('operation_type_list') }}" class="nav-link" onclick="setactive('cpm','operation_type_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Operation Type</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "operating_unit" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="operating_unit_list_setup" href="{{ route('operating_unit_list') }}" class="nav-link" onclick="setactive('cpm','operating_unit_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Operating Unit Setup</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "officer_position" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="officer_position_list_setup" href="{{ route('officer_position_list') }}" class="nav-link" onclick="setactive('cpm','officer_position_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Officer Position</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "hio_type" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="hio_type_list_setup" href="{{ route('hio_type_list') }}" class="nav-link" onclick="setactive('cpm','hio_type_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>HIO Type</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            Other Information
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "approved_by" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="approved_by_list_setup" href="{{ route('approved_by_list') }}" class="nav-link" onclick="setactive('cpm','approved_by_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Approved By</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "case_list_setup" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="case_list_setup" href="{{ route('case_list') }}" class="nav-link" onclick="setactive('cpm','case_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Case List Setup</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "jail_facility" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="jail_facility_list_setup" href="{{ route('jail_facility_list') }}" class="nav-link" onclick="setactive('cpm','jail_facility_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Jail Facility Setup</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "laboratory_facility" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="laboratory_facility_list_setup" href="{{ route('laboratory_facility_list') }}" class="nav-link" onclick="setactive('cpm','laboratory_facility_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Laboratory Facility Setup</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "negative_reason" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="negative_reason_list_setup" href="{{ route('negative_reason_list') }}" class="nav-link" onclick="setactive('cpm','negative_reason_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Negative Reason Setup</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "position_setup" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="position_setup" href="{{ route('position_list') }}" class="nav-link" onclick="setactive('cpm','position_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Rank Position Setup</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "regional_office" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="regional_office_list_setup" href="{{ route('regional_office_list') }}" class="nav-link" onclick="setactive('cpm','regional_office_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Regional Office</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            Drug
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "drug_type" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="drug_type_list_setup" href="{{ route('drug_type_list') }}" class="nav-link" onclick="setactive('cpm','drug_type_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Drug Type Setup</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "evidence" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="evidence_list_setup" href="{{ route('evidence_list') }}" class="nav-link" onclick="setactive('cpm','evidence_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Evidence Setup</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "evidence_type" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="evidence_type_list_setup" href="{{ route('evidence_type_list') }}" class="nav-link" onclick="setactive('cpm','evidence_type_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Evidence Type Setup</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "packaging" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="packaging_list_setup" href="{{ route('packaging_list') }}" class="nav-link" onclick="setactive('cpm','packaging_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Packaging Setup</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "unit_measurement" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="unit_measurement_list_setup" href="{{ route('unit_measurement_list') }}" class="nav-link" onclick="setactive('cpm','unit_measurement_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Unit Of Measurement</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            <!-- Suspect -->
                                            Suspect
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "civil_status" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="civil_status" href="{{ route('civil_status') }}" class="nav-link" onclick="setactive('cpm','civil_status')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Civil Status Setup</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "educational_attainment" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="educational_attainment_list_setup" href="{{ route('educational_attainment_list') }}" class="nav-link" onclick="setactive('cpm','educational_attainment_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Educational Attainment</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "ethnic_group" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="ethnic_group_list_setup" href="{{ route('ethnic_group_list') }}" class="nav-link" onclick="setactive('cpm','ethnic_group_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Ethinic Group Setup</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "group_affiliation" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="group_affiliation_list_setup" href="{{ route('group_affiliation_list') }}" class="nav-link" onclick="setactive('cpm','group_affiliation_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Group Affiliation</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "nationality" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="nationality_list_setup" href="{{ route('nationality_list') }}" class="nav-link" onclick="setactive('cpm','nationality_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Nationality</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "occupation" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="occupation_list_setup" href="{{ route('occupation_list') }}" class="nav-link" onclick="setactive('cpm','occupation_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Occupation Setup</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "religion_setup" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="religion_setup" href="{{ route('religions') }}" class="nav-link" onclick="setactive('cpm','religion_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Religion Setup</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "suspect_category" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="suspect_category_list_setup" href="{{ route('suspect_category_list') }}" class="nav-link" onclick="setactive('cpm','suspect_category_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Suspect Category</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "suspect_sub_category" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="suspect_sub_category_list_setup" href="{{ route('suspect_sub_category_list') }}" class="nav-link" onclick="setactive('cpm','suspect_sub_category_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Suspect Sub-Category</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "suspect_classification" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="suspect_classification_list_setup" href="{{ route('suspect_classification_list') }}" class="nav-link" onclick="setactive('cpm','suspect_classification_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Suspect Classification</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "identifier" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="identifier_list_setup" href="{{ route('identifier_list') }}" class="nav-link" onclick="setactive('cpm','identifier_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Suspect Identifier</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "suspect_information" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="suspect_information_list_setup" href="{{ route('suspect_information_list') }}" class="nav-link" onclick="setactive('cpm','suspect_information_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Suspect Information</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "suspect_status" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="suspect_status_list" href="{{ route('suspect_status_list') }}" class="nav-link" onclick="setactive('cpm','suspect_status_list')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Suspect Status</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            User
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "user_activities" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="user_activities" href="{{ route('audits') }}" class="nav-link" onclick="setactive('cpm','user_activities')">
                                                <i class=" far fa-dot-circle nav-icon"></i>
                                                <p>User Activities</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "user_level_setup" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="user_level_setup" href="{{ route('user_level_list') }}" class="nav-link" onclick="setactive('cpm','user_level_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>User Level Setup</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "user_list" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="user_list" href="{{ route('list') }}" class="nav-link" onclick="setactive('cpm','user_list')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Users List</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            UACS
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "region" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="region_list_setup" href="{{ route('region_list') }}" class="nav-link" onclick="setactive('cpm','region_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Region Setup</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "province" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="province_list_setup" href="{{ route('province_list') }}" class="nav-link" onclick="setactive('cpm','province_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Province Setup</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "city" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="city_list_setup" href="{{ route('city_list') }}" class="nav-link" onclick="setactive('cpm','city_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>City Setup</p>
                                            </a>
                                        </li>
                                        @foreach($access_menu as $accessmenu)
                                        @if(rtrim($accessmenu->menu_key) == "barangay" && $accessmenu->status == true)
                                        <li class="nav-item">
                                            @break
                                            @else
                                        <li class="nav-item" hidden>
                                            @endif
                                            @endforeach
                                            <a id="barangay_list_setup" href="{{ route('barangay_list') }}" class="nav-link" onclick="setactive('cpm','barangay_list_setup')">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Barangay Setup</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')

            @if (Auth::check())
            <div class="chat_frame">
                <button class="chat_button ch_openX"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
            </div>
            <div class="chat_list">
                <div class="c_list_title">
                    <div class="eighty">CONTACTS</div>
                    <div class="twenty"><button class="chat_button ch_closeX"><i class="fa fa-times" aria-hidden="true"></i></button></div>
                </div>
                <div class="c_listX">
                    <iframe src="{{ route('chat_list') }}"></iframe>
                </div>
            </div>
            <div id="msg_pane" class="msg_pane">
                <iframe id="the_pane" src=""></iframe>
            </div>
            @endif
        </div>
        <!-- /.content-wrapper -->
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; 2021 All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('dist/js/demo.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Sweet alert -->
    <script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="{{ asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
    <!-- bs-custom-file-input -->
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <!-- FLOT CHARTS -->
    <script src="{{ asset('plugins/flot/jquery.flot.js') }}"></script>
    <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
    <script src="{{ asset('plugins/flot/plugins/jquery.flot.resize.js') }}"></script>
    <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
    <script src="{{ asset('plugins/flot/plugins/jquery.flot.pie.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>



    <!-- Page specific script -->
    @yield('scripts')
    <!-- DOM jquery to upload User Profile Photos -->
    <script>
        //set preview of image to upload
        $('#photo').on('change', function() {
            var file = this.files[0];
            var imagefile = file.type;
            var imageTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            if (imageTypes.indexOf(imagefile) == -1) {
                //display error
                return false;
                $(this).empty();
            } else {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.empty-text').html(
                        '<img class="profile-user-img img-fluid" style="height: 200px; width:200px;" alt="User profile picture" src="' +
                        e.target.result +
                        '" onerror=this.src="../../dist/img/profile.png"/>'
                    );
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>
    <!-- Collopse and set menus to active
    <script>
        function setCookie(key, value, expiry) {
            var expires = new Date();
            expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
            document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
        }

        function getCookie(key) {
            var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
            return keyValue ? keyValue[2] : null;
        }

        function eraseCookie(key) {
            var keyValue = getCookie(key);
            setCookie(key, keyValue, '-1');
        }

        function setactive(modulename, menu) {
            setCookie("modulename", modulename);
            setCookie("menu", menu);
        }

        function removeCokie() {
            eraseCookie('modulename');
            eraseCookie('menu');
        }

        $(document).ready(function() {

            if (getCookie('modulename') == '') {
                eraseCookie('modulename');

                $("#" + getCookie('menu')).removeClass('active');
                $("#" + getCookie('menu')).addClass('active');
            } else {

                $("#" + getCookie('modulename')).removeClass('menu-open');
                $("#" + getCookie('modulename')).addClass('menu-open');

                $("#" + getCookie('menu')).removeClass('active');
                $("#" + getCookie('menu')).addClass('active');

            }

            var hrm_checked = $("#customCheckbox3").prop('checked');
            var hrt_checked = $("#customCheckbox4").prop('checked');
            var hrp_checked = $("#customCheckbox5").prop('checked');
            var cpm_checked = $("#customCheckbox6").prop('checked');

            if (hrm_checked == false) {
                $("#hrm_table tbody tr td:first-child input:checkbox").removeAttr('checked');
                $("#hrm_table tbody tr td:first-child input:checkbox").attr('disabled', 'true');
            }

            if (hrt_checked == false) {
                $("#hrt_table tbody tr td:first-child input:checkbox").removeAttr('checked');
                $("#hrt_table tbody tr td:first-child input:checkbox").attr('disabled', 'true');
            }

            if (hrp_checked == false) {
                $("#hrp_table tbody tr td:first-child input:checkbox").removeAttr('checked');
                $("#hrp_table tbody tr td:first-child input:checkbox").attr('disabled', 'true');
            }

            if (cpm_checked == false) {
                $("#cpm_table tbody tr td:first-child input:checkbox").removeAttr('checked');
                $("#cpm_table tbody tr td:first-child input:checkbox").attr('disabled', 'true');
            }

        });
    </script> -->

    <script>
        $('#customCheckbox3').click(function() {

            var checked = $(this).prop('checked');

            if (checked) {
                $("#hrm_table tbody tr td:first-child input:checkbox").attr('checked', 'checked');
                $("#hrm_table tbody tr td:first-child input:checkbox").removeAttr('disabled');
            } else {
                $("#hrm_table tbody tr td:first-child input:checkbox").removeAttr('checked');
                $("#hrm_table tbody tr td:first-child input:checkbox").attr('disabled', 'true');
            }
        });

        $('#customCheckbox4').click(function() {

            var checked = $(this).prop('checked');

            if (checked) {
                $("#hrt_table tbody tr td:first-child input:checkbox").attr('checked', 'checked');
                $("#hrt_table tbody tr td:first-child input:checkbox").removeAttr('disabled');
            } else {
                $("#hrt_table tbody tr td:first-child input:checkbox").removeAttr('checked');
                $("#hrt_table tbody tr td:first-child input:checkbox").attr('disabled', 'true');
            }
        });

        $('#customCheckbox5').click(function() {

            var checked = $(this).prop('checked');

            if (checked) {
                $("#hrp_table tbody tr td:first-child input:checkbox").attr('checked', 'checked');
                $("#hrp_table tbody tr td:first-child input:checkbox").removeAttr('disabled');
            } else {
                $("#hrp_table tbody tr td:first-child input:checkbox").removeAttr('checked');
                $("#hrp_table tbody tr td:first-child input:checkbox").attr('disabled', 'true');
            }
        });

        $('#customCheckbox6').click(function() {

            var checked = $(this).prop('checked');

            if (checked) {
                $("#cpm_table tbody tr td:first-child input:checkbox").attr('checked', 'checked');
                $("#cpm_table tbody tr td:first-child input:checkbox").removeAttr('disabled');
            } else {
                $("#cpm_table tbody tr td:first-child input:checkbox").removeAttr('checked');
                $("#cpm_table tbody tr td:first-child input:checkbox").attr('disabled', 'true');
            }
        });
    </script>

    <!-- Page specific script -->
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": false,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });

        $(function() {
            $("#example_info").DataTable({
                "responsive": false,
                "lengthChange": false,
                "autoWidth": false,
                "bPaginate": false,
                "bFilter": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });

        // $(function() {
        //     $("#example1").DataTable({
        //         "responsive": false,
        //         "lengthChange": false,
        //         "autoWidth": false,
        //         "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        //     }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        // });
    </script>

    <script>
        // add rows to specified table element
        function AddRow(tableName) {

            var $TABLE = $('#' + tableName);

            // copy the hidden row in the table and unhide
            var $clone = $TABLE.find('tr.hide').clone(true).removeClass('hide');

            // append the copied row to the table
            $TABLE.find('table').append($clone);

        }

        // remove row
        $('.table-remove').click(function() {
            $(this).parents('tr').detach();
        });
    </script>

    <!-- Initialize Select2 Elements -->
    <script>
        $(function() {
            $('.select2').select2();
        });
    </script>

    <!-- Set menu to active -->
    <script>
        $('#menu_sample > ul.nav li a').click(function(e) {
            var $this = $(this);
            $this.parent().siblings().removeClass('active').end().addClass('active');
            e.preventDefault();
        });
    </script>

    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>

    <style>
        .disabled_field {
            pointer-events: none;
            background-color: #e9ecef;
        }
    </style>
</body>

</html>