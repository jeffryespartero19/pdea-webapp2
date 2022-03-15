@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->

<!-- Main content -->
<section class="content" style="padding-top: 20px; padding-bottom:20px">
    <!-- Default box -->
    <center>
        <div class="card card-info" style="width: 60%;">
            <div class="card-body" style="height: 100%">
                <div class="chat-area">
                    <header style="padding:10px">
                        <a href="{{ route('chat_list') }}" class="back-icon"><i class="fa fa-arrow-left"></i></a>
                        <img src="data:image/jpeg;base64,{{ Auth::user()->photo ?? '' }}" onerror=this.src="../../dist/img/profile.png" class="img-circle elevation-2 mt-1" width="30px" height="30px" alt="User Image">
                        <div class="details" style="padding-top: 20px;">
                            <span>Sample</span>
                            <p>Active now</p>
                        </div>
                    </header>
                    <div class="chat-box" style="display: flex; flex-direction: column-reverse;">
                        <div class="chat outgoing">
                            <div class="details">
                                <p>Sample</p>
                            </div>
                        </div>

                        <div class="chat incoming">
                            <div class="details">
                                <p>Sample</p>
                            </div>
                        </div>
                    </div>
                    <form action="#" class="typing-area">
                        <input type="text" id="u_id" name="u_id" value="" hidden>
                        <input type="text" id="contact_id" name="contact_id" value="" hidden>
                        <input type="text" id="message" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
                        <button class="SaveChat" type="submit"><i class="fa fa-paper-plane"></i></button>
                    </form>
                </div>



                <!-- /.card -->
            </div>
        </div>
        <!-- /.card -->
    </center>


</section>
<!-- /.content -->

<!-- Set menu to collapse and active -->
@endsection

@section('scripts')

<style>
    /* Chat Area CSS Start */

    .chat-area header {
        display: flex;
        align-items: center;
        padding: 18px 30px;
    }

    .chat-area header .back-icon {
        color: #333;
        font-size: 18px;
    }

    .chat-area header img {
        height: 45px;
        width: 45px;
        margin: 0 15px;
    }

    .chat-area header .details span {
        font-size: 17px;
        font-weight: 500;
    }

    .chat-box {
        position: relative;
        min-height: 60vh;
        max-height: 60vh;
        overflow-y: auto;
        padding: 10px 30px 20px 30px;
        background: #f7f7f7;
        box-shadow: inset 0 32px 32px -32px rgb(0 0 0 / 5%), inset 0 -32px 32px -32px rgb(0 0 0 / 5%);
    }

    .chat-box .text {
        position: absolute;
        top: 45%;
        left: 50%;
        width: calc(100% - 50px);
        text-align: center;
        transform: translate(-50%, -50%);
    }

    .chat-box .chat {
        margin: 15px 0;
    }

    .chat-box .chat p {
        word-wrap: break-word;
        padding: 8px 16px;
        box-shadow: 0 0 32px rgb(0 0 0 / 8%), 0rem 16px 16px -16px rgb(0 0 0 / 10%);
    }

    .chat-box .outgoing {
        display: flex;
    }

    .chat-box .outgoing .details {
        margin-left: auto;
        max-width: calc(100% - 130px);
    }

    .outgoing .details p {
        background: #333;
        color: #fff;
        border-radius: 18px 18px 0 18px;
    }

    .chat-box .incoming {
        display: flex;
        align-items: flex-end;
    }

    .chat-box .incoming img {
        height: 35px;
        width: 35px;
    }

    .chat-box .incoming .details {
        margin-right: auto;
        margin-left: 10px;
        max-width: calc(100% - 130px);
    }

    .incoming .details p {
        background: #fff;
        color: #333;
        border-radius: 18px 18px 18px 0;
    }

    .typing-area {
        padding: 18px 30px;
        display: flex;
        justify-content: space-between;
    }

    .typing-area input {
        height: 45px;
        width: calc(100% - 58px);
        font-size: 16px;
        padding: 0 13px;
        border: 1px solid #e6e6e6;
        outline: none;
        border-radius: 5px 0 0 5px;
    }

    .typing-area button {
        color: #fff;
        width: 55px;
        border: none;
        outline: none;
        background: #333;
        font-size: 19px;
        cursor: pointer;
        opacity: 0.7;
        pointer-events: none;
        border-radius: 0 5px 5px 0;
        transition: all 0.3s ease;
    }

    .typing-area button.active {
        opacity: 1;
        pointer-events: auto;
    }
</style>


@endsection