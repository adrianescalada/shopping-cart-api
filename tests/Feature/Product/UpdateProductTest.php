<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class UpdateProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_product_is_updated()
    {
        $product = Product::factory()->create();

        $this->putJson("/api/product/$product->id", [
            'data' => [
                'code' => "A1234",
                'name' => "Notebook",
                'price' => 33.5,
                'quantity' => 2,
                'description' => "notebook mac 15",
            ]
        ])->assertStatus(200);

        $this->json('GET', "/api/product/$product->id")
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'code' => $product->code,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $product->quantity,
                    'description' => $product->description,
                ]
            ]);
    }
}
