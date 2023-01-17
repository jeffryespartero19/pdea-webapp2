@foreach($data as $preops_header)
<tr>
    <td hidden>{{ $preops_header->id }}</td>
    <td>{{ $preops_header->preops_number }}</td>
    <td>{{ $preops_header->operating_unit }}</td>
    <td>{{ $preops_header->operation_type }}</td>
    <td>{{ $preops_header->operation_datetime }}</td>
    <td>
        <?php date_default_timezone_set('Asia/Manila'); ?>
        @if($preops_header->validity < date("Y-m-d H:i:s")) No @elseif($preops_header->validity > date("Y-m-d H:i:s") && $preops_header->operation_datetime > date("Y-m-d H:i:s")) Pending
            @elseif($preops_header->validity > date("Y-m-d H:i:s") && $preops_header->operation_datetime < date("Y-m-d H:i:s")) Yes @endif </td>
    <td>@if($preops_header->validity < date("Y-m-d H:i:s") && $preops_header->with_aor == 0 && $preops_header->with_sr == 0) 1 @else 0 @endif</td>
    <td>{{ $preops_header->with_aor }}</td>
    <td>{{ $preops_header->with_sr }}</td>
    <td>{{ $preops_header->with_pr }}</td>
    <td>
        <center>
            <a href="{{ url('issuance_of_preops_edit/'.$preops_header->id) }}" class="btn btn-info">Edit</a>
        </center>
    </td>
</tr>
@endforeach
<tr>
    <td colspan="10" align="center">
        {!! $data->links() !!}
    </td>
</tr>