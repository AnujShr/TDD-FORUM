<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */

    public function setUp()
    {
        parent::setUp();
        $this->threads = create('App\Thread');


    }

    /** Thread URL*/
    public function test_a_can_make_a_string_path()
    {
        $thread = create('App\Thread');
        $this->assertEquals(
            "/threads/{$thread->channel->slug}/{$thread->id}", $thread->path());
    }

    /** All thread view */
    public function test_a_user_can_browse_all_threads()
    {
        $response = $this->get('/threads')->assertSee($this->threads->title);
    }

    /** Single Thread*/
    public function test_a_user_can_view_single_thread()
    {
        $response = $this->get($this->threads->path())->assertSee($this->threads->title);
    }

    /** *has replies*/
    public function test_can_read_reply()
    {
        $reply = factory('App\Reply')->create([
            'thread_id' => $this->threads->id
        ]);
        $response = $this->get($this->threads->path())->assertSee($reply->body);


    }

    public function test_user_can_filter_threads_according_to_a_tags()
    {
        $channel = create('App\Channel');
        $threadInChannle = create('App\Thread',['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');
        $this->get('/threads/'.$channel->slug)
            ->assertSee($threadInChannle->title)
            ->assertDontSee($threadNotInChannel->title);
    }
}
