<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Cart\Domain\ValueObjects;

final class CartItemPrice
{
    private $value;

    public function __construct(float $price)
    {
        $this->value = $price;
    }

    public function value(): float
    {
        return $this->value;
    }
}
