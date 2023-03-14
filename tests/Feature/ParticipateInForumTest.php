<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_users_may_not_add_replies(): void
    {
        $this->withExceptionHandling()
            ->post('/threads/some-channel/1/replies', [])
            ->assertRedirect('/login');
    }

    public function test_an_authenticated_user_may_participate_in_forum_threads(): void
    {
        $thread = create(Thread::class);
        $reply = make(Reply::class);

        $this->signIn()->post("{$thread->path()}/replies", $reply->toArray());
        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
