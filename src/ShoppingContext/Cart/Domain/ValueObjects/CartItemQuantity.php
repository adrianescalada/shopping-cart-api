<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Cart\Domain\ValueObjects;

final class CartItemQuantity
{
    private $value;

    public function __construct(int $quantity)
    {
        $this->value = $quantity;
    }

    public function value(): int
    {
        return $this->value;
    }
}
