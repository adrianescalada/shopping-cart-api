<?php

namespace Tests\Feature\Cart;

use App\Models\Cart;
use App\Models\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\ShoppingContext\Product\Domain\ValueObjects\ProductId;
use Tests\TestCase;

class UpdateCartTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_update_cart_with_new_product_quantity()
    {
        // Create a product
        $productResponse = $this->postJson('/api/product', $this->dataProduct())
            ->assertStatus(201);

        $productId = $productResponse->json('data.id');
        $this->assertNotNull($productId);

        // Create a cart with the initial product
        $cartResponse = $this->postJson('/api/cart/add', $this->dataCart($productId))
            ->assertStatus(201);

        $cartId = $cartResponse->json('data.id');
        $this->assertNotNull($cartId);

        // Update the cart with new product quantity
        $updatedCartResponse = $this->putJson("/api/cart/$cartId", $this->updatedDataCart($productId))
            ->assertStatus(200);

        // Check if the cart has been updated successfully
        $updatedCartResponse->assertJson([
            'data' => [
                'id' => $cartId,
                'userId' => null,
                'status' => 'active',
                'items' => [
                    [
                        'id' => 1,
                        'productId' => $productId,
                        'quantity' => 5, // Updated quantity
                        'price' => 10.00
                    ]
                ]
            ]
        ]);

        // Check the database to ensure the changes have been persisted
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
            'items' => [
                $productId => [
                    "quantity" => 2,
                    "price" => 100.00
                ]
            ]
        ];
    }

    private function updatedDataCart(int $productId): array
    {
        return [
            'items' => [
                $productId => [
                    "quantity" => 5, // Updated quantity
                    "price" => 10.50
                ]
            ]
        ];
    }
}
