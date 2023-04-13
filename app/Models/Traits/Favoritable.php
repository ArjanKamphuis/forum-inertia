<?php

namespace App\Models\Traits;

use App\Models\Favorite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Favoritable
{
    protected static function bootFavoritable(): void
    {
        static::deleting(function(Model $model) {
            $model->favorites->each->delete();
        });
    }

    public function favorites(): MorphMany
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    public function favorite(): bool
    {
        return $this->isFavorited() ? false : !! $this->favorites()->create(['user_id' => auth()->id()]);
    }

    public function unfavorite(): bool
    {
        return !! $this->favorites()->where('user_id', auth()->id())->get()->each->delete();
    }

    public function isFavorited(): bool
    {
        return $this->favorites->where('user_id', auth()->id())->isNotEmpty();
    }

    public function getFavoritesCountAttribute(): int
    {
        return $this->favorites->count();
    }
}
