<?php

namespace Tests\Feature\Cart;

use App\Models\User;
use App\Models\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteCartTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        User::factory()->count(5)->create();
    }


    /** @test */
    public function a_cart_is_deleted()
    {
        $cart = Cart::factory()->create();

        $this->assertCount(1, Cart::all());

        $this->json('DELETE', "/api/cart/$cart->id")
            ->assertStatus(204);

        $this->assertCount(0, Cart::all());
    }
}
