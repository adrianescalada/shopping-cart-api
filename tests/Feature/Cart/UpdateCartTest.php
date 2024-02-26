<?php

namespace Tests\Feature\Cart;

use App\Models\Cart;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateCartTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_update_cart_with_new_product_quantity()
    {
        $productResponse = $this->postJson('/api/product', $this->dataProduct())
            ->assertStatus(201);

        $productId = $productResponse->json('data.id');
        $this->assertNotNull($productId);

        $cartResponse = $this->postJson('/api/cart/add', $this->dataCart($productId))
            ->assertStatus(201);

        $cartId = $cartResponse->json('data.id');
        $this->assertNotNull($cartId);

        $updatedCartResponse = $this->putJson("/api/cart/$cartId", $this->updatedDataCart($productId))
            ->assertStatus(200);

        $updatedCartResponse->assertJson([
            'data' => [
                'id' => $cartId,
                'userId' => null,
                'status' => 'active',
                'items' => [
                    [
                        [
                            'id' => 3,
                            'productId' => $productId,
                            'quantity' => 5,
                            'price' => "10.55",
                        ]
                    ]
                ]
            ]
        ]);

        $cart = Cart::find($cartId);
        $this->assertEquals(5, $cart->items()->where('product_id', $productId)->first()->quantity);
    }

    private function dataProduct(): array
    {
        return [
            'code' => "A1234",
            'name' => "Notebook",
            'price' => 33.5,
            'quantity' => 2,
            'description' => "notebook mac 15",
        ];
    }

    private function dataCart(int $productId): array
    {
        return [
            'products' => [
                $productId => [
                    "quantity" => 2,
                    "price" => 10.99
                ]
            ]
        ];
    }

    private function updatedDataCart(int $productId): array
    {
        return [
            'products' => [
                $productId => [
                    "quantity" => 5,
                    "price" => 10.55
                ]
            ]
        ];
    }
}
