<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Thread extends Model
{
    use HasFactory;

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

    public function addReply(array $attributes)
    {
        $this->replies()->create($attributes);
    }
}
