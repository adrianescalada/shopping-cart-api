<?php

namespace App\Http\Controllers\Resources\Cart;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Controllers\Resources\Product\Product as ProductResource;

class Cart extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $totalProducts = collect($this->items)->flatten()->sum('quantity');
        $totalPrice = collect($this->items)->flatten()->sum(function ($item) {
            return $item['quantity'] * $item['price'];
        });
        return [
            'data' => [
                'id' => $this->cartId()->value(),
                'userId' => $this->cartUserId()->value(),
                'status' => $this->cartStatus()->value(),
                'countProducts' => $totalProducts,
                'totalPrice' => $totalPrice,
                'items' => collect($this->items)->map(function ($cartItems) {
                    return collect($cartItems)->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'productId' => $item->product_id,
                            'quantity' => $item->quantity,
                            'price' => $item->price,
                        ];
                    })->toArray();
                })->toArray(),
                /* TODO: review
                    'products' => collect($this->items)->map(function ($cartItems) {
                        return collect($cartItems)->map(function ($item) {
                            return $item->products;
                        });
                    }),
                */
            ]
        ];
    }
}
