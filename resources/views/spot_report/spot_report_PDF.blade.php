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
        CONFIDENTIAL
    </header>
    <footer>
        <span class="vendana">{{$Sdate}} | {{Auth::user()->name}} | @if ($spot_report[0]->print_count == 1) O @else C @endif</span>
        <br>
        <span style="color: blue; font-size: 20px">CONFIDENTIAL</span>
    </footer>
    @if(isset($regional_office[0]->report_header) && $regional_office[0]->report_header != null)
    <img id="currentPhoto" src="./files/uploads/report_header/{{$regional_office[0]->report_header}}" onerror="this.src='./files/uploads/report_header/newhead.jpg'" alt="" class="col-3" style="width:100%;">
    @else
    <img id="currentPhoto" src="./files/uploads/report_header/newhead.jpg" onerror="this.onerror=null; this.remove();" alt="2" class="col-3" style="width:100%;">
    @endif
    <br>
    <div style="text-align:center;">
        <h2 class="arial">{{$spot_report[0]->spot_report_number}}</h2>
    </div>
    <div style="border:solid;" align="center"><span class="arial">SPOT REPORT</span></div>
    <br>
    <table width="100%" style="border-collapse: collapse; border: 0px;">
        <tr style="border:none;">
            <td width="100%" style="border: nonce; padding:0;"><span class="vendana" style="margin-left:33px">Date Reported:</span></td>
            <td width="100%" style="border: nonce; padding:0; text-align:left"><span class="vendana">{{$reported_date}}</span></td>
            <td width="100%" style="border: nonce; padding:0; text-align:left"><span></span></td>
            <td width="100%" style="border: nonce; padding:0; text-align:left"><span></span></td>
            <td width="100%" style="border: nonce; padding:0; text-align:left"><span></span></td>
        </tr>
        <tr style="border:none;">
            <td style="border: none; padding:0;" width="100%"><span class="vendana" style="margin-left:33px;">Reporting Office:</span></td>
            <td colspan="4" style="border: none; padding:0; text-align:left" width="100%"><span class="vendana" style="font-weight:bold">{{$regional_office[0]->name}}</span></td>
        </tr>
        <tr style="border:none;">
            <td style="border: none; padding:0;" width="100%"><span class="vendana" style="margin-left:33px;">Pre-Ops Number:</span></td>
            <td style="border: none; padding:0; text-align:left" width="100%"><span class="vendana" style="font-weight:bold">{{$spot_report[0]->preops_number}}</span></td>
            <td style="border: none; padding:0;" width="100%"><span class="vendana" style="margin-left:33px;">Date/Time of OPN:</span></td>
            <td colspan="2" style="border: none; padding:0; text-align:left" width="100%"><span class="vendana" style="font-weight:bold">{{$operation_datetime}}</span></td>
        </tr>
        <tr style="border:none;">
            <td style="border: none; padding:0;" width="100%"><span class="vendana" style="margin-left:33px;">Type of Operation:</span></td>
            <td colspan="4" style="border: none; padding:0; text-align:left" width="100%"><span class="vendana" style="font-weight:bold">{{$spot_report[0]->operation_type}}</span></td>
        </tr>
        <tr style="border:none;">
            <td style="border: none; padding:0;" width="100%"><span class="vendana" style="margin-left:33px;">Lead Unit:</span></td>
            <td colspan="4" style="border: none; padding:0; text-align:left" width="100%"><span class="vendana" style="font-weight:bold">{{$spot_report[0]->operating_unit}}</span></td>
        </tr>
        @if(isset($support_unit[0]->description))
        <tr style="border:none;">
            <td style="border: none; padding:0;" width="100%"><span class="vendana" style="margin-left:33px;">Support Unit:</span></td>
            <td colspan="4" style="border: none; padding-left:0;" width="50%"><span class="vendana" style="font-weight:bold; ">
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
        @else
        @endif
        <tr style="border:none;">
            <td style="border: none; padding:0;" width="100%"><span class="vendana" style="margin-left:33px;">Area of Operation:</span></td>
            <td colspan="4" style="border: none; padding:0; text-align:left" width="100%"><span class="vendana" style="font-weight:bold">{{$spot_report[0]->barangay_m}}, {{$spot_report[0]->city_m}}</span></td>
        </tr>
        @if(isset($spot_report[0]->remarks))
        <tr style="border:none;">
            <td style="border: none; padding:0;" width="100%"><span class="vendana" style="margin-left:33px;">Remarks:</span></td>
            <td colspan="4" style="border: none; padding:0; text-align:left" width="100%"><span class="vendana" style="font-weight:bold">{{$spot_report[0]->remarks}}</span></td>
        </tr>
        @else
        @endif
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
            <td class="vendana" style="border: none; padding:0 12px;" width="25%" align="left">{{$ar->quantity}} {{$ar->unit_measurement}}</td>
            <td class="vendana" style="border: none; padding:0 12px;" width="25%">{{$ar->evidence_type}} - {{$ar->evidence}}</td>
            <td class="vendana" style="border: none; padding:0 12px;" width="50%">{{$ar->packaging}}</td>
        </tr>
        <tr>
            <td class="vendana" style="border: none; padding:0 12px;" colspan="3" width="100%" align="left">seized/confiscated from {{$ar->lastname}}, {{$ar->firstname}} {{$ar->middlename}} with serial/plate no: . marked as .</td>
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
        @foreach ($suspects as $suspect)
        <tr style="border: 1px solid;">
            <th class="vendana" style="border: none; padding:0 12px;" width="50%" align="left">Suspect(s)</th>
            <th class="vendana" style="border: none; padding:0 12px;" width="50%" align="left"></th>
        </tr>
        <tr style="border:none;">
            <td colspan="2" style="border: none; padding:0;"><span class="vendana" style="margin-right:39px; margin-left:33px">Name: {{$suspect->lastname}}, {{$suspect->firstname}} {{$suspect->middlename}}</span>
            </td>
        </tr>
        <tr style="border:none;">
            <td colspan="2" style="border: none; padding:0;"><span class="vendana" style="margin-right:28px; margin-left:33px;">Suspect Status: {{$suspect->suspect_status}}</span>
            </td>
        </tr>
        <tr style="border:none;">
            <td colspan="2" style="border: none; padding:0;"><span class="vendana" style="margin-right:28px; margin-left:33px;">Address: {{$suspect->street}}, {{$suspect->barangay_name}}, {{$suspect->city_name}}, {{$suspect->province_name}}, {{$suspect->region_name}}</span>
            </td>
        </tr>
        <tr style="border:none;">
            <td style="border: none; padding:0;"><span class="vendana" style="margin-right:28px; margin-left:33px;">DOB/Age: <?php echo date_create_from_format("Y-m-d", $suspect->birthdate)->format("F j, Y") ?><?php
                                                                                                                                                                                                                    $birthDate = date_create_from_format("Y-m-d", $suspect->birthdate)->format("m/d/Y");
                                                                                                                                                                                                                    //explode the date to get month, day and year
                                                                                                                                                                                                                    $birthDate = explode("/", $birthDate);
                                                                                                                                                                                                                    //get age from date or birthdate
                                                                                                                                                                                                                    $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
                                                                                                                                                                                                                        ? ((date("Y") - $birthDate[2]) - 1)
                                                                                                                                                                                                                        : (date("Y") - $birthDate[2]));
                                                                                                                                                                                                                    echo " (" . $age . ")";
                                                                                                                                                                                                                    ?></span>
            </td>
            <td style="border: none; padding:0;"><span class="vendana" style="border: none; padding:0 12px;">Educ Att: {{$suspect->educational_attainment}}</span>
            </td>
        </tr>
        <tr style="border:none;">
            <td style="border: none; padding:0;"><span class="vendana" style="margin-right:28px; margin-left:33px;">POB: {{$suspect->birthplace}}</span>
            </td>
            <td style="border: none; padding:0;"><span class="vendana" style="border: none; padding:0 12px;">Occupation: {{$suspect->occupation}}</span>
            </td>
        </tr>
        <tr style="border:none;">
            <td colspan="2" style="border: none; padding:0;"><span class="vendana" style="margin-right:28px; margin-left:33px;">Nationality: {{$suspect->nationality}}</span>
            </td>
        </tr>
        <tr style="border:none;">
            <td colspan="2" style="border: none; padding:0;"><span class="vendana" style="margin-right:28px; margin-left:33px;">Gender: {{$suspect->gender}}</span>
            </td>
        </tr>
        <tr style="border:none;">
            <td style="border: none; padding:0;"><span class="vendana" style="margin-right:28px; margin-left:33px;">Civil Status: {{$suspect->civil_status}}</span>
            </td>
            <td style="border: none; padding:0;"><span class="vendana" style="border: none; padding:0 12px;">Category: {{$suspect->suspect_category}} - {{$suspect->sub_category}}</span>
            </td>
        </tr>
        <tr style="border:none;">
            <td colspan="2" style="border: none; padding:0;"><span class="vendana" style="margin-right:28px; margin-left:33px;">Ethnic Group: {{$suspect->ethnic_group}}</span>
            </td>
        </tr>
        <tr style="border:none;">
            <td style="border: none; padding:0;"><span class="vendana" style="margin-right:28px; margin-left:33px;">Religion: {{$suspect->religion}}</span>
            </td>
            <td style="border: none; padding:0;"><span class="vendana" style="border: none; padding:0 12px;">Classification: {{$suspect->suspect_classification}}</span>
            </td>
        </tr>
        <tr style="border:none;"></tr>
        @endforeach
    </table>
    <br>
    <table width="100%" style="border-collapse: collapse; border: 0px;">
        <tr style="border: 1px solid;">
            <th class="vendana" style="border: none; padding:0 12px;" width="50%" align="left">Operating Team Name</th>
            <th class="vendana" style="border: none; padding:0 12px;" width="50%" align="left">Position/Department</th>
        </tr>
        @foreach ($team as $tm)
        <tr>
            <td class="vendana" style="border: none; padding:0 12px;" width="50%">{{$tm->officer_name}}</td>
            <td class="vendana" style="border: none; padding:0 12px;" width="50%">{{$tm->officer_position}}</td>
        </tr>
        @endforeach
    </table>

    <br>
    <table width="100%" style="border-collapse: collapse; border: 0px;">
        <tr style="border: 1px solid;">
            <th class="vendana" style="border: none; padding:0 12px;" width="50%" align="left">Summary</th>
        </tr>
    </table>
    <span class="vendana" style="margin-right:23px; margin-left:13px;">{{$spot_report[0]->summary}}</span>
    <h4 class="vendana" align="center">*** end of report ***</h4>

</body>

</html>