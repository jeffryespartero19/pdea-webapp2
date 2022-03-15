<!-- jQuery -->
<meta http-equiv="refresh" content="60">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/c_gl.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="{{ asset('/js/chatX.js') }}" defer></script>

<script type="text/javascript">
    ;(function () {
        var reloads = [200, 200],
            storageKey = 'reloadIndex',
            reloadIndex = parseInt(localStorage.getItem(storageKey), 10) || 0;

        if (reloadIndex >= reloads.length || isNaN(reloadIndex)) {
            localStorage.removeItem(storageKey);
            return;
        }

        setTimeout(function(){
            window.location.reload();
        }, reloads[reloadIndex]);

        localStorage.setItem(storageKey, parseInt(reloadIndex, 10) + 2);
    }());
</script>

<div class="pane_header">
    <table class="c_table">
        @isset($chatting_with)
            @foreach($chatting_with as $cx)
            <tr class="usr_row">
                <td style="width: 10%;">
                    <img src="data:image/jpeg;base64,{{ Auth::user()->photo ?? '' }}" onerror=this.src="../../dist/img/profile.png" class="img-circle elevation-2 mt-1" width="25px" height="25px" alt="User Image">
                </td>
                <td>{{$cx->name}}</td>
                <td class="txtCtr width10"><button class="ref_pane"><i class="fa fa-refresh" aria-hidden="true"></i></button></td>
                <td class="txtCtr width10"><button class="close_pane"><i class="fa fa-times" aria-hidden="true"></i></button></td>
            </tr>
            @endforeach
        @endisset
    </table>
</div>

<div class="pane_body">
    @foreach($messagesX as $mx)
        @if($mx->sender_id == Auth::user()->id)
        <div class="flexer one_hundered flex_right marg_bt6">
            <div class="msg_bubble_right">
                <u style="margin-bottom:5px;">Me: </u><br>
                {{$mx->content}}
            </div>
        </div>
        @else
        <div class="flexer one_hundered marg_bt6">
            <div class="msg_bubble_left">
                <u style="margin-bottom:5px;">{{$chatting_with[0]->name}}: </u><br>
                {{$mx->content}}
            </div>
        </div>
        @endif
    @endforeach
</div>

<form id="chatX_form" method="POST" action="{{ route('send_chat') }}" autocomplete="off" enctype="multipart/form-data">@csrf 
<input name="senderX" value="{{$userXZ[0]->id}}" hidden>
<input name="recieverX" value="{{$chatting_with[0]->id}}" hidden>
<input name="convo_idX" value="{{$userXZ[0]->current_convo_id}}" hidden>
<div class="pane_footer">
    
    <div class="flexer">
        <textarea name="contentX" class="contentX"></textarea>
        <button class="senderX">Send</button>
    </div>
    
</div>
</form>