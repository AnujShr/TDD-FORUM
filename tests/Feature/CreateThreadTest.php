<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadTest extends TestCase
{
    use RefreshDatabase;

    function test_guest_can_not_create_threads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $thread = make('App\Thread');

        $this->post('/threads', $thread->toArray());
    }

// Too much of Need to remove  the custom if condiion in handler.php
//    public function test_guest_cannot_see_create_thread_forms()
//    {
//
//        $this->get('/threads/create')->assertRedirect('/login');
//    }

    public function test_authenticated_user_can_create_new_forum_threads()
    {
        $this->signIn();

        $thread = make('App\Thread');

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))->assertSee($thread->title)->assertSee($thread->body);
    }

//    function test_a_thread_requires_a_title(){
//        $this->signIn();
//        $thread = make('App\Thread',['title' =>null]);
//        $this->post('/threads',$thread->toArray())->assertSessionHasErrors('title');
//    }
    function test_authorize_user_can_delete_threads()
    {
        $this->signIn();
        $thread = create('App\Thread', ['user_id' => auth()->user()->id]);
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());
        $response->assertStatus(204);
        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

//    function test_threads_be_deleted_only_who_have_permission()
//    {
//        $this->signIn();
//        $thread = create('App\Thread');
//        $this->delete($thread->path())->assertStatus(403);
//
//
//    }
}
