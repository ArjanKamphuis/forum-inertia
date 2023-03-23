<?php

namespace App\Filters;

use App\Models\User;

class ThreadFilters extends Filters
{
    protected array $filters = ['by'];
    
    protected function by(string $username): void
    {
        $user = User::where('name', $username)->firstOrFail();
        $this->builder->where('user_id', $user->id);
    }
}
