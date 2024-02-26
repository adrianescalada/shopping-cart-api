<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Order\Domain\ValueObjects;

final class OrderNumber
{
    private $value;

    public function __construct(string $orderNumber)
    {
        $this->value = $orderNumber;
    }

    public function value(): string
    {
        return $this->value;
    }
}
