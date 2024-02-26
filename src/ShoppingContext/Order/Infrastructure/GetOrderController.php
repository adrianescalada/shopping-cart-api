<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Order\Infrastructure;

use Illuminate\Http\Request;
use Src\ShoppingContext\Order\Application\GetOrderUseCase;
use Src\ShoppingContext\Order\Infrastructure\Repositories\EloquentOrderRepository;

final class GetOrderController
{
    private $repository;

    public function __construct(EloquentOrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Request $request)
    {
        $orderId = (int)$request->id;

        $getProductUseCase = new GetOrderUseCase($this->repository);
        $order           = $getProductUseCase->__invoke($orderId);

        return $order;
    }
}
