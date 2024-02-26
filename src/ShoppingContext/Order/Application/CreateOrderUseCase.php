<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Order\Application;

use Src\ShoppingContext\Order\Domain\Contracts\OrderRepositoryContract;
use Src\ShoppingContext\Order\Domain\Order;
use Src\ShoppingContext\Order\Domain\ValueObjects\OrderId;

final class CreateOrderUseCase
{
    private $repository;

    public function __construct(OrderRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(int $orderId): ?Order
    {
        $orderId  = new OrderId($orderId);

        $order = $this->repository->find($orderId);

        return $order;
    }
}
