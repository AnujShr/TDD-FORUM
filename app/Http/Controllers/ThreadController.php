<?php

namespace App\Http\Controllers;

use App\Channel;
//use App\User;
use App\Filters\ThreadFilter;
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
     * @param Channel $channel
     * @param ThreadFilter $filter
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @internal param null $channelSlug
     */
    public function index(Channel $channel, ThreadFilter $filter)
    {
        $threads = $this->getThreads($channel, $filter);

        if (request()->wantsJson()) {
            return $threads;
        }
        return view('threads.index', compact('threads'));
    }

    /**
     * @param $channel_id
     * @param Thread $thread
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($channel_id, Thread $thread)
    {
        return view('threads.show', ['thread' => $thread, 'replies' => $thread->replies()->paginate(20)]);
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


    /**
     * @param Channel $channel
     * @param ThreadFilter $filter
     * @return mixed
     */
    public function getThreads(Channel $channel, ThreadFilter $filter)
    {
        $threads = Thread::with('channel')->filter($filter)->latest();
        if ($channel->exists) $threads->where('channel_id', $channel->id);
        $threads = $threads->get();
        return $threads;
    }
}
