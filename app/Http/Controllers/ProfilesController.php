<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityResource;
use App\Http\Resources\ProfileShowResource;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProfilesController extends Controller
{
    public function show(User $user): Response
    {
        return Inertia::render('Profiles/Show', [
            'profile' => ProfileShowResource::make($user),
            'activities' => $this->mapActivityIntoResources(Activity::feed($user))
        ]);
    }

    protected function mapActivityIntoResources(Collection $feed)
    {
        $activities = [];
        foreach ($feed as $date => $activity) {
            $activities[$date] = [];
            foreach ($activity as $record) {
                $activities[$date][] = ActivityResource::make($record);
            }
        }
        return $activities;
    }
}
