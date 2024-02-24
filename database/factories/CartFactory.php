<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Src\ShoppingContext\Cart\Domain\Enums\CartStatus as CartStatusEnum;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


    public function definition(): array
    {
        $userIds = User::pluck('id')->toArray();

        $statuses = [
            CartStatusEnum::ACTIVE,
            CartStatusEnum::PENDING_PAYMENT,
            CartStatusEnum::COMPLETED,
            CartStatusEnum::CANCELLED,
            CartStatusEnum::EXPIRED,
        ];

        return [
            'user_id' => $userIds[array_rand($userIds)],
            'status' => $statuses[array_rand($statuses)],
        ];
    }
}
