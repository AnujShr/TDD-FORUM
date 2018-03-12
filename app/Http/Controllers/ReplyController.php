<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Inspections\Spam;
use Illuminate\Http\Request;
use App\Thread;

class ReplyController extends Controller
{
    /**
     * @param Thread $thread
     */

    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);

    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(5);
    }

    /**
     * @param $channelId
     * @param Thread $thread
     * @param Spam $spam
     * @return \Illuminate\Http\RedirectResponse
     * @internal param Request $request
     */
    public function store($channelId, Thread $thread, Spam $spam)
    {
        $this->validate(request(), ['body' => 'required']);

        $spam->detect(request('body'));
        $reply = $thread->addReply(['body' => request('body'), 'user_id' => auth()->id()]);

        if (request()->expectsJson()) {
            return $reply->load('owner');
        }
        return back()->with('flash', 'Your reply has been left!!!');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);
        $reply->update(request(['body']));

    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);
        $reply->delete();
        if (request()->expectsJson()) {
            return response(['status' => 'Reply Deleted']);
        }
        return back();
    }


}
