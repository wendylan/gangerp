<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
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
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function show()
    {
        $uid = Auth::id();
        $user = \App\User::find($uid);
        $user->unreadNotifications->markAsRead();
        return view("message-center");
    }

    public function msg()
    {
        $uid = Auth::id();
        $list = Message::query()->with('users')->where('to_uid', $uid)->where('is_read', 0)
            ->orderBy('id', 'desc')->get();
        return response()->json($list);
    }


    public function sendmsg(Request $request)
    {
        $rs=\Illuminate\Support\Facades\Event::fire(new \App\Events\NeworderEvent($request->to_uid, $request->msg));
    }

}