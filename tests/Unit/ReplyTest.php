<?php

namespace Tests\Unit;

use App\Reply;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_reply_has_an_owner()
    {
        $reply = create('App\Reply');;
        $this->assertInstanceOf('App\User',$reply->owner);
    }
    function test_knows_if_it_was_just_published()
    {
        $reply = create('App\Reply');

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());
    }

    function test_can_detect_all_mentioned_user_in_reply()
    {
     $reply = new Reply([
         'body' => '@JaneDoe wants to talk to @JohnDoe'
     ]);
     $this->assertEquals(['JaneDoe','JohnDoe'], $reply->mentionedUsers());
    }

    function test_wraps_mention_usernames_in_the_body_within_anchor_tags()
    {
        $reply = new Reply(['body' => 'Hello @JaneDoe.']);
            $this->assertEquals('Hello <a href="/profiles/JaneDoe">@JaneDoe</a>.', $reply->body);
    }

    function test_knows_it_is_a_best_reply()
    {
        $reply = create('App\Reply');
        $this->assertFalse($reply->isBest());
        $reply->thread->update(['best_reply_id' => $reply->id ]);
        $this->assertTrue($reply->fresh()->isBest());

    }

    
     
}
