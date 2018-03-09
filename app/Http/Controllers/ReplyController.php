<?php

namespace App\Http\Controllers;

use App\Reply;
use Illuminate\Http\Request;
use App\Thread;

class ReplyController extends Controller
{
    /**
     * @param Thread $thread
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param $channelId
     * @param Thread $thread
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($channelId, Thread $thread, Request $request)
    {
        $this->validate($request, ['body' => 'required']);
        $reply = $thread->addReply(['body' => request('body'), 'user_id' => auth()->id()]);

       if(request()->expectsJson()){
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
        if(request()->expectsJson()){
            return response(['status' => 'Reply Deleted']);
        }
        return back() ;
    }
}
