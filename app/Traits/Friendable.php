<?php

namespace App\Traits;
use App\Friendships;

trait Friendable
{
    public function addFriend($user_id) {
        $Friendship = Friendships::create([
            'requester' => $this->id,
            'user_requested' => $user_id, 
        ]);
        
        if($Friendship) {

            return $Friendship;
        }
        return 'failed';

    }
    
}