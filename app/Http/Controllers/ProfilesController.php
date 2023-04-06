<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityResource;
use App\Http\Resources\ProfileShowResource;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProfilesController extends Controller
{
    public function show(User $user): Response
    {
        $activities = [];
        foreach ($user->activity()->latest()->with('subject')->take(50)->get()->groupBy(fn(Activity $activity) => $activity->created_at->format('Y-m-d')) as $date => $activity) {
            $activities[$date] = [];
            foreach ($activity as $record) {
                $activities[$date][] = ActivityResource::make($record);
            }
        }

        return Inertia::render('Profiles/Show', [
            'profile' => ProfileShowResource::make($user),
            'activities' => $activities
        ]);
    }
}
