<?php

namespace App\Policies;

use App\Reply;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @param User $user
     * @param Reply $reply
     * @return void
     */
    public function update(User $user, Reply $reply)
    {
        return $reply->user_id = $user->id;
    }
}
