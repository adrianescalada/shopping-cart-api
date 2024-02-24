<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cart;
use App\Models\CartItem;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cart = Cart::factory()->count(50)->create();

        $cart->cartItems()->createMany(
            CartItem::factory()->count(5)->make()->toArray()
        );
    }
}
