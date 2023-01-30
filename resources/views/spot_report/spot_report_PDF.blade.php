<html>

<head>
    <style>
        /** Define the margins of your page **/
        @page {
            margin: 100px 25px;
        }

        header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            height: 50px;

            /** Extra personal styles **/
            color: blue;
            text-align: center;
            line-height: 35px;
            font-size: 20px;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            height: 50px;

            /** Extra personal styles **/
            color: black;
            text-align: center;
            line-height: 35px;
        }

        .arial {
            font-family: Arial, Helvetica, sans-serif;
        }

        #watermark {
            position: fixed;
            margin-top: 6cm;
            margin-left: 4cm;
            z-index: 1000;
            opacity: 0.2;
            height: 11cm;
            width: 11cm;
        }
    </style>
</head>

<body>
    <div id="watermark">
        <img src="./files/watermark/pdea_logo.png" height="100%" width="100%" />
    </div>
    <!-- Define header and footer blocks before your content -->
    <header>
        CONFIDENTIAL
    </header>
    @if($regional_office[0]->report_header != null)
    <img id="currentPhoto" src="./files/uploads/report_header/'{{$regional_office[0]->report_header}}" onerror="this.src='./files/uploads/report_header/newhead.jpg'" alt="" class="col-3" style="width:100%;">
    @else
    <img id="currentPhoto" src="./files/uploads/report_header/newhead.jpg" onerror="this.onerror=null; this.remove();" alt="2" class="col-3" style="width:100%;">
    @endif
    <br>
    <br>
    <div style="text-align:center;">
        <h2 class="arial">{{$spot_report[0]->spot_report_number}}</h2>
    </div>
    <div style="border:solid;" align="center"><span class="arial" style="font-size:20px">SPOT REPORT</span></div>
    <br>
    <table width="100%" style="border-collapse: collapse; border: 0px;">
        <tr style="border:none;">
            <td colspan="2" style="border: none; padding:0;" width="100%"><span class="arial" style="font-size:15px; margin-right:39px; margin-left:33px">Date Reported:</span><span>{{$spot_report[0]->reported_date}}</span></td>
        </tr>
        <tr style="border:none;">
            <td colspan="2" style="border: none; padding:0;" width="100%"><span class="arial" style="font-size:15px; margin-right:28px; margin-left:33px;">Reporting Office:</span><span class="arial" style="font-weight:bold">{{$regional_office[0]->name}}</span></td>
        </tr>
        <tr style="border:none;">
            <td style="border: none; padding:0;" width="50%"><span class="arial" style="font-size:15px; margin-right:23px; margin-left:33px">Pre-Ops Number:</span><span class="arial" style="font-weight:bold">Preops Number</span></td>
            <td style="border: none; padding-left:20px;" width="50%"><span style="margin-right:10px;">Date/Time of OPN:</span><span class="arial" style="font-weight:bold">{{$spot_report[0]->operation_datetime}}</span></td>
        </tr>
        </tr>
        <tr style="border:none;">
            <td colspan="2" style="border: none; padding:0;" width="100%"><span class="arial" style="font-size:15px; margin-right:17px; margin-left:33px">Type of Operation:</span><span class="arial" style="font-weight:bold">Operation Type</span></td>
        </tr>
        </tr>
        <tr style="border:none;">
            <td style="border: none; padding:0;" width="50%"><span class="arial" style="font-size:15px; margin-right:39px; margin-left:33px">Operating Unit:</span><span class="arial" style="font-weight:bold">Operating Unit</span></td>
            <td style="border: none; padding-left:20px;" width="50%"><span style="margin-right:10px;">Support Unit:</span><span class="arial" style="font-weight:bold; ">
                    <?php $count = 0; ?>
                    @foreach ($support_unit as $su)
                    <?php $count++; ?>
                    @if ($count == 1)
                    {{$su->description}}
                    @else
                    , {{$su->description}}
                    @endif
                    @endforeach
            </td>
        </tr>
        </tr>
        <tr style="border:none;">
            <td colspan="2" style="border: none; padding:0;" width="100%"><span class="arial" style="font-size:15px; margin-right:17px; margin-left:33px;">Area of Operation:</span><span class="arial" style="font-weight:bold">{{$spot_report[0]->barangay_m}}, {{$spot_report[0]->city_m}}</span></td>
        </tr>
        <tr style="border:none;">
            <td colspan="2" style="border: none; padding:0;" width="100%"><span class="arial" style="font-size:15px; margin-right:74px; margin-left:33px">Remarks:</span><span>{{$spot_report[0]->remarks}}</span></td>
        </tr>
    </table>
    <br>
    <table width="100%" style="border-collapse: collapse; border: 0px;">
        <tr style="border: 1px solid;">
            <th class="arial" style="border: none; padding:0 12px;" width="25%" align="left">Qty</th>
            <th class="arial" style="border: none; padding:0 12px;" width="25%" align="left">Evidence</th>
            <th class="arial" style="border: none; padding:0 12px;" width="50%" align="left">Packaging</th>
        </tr>
        @foreach ($evidence as $ar)
        <tr>
            <td class="arial" style="border: none; padding:0 12px;" width="25%" align="left">{{$ar->quantity}} {{$ar->unit_measurement}}</td>
            <td class="arial" style="border: none; padding:0 12px;" width="25%">{{$ar->evidence_type}} - {{$ar->evidence}}</td>
            <td class="arial" style="border: none; padding:0 12px;" width="50%">{{$ar->packaging}}</td>
        </tr>
        @endforeach
    </table>
    <br>
    <table width="100%" style="border-collapse: collapse; border: 0px;">
        <tr style="border: 1px solid;">
            <th class="arial" style="border: none; padding:0 12px;" width="50%" align="left">Case(s) Filed</th>
            <th class="arial" style="border: none; padding:0 12px;" width="50%" align="left">Name of Suspect</th>
        </tr>
        @foreach ($case as $cs)
        <tr>
            <td class="arial" style="border: none; padding:0 12px;" width="50%">{{$cs->case}}</td>
            <td class="arial" style="border: none; padding:0 12px;" width="50%">{{$cs->lastname}}, {{$cs->firstname}} {{$cs->middlename}}</td>
        </tr>
        @endforeach
    </table>
    <br>
    <table width="100%" style="border-collapse: collapse; border: 0px;">
        <tr style="border: 1px solid;">
            <th class="arial" style="border: none; padding:0 12px;" width="50%" align="left">Operating Team Name</th>
            <th class="arial" style="border: none; padding:0 12px;" width="50%" align="left">Position/Department</th>
        </tr>
        @foreach ($team as $tm)
        <tr>
            <td class="arial" style="border: none; padding:0 12px;" width="50%">{{$tm->officer_name}}</td>
            <td class="arial" style="border: none; padding:0 12px;" width="50%">{{$tm->officer_position}}</td>
        </tr>
        @endforeach
    </table>

    <br>
    <table width="100%" style="border-collapse: collapse; border: 0px;">
        <tr style="border: 1px solid;">
            <th class="arial" style="border: none; padding:0 12px;" width="50%" align="left">Summary</th>
        </tr>
    </table>
    <span class="arial" style="margin-right:23px; margin-left:13px;">{{$spot_report[0]->summary}}</span>
    <h4 class="arial" align="center">*** end of report ***</h4>
    <footer>
        {{$Sdate}} | {{Auth::user()->name}} | @if ($spot_report[0]->print_count == 1) O @else C @endif
    </footer>
</body>

</html>