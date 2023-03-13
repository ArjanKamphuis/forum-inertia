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
        $this->thread = create(Thread::class);
    }

    public function test_it_has_replies(): void
    {
        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    public function test_it_has_an_owner(): void
    {
        $this->assertInstanceOf(User::class, $this->thread->owner);
    }

    public function test_it_can_add_a_reply(): void
    {
        $this->thread->addReply([
            'body' => 'foobar',
            'user_id' => 1
        ]);
        $this->assertCount(1, $this->thread->replies);
    }
}
