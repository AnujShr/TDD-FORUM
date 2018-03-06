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

    function test_unauthenticated_users_may_not_add_reply(){
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('/threads/some/1/replies', []);
    }

    public function test_an_authenticated_user_may_participate_in_forum_threads()
    {
        //Given we has an authenticated User

        $this->be($user = create('App\User'));

        //And an existing thread
        $thread = create('App\Thread');

        //When the user adds a reply to the thread
        $reply = make('App\Reply');

        $this->post($thread->path().'/replies', $reply->toArray());

        //Then a thread should be visible on a page
        $this->get($thread->path())->assertSee($reply->body);

    }

    function test_authorized_user_can_delete_thread()
    {
        $this->signIn();

        $reply = create('App\Reply',['user_id' => auth()->id()]);

        $this->delete("/replies/{$reply->id}")->assertStatus(302);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }
}
