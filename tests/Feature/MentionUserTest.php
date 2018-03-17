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
        $reply = make('App\Reply', ['body' => '@JaneDoe look at this. Also @FranDoe']);
        $this->json('post', $thread->path() . '/replies', $reply->toArray());
        $this->assertCount(1, $jane->notifications);

    }

    function test_can_fetch_all_mentioned_users_starting_with_the_given_charavters()
    {
        create('App\User', ['name' => 'JohnDoe']);
        create('App\User', ['name' => 'JohnDoeq1']);
        create('App\User', ['name' => 'JaneDoe2']);
        $results = $this->json('GET', '/api/users', ['name' => 'john']);
        $this->assertCount(2, $results->json());
    }
}
