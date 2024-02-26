<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Order\Domain\ValueObjects;

class Links
{
    private string $orderDetail;
    private string $confirmationPage;

    public function __construct(array $data)
    {
        $this->orderDetail = $data['order_detail'];
        $this->confirmationPage = $data['confirmation_page'];
    }

    public function getOrderDetail(): string
    {
        return $this->orderDetail;
    }

    public function getConfirmationPage(): string
    {
        return $this->confirmationPage;
    }
}
