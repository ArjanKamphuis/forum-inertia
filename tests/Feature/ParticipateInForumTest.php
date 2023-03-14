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

    protected Thread $thread;

    public function setUp(): void
    {
        parent::setUp();
        $this->thread = create(Thread::class);
    }

    public function test_unauthenticated_users_may_not_add_replies(): void
    {
        $this->withExceptionHandling()
            ->post('/threads/some-channel/1/replies', [])
            ->assertRedirect('/login');
    }

    public function test_an_authenticated_user_may_participate_in_forum_threads(): void
    {
        $reply = make(Reply::class);
        $this->signIn()->post("{$this->thread->path()}/replies", $reply->toArray());

        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    public function test_a_new_reply_requires_a_body(): void
    {
        $this->withExceptionHandling()->signIn();
        $reply = make(Reply::class, ['body' => null]);
        $this->post("{$this->thread->path()}/replies", $reply->toArray())
            ->assertSessionHasErrors('body');
    }
}
