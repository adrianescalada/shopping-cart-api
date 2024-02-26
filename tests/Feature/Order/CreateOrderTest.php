<?php

namespace Tests\Feature\Order;

use App\Models\Cart;
use App\Models\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\ShoppingContext\Product\Domain\ValueObjects\ProductId;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_create_confirm_purchase()
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

        $orderId = $responseFind->json('data.id');

        $response = $this->postJson("/api/order/$orderId/confirm-purchase", $this->dataConfirmPurchase($productId))
            ->assertStatus(200);
    }

    private function dataProduct(): array
    {
        return [
            'code' => "A1234",
            'name' => "Notebook",
            'price' => 33.50,
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
                'products' => [
                    [
                        'id' => 1,
                        'productId' => $productId,
                        'quantity' => 2,
                        'price' => 10.99
                    ]
                ]
            ]
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

    private function dataConfirmPurchase(int $productId): array
    {
        return  [
            "customer" => [
                "name" => "John Doe",
                "email" => "johndoe@example.com"
            ],
            "products" => [
                $productId => [
                    "quantity" => 7,
                    "price" => 7.99
                ],
            ],
            "total_amount" => 42.48,
            "payment" => [
                "method" => "credit_card",
                "transaction_id" => "TRANS123456789",
                "status" => "completed"
            ],
            "shipping_address" => [
                "address_line1" => "123 Main St",
                "city" => "Anytown",
                "state" => "NY",
                "postal_code" => "12345",
                "country" => "USA"
            ],
            "billing_address" => [
                "address_line1" => "123 Billing St",
                "city" => "Anytown",
                "state" => "NY",
                "postal_code" => "12345",
                "country" => "USA"
            ],
            "links" => [
                "order_detail" => "/api/orders/ORD123456",
                "confirmation_page" => "/order/confirmation"
            ]
        ];
    }
}
