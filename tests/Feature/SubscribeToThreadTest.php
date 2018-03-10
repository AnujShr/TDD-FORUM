<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscribeToThreadTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->signIn();
    }

    public function test_a_user_can_susbscribe_to_threads()
    {

        $thread = create('App\Thread');
        $this->post($thread->path() . '/subscriptions');
        $this->assertCount(1, $thread->fresh()->subscriptions);
    }

    function test_user_can_unsubscribe_from_thread()
    {

        $thread = create('App\Thread');
        $thread->subscribe();
        $this->delete($thread->path() . '/subscriptions');
        $this->assertCount(0, $thread->subscriptions);
    }
}
