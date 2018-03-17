<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Reply;
use App\Rules\SpamFree;
use App\Thread;

class ReplyController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);

    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(5);
    }

    public function store($channelId, Thread $thread, CreatePostRequest $form)
    {
            //check authorize in formrequest

        return $thread->addReply(['body' => request('body'), 'user_id' => auth()->id()])->load('owner');
    }

    public function update(Reply $reply)
    {
            $this->authorize('update', $reply);

            request()->validate(['body' => ['required', new SpamFree]]);
            $reply->update(request((['body'])));

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
