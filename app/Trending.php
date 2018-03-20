<?php
/**
 * Created by PhpStorm.
 * User: VanHellsing
 * Date: 20/03/2018
 * Time: 8:31 PM
 */

namespace App;


use Illuminate\Support\Facades\Redis;

class Trending
{
    public function get()
    {
        return array_map('json_decode', Redis::zrevrange($this->cachKey(), 0, 4));

    }

    public function push($thread)
    {
        Redis::zincrby($this->cachKey(), 1, json_encode(['title' => $thread->title, 'path' => $thread->path()]));

    }

    public function cachKey()
    {
        return app()->environment('testing') ? 'testing_trending_threads' : 'trending_threads';
    }

    public function reset()
    {
        Redis::del($this->cachKey());
    }
}