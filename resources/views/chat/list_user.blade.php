<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/c_gl.css') }}">
<script src="{{ asset('/js/chatX.js') }}" defer></script>
<table class="c_table">
    @isset($userX)
        @foreach($userX as $ux)
        <tr class="usr_row">
            <td style="width: 10%;">
                <img src="data:image/jpeg;base64,{{ Auth::user()->photo ?? '' }}" onerror=this.src="../../dist/img/profile.png" class="img-circle elevation-2 mt-1" width="25px" height="25px" alt="User Image">
            </td>
            <td class="chat_person"><input value="{{$ux->id}}" hidden>{{$ux->name}}</td>
        </tr>
        @endforeach
    @endisset
</table>
<form id="chat_this_form" method="POST" action="{{ route('chatting_with') }}" autocomplete="off" enctype="multipart/form-data">@csrf
    <input id="chat_this" value="" name="chat_this" hidden>
</form>