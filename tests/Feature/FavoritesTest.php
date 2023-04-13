<?php

namespace Tests\Feature;

use App\Models\Reply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_favor_anything(): void
    {
        $this->withExceptionHandling()
            ->post('/replies/1/favorites')
            ->assertRedirect('/login');
    }

    public function test_an_authenticated_user_can_favorite_any_reply(): void
    {
        $this->signIn();
        $reply = create(Reply::class);

        $this->post("/replies/{$reply->id}/favorites");
        $this->assertCount(1, $reply->favorites);
    }

    public function test_an_authenticated_user_can_unfavorite_a_reply(): void
    {
        $this->signIn();
        $reply = create(Reply::class);
        $reply->favorite();

        $this->delete("/replies/{$reply->id}/favorites");
        $this->assertCount(0, $reply->favorites);
    }

    public function test_an_authenticated_user_may_only_favorite_a_reply_once(): void
    {
        $this->signIn();
        $reply = create(Reply::class);

        $this->post("/replies/{$reply->id}/favorites");
        $this->post("/replies/{$reply->id}/favorites");
        
        $this->assertCount(1, $reply->favorites);
    }
}
