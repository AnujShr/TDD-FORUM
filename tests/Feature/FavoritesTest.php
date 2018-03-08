<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoritesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */

    public function test_an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();
        $reply = create('App\Reply');

        $this->post('/replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);
    }

    function test_autheticated_user_can_favorite_only_once()
    {
        $this->signIn();
        $reply = create('App\Reply');
        try {
            $this->post('/replies/' . $reply->id . '/favorites');
            $this->post('/replies/' . $reply->id . '/favorites');
        } catch (\Exception $e) {
            $this->fail('Did not expect to insert same record type');
        }

        $this->assertCount(1, $reply->favorites);
    }

    function test_auth_user_can_unfavorite_reply()
    {
        $this->signIn();
        $reply = create('App\Reply');
        $reply->favorites();
        $this->delete('/replies/' . $reply->id . '/favorites');

        $this->assertCount(0, $reply->favorites);


    }
}
