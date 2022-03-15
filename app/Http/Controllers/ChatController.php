<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;


class ChatController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('chat.chat');
    }

    public function chat_list(Request $request)
    {
        $userX = DB::table('users')->where('id','!=',Auth::user()->id)->get();

        return view('chat/list_user',compact('userX') );
    }

    public function chatting_with(Request $request)
    {
        $data = $request->all();

        $convo_id=DB::table('chat_log')->where('sender_id',Auth::user()->id)->where('reciever_id',$data['chat_this'])->pluck('convo_id');

        $list_convo_ids=DB::table('chat_log')->groupBy('convo_id')->pluck('convo_id');
        $array_len=count($list_convo_ids);


        if(!$convo_id->isEmpty() ){
            $convo_idx=DB::table('chat_log')->where('sender_id',$data['chat_this'])->where('reciever_id',Auth::user()->id)->pluck('convo_id');
            $convo_id=$convo_idx[0];
        }else{
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 11; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }

            for($i=0;!$i<$array_len;$i++){
                if($list_convo_ids[$i]==$randomString){
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $charactersLength = strlen($characters);
                    $randomString = '';
                    for ($i = 0; $i < 11; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                    }
                }
            }

            $convo_id=$randomString;
        }

        DB::table('users')->where('id',Auth::user()->id)->update(
            array(
                'chatting_with'  =>  $data['chat_this'],
                'current_convo_id'  =>  $convo_id,
            )
        );

        return redirect()->back();
    }

    public function msg_pane(Request $request)
    {
        $convo_id =Auth::user()->current_convo_id;

        $userXZ = DB::table('users')->where('id',Auth::user()->id)->get();
        $chatting_with = DB::table('users')->where('id',Auth::user()->chatting_with)->get();

        $messagesX= DB::table('chat_log')->where('convo_id',$convo_id)
                ->orderBy('date_time_sent', 'asc')
                ->take(30)
                ->get();

        return view('chat/msg_pane',compact('userXZ','chatting_with','messagesX') );
    }

    public function send_chat(Request $request)
    {
        $data = $request->all();
        $date = Carbon::now();

        DB::table('chat_log')->insert(
            array(
                'sender_id'       =>  $data['senderX'],
                'reciever_id'     =>  $data['recieverX'],
                'content'         =>  $data['contentX'],
                'date_time_sent'  =>  $date,
                'convo_id'        =>  $data['convo_idX'],
            )
        );

        return redirect()->back();
    }
}
