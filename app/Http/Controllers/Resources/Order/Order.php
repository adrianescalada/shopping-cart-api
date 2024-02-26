<?php

namespace App\Http\Controllers\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class Order extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'data' => [
                'id' => $this->orderId()->value(),
                'order_number' => $this->getOrderNumber()->value(),
            ]
        ];
    }
}
