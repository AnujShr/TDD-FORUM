<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Filters\ThreadFilter;
use App\Rules\SpamFree;
use App\Thread;
use App\Trending;
use Illuminate\Support\Facades\Redis;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Channel $channel, ThreadFilter $filter, Trending $trending)
    {
        $threads = $this->getThreads($channel, $filter);

        if (request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index', ['threads' => $threads, 'trending' => $trending->get()]);

    }

    public function create()
    {
        return view('threads.create');
    }

    public function show($channel, Thread $thread, Trending $trending)
    {
        if (auth()->check()) {
            auth()->user()->read($thread);
        }
        $trending->push($thread);
        $thread->recordVisit();
        return view('threads.show', compact('thread'));
    }

    public function store()
    {
//        dd(auth()->user());

        request()->validate(['title' => ['required', new SpamFree], 'channel_id' => 'required|exists:channels,id', 'body' => ['required', new SpamFree]]);

        $thread = Thread::create(['user_id' => auth()->id(), 'channel_id' => request('channel_id'),
            'title' => request('title'),
            'slug'=>request('title'),
            'body' => request('body')]);

        return redirect($thread->path())->with('flash', 'Your Thread Has Been Published!!!');
    }

    public function destroy($channel, Thread $thread)
    {
        $this->authorize('update', $thread);
        if ($thread->user_id != auth()->id()) {
            abort(403, 'YOU DO NOT HAVE PERMISSION ');
        }
        $thread->delete();
        if (request()->wantsJson()) return response([], 204); else return redirect('/threads');
    }

    public function getThreads(Channel $channel, ThreadFilter $filter)
    {
        $threads = Thread::filter($filter)->latest();
        if ($channel->exists) $threads->where('channel_id', $channel->id);
        $threads = $threads->paginate(20);
        return $threads;
    }

}
