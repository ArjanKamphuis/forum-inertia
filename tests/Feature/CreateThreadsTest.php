<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_may_not_create_threads(): void
    {
        $this->expectException(AuthenticationException::class);
        $this->post('/threads', []);
    }

    public function test_guests_cannot_see_the_create_thread_page(): void
    {
        $this->withExceptionHandling()
            ->get('/threads/create')
            ->assertRedirect('/login');
    }

    public function test_an_authenticated_user_can_create_new_forum_threads(): void
    {
        $this->signIn($user = create(User::class));

        $thread = make(Thread::class, ['user_id' => $user->id]);
        $this->post('/threads', $thread->toArray());
        
        $this->get($thread->path())
            ->assertSee($thread->title);
    }
}
