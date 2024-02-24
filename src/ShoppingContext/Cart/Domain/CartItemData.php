<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Cart\Domain;

use Src\ShoppingContext\Cart\Domain\Exceptions\CartItemsException;
use Src\ShoppingContext\Cart\Domain\CartItemData as CartItemValueObject;

class CartItemData
{
    private array $items;

    public function __construct(array $items)
    {
        foreach ($items as $productId => $item) {
            if (!is_array($item)) {
                throw new CartItemsException("Items", "array", "$productId");
            }

            if (!isset($item['quantity']) || !is_int($item['quantity']) || $item['quantity'] < 0) {
                throw new CartItemsException("Quantity", "Int",  "$productId");
            }

            if (!isset($item['price']) || !is_float($item['price']) || $item['price'] < 0) {
                throw new CartItemsException("Price", "float", "$productId");
            }
        }

        $this->items = $items;
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
