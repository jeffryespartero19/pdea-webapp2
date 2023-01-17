@foreach($data as $preops_header)
<tr>
    <td hidden>{{ $preops_header->id }}</td>
    <td>{{ $preops_header->preops_number }}</td>
    <td>{{ $preops_header->operating_unit_name }}</td>
    <td>{{ $preops_header->operation_type_name }}</td>
    <td>{{ $preops_header->operation_datetime }}</td>
    <td>{{ $preops_header->aor_date }}</td>
    <td>{{ $preops_header->status == 1 ? 'Yes' : 'No' }}</td>
    <td>
        <center>
            <a href="{{ url('after_operation_report_edit/'.$preops_header->preops_number) }}" class="btn btn-info">Edit</a>
        </center>
    </td>
</tr>
@endforeach
<tr>
    <td colspan="10" align="center">
        {!! $data->links() !!}
    </td>
</tr>