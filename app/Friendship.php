<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    /**
     * @var array $fillable
     */
    protected $fillable = [
        'requester', 'user_requested', 'status'
    ];

}
