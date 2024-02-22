<?php

namespace App\Http\Controllers\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Request;


class Users extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function ($user) {
                return [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                ];
            }),
        ];
    }
}
