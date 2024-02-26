<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Order\Infrastructure\Repositories;

use App\Models\Order as EloquentOrderModel;
use Src\ShoppingContext\Order\Domain\Contracts\OrderRepositoryContract;
use Illuminate\Support\Facades\DB;
use Src\ShoppingContext\Cart\Infrastructure\Common\Exceptions\ExceptionHandler;
use Src\ShoppingContext\Order\Application\Services\OrderNumberGenerator;
use Src\ShoppingContext\Order\Domain\Order;
use Src\ShoppingContext\Order\Domain\ValueObjects\OrderId;
use Src\ShoppingContext\Order\Domain\ValueObjects\OrderNumber;
use Src\ShoppingContext\Order\Domain\ValueObjects\TotalAmount;
use Src\ShoppingContext\Order\Domain\ValueObjects\Customers;
use Src\ShoppingContext\Order\Domain\ValueObjects\Products;
use Src\ShoppingContext\Order\Domain\ValueObjects\Payments;
use Src\ShoppingContext\Order\Domain\ValueObjects\Address;
use Src\ShoppingContext\Order\Domain\ValueObjects\Links;

class EloquentOrderRepository implements OrderRepositoryContract
{
    private $eloquentOrderModel;
    private $orderNumberGenerator;

    public function __construct(EloquentOrderModel $eloquentOrderModel, OrderNumberGenerator $orderNumberGenerator)
    {
        $this->eloquentOrderModel = $eloquentOrderModel;
        $this->orderNumberGenerator = $orderNumberGenerator;
    }

    public function find(OrderId $id): Order
    {
        $order = $this->eloquentOrderModel->findOrFail($id->value());

        return new Order(
            new OrderId($order->id),
            new OrderNumber($order->order_number),
            new Customers($order->customer),
            new Products($order->products),
            new TotalAmount((float)$order->total_amount),
            new Payments($order->payment),
            new Address($order->shipping_address),
            new Links($order->links),
        );
    }

    public function createOrder(array $orderData): OrderId
    {
        DB::beginTransaction();
        try {

            $orderNumber = $this->orderNumberGenerator->generateOrderNumber();
            $newOrder = $this->eloquentOrderModel->create([
                'order_number' => $orderNumber,
                'customer' => $orderData[0]['customer'],
                'products' => $orderData[0]['products'],
                'total_amount' => $orderData[0]['total_amount'],
                'payment' => $orderData[0]['payment'],
                'shipping_address' => $orderData[0]['shipping_address'],
                'billing_address' => $orderData[0]['billing_address'],
                'links' => $orderData[0]['links'],
            ]);

            DB::commit();

            $orderId = new OrderId($newOrder->id);

            return $orderId;
        } catch (\Exception $exception) {
            DB::rollback();
            ExceptionHandler::handle($exception);
        }
    }
}
