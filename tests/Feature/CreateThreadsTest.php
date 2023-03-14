<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
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
        $response = $this->post('/threads', $thread->toArray());
        
        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    public function test_a_new_thread_requires_a_title(): void
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    public function test_a_new_thread_requires_a_body(): void
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    public function test_a_new_thread_requires_a_valid_channel(): void
    {
        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');
        $this->publishThread(['channel_id' => 9999])
            ->assertSessionHasErrors('channel_id');
    }

    protected function publishThread(array $overrides = []): TestResponse
    {
        return $this->withExceptionHandling()->signIn()
            ->post('/threads', make(Thread::class, $overrides)->toArray());
    }
}
