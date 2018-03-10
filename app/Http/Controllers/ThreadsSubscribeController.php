<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;


class ThreadsSubscribeController extends Controller
{
    public function store($channelId, Thread $thread)
    {
        $thread->subscribe();
    }
}