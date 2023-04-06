<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Activity extends Model
{
    use HasFactory;

    public static function feed(User $user, int $take = 50): Collection
    {
        return static::where('user_id', $user->id)
            ->latest()
            ->with('subject')
            ->take($take)
            ->get()
            ->groupBy(fn(Activity $activity) => $activity->created_at->format('Y-m-d'));
    }

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }
}
