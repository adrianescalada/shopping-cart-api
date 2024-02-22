<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class CreateProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_new_product_is_created()
    {
        $this->postJson('/api/product', $this->data())
            ->assertStatus(201);

        $this->assertCount(1, Product::all());

        $product = Product::first();

        $this->json('GET', "/api/product/$product->id")
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'code' => "A1234",
                    'name' => "Notebook",
                    'price' => 33.5,
                    'quantity' => 2,
                    'description' => "notebook mac 15",
                ]
            ]);
    }

    /** @test */
    public function a_new_product_is_created_with_correct_data_and_response_structure()
    {
        $response = $this->postJson('/api/product', $this->data());

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'code',
                    'name',
                    'price',
                    'quantity',
                    'description',
                ],
            ]);

        $product = Product::first();
        $this->assertNotNull($product);
        $this->assertEquals("A1234", $product->code);
        $this->assertEquals("Notebook", $product->name);
        $this->assertEquals(33.5, $product->price);
        $this->assertEquals(2, $product->quantity);
        $this->assertEquals("notebook mac 15", $product->description);
    }


    private function data()
    {
        return [
            'code' => "A1234",
            'name' => "Notebook",
            'price' => 33.5,
            'quantity' => 2,
            'description' => "notebook mac 15",
        ];
    }
}
