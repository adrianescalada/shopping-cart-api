<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_is_deleted()
    {
        $user = User::factory()->create();

        $this->assertCount(1, User::all());

        $this->json('DELETE', "/api/user/$user->id")
            ->assertStatus(204);

        $this->assertCount(0, User::all());
    }
}
