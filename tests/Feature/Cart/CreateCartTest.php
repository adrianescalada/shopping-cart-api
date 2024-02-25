<?php

namespace Tests\Feature\Cart;

use App\Models\Cart;
use App\Models\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\ShoppingContext\Product\Domain\ValueObjects\ProductId;
use Tests\TestCase;

class CreateCartTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_create_cart_with_product()
    {
        $response = $this->postJson('/api/product', $this->dataProduct())
            ->assertStatus(201);

        $productId = $response->json('data.id');

        $this->assertNotNull($productId);

        $product = Product::find($productId);

        $response->assertJson([
            'data' => [
                'code' => "A1234",
                'name' => "Notebook",
                'price' => 33.5,
                'quantity' => 2,
                'description' => "notebook mac 15",
            ]
        ]);


        $response = $this->postJson('/api/cart/add', $this->dataCart($productId))
            ->assertStatus(201);

        $this->assertCount(1, Cart::all());

        $cart = Cart::first();

        $responseFind = $this->json('GET', "/api/cart/$cart->id")
            ->assertStatus(200);

        $responseData = $responseFind->decodeResponseJson();
        $this->assertEquals($cart->id, $responseData['data']['id']);
        $this->assertEquals(null, $responseData['data']['userId']);
        $this->assertEquals('active', $responseData['data']['status']);

        $this->assertCount(1, $responseData['data']['items']);
        $this->assertEquals(1, $responseData['data']['items'][0][0]['id']);
        $this->assertEquals(2, $responseData['data']['items'][0][0]['quantity']);
        $this->assertEquals(10.0, $responseData['data']['items'][0][0]['price']);
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

    private function dataCartResponse(int $cartId, int $productId): array
    {
        return [
            'data' => [
                'id' => $cartId,
                'userId' => null,
                'status' => 'active',
                'items' => [
                    [
                        'id' => 1,
                        'productId' => $productId,
                        'quantity' => 2,
                        'price' => 10.00
                    ]
                ]
            ]
        ];
    }


    private function dataCart(int $productId): array
    {
        return [
            'items' => [
                $productId => [
                    "quantity" => 2,
                    "price" => 10.00
                ]
            ]
        ];
    }
}
