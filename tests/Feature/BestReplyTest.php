<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BestReplyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */

    public function test_mark_best_reply_by_thread_creator()
    {
        $this->signIn();
        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $replies = create('App\Reply', ['thread_id' => $thread->id], 2);
        $this->assertFalse($replies[1]->fresh()->isBest());
        $this->postJson(route('best-replies.store', [$replies[1]->id]));
        $this->assertTrue($replies[1]->fresh()->isBest());
    }

    function test_thread_creator_can_mark_reply_as_best()
    {
        $this->withExceptionHandling();

        $this->signIn();
        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $replies = create('App\Reply', ['thread_id' => $thread->id], 2);
        $this->signIn(create('App\User'));
        $this->postJson(route('best-replies.store', [$replies[1]->id]))->assertStatus(403);
        $this->assertFalse($replies[1]->fresh()->isBest());
    }

    function test_a_reply_is_deleted_then_the_thread_is_properly_updated()
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);
        $reply->thread->markBestReply($reply);
        $this->deleteJson(route('replies.destroy', $reply));
        $this->assertNull($reply->thread->fresh()->best_reply_id);
    }
}
