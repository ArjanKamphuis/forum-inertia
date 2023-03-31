<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileShowResource;
use App\Http\Resources\ThreadShowResource;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfilesController extends Controller
{
    public function show(User $user)
    {
        return Inertia::render('Profiles/Show', [
            'profile' => ProfileShowResource::make($user),
            'threads' => ThreadShowResource::collection($user->threads()->paginate(30))
        ]);
    }
}
