<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReplyTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_reply_has_an_owner()
    {
        $reply = create('App\Reply');;
        $this->assertInstanceOf('App\User',$reply->owner);
    }
}
