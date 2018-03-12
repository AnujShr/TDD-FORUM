<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     *
     */
    protected $thread;
    public function setUp()
    {
        parent::setUp();
        $this->thread = create('App\Thread');

    }


    /**
     *Thread has a user associated with it
     */
    public function test_thread_has_a_creator()
    {
        $this->assertInstanceOf('App\User', $this->thread->creator);
    }

    public function test_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }


    /**
     * User can reply to a thread
     */
    public function test_thread_can_add_reply()
    {
        $this->thread->addReply(['body' => 'Foobar', 'user_id' => 1]);
        $this->assertCount(1,$this->thread->replies);
    }

    public function test_a_thread_belongs_to_channel()
    {
        $thread = create('App\Thread');
        $this->assertInstanceOf('App\Channel',$thread->channel);
    }
    function test_a_thread_can_be_subscribed_to()
    {
        $thread = create('App\Thread');
        $thread->subscribe($userId = 1);
        $this->assertEquals(1, $thread->subscriptions()->where('user_id', $userId)->count());
    }

    function test_a_thread_can_be_unsubscribed_from()
    {
        $thread = create('App\Thread');
        $thread->subscribe($userId = 1);
        $thread->unsubscribe($userId = 1);

        $this->assertCount(0, $thread->subscriptions);
    }
    function test_thread_can_check_if_the_authenticated_user_has_read_all_replies()
    {
      $this->signIn();

      $thread = create('App\Thread');

      tap(auth()->user(), function ($user) use ($thread) {
          $this->assertTrue($thread->hasUpdatesFor($user));

          $user->read($thread);

          $this->assertFalse($thread->hasUpdatesFor($user));
      });
  }
}