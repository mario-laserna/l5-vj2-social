<?php

namespace App\Traits;
use App\Friendship;
use Illuminate\Http\Response;

trait Friendable
{
    public function add_friend($user_requested_id)
    {
        $friendship = Friendship::create([
            'requester' => $this->id,
            'user_requested' => $user_requested_id
        ]);

        if($friendship) {
            return response()->json($friendship, 200);
        }

        return response()->json('fail', 501);
    }

    public function accept_friend($requester)
    {
        $friendship = Friendship::where('requester', $requester)
            ->where('user_requested', $this->id)
            ->first();

        if($friendship) {
            $friendship->update([
               'status' => true
            ]);

            return response()->json('ok', 200);
        }

        return response()->json('fail', 501);
    }
}