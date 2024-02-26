<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Order\Domain\Contracts;

use Src\ShoppingContext\Order\Domain\ValueObjects\OrderId;
use Src\ShoppingContext\Order\Domain\Order;

interface OrderRepositoryContract
{
    public function find(OrderId $id): ?Order;
    public function createOrder(array $orderData): OrderId;
}
