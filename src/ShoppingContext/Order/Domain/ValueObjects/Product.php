<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Order\Domain\ValueObjects;

class Product
{
    private int $productId;
    private float $price;
    private int $quantity;

    public function __construct(int $productId, float $price, int $quantity)
    {
        $this->productId = $productId;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
