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
        $this->withExceptionHandling();

        $this->get('/threads/create')
            ->assertRedirect('/login');

        $this->post('/threads')
            ->assertRedirect('/login');
    }

    public function test_an_authenticated_user_can_create_new_forum_threads(): void
    {
        $this->signIn($user = create(User::class));

        $thread = make(Thread::class, ['user_id' => $user->id]);
        $this->post('/threads', $thread->toArray());
        
        $this->get(Thread::first()->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
