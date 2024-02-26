<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Cart\Application;

use Src\ShoppingContext\Order\Domain\Contracts\OrderRepositoryContract;
use Src\ShoppingContext\Order\Domain\ValueObjects\OrderId;

final class ConfirmPurchaseUseCase
{
    private $repository;

    public function __construct(OrderRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(
        array $confirmPurchase,
    ): OrderId {
        $confirmPurchase  = array($confirmPurchase);
        return $this->repository->createOrder($confirmPurchase);
    }
}
