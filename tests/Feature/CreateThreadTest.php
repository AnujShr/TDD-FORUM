<?php

namespace Tests\Feature;

use App\Thread;
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

        $this->post(route('threads'), $thread->toArray());
    }

    public function test_guest_cannot_see_create_thread_forms()
    {
        $this->withExceptionHandling();
        $this->get('/threads/create')->assertRedirect(route('login'));
    }

    public function test_a_user_can_create_new_forum_threads()
    {
        $this->signIn();

        $thread = make('App\Thread');

        $response = $this->post(route('threads'), $thread->toArray());

        $this->get($response->headers->get('Location'))->assertSee($thread->title)->assertSee($thread->body);
    }

    function test_a_thread_requires_a_title()
    {
        $this->withExceptionHandling()->signIn();
        $thread = make('App\Thread', ['title' => null]);
        $this->post(route('threads', $thread->toArray()))->assertSessionHasErrors('title');
    }

    function test_authorize_user_can_delete_threads()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->user()->id]);
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());
        $response->assertStatus(204);
        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertDatabaseMissing('activities', ['subject_id' => $thread->id, 'subject_body' => get_class($thread)]);
    }

    function test_threads_be_deleted_only_who_have_permission()
    {
        $this->withExceptionHandling()->signIn();
        $thread = create('App\Thread');
        $this->delete($thread->path())->assertStatus(403);


    }

    function test_users_must_confirm_their_email_address_before_creating_threads()
    {
        $user = factory('App\User')->states('unconfirmed')->create();
        $this->signIn($user);
        $thread = make('App\Thread');
        $this->post(route('threads'), $thread->toArray())->assertRedirect(route('threads'))->assertSessionHas('flash', 'You must first confirm email address');
    }

    protected function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();
        $thread = make('App\Thread', $overrides);
        return $this->post(route('threads'), $thread->toArray());
    }

    function test_slug_need_to_be_unique()
    {
        $this->signIn();
        $thread = create('App\Thread',['title' => 'Foo Title']);
        $this->assertEquals($thread->fresh()->slug,'foo-title');
        $thread = $this->postJson(route('threads'), $thread->toArray())->json();
        $this->assertEquals("foo-title-{$thread['id']}", $thread['slug']);
    }

    function test_thread_with_a_number_title()
    {
        $this->signIn();
        $thread = create('App\Thread',['title' => 'Some Title 24']);
        $thread = $this->postJson(route('threads'), $thread->toArray())->json();
        $this->assertTrue(Thread::whereSlug("some-title-24-{$thread['id']}")->exists());
    }
}

