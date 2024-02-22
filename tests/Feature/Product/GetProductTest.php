<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_created_product_is_retrieved()
    {
        $this->withoutExceptionHandling();

        Product::factory()->create();

        $this->assertCount(1, Product::all());

        $product = Product::first();

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
