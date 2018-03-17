<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_fetch_most_recent_reply()
    {
        $user = create('App\User');
        $reply = create('App\Reply',['user_id' => $user->id]);
        $this->assertEquals($reply->id,$user->lastReply->id);
    }
}
