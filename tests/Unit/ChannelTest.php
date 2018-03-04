<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChannelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */

    public function test_channel_consists_of_threads()
    {
        $channel = create('App\Channel');
        $thread = create('App\Thread',['channel_id' => $channel->id]);
        $this->assertTrue($channel->threads->contains($thread));
    }
}
