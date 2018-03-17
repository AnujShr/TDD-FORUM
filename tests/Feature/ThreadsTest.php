<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Notification;
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


    public function test_user_can_filter_threads_according_to_a_channel()
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

    function test_can_filter_by_unanswered()
    {
        $thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->getJson('threads?unanswered=1')->json();
        $this->assertCount(1, $response['data']);
    }
    function test_user_can_filter_thread_by_popular()
    {
        $threadwithTwoReplies = create('App\Thread');
        $reply = create('App\Reply', ['thread_id' => $threadwithTwoReplies->id], 2);

        $threadwiththreeReplies = create('App\Thread');
        $reply = create('App\Reply', ['thread_id' => $threadwiththreeReplies->id], 3);

        $threadwithNoReplies = $this->threads;

        $response = $this->getJson('threads/?popular=1')->json();

        $this->assertEquals([3, 2, 0], array_column($response['data'], 'replies_count'));
    }

    function test_user_can_request_all_replies_for_a_given_thread()
    {
        $thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $thread->id], 2);

        $response = $this->getJson($thread->path() . '/replies')->json();
        $this->assertCount(2, $response['data']);
    }

    function test_thread_knows_it_is_subscribed_by_authenticated_user()
    {
        $thread = create('App\Thread');
        $this->signIn();
        $this->assertFalse($thread->isSubscribedTo);

        $thread->subscribe();
        $this->assertTrue($thread->isSubscribedTo);
    }
//    function test_notifies_all_registered_subscribers_when_a_reply_is_added()
//    {
//        Notification::fake();
//        $this->signIn()->threads->subscribe();
//        $this->threads->addReply(['body' => 'Foobar', 'user_id' => 1]);
//
//        Notification::assertSentTo(auth()->user(),ThreadWasUpdated::class);
//    }


}
