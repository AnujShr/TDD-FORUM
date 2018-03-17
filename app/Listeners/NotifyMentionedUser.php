<?php

namespace App\Listeners;

use App\Events\ThreadReceivedNewReply;
use App\Notifications\YouWereMentioned;
use App\User;

class NotifyMentionedUser
{
    /**
     * Handle the event.
     *
     * @param  ThreadReceivedNewReply $event
     * @return void
     */
    public function handle(ThreadReceivedNewReply $event)
    {

//        $mentionedUsers =$event->reply->mentionedUsers();
//        foreach ($mentionedUsers as $name) {
//            $user = User::whereName($name)->first();
//            if ($user) {
//                $user->notify(new YouWereMentioned($event->reply));
//            }
//        }
        User::whereIn('name', $event->reply->mentionedUsers())->get()->each(function ($user) use ($event) {
            $user->notify(new YouWereMentioned($event->reply));
        });

    }
}
