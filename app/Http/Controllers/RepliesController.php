<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Channel $channel, Thread $thread): RedirectResponse
    {
        request()->validate([
            'body' => ['required']
        ]);
        $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);
        return back()->with('flash', 'Your reply has been left.');
    }

    public function destroy(Reply $reply): RedirectResponse
    {
        $this->authorize('update', $reply);
        $reply->delete();
        return back();
    }
}
