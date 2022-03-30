@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#" onclick="removeCokie();">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- DONUT CHART -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">COC Pie Chart</h3>
                    </div>
                    <br>
                    <center>
                        <h3>Total COC: {{$total_coc}}</h3>
                    </center>
                    <input id="pending_coc" type="text" hidden value="{{$pending_coc}}">
                    <input id="active_coc" type="text" hidden value="{{$active_coc}}">
                    <input id="expired_coc" type="text" hidden value="{{$expired_coc}}">
                    <input id="submitted_report" type="text" hidden value="{{$submitted_report}}">
                    <div class="card-body">
                        <canvas id="donutChart" style="height: 500px; max-width: 100%;"></canvas>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->

</section>
<!-- /.content -->
@endsection

@section('scripts')

<script>
    $(function() {

        //-------------
        //- DONUT CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
        var pending_coc = $('#pending_coc').val()
        var active_coc = $('#active_coc').val()
        var expired_coc = $('#expired_coc').val()
        var submitted_report = $('#submitted_report').val()
        var donutData = {
            labels: [
                'Active COC',
                'Pending COC',
                'Expired COC with no Reports',
                'Report Submitted',
            ],
            datasets: [{
                data: [active_coc, expired_coc, pending_coc, submitted_report],
                backgroundColor: ['#00a65a', '#f39c12', '#f56954', '#00c0ef'],
            }],
            
            
        }
        var donutOptions = {
            maintainAspectRatio: false,
            responsive: true,
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        new Chart(donutChartCanvas, {
            type: 'doughnut',
            data: donutData,
            options: donutOptions,
        })

    })

    /*
     * Custom Label formatter
     * ----------------------
     */
    function labelFormatter(label, series) {
        return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">' +
            label +
            '<br>' +
            Math.round(series.percent) + '%</div>'
    }
</script>
@endsection