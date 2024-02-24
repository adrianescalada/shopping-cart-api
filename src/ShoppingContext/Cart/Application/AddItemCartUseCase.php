<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Cart\Application;

use Src\ShoppingContext\Cart\Domain\Contracts\CartRepositoryContract;
use Src\ShoppingContext\Cart\Domain\ValueObjects\CartId;

final class AddItemCartUseCase
{
    private $repository;

    public function __construct(CartRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(
        array $cartItems,
    ): CartId {
        $cartItems  = array($cartItems);
        $response = $this->repository->addCart($cartItems);
        return $response;
    }
}
