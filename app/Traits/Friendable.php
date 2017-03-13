<?php

namespace App\Traits;
use App\Friendship;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

trait Friendable
{
    public function add_friend($user_requested_id)
    {
        if($this->id === $user_requested_id) {
            return false;
        }

        if($this->has_pending_friend_requests_sent_to($user_requested_id)){
            return 'Already sent a friends request';
        }

        if($this->has_pending_friend_requests_from($user_requested_id)){
            return $this->accept_friend($user_requested_id);
        }

        $friendship = Friendship::create([
            'requester' => $this->id,
            'user_requested' => $user_requested_id
        ]);

        if($friendship) {
            return true;
        }

        return false;
    }

    public function accept_friend($requester)
    {
        if(!$this->has_pending_friend_requests_from($requester)){
            return false;
        }

        $friendship = Friendship::where('requester', $requester)
            ->where('user_requested', $this->id)
            ->first();

        if($friendship) {
            $friendship->update([
               'status' => true
            ]);

            return 'true';
        }

        return 'false';
    }

    public function friends()
    {
        $friends = array();

        $f1 = Friendship::where('status', true)
            ->where('requester', $this->id)
            ->get();

        foreach ($f1 as $friendship)
        {
            array_push($friends, User::find($friendship->user_requested));
        }

        $friends2 = array();

        $f2 = Friendship::where('status', true)
            ->where('user_requested', $this->id)
            ->get();

        foreach ($f2 as $friendship)
        {
            array_push($friends2, User::find($friendship->requester));
        }

        return array_merge($friends, $friends2);
    }

    public function pending_friend_requests()
    {
        $users = array();

        $friendships = Friendship::where('status', false)
            ->where('user_requested', $this->id)
            ->get();

        foreach ($friendships as $friendship)
        {
            array_push($users, User::find($friendship->requester));
        }

        return $users;
    }

    public function friends_ids()
    {
        return collect($this->friends())->pluck('id')->toArray();
    }

    public function is_friends_with($user_id)
    {
        if(in_array($user_id, $this->friends_ids())){
            return true;
        }

        return false;
    }

    public function pending_friend_requests_ids()
    {
        return collect($this->pending_friend_requests())->pluck('id')->toArray();
    }

    public function pending_friend_requests_sent()
    {
        $users = array();

        $friendships = Friendship::where('status', false)
            ->where('requester', $this->id)
            ->get();

        foreach ($friendships as $friendship)
        {
            array_push($users, User::find($friendship->user_requested));
        }

        return $users;
    }

    public function pending_friend_requests_sent_ids()
    {
        return collect($this->pending_friend_requests_sent())->pluck('id')->toArray();
    }

    public function has_pending_friend_requests_from($user_id)
    {
        if(in_array($user_id, $this->pending_friend_requests_ids())) {
            return true;
        }

        return false;
    }

    public function has_pending_friend_requests_sent_to($user_id)
    {
        if(in_array($user_id, $this->pending_friend_requests_sent_ids())) {
            return true;
        }

        return false;
    }
}