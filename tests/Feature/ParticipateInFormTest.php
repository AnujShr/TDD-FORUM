<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInForm extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */

    function test_unauthenticated_users_may_not_add_reply()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('/threads/some/1/replies', []);
    }

    public function test_an_authenticated_user_may_participate_in_forum_threads()
    {
        //Given we has an authenticated User

        $this->signIn();
        //And an existing thread
        $thread = create('App\Thread');

        //When the user adds a reply to the thread
        $reply = make('App\Reply');

        $this->post($thread->path() . '/replies', $reply->toArray());

        //Then a thread should be visible on a page
//        $this->get($thread->path())->assertSee($reply->body);
        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
        $this->assertEquals(1, $thread->fresh()->replies_count);
    }

    function test_authorized_user_can_delete_replies()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->delete("/replies/{$reply->id}")->assertStatus(302);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertEquals(0, $reply->thread->fresh()->replies_count);
    }

    function test_authorize_user_can_update_replies()
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);
        $updatedBody = "You have changed fool.";
        $this->patch("/replies/{$reply->id}", ['body' => $updatedBody]);
        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updatedBody]);
    }

    function test_replies_that_contain_spam_may_not_be_created()
    {
        $this->withExceptionHandling()->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => 'fuck']);


        $this->post($thread->path() . '/replies', $reply->toArray())->assertStatus(422);
    }

    function test_users_may_only_reply_a_maximum_of_once_per_minute()
    {
        $this->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply',['body' => 'My simple reply.']);

        $this->post($thread->path() . '/replies', $reply->toArray())->assertStatus(201);

        $this->post($thread->path() . '/replies', $reply->toArray())->assertStatus(422);
    }


}
