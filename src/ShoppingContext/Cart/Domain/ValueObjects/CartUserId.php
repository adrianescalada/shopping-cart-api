<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Cart\Domain\ValueObjects;

final class CartUserId
{
    private $value;

    public function __construct(?int $userId)
    {
        $this->value = $userId;
    }

    public function value(): ?int
    {
        return $this->value;
    }
}
