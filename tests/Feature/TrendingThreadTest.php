<?php

namespace Tests\Feature;

use App\Trending;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrendingThreadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();
        $this->trending = new Trending();
        $this->trending->reset();
    }

    public function test_increments_trending_thread_as_it_read()
    {
        $this->assertEmpty($this->trending->get());

        $thread = create('App\Thread');

        $this->call('GET', $thread->path());

        $this->assertCount(1, $trending = $this->trending->get());
        $this->assertEquals($thread->title, $trending[0]->title);
    }


}
