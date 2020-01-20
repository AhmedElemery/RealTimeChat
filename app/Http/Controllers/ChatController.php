<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Message;
use App\Events\ChatEvent;
use Auth;
use Input;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function Chat()
    {
        return view('chat');
    }

    public function Send(Request $request)
    {
        $user = User::find(Auth::id());
        $this->saveMessage($request);
        event(new ChatEvent($request->message , $user));
    }

    
    public function saveMessage(request $request)
    {
        session()->put('chat', $request->chat);
    }

    public function getOldMessage()
    {
        return session('chat');
    }
}
