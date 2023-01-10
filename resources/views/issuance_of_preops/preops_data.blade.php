<table id="example_info" class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th hidden>ID</th>
            <th>Pre-Ops Number</th>
            <th>Operating Unit</th>
            <th>Operation Type</th>
            <th>Operation Date</th>
            <th>Active</th>
            <th>Expire COC</th>
            <th>With AOR</th>
            <th>Spot Only</th>
            <th>With Progress</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody id="preops_list">
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
            <td>{{ $preops_header->report_status }}</td>
            <td>
                <center>
                    <a href="{{ url('issuance_of_preops_edit/'.$preops_header->id) }}" class="btn btn-info">Edit</a>
                </center>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<span class="pagination">{{ $data->links() }}</span>