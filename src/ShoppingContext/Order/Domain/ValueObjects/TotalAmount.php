<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Order\Domain\ValueObjects;

final class TotalAmount
{
    private $value;

    public function __construct(float $totalAmount)
    {
        $this->value = $totalAmount;
    }

    public function value(): float
    {
        return $this->value;
    }
}
