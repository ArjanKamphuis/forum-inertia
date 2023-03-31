<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfilesTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = create(User::class);
    }

    public function test_a_user_has_a_profile(): void
    {
        $this->get("/profiles/{$this->user->name}")
            ->assertSee($this->user->name);
    }

    public function test_profiles_display_all_threads_created_by_the_associated_user(): void
    {
        $thread = create(Thread::class, ['user_id' => $this->user->id]);
        $this->get("/profiles/{$this->user->name}")
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
