<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cart;
use App\Models\CartItem;

class CartItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carts = Cart::all();

        $carts->each(function ($cart) {
            $cart->cartItems()->createMany(
                CartItem::factory()->count(5)->make()->toArray()
            );
        });
    }
}
