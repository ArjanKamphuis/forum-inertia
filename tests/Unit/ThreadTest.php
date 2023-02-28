<?php

namespace Tests\Unit;

use App\Models\Thread;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_replies(): void
    {
        $thread = Thread::factory()->create();
        $this->assertInstanceOf(Collection::class, $thread->replies);
    }
}
