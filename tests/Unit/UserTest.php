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
        $reply = create('App\Reply', ['user_id' => $user->id]);
        $this->assertEquals($reply->id, $user->lastReply->id);
    }

    public function test_use_can_determin_avatar_path()
    {
        $user = create('App\User');
        $this->assertEquals(asset('images/default-avatar.png'), $user->avatar_path);
        $user->avatar_path = 'avatars/me.jpeg';
        $this->assertEquals(asset('storage/avatars/me.jpeg'), $user->avatar_path);
    }

}
