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
            color: red;
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
            text-align: right;
            line-height: 35px;
            font-size: smaller;
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
        SECRET
    </header>
    @if($regional_office[0]->report_header != null)
    <img id="currentPhoto" src="./files/uploads/report_header/'{{$regional_office[0]->report_header}}" onerror="this.src='./files/uploads/report_header/newhead.jpg'" alt="" class="col-3" style="width:100%;">
    @else
    <img id="currentPhoto" src="./files/uploads/report_header/newhead.jpg" onerror="this.onerror=null; this.remove();" alt="2" class="col-3" style="width:100%;">
    @endif
    <br>
    <br>
    <h3 align="center">CERTIFICATE OF COORDINATION</h3>
    <span style="margin-right:110px">Issuing Office:</span><span>{{$regional_office[0]->name}}</span>
    <br>
    <span style="margin-right:39px;">Pre-Ops Control Number:</span><span style="font-weight: bold;">{{$preops_data[0]->preops_number}}</span>
    <br>
    <span style="margin-right:23px">Date and Time Coordinated:</span><span>{{$coordinated_datetime}}H</span>
    <br>
    <span style="margin-right:104px">Lead Unit:</span><span style="font-weight: bold;">{{$operating_unit[0]->description}}</span>
    <br>
    @if(isset($support_unit->description))
    <span style="margin-right:113px">Support Unit:</span>
    @foreach ($support_unit as $su)
   
    @if($loop->iteration == 1)
    <span style="font-weight: bold;">{{$su->description}}</span>
    @elseif($loop->iteration > 1)
    <br>
    <span style="font-weight: bold; margin-left:205px">{{$su->description}}
    </span>
    @endif
    @endforeach
    <br>
    @endif
    <span style="margin-right:82px">Type of Operation:</span><span style="font-weight: bold;">{{$operation_type[0]->name}}</span>
    <br>
    <span style="margin-right:143px">Duration:</span><span>{{$operation_datetime}}H to {{$validity}}H ({{$duration}} HRS)</span>
    <br>
    @if(isset($preops_data[0]->remarks))
    <span style="margin-right:149px">Remark:</span><span>{{$preops_data[0]->remarks}}</span>
    <br>
    @endif
    <br>
    <div style="background-color:green; color:white; padding-left:5px">Area(s) of Operation</div>
    <table width="100%" style="border-collapse: collapse; border: 0px;">
        <tr style="border: 1px solid;">
            <th style="border:solid; border-width: thin; padding:0 12px;" align="left">Region</th>
            <th style="border:solid; border-width: thin; padding:0 12px;" align="left">Province</th>
            <th style="border:solid; border-width: thin; padding:0 12px;" align="left">City/Municipality</th>
            <th style="border:solid; border-width: thin; padding:0 12px;" align="left">Barangay</th>
            <th style="border:solid; border-width: thin; padding:0 12px;" align="left">Area</th>
        </tr>

        @foreach ($area as $ar)
        @if ($ar->area == 'N/A')
        <?php $areas = null ?>
        @else
        <?php $areas = $ar->area ?>
        @endif
        <tr>
            <td style="border:solid; border-width: thin; padding:0 12px;">{{$ar->region_m}}</td>
            <td style="border:solid; border-width: thin; padding:0 12px;">{{$ar->province_m}}</td>
            <td style="border:solid; border-width: thin; padding:0 12px;">{{$ar->city_m}}</td>
            <td style="border:solid; border-width: thin; padding:0 12px;">{{$ar->barangay_m}}</td>
            <td style="border:solid; border-width: thin; padding:0 12px;">{{$areas}}</td>
        </tr>
        @endforeach
    </table>
    <br>
    <div style="background-color:green; color:white; padding-left:5px">Target(s)</div>
    <table width="100%" style="border-collapse: collapse; border: 0px;">
        <tr style="border: 1px solid;">
            <th style="border:solid; border-width: thin; padding:0 12px;" align="left">Name</th>
            <th style="border:solid; border-width: thin; padding:0 12px;" align="left">Nationality</th>
        </tr>
        @foreach ($target as $tr)
        <tr>
            <td style="border:solid; border-width: thin; padding:0 12px;">{{$tr->name}}</td>
            <td style="border:solid; border-width: thin; padding:0 12px;">{{$tr->nationality}}</td>
        </tr>
        @endforeach
    </table>
    <h4 align="center">***** nothing follows *****</h4>
    <div style="margin-right:39px; margin-bottom:40px">Prepared by:</div>
    <div style="margin-right:39px; font-weight: bold;">{{$preops_data[0]->prepared_by}}</div>
    <div style="margin-right:39px;">DUTY, ROC</div>
    <br>
    <div style="padding-left:300px; margin-bottom:40px">Approved by:</div>
    <div style="padding-left:300px; font-weight: bold;">{{$approved_by[0]->name}}</div>
    <div style="padding-left:300px;">REGIONAL DIRECTOR</div>
    <footer >
        {{$date}} | {{Auth::user()->name}} | @if ($preops_data[0]->print_count == 1) O @else C @endif
    </footer>
</body>

</html>