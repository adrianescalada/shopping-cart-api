<?php

namespace App\Http\Controllers\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // Map Domain User model values
        return [
            'data' => [
                'name' => $this->name()->value(),
                'email' => $this->email()->value(),
            ]
        ];
    }
}
