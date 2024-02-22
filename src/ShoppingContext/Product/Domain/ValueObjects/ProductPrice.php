<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Product\Domain\ValueObjects;

final class ProductPrice
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
