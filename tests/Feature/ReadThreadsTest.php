<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
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
}
