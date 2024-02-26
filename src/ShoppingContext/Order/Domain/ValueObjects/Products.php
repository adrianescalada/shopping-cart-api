<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Order\Domain\ValueObjects;

class Products
{
    private array $products = [];

    public function __construct(array $productsData)
    {
        foreach ($productsData as $productId => $product) {
            $price = $product['price'] ?? 0;
            $quantity = $product['quantity'] ?? 0;
            $this->products[] = new Product((int)$productId, (float)$price, (int)$quantity);
        }
    }

    public function getProducts(): array
    {
        return $this->products;
    }
}
