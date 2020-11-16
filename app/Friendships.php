<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friendships extends Model
{
    public $timestamps = false;
    protected $fillable = ['requester', 'user_requested', 'status'];
}
