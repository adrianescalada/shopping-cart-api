<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Order\Application;

use Src\ShoppingContext\Order\Domain\Contracts\OrderRepositoryContract;
use Src\ShoppingContext\Order\Domain\Order;
use Src\ShoppingContext\Order\Domain\ValueObjects\OrderId;

final class GetOrderUseCase
{
    private $repository;

    public function __construct(OrderRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(int $OrderId): ?Order
    {
        $orderId  = new orderId($OrderId);

        $order = $this->repository->find($orderId);

        return $order;
    }
}
