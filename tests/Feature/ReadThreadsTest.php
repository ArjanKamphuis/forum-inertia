<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use RefreshDatabase;

    protected Thread $thread;

    protected function setUp(): void
    {
        parent::setUp();
        $this->thread = create(Thread::class);
    }

    public function test_a_user_can_view_all_threads(): void
    {
        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    public function test_a_user_can_read_a_single_thread(): void
    {
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    public function test_a_user_can_read_replies_that_are_associated_with_a_thread(): void
    {
        $reply = create(Reply::class, ['thread_id' => $this->thread->id]);
        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    public function test_a_user_can_filter_threads_according_to_a_channel(): void
    {
        $channel = create(Channel::class);
        $threadInChannel = create(Thread::class, ['channel_id' => $channel->id]);
        $threadNotInChannel = $this->thread;

        $this->get("/threads/{$channel->slug}")
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    public function test_a_user_can_filter_threads_by_any_username(): void
    {
        $this->signIn($user = create(User::class, ['name' => 'JohnDoe']));

        $threadByJohn = create(Thread::class, ['user_id' => $user->id]);
        $threadNotByJohn = $this->thread;

        $this->get("/threads?by={$user->name}")
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }

    public function test_a_user_can_filter_threads_by_popularity(): void
    {
        $threadWithTwoReplies = create(Thread::class);
        create(Reply::class, ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create(Thread::class);        
        create(Reply::class, ['thread_id' => $threadWithThreeReplies->id], 3);

        // $threadWithNoReplies = $this->thread;

        $response = $this->getJson('/threads?popular=1')->json();
        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }
}
