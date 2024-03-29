<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Cart\Domain\Contracts;

use Src\ShoppingContext\Cart\Domain\Cart;
use Src\ShoppingContext\Cart\Domain\ValueObjects\CartId;
use Src\ShoppingContext\Cart\Domain\ValueObjects\CartUserId;

interface CartRepositoryContract
{
    public function find(CartId $id): ?Cart;
    public function findByCriteria(CartId $id, CartUserId $userId): ?Cart;
    public function addCart(array $cartItemsData): CartId;
    public function updateCart(int $cartId, array $cartItemsData): CartId;
    public function delete(CartId $id): void;
}
