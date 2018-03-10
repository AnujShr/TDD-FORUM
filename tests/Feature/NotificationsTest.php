<?php

namespace Tests\Feature;

use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->signIn();
    }

    function test_notifactions_is_prepared_when_a_subscribed_thread_receives_a_new_reply_that_is_not_by_current_user()
    {

        $thread = create('App\Thread')->subscribe();
        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply(['user_id' => auth()->id(), 'body' => 'Some reply here']);
        $this->assertCount(0, auth()->user()->fresh()->notifications);

        $thread->addReply(['user_id' => create('App\User')->id, 'body' => 'Some reply here']);
        $this->assertCount(1, auth()->user()->fresh()->notifications);

    }

    function test_can_fetch_their_unread_notifications()
    {
        create(DatabaseNotification::class);
        $this->assertCount(1, $this->getJson("/profiles/'" . auth()->user()->name . "/notifications")->json());
    }


    function test_can_mark_a_notifiation_as_read()
    {

        create(DatabaseNotification::class);
        $user = auth()->user();
        $this->assertCount(1, $user->unreadNotifications);
        $notificationId = $user->unreadNotifications->first()->id;
        $this->delete("/profiles/{$user->name}/notifications/{$notificationId}");

        $this->assertCount(0, $user->fresh()->unreadNotifications);
    }

}
