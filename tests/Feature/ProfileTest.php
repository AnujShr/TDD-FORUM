<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_has_profile()
    {
        $user = create('App\User');
        $this->get("/profiles/{$user->name}")->assertSee($user->name);
    }

    function test_profile_display_all_threads_created_by_associated_users()
    {
        $user = create('App\User');
        $thread = create('App\Thread', ['user_id' => $user->id]);
        $this->get("/profiles/{$user->name}")->assertSee($thread->title)->assertSee($thread->body);
    }
}
