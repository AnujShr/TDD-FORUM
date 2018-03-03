<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;

class ReplyController extends Controller
{
    /**
     * @param Thread $thread
     */

    public function __construct(){
        $this->middleware('auth');
    }
    public function store(Thread $thread, Request $request)
    {
        $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);
        return back();
    }
}
