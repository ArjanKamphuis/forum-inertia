<?php

namespace App\Models;

use App\Filters\ThreadFilters;
use App\Models\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Thread extends Model
{
    use HasFactory;
    use RecordsActivity;

    protected $with = ['owner', 'channel'];

    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope('replyCount', function(Builder $builder) {
            $builder->withCount('replies');
        });
        static::deleting(function(Thread $thread) {
            $thread->replies->each->delete();
        });
    }

    public function path(): string
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }

    public function addReply(array $attributes): Reply
    {
        return $this->replies()->create($attributes);
    }

    public function scopeFilter(Builder $builder, ThreadFilters $filters): Builder
    {
        return $filters->apply($builder);
    }
}
