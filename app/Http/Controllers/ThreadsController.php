<?php

namespace App\Http\Controllers;

use App\Http\Resources\ThreadIndexResource;
use App\Http\Resources\ThreadShowResource;
use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(?Channel $channel): Response
    {
        $threads = $channel->exists ? $channel->threads()->latest() : Thread::latest();

        if ($username = request('by')) {
            $user = User::where('name', $username)->firstOrFail();
            $threads->where('user_id', $user->id);
        }

        return Inertia::render('Threads/Index', [
            'threads' => ThreadIndexResource::collection($threads->get())
        ]);
    }

    public function show(Channel $channel, Thread $thread): Response
    {
        return Inertia::render('Threads/Show', [
            'thread' => ThreadShowResource::make($thread)
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
}
