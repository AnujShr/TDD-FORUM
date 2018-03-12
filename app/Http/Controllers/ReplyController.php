<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Rules\SpamFree;
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
     * @return \Illuminate\Http\RedirectResponse
     * @internal param Request $request
     */
    public function store($channelId, Thread $thread)
    {
        try {
            request()->validate(['body' => ['required',new SpamFree]]);
            $reply = $thread->addReply(['body' => request('body'), 'user_id' => auth()->id()]);
        } catch (\Exception $e) {
            return response('Sorry, your reply could not be save at this time.', 422);
        }
        return $reply->load('owner');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);
        try {
            request()->validate(['body' => ['required',new SpamFree]]);
            $reply->update(request((['body'])));
        } catch (\Exception $e) {
            return response('Sorry, your reply could not be save at this time.', 422);

        }
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
