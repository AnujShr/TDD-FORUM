<?php

namespace App;


use Illuminate\Support\Facades\Redis;

trait RecordVisits
{

    public function recordVisit()
    {
        Redis::incr($this->visitCacheKey());
        return $this;
    }

    public function visits()
    {
        return Redis::get($this->visitCacheKey()) ?? 0;
    }

    public function resetVisit()
    {
        Redis::del($this->visitCacheKey());
        return $this;
    }

    /**
     * @return string
     */
    public function visitCacheKey(): string
    {
        return "threads.{$this->id}.vists";
    }
}