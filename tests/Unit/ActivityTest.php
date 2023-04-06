<?php

namespace Tests\Unit;

use App\Models\Activity;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
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

    public function test_it_fetches_a_feed_for_any_user(): void
    {
        $this->signIn($user = create(User::class));
        
        create(Thread::class, ['user_id' => $user->id], 2);
        DB::table('activities')->where('subject_id', 1)->update(['created_at' => Carbon::now()->subWeek()]);

        $feed = Activity::feed($user);

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));
    }
}
