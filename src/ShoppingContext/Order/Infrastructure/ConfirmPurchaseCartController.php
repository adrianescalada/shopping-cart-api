<?php

declare(strict_types=1);

namespace src\ShoppingContext\Order\Infrastructure;

use Illuminate\Http\Request;
use Src\ShoppingContext\Order\Application\ConfirmPurchaseUseCase;
use Src\ShoppingContext\Order\Application\CreateOrderUseCase;
use Src\ShoppingContext\Order\Infrastructure\Repositories\EloquentOrderRepository;
use Src\ShoppingContext\Cart\Application\Validations\ValidatePurchaseDataUseCase;

final class ConfirmPurchaseCartController
{
    private $repository;
    private $validatePurchaseDataUseCase;

    public function __construct(EloquentOrderRepository $repository, ValidatePurchaseDataUseCase $validatePurchaseDataUseCase)
    {
        $this->repository = $repository;
        $this->validatePurchaseDataUseCase = $validatePurchaseDataUseCase;
    }

    public function __invoke(Request $request)
    {
        $orderNumber  = $request->input('order_number');
        $customer  = $request->input('customer');
        $products  = $request->input('products');
        $totalAmount  = $request->input('total_amount');
        $payment  = $request->input('payment');
        $shippingAddress  = $request->input('shipping_address');
        $billingAddress  = $request->input('billing_address');
        $links  = $request->input('links');

        $data = [
            'orderNumber' => $orderNumber,
            'customer' => $customer,
            'products' => $products,
            'total_amount' => $totalAmount,
            'payment' => $payment,
            'shipping_address' => $shippingAddress,
            'billing_address' => $billingAddress,
            'links' => $links,
        ];

        $this->validatePurchaseDataUseCase->validate($data);

        $confirmPurchaseUseCase = new ConfirmPurchaseUseCase($this->repository);

        $newPurchaseConfirm = $confirmPurchaseUseCase->__invoke(
            $data
        );

        $createOrderUseCase = new CreateOrderUseCase($this->repository);

        $newOrder = $createOrderUseCase->__invoke($newPurchaseConfirm->value());

        return $newOrder;
    }
}
