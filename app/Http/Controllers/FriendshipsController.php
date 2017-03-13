<?php

namespace App\Http\Controllers;

use App\Notifications\NewFriend;
use App\Notifications\NewFriendRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendshipsController extends Controller
{
    public function check($id)
    {
        if(Auth::user()->is_friends_with($id)) {
            return ['status' => 'friends'];
        }

        if(Auth::user()->has_pending_friend_requests_from($id)){
            return ['status' => 'pending'];
        }

        if(Auth::user()->has_pending_friend_requests_sent_to($id)){
            return ['status' => 'waiting'];
        }

        return ['status' => false];
    }

    public function add_friend($id)
    {
        $resp = Auth::user()->add_friend($id);

        User::find($id)->notify(new NewFriendRequest(Auth::user()));

        return $resp;
    }

    public function accept_friend($id)
    {
        return Auth::user()->accept_friend($id);
    }
}
