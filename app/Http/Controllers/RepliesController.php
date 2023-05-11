<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReplyIndexResource;
use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Channel $channel, Thread $thread): RedirectResponse
    {
        $reply = $thread->addReply(array_merge($this->validateReply(), [
            'user_id' => auth()->id()
        ]));
        return back()
            ->with('flash', 'Your reply has been left.')
            ->with('newReply', ReplyIndexResource::make($reply));
    }

    public function update(Reply $reply): void
    {
        $this->authorize('update', $reply);
        $reply->update($this->validateReply());
    }

    public function destroy(Reply $reply): Response|ResponseFactory|Redirector|RedirectResponse
    {
        $this->authorize('update', $reply);
        $reply->delete();
        return request()->wantsJson() ? response(['status' => 'Reply deleted']) : back();
    }

    protected function validateReply(): array
    {
        return request()->validate([
            'body' => ['required']
        ]);
    }
}
