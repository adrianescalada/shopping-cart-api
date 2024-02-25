<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Cart\Application;

use Src\ShoppingContext\Cart\Domain\Contracts\CartRepositoryContract;
use Src\ShoppingContext\Cart\Domain\Cart;
use Src\ShoppingContext\Cart\Domain\ValueObjects\CartId;
use Src\ShoppingContext\Cart\Domain\ValueObjects\CartUserId;

final class GetCartByCriteriaUseCase
{
    private $repository;

    public function __construct(CartRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(string $cartId, string $cartUserId): ?Cart
    {
        $id  = new CartId(intval($cartId));
        $userId  = new CartUserId(intval($cartUserId));

        $product = $this->repository->findByCriteria($id, $userId);

        return $product;
    }
}
