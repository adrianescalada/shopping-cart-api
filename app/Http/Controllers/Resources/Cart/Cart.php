<?php

namespace App\Http\Controllers\Resources\Cart;

use Illuminate\Http\Resources\Json\JsonResource;

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
        // Map Domain Product model values
        return [
            'data' => [
                'id' => $this->cartId()->value(),
                'userId' => $this->cartUserId()->value(),
                'status' => $this->cartStatus()->value(),
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

            ]
        ];
    }
}
