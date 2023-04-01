<?php

namespace App\Http\Controllers;

use App\Filters\ThreadFilters;
use App\Http\Resources\ReplyIndexResource;
use App\Http\Resources\ThreadIndexResource;
use App\Http\Resources\ThreadShowResource;
use App\Models\Channel;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Channel $channel, ThreadFilters $filters): Response|Collection
    {
        $threads = $this->getThreads($channel, $filters);
        return request()->wantsJson() ? $threads : Inertia::render('Threads/Index', [
            'threads' => ThreadIndexResource::collection($threads)
        ]);
    }

    public function show(Channel $channel, Thread $thread): Response
    {
        $replies = $thread->replies()->paginate(20);
        return Inertia::render('Threads/Show', [
            'thread' => ThreadShowResource::make($thread),
            'replies' => ReplyIndexResource::collection($replies),
            'hasPages' => $replies->hasPages()
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Threads/Create');
    }

    public function store(): RedirectResponse
    {
        request()->validate([
            'title' => ['required'],
            'body' => ['required'],
            'channel_id' => ['required', 'exists:channels,id']
        ]);
        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body')
        ]);
        return redirect($thread->path());
    }

    protected function getThreads(Channel $channel, ThreadFilters $filters): Collection
    {
        $threads = Thread::filter($filters);
        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }
        return $threads->latest()->get();
    }
}
