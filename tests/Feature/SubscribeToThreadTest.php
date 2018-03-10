<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscribeToThreadTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */

    public function test_a_user_can_susbscribe_to_threads()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $this->post($thread->path() . '/subscriptions');
        $thread->addReply(['user_id' => auth()->id(), 'body' => 'Some reply here']);
    }

    function test_user_can_unsubscrbe_from_test()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $thread->subscribe();

        $this->delete($thread->path().'/subsriptions');
        $this->assertCount(0,$thread->subscriptions);
    }
}
