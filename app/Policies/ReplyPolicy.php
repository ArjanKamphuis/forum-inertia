<?php

namespace App\Policies;

use App\Models\Reply;
use App\Models\User;

class ReplyPolicy
{
    public function update(User $user, Reply $reply): bool
    {
        return $reply->user_id === $user->id;
    }
}
