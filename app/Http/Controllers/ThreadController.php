<?php

namespace App\Http\Controllers;

use App\Channel;
use Illuminate\Http\Request;
use App\Thread;

class ThreadController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth')->only('store');
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * @param null $channelSlug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Channel $channel)
    {
        if ($channel->exists) {
            $threads = $channel->threads()->latest()->get();

        } else
            $threads = Thread::latest()->get();

        return view('threads.index', compact('threads'));
    }

    /**
     * @param $channel_id
     * @param Thread $thread
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($channel_id, Thread $thread)
    {
        return view('threads.show', compact('thread'));
    }

    public function store(Request $request)
    {
        $this->validate($request, ['title' => 'required', 'channel_id' => 'required|exists:channels,id', 'body' => 'required']);
        $thread = Thread::create(['user_id' => auth()->id(), 'channel_id' => request('channel_id'), 'title' => request('title'), 'body' => request('body')]);

        return redirect($thread->path());
    }

    public function create()
    {
        return view('threads.create');
    }
}
