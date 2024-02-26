<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Order\Domain;

use Src\ShoppingContext\Order\Domain\ValueObjects\OrderId;
use Src\ShoppingContext\Order\Domain\ValueObjects\OrderNumber;
use Src\ShoppingContext\Order\Domain\ValueObjects\TotalAmount;
use Src\ShoppingContext\Order\Domain\ValueObjects\Customers;
use Src\ShoppingContext\Order\Domain\ValueObjects\Products;
use Src\ShoppingContext\Order\Domain\ValueObjects\Payments;
use Src\ShoppingContext\Order\Domain\ValueObjects\Address;
use Src\ShoppingContext\Order\Domain\ValueObjects\Links;

final class Order
{
    private OrderId $id;
    private OrderNumber $orderNumber;
    private Customers $customer;
    private Products $products;
    private TotalAmount $totalAmount;
    private Payments $payment;
    private Address $shippingAddress;
    private Links $links;

    public function __construct(
        OrderId $id,
        OrderNumber $orderNumber,
        Customers $customer,
        Products $products,
        TotalAmount $totalAmount,
        Payments $payment,
        Address $shippingAddress,
        Links $links
    ) {
        $this->id = $id;
        $this->orderNumber = $orderNumber;
        $this->customer = $customer;
        $this->products = $products;
        $this->totalAmount = $totalAmount;
        $this->payment = $payment;
        $this->shippingAddress = $shippingAddress;
        $this->links = $links;
    }

    public function orderId(): OrderId
    {
        return $this->id;
    }

    public function getOrderNumber(): OrderNumber
    {
        return $this->orderNumber;
    }

    public function getCustomer(): Customers
    {
        return $this->customer;
    }

    public function getProducts(): Products
    {
        return $this->products;
    }

    public function getTotalAmount(): TotalAmount
    {
        return $this->totalAmount;
    }

    public function getPayment(): Payments
    {
        return $this->payment;
    }

    public function getShippingAddress(): Address
    {
        return $this->shippingAddress;
    }

    public function getLinks(): Links
    {
        return $this->links;
    }
}
