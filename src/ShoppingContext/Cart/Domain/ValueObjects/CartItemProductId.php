<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Cart\Domain\ValueObjects;

final class CartItemProductId
{
    private $value;

    public function __construct(int $cartId)
    {
        $this->value = $cartId;
    }

    public function value(): int
    {
        return $this->value;
    }
}
