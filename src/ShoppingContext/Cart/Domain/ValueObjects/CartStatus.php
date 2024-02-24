<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Cart\Domain\ValueObjects;

final class CartStatus
{
    private $value;

    public function __construct(string $status)
    {
        $this->value = $status;
    }

    public function value(): string
    {
        return $this->value;
    }
}
