<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadLockTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */

    public function test_lock_thread_may_not_recieve_new_reply()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $thread->lock();
        $this->post($thread->path() . '/replies', ['body' => 'Foobar', 'user_id' => create('App\User')->id])->assertStatus(422);
    }

    function test_non_admin_can_lock_any_thread()
    {
        $this->signIn();
        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $this->post(route('locked-threads.store', $thread));
        $this->assertFalse(!!$thread->fresh()->locked);
    }

    function test_admin_can_lock_any_thread()
    {
        $this->signIn(factory('App\User')->states('administrator')->create());
        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $this->post(route('locked-threads.store', $thread));
        $this->assertTrue(!!$thread->fresh()->locked);

    }

}
