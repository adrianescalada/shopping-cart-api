<?php

namespace App\Http\Controllers\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
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
                'code' => $this->code()->value(),
                'name' => $this->name()->value(),
                'price' => $this->price()->value(),
                'quantity' => $this->quantity()->value(),
                'description' => $this->description()->value(),
            ]
        ];
    }
}
