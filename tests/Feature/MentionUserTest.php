<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MentionUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return voidphp
     *
     */

    public function test_mention_users_in__reply_are_notified()
    {
        $john = create('App\User', ['name' => 'JohnDoe']);
        $this->signIn($john);
        $jane = create('App\User', ['name' => 'JaneDoe']);
        $thread = create('App\Thread');
        $reply = make('App\Reply',[
            'body' => '@JaneDoe look at this. Also @FranDoe'
        ]);
        $this->json('post',$thread->path() . '/replies', $reply->toArray());
        $this->assertCount(1, $jane->notifications);

    }
}
