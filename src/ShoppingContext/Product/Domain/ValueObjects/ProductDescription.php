<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Product\Domain\ValueObjects;

final class ProductDescription
{
    private $value;

    public function __construct(string $description)
    {
        $this->value = $description;
    }

    public function value(): string
    {
        return $this->value;
    }
}
