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
            font-size: 16px;
        }

        .vendana {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 9px;
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
        <span class="arial">CONFIDENTIAL</span>
    </header>
    <footer>
        <span class="vendana" >{{$Sdate}} | {{Auth::user()->name}}</span>
        <br>
        <span class="arial" style="color: blue;">CONFIDENTIAL</span>
    </footer>
    @if(isset($regional_office[0]->report_header) && $regional_office[0]->report_header != null)
    <img id="currentPhoto" src="./files/uploads/report_header/{{$regional_office[0]->report_header}}" onerror="this.src='./files/uploads/report_header/newhead.jpg'" alt="" class="col-3" style="width:100%;">
    @else
    <img id="currentPhoto" src="./files/uploads/report_header/newhead.jpg" onerror="this.onerror=null; this.remove();" alt="2" class="col-3" style="width:100%;">
    @endif
    <br>
    <div style="text-align:center;">
        <h2 class="arial" >{{$spot_report[0]->spot_report_number}}</h2>
    </div>
    <div style="border:solid;" align="center"><span>PROGRESS REPORT</span></div>
    <br>
    <table width="100%" style="border-collapse: collapse; border: 0px;">
        <tr style="border:none;">
            <td width="100%" style="border: nonce; padding:0;"><span class="vendana" style="margin-left:33px">Date Reported:</span></td>
            <td width="100%" style="border: nonce; padding:0; text-align:left"><span class="vendana">{{$reported_date}}</span></td>
            <td width="100%" style="border: nonce; padding:0; text-align:left"><span></span></td>
            <td width="100%" style="border: nonce; padding:0; text-align:left"><span></span></td>
        </tr>
        <tr style="border:none;">
            <td style="border: none; padding:0;" width="100%"><span class="vendana" style="margin-left:33px;">Reporting Office:</span></td>
            <td colspan="3" style="border: none; padding:0;" width="100%"><span class="vendana" style="font-weight:bold">{{$regional_office[0]->name}}</span></td>
        </tr>
        <tr style="border:none;">
            <td style="border: none; padding:0;" width="100%"><span class="vendana" style="margin-left:33px;">Pre-Ops Number:</span></td>
            <td colspan="3" style="border: none; padding:0;" width="100%"><span class="vendana" style="font-weight:bold">{{$spot_report[0]->preops_number}}</span></td>
        </tr>
        <tr style="border:none;">
            <td style="border: none; padding:0;" width="100%"><span class="vendana" style="margin-left:33px;">Date/Time of OPN:</span></td>
            <td colspan="3" style="border: none; padding:0;" width="100%"><span class="vendana" style="font-weight:bold">{{$operation_datetime}}</span></td>
        </tr>
        <tr style="border:none;">
            <td style="border: none; padding:0;" width="100%"><span class="vendana" style="margin-left:33px;">Lead Unit:</span></td>
            <td colspan="3" style="border: none; padding:0;" width="100%"><span class="vendana" style="font-weight:bold">{{$operating_unit[0]->description}}</span></td>
        </tr>
        <tr style="border:none;">
            <td style="border: none; padding:0;" width="100%"><span class="vendana" style="margin-left:33px;">Type of Operation:</span></td>
            <td colspan="3" style="border: none; padding:0;" width="100%"><span class="vendana" style="font-weight:bold">{{$operation_type[0]->name}}</span></td>
        </tr>
        <tr style="border:none;">
            <td style="border: none; padding:0;" width="100%"><span class="vendana" style="margin-left:33px;">Remarks:</span></td>
            <td colspan="3" style="border: none; padding:0;" width="100%"><span class="vendana" style="font-weight:bold">{{$spot_report[0]->remarks}}</span></td>
        </tr>
    </table>
    <br>
    <table width="100%" style="border-collapse: collapse; border: 0px;">
        <tr style="border: 1px solid;">
            <th class="vendana" style="border: none; padding:0 12px;" align="left">Suspect(s) Arrested</th>
            <th style="border: none; padding:0 12px;" align="left"></th>
            <th style="border: none; padding:0 12px;" align="left"></th>
        </tr>
        @foreach ($suspect as $sp)
        <tr>
            <td class="vendana" colspan="3" style="border: none; padding:0 12px;" align="left"><b>{{$sp->lastname}}, {{$sp->firstname}} {{$sp->middlename}} {{$sp->alias}}</b></td>
        </tr>
        <tr>
            <td class="vendana" style="border: none; padding-left:22px;" align="left">Drug Test Result: <b>{{$sp->drug_test_result}}</b></td>
            <td class="vendana" colspan="2" style="border: none;" align="left">Metabolites: <b>{{$sp->drug_name}}</b></td>
        </tr>
        <tr>
            <td class="vendana" colspan="3" style="border: none; padding-left:22px;" align="left">Whereabouts: <b>{{$sp->whereabouts}}</b></td>
        </tr>
        @endforeach
    </table>
    <br>
    <table width="100%" style="border-collapse: collapse; border: 0px;">
        <tr style="border: 1px solid;">
            <th class="vendana" style="border: none; padding:0 12px;" width="25%" align="left">Qty</th>
            <th class="vendana" style="border: none; padding:0 12px;" width="25%" align="left">Evidence</th>
            <th class="vendana" style="border: none; padding:0 12px;" width="50%" align="left">Packaging</th>
        </tr>
        @foreach ($evidence as $ar)
        <tr>
            <td class="vendana" style="border: none; padding:0 12px;" width="25%" align="right">{{$ar->actual_qty}} {{$ar->unit_measurement}}</td>
            <td class="vendana" style="border: none; padding:0 12px;" width="25%">{{$ar->evidence_type}} - {{$ar->evidence}}</td>
            <td class="vendana" style="border: none; padding:0 12px;" width="50%">{{$ar->packaging}}</td>
        </tr>
        @endforeach
    </table>
    <br>
    <table width="100%" style="border-collapse: collapse; border: 0px;">
        <tr style="border: 1px solid;">
            <th class="vendana" style="border: none; padding:0 12px;" width="50%" align="left">Case(s) Filed</th>
            <th class="vendana" style="border: none; padding:0 12px;" width="50%" align="left">Name of Suspect</th>
        </tr>
        @foreach ($case as $cs)
        <tr>
            <td class="vendana" style="border: none; padding:0 12px;" width="50%">{{$cs->case}}</td>
            <td class="vendana" style="border: none; padding:0 12px;" width="50%">{{$cs->lastname}}, {{$cs->firstname}} {{$cs->middlename}}</td>
        </tr>
        @endforeach
    </table>
    <br>
    <table width="100%" style="border-collapse: collapse; border: 0px;">
        <tr style="border: 1px solid;">
            <th class="vendana" style="border: none; padding:0 12px;" width="50%" align="left">Case Status</th>
        </tr>
        <tr>
            <th class="vendana" style="border: none; padding:0 12px;" width="50%" align="left">Inquest</th>
        </tr>
        <tr>
            <td class="vendana" style="border: none; padding:0 12px;" width="100%">Date: {{$spot_report[0]->case_status_date}}</td>
        </tr>
        <tr>
            <td class="vendana" style="border: none; padding:0 12px;" width="100%">Name of Prosecutor: {{$spot_report[0]->procecutor_name}}</td>
        </tr>
        <tr>
            <td class="vendana" style="border: none; padding:0 12px;" width="100%">Prosecutor's Office: {{$spot_report[0]->procecutor_office}}</td>
        </tr>
        <!-- <tr>
            <br>
        </tr>
        <tr>
            <th style="border: none; padding:0 12px;" width="50%" align="left">Preliminary Investigation</th>
        </tr>
        <tr>
            <td style="border: none; padding:0 12px;" width="100%">Date: {{$spot_report[0]->prelim_case_date}}</td>
        </tr>
        <tr>
            <td style="border: none; padding:0 12px;" width="100%">Name of Prosecutor: {{$spot_report[0]->prelim_prosecutor}}</td>
        </tr>
        <tr>
            <td style="border: none; padding:0 12px;" width="100%">Prosecutor's Office: {{$spot_report[0]->prelim_prosecutor_office}}</td>
        </tr> -->
    </table>
    <br>
    <table width="100%" style="border-collapse: collapse; border: 0px;">
        <tr style="border: 1px solid;">
            <th class="vendana" style="border: none; padding:0 12px;" width="50%" align="left">Summary</th>
        </tr>
    </table>
    <p class="vendana"  style="margin-right:23px; margin-left:40px;"><b>{{$spot_report[0]->report_header}}</b></p>
    <p class="vendana"  style="margin-right:23px; margin-left:60px;">{{$spot_report[0]->summary}}</p>
    <h4 class="vendana"  align="center">*** end of report ***</h4>
</body>

</html>