<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthenticated_users_may_not_add_replies(): void
    {
        $this->expectException(AuthenticationException::class);
        $this->withoutExceptionHandling()
            ->post('/threads/1/replies', []);
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads(): void
    {
        $thread = create(Thread::class);
        $reply = make(Reply::class);

        $this->withoutExceptionHandling();
        $this->signIn()->post("{$thread->path()}/replies", $reply->toArray());
        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
