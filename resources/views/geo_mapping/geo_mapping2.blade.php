@extends('layouts.template')

@section('content')
<link rel="stylesheet" href="{{ asset('css/c_gl.css') }}">
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script> --}}
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Geo Mapping</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="removeCokie();">Home</a></li>
                    <li class="breadcrumb-item active">Geo Mapping</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="col-md-12 flexer card2X">
        <div class="col-md-5"> 
            <div><h3>Select Sector</h3></div>
            <div><button class="scx_btn">Sector I </button></div>
            <div><button class="scx_btn">Sector II </button></div>
            <div><button class="scx_btn">Sector III </button></div>
        </div>
        <div class="col-md-7">
            <div><h3>Makati Proper(Sector I)</h3></div>
             <div class="txtCtr">
                 <img src="{{ asset('images/Sector_1.png') }}" class="scx_img">
             </div>
        </div>
</section>
<div class="col-md-12">
    <div><h3>List of Recent Operations</h3></div>
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th>Operation Name</th>
                <th>Date Launched</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>OPLAN Tabing Ilog</td>
                <td>Jan. 10, 2022</td>
                <td>Active</td>
            </tr>
            <tr>
                <td>OPLAN Ligaya</td>
                <td>Jan. 01, 2022</td>
                <td>Active</td>
            </tr>
            <tr>
                <td>OPLAN Salubong</td>
                <td>Dec. 24, 2021</td>
                <td>Completed</td>
            </tr>
        </tbody>
    </table>
</div>
</div>

<!-- /.content -->

<!-- Set menu to collapse and active -->

@endsection