<table class="table table-dark table-striped">
    <thead>
        <tr>
            <th style="text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20">Operation #</th>
            <th style="text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20">Date Launched</th>
            <th style="text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20">Operating Unit</th>
            <th style="text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20">Contact</th>
            <th style="text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20">Region</th>
            <th style="text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20">Province</th>
            <th style="text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20">City-Municipality</th>
            <th style="text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20">Barangay</th>
            <th style="text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20">Status</th>
            <th style="text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20">Warning Issuance</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ops_details as $opd)
            <tr>
                <td>{{$opd->preops_number}}</td>
                <td>{{$opd->operation_datetime}}</td>
                <td>
                    @foreach($ops_teams as $op_t)
                        @if($op_t->id == $opd->operating_unit_id)
                            {{$op_t->name}}
                        @endif                       
                    @endforeach
                </td>
                <td>
                    @foreach($ops_teams as $op_t)
                        @if($op_t->id == $opd->operating_unit_id)
                            {{$op_t->contact}}
                        @endif                       
                    @endforeach
                </td>
                <td>@isset($region[0]){{$region[0]}}@endisset</td>
                <td>
                    @foreach ($ops_details_area as $opd_a)
                        @if ($opd->preops_number == $opd_a->preops_number)
                            @isset($province[0]){{$province[0]}}@endisset
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach ($ops_details_area as $opd_a)
                        @if ($opd->preops_number == $opd_a->preops_number)
                            @isset($city[0]){{$city[0]}}@endisset
                        @endif
                    @endforeach    
                </td>
                <td>
                    @foreach ($ops_details_area as $opd_a)
                        @if ($opd->preops_number == $opd_a->preops_number)
                            @isset($brgy[0]){{$brgy[0]}}@endisset
                        @endif
                    @endforeach    
                </td>
                <td>{{$opd->status}}</td>
               
                @if($opd->warning_issuance == 1)
                <td style="text-align: center; background:green; padding:3px;">Issued</td>
                @else 
                <td style="text-align: center; background:salmon; padding:3px;">Not Issued</td>
                @endif
                
            </tr>
        @endforeach
    </tbody>
</table>