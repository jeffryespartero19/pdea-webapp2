@foreach($data as $spot_report)
<tr>
    <td hidden>{{ $spot_report->id }}</td>
    <td>{{ $spot_report->spot_report_number }}</td>
    <td>@if($spot_report->preops_number == 1) Uncoordinated @else {{ $spot_report->preops_number }} @endif</td>
    <td>{{ $spot_report->operating_unit_name }}</td>
    <td>{{ $spot_report->operation_type_name }}</td>
    <td>{{ $spot_report->operation_datetime }}</td>
    <td>{{ $spot_report->created_at }}</td>
    <td>{{ $spot_report->status == 1 ? 'Yes' : 'No' }}</td>
    <td>
        <center>
            <a href="{{ url('spot_report_edit/'.$spot_report->id) }}" class="btn btn-info">Edit</a>
        </center>
    </td>
</tr>
@endforeach
<tr>
    <td colspan="10" align="center">
        {!! $data->links() !!}
    </td>
</tr>