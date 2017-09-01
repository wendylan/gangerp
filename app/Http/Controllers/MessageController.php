<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
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
}