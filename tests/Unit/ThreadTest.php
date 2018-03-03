<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     *
     */

    public function setUp()
    {
        parent::setUp();
        $this->thread = create('App\Thread');

    }


    /**
     *Thread has a user associated with it
     */
    public function test_thread_has_a_creator()
    {
        $this->assertInstanceOf('App\User', $this->thread->creator);
    }

    public function test_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }


    /**
     * User can reply to a thread
     */
    public function test_thread_can_add_reply()
    {
        $this->thread->addReply(['body' => 'Foobar', 'user_id' => 1]);
        $this->assertCount(1,$this->thread->replies);
    }

    public function test_a_thread_belongs_to_channel()
    {
        $thread = create('App\Thread');
        $this->assertInstanceOf('App\Channel',$thread->channel);
    }
}