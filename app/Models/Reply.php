<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Reply extends Model
{
    use HasFactory;

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function favorites(): MorphMany
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    public function favorite(): Favorite|bool
    {
        return $this->isFavorited() ? false : $this->favorites()->create(['user_id' => auth()->id()]);
    }

    public function isFavorited(): bool
    {
        return $this->favorites()->where('user_id', auth()->id())->exists();
    }
}
