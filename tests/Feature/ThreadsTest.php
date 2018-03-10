<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadsTest extends TestCase
{
    use RefreshDatabase;

    protected $threads;

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
        $threadwithTwoReplies = create('App\Thread');
        $this->assertEquals("/threads/{$threadwithTwoReplies->channel->slug}/{$threadwithTwoReplies->id}", $threadwithTwoReplies->path());
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
        $reply = factory('App\Reply')->create(['thread_id' => $this->threads->id]);
        $response = $this->get($this->threads->path())->assertSee($reply->body);


    }

    public function test_user_can_filter_threads_according_to_a_tags()
    {
        $channel = create('App\Channel');
        $threadInChannle = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');
        $this->get('/threads/' . $channel->slug)->assertSee($threadInChannle->title)->assertDontSee($threadNotInChannel->title);
    }

    public function test_user_can_filter_threads_by_user_name()
    {
        $this->signIn(create('App\User', ['name' => 'John Doe']));

        $threadByJohn = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotByJohn = create('App\Thread');

        $this->get('threads/?by=John Doe')->assertSee($threadByJohn->title)->assertDontSee($threadNotByJohn->title);
    }

    function test_user_can_filter_thread_by_popular()
    {
        $threadwithTwoReplies = create('App\Thread');
        $reply = create('App\Reply', ['thread_id' => $threadwithTwoReplies->id], 2);

        $threadwiththreeReplies = create('App\Thread');
        $reply = create('App\Reply', ['thread_id' => $threadwiththreeReplies->id], 3);

        $threadwithNoReplies = $this->threads;

        $response = $this->getJson('threads/?popular=1')->json();

        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }

    function test_user_can_request_all_replies_for_a_given_thread()
    {
        $thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $thread->id], 2);

        $response = $this->getJson($thread->path() . '/replies')->json();
        $this->assertCount(1, $response['data']);
    }
}
