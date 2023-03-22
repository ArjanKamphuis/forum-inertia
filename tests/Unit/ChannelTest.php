<?php

namespace Tests\Unit;

use App\Models\Channel;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_consists_of_threads(): void
    {
        $channel = create(Channel::class);
        $thread = create(Thread::class, ['channel_id' => $channel->id]);
        $this->assertTrue($channel->threads->contains($thread));
    }
}
