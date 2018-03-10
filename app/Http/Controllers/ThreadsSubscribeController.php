<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;


class ThreadsSubscribeController extends Controller
{
public function __construct(){
    $this->middleware('auth',['except'=>'index']);
}
    public function store($channelId, Thread $thread)
    {
        $thread->subscribe();
    }

    public function destroy($channelId,Thread $thread)
    {
        $thread->unsubscribe();
    }
}