<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Filters\ThreadFilter;
use App\Rules\Recaptcha;
use App\Rules\SpamFree;
use App\Thread;
use App\Trending;

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

    public function store(Recaptcha $recaptcha)
    {
        $rules = [
            'title' => ['required', new SpamFree],
            'channel_id' => 'required|exists:channels,id',
            'body' => ['required', new SpamFree],
            'g-recaptcha-response' => ['required',$recaptcha]

        ];
        $message = [
            'g-recaptcha-response.required' => 'RECAPTCHA VERIFICATION REQUIRED!!!'
        ];
        request()->validate($rules,$message);
        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body')]);
        if (request()->wantsJson()) {
            return response($thread, 201);
        }
        return redirect($thread->path())->with('flash', 'Your Thread Has Been Published!!!');
    }

    public function destroy($channel, Thread $thread)
    {
        $this->authorize('update', $thread);
        $thread->delete();
        if (request()->wantsJson()) {
            return response([], 204);
        }
        return redirect('/threads');
    }

    public function getThreads(Channel $channel, ThreadFilter $filter)
    {
        $threads = Thread::filter($filter)->latest();
        if ($channel->exists) $threads->where('channel_id', $channel->id);
        $threads = $threads->paginate(20);
        return $threads;
    }

}
