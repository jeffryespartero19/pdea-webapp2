<table class="table table-dark table-striped">
    <thead>
        <tr>
            <td style="border-bottom:1px solid black; text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20" colspan="10">Ongoing Operations</td>
        </tr>
        <tr>
            <th style="text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20">Operation #</th>
            <th style="text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20">Date Launched</th>
            <th style="text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20">Operating Unit</th>
            <th style="text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20">Contact</th>
            <th style="text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20">Region</th>
            <th style="text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20">Province</th>
            <th style="text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20">City-Municipality</th>
            <th style="text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20">Barangay</th>
            <th style="text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20">UACS Code</th>
            <th style="text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20">Warning Issuance</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ops_details as $opd)
            <?php $x=$loop->index ?>
            <tr>
                <td>{{$opd->preops_number}}</td>
                <td>{{$opd->operation_datetime}}</td>
                <td>
                    @foreach($ops_teams as $op_t)
                        @if($op_t->preops_number == $opd->preops_number)
                            {{$op_t->name}}
                        @endif                       
                    @endforeach
                </td>
                <td>
                    @foreach($ops_teams as $op_t)
                        @if($op_t->preops_number == $opd->preops_number)
                            {{$op_t->contact}}
                        @endif                       
                    @endforeach
                </td>
                <td>@isset($region[0]){{$region[$x]}}@endisset</td>
                            <td>
                                @foreach ($ops_details_area as $opd_a)
                                    @if ($opd->preops_number == $opd_a->preops_number)
                                        @isset($province[0]){{$province[$x]}}@endisset
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach ($ops_details_area as $opd_a)
                                    @if ($opd->preops_number == $opd_a->preops_number)
                                        @isset($city[0]){{$city[$x]}}@endisset
                                    @endif
                                @endforeach    
                            </td>
                            <td>
                                @foreach ($ops_details_area as $opd_a)
                                    @if ($opd->preops_number == $opd_a->preops_number)
                                        @isset($brgy[0]){{$brgy[$x]}}@endisset
                                    @endif
                                @endforeach    
                            </td>
                            <td>
                                @foreach ($ops_details_area as $opd_a)
                                    @if ($opd->preops_number == $opd_a->preops_number)
                                        @if($brgy2[$x]!=0)
                                            @isset($brgy2[0]){{$brgy2[$x]}}@endisset
                                        @else
                                            @isset($city2[0]){{$city2[$x]}}@endisset
                                        @endif
                                    @endif
                                @endforeach 
                            </td>
               
                @if($opd->warning_issuance == 1)
                <td style="text-align: center; background:green; padding:3px;">Issued</td>
                @else 
                <td style="text-align: center; background:salmon; padding:3px;">Not Issued</td>
                @endif
                
            </tr>
        @endforeach
    </tbody>
</table>

<br><br><br>

<table class="table table-dark table-striped">
    <thead>
        <tr>
            <td style="border-bottom:1px solid black; text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20" colspan="10">Pending Operations</td>
        </tr>
        <tr>
            <th style="text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20">Operation #</th>
            <th style="text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20">Date Launched</th>
            <th style="text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20">Operating Unit</th>
            <th style="text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20">Contact</th>
            <th style="text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20">Region</th>
            <th style="text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20">Province</th>
            <th style="text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20">City-Municipality</th>
            <th style="text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20">Barangay</th>
            <th style="text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20">UACS Code</th>
            <th style="text-align: center; font-size:14px; background: cornflowerblue; color:whitesmoke" width="25" height="20">Warning Issuance</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ops_details2 as $opd2)
                    <?php $x2=$loop->index ?>
                        <tr>
                            <td>{{$opd2->preops_number}}</td>
                            <td>{{$opd2->operation_datetime}}</td>
                            <td>
                                @foreach($ops_teams2 as $op_t2)
                                    @if($op_t2->preops_number == $opd2->preops_number)
                                        {{$op_t2->name}}
                                    @endif                       
                                @endforeach
                            </td>
                            <td>
                                @foreach($ops_teams2 as $op_t2)
                                    @if($op_t2->preops_number == $opd2->preops_number)
                                        {{$op_t2->contact}}
                                    @endif                       
                                @endforeach
                            </td>
                            <td>@isset($regionB[0]){{$regionB[$x2]}}@endisset</td>
                            <td>
                                @foreach ($ops_details_area as $opd_a)
                                    @if ($opd->preops_number == $opd_a->preops_number)
                                        @isset($provinceB[0]){{$provinceB[$x2]}}@endisset
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach ($ops_details_area as $opd_a)
                                    @if ($opd->preops_number == $opd_a->preops_number)
                                        @isset($cityB[0]){{$cityB[$x2]}}@endisset
                                    @endif
                                @endforeach    
                            </td>
                            <td>
                                @foreach ($ops_details_area as $opd_a)
                                    @if ($opd->preops_number == $opd_a->preops_number)
                                        @isset($brgyB[0]){{$brgyB[$x2]}}@endisset
                                    @endif
                                @endforeach    
                            </td>
                            <td>
                                @foreach ($ops_details_area as $opd_a)
                                    @if ($opd->preops_number == $opd_a->preops_number)
                                        @if($brgy2B[$x2]!=0)
                                            @isset($brgy2B[0]){{$brgy2B[$x2]}}@endisset
                                        @else
                                            @isset($city2B[0]){{$city2B[$x2]}}@endisset
                                        @endif
                                    @endif
                                @endforeach 
                            </td>
                            @if($opd->warning_issuance == 1)
                            <td style="text-align: center; background:green; padding:3px;">Issued</td>
                            @else 
                            <td style="text-align: center; background:salmon; padding:3px;">Not Issued</td>
                            @endif
                        </tr>
                    @endforeach
    </tbody>
</table>
