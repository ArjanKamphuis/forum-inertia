<?php

namespace App\Http\Controllers;

use App\Http\Resources\ThreadIndexResource;
use App\Http\Resources\ThreadShowResource;
use App\Models\Thread;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('store');
    }

    public function index(): Response
    {
        return Inertia::render('Threads/Index', [
            'threads' => ThreadIndexResource::collection(Thread::all())
        ]);
    }

    public function show(Thread $thread): Response
    {
        return Inertia::render('Threads/Show', [
            'thread' => ThreadShowResource::make($thread)
        ]);
    }

    public function store(): RedirectResponse
    {
        $thread = Thread::create([
            'user_id' => auth()->id(),
            'title' => request('title'),
            'body' => request('body')
        ]);
        return redirect($thread->path());
    }
}
