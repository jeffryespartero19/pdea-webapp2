@foreach($data1 as $dt)
<tr class="suspect_info">
    <td hidden><input type="text" class="suspect_id" value="{{ $dt->id }}"></td>
    <td style="width: 150px;">{{$dt->preops_number}}</td>
    <td style="width: 150px;">{{$dt->spot_report_number}}</td>
    <td style="width: 150px;">{{$dt->region_m}}</td>
    <td style="width: 150px;">{{$dt->province_m}}</td>
    <td style="width: 150px;">{{$dt->operation_type}}</td>
    <td style="width: 150px;">{{$dt->operating_unit}}</td>
    <td style="width: 150px;">{{$dt->operation_datetime}}</td>
    <td class="s_name" style="width: 150px;">{{$dt->lastname}}, {{$dt->firstname}} {{$dt->middlename}}</td>
    <td style="width: 150px;">{{$dt->suspect_classification}}</td>
    <td style="width: 150px;">{{$dt->suspect_category}}</td>
    <td style="width: 150px;">{{$dt->status}}</td>
    <td style="width: 150px;">{{$dt->case}}</td>
    <td style="width: 150px;">{{$dt->docket_number}}</td>
    <td style="width: 150px;">{{$dt->case_status}}</td>
</tr>
@endforeach
<tr>
    <td colspan="17" align="center">
        {!! $data1->links() !!}
    </td>
</tr>