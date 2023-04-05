<?php

namespace Tests\Unit;

use App\Models\Activity;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_records_activity_when_a_thread_is_created(): void
    {
        $this->signIn($user = create(User::class));
        $thread = create(Thread::class, ['user_id' => $user->id]);

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => $user->id,
            'subject_id' => $thread->id,
            'subject_type' => Thread::class
        ]);

        $activity = Activity::first();
        $this->assertEquals($thread->id, $activity->subject->id);
    }

    public function test_it_records_activity_when_a_reply_is_created(): void
    {
        $this->signIn($user = create(User::class));
        create(Reply::class, ['user_id' => $user->id]);
        $this->assertEquals(2, Activity::count());
    }
}
