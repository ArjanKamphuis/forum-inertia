<?php

namespace App\Http\Controllers;

use App\Http\Resources\ThreadIndexResource;
use App\Http\Resources\ThreadShowResource;
use App\Models\Thread;
use Inertia\Inertia;
use Inertia\Response;

class ThreadsController extends Controller
{
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
}
