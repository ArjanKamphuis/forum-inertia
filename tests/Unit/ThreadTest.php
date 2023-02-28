<?php

namespace Tests\Unit;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    protected Thread $thread;

    protected function setUp(): void
    {
        parent::setUp();
        $this->thread = Thread::factory()->create();
    }

    /** @test */
    public function it_has_replies(): void
    {
        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    /** @test */
    public function it_has_an_owner(): void
    {
        $this->assertInstanceOf(User::class, $this->thread->owner);
    }

    /** @test */
    public function it_can_add_a_reply(): void
    {
        $this->thread->addReply([
            'body' => 'foobar',
            'user_id' => 1
        ]);
        $this->assertCount(1, $this->thread->replies);
    }
}
