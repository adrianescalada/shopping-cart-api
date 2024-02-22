<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_product_is_deleted()
    {
        $product = Product::factory()->create();

        $this->assertCount(1, Product::all());

        $this->json('DELETE', "/api/product/$product->id")
            ->assertStatus(204);

        $this->assertCount(0, Product::all());
    }
}
