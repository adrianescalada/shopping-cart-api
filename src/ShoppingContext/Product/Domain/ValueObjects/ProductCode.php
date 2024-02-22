<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Product\Domain\ValueObjects;

final class ProductCode
{
    private $value;

    public function __construct(string $code)
    {
        $this->value = $code;
    }

    public function value(): string
    {
        return $this->value;
    }
}
