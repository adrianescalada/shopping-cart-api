<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Order\Application\Services;

class OrderNumberGenerator
{
    private const ORDER_NUMBER_LENGTH = 6;

    public function generateOrderNumber(): string
    {
        $randomNumber = $this->generateRandomNumber();
        $orderNumber = 'ORD-' . str_pad((string)$randomNumber, self::ORDER_NUMBER_LENGTH, '0', STR_PAD_LEFT);

        return $orderNumber;
    }

    private function generateRandomNumber(): int
    {
        return mt_rand(1, 999999);
    }
}
