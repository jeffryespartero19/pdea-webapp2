@foreach($data as $barangay)
<tr>
    <td>{{ $barangay->barangay_c }}</td>
    <td>{{ $barangay->barangay_m }}</td>
    <td>{{ $barangay->city_m }}</td>
    <td><b>{{ $barangay->status == 1 ? 'YES' : 'NO' }}</b></td>
    <td>
        <center>
            <a href="{{ url('barangay_edit/'.$barangay->id) }}" class="btn btn-info">Edit</a>
        </center>
    </td>
</tr>
@endforeach
<tr>
    <td colspan="5" align="center">
        {!! $data->links() !!}
    </td>
</tr>