<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $threads = Thread::factory(50)->create();
        $users = User::all();
        $threads->each(function(Thread $thread) use ($users) {
            Reply::factory(10)->create([
                'thread_id' => $thread,
                'user_id' => $users->random()
            ]);
        });
    }
}
