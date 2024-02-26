<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Order\Domain\ValueObjects;

class Payments
{
    private string $method;
    private string $status;
    private string $transactionId;


    public function __construct(array $data)
    {
        $this->method = $data['method'];
        $this->status = $data['status'] ?? '';
        $this->transactionId = $data['transaction_id'] ?? '';
    }


    public function getMethod(): string
    {
        return $this->method;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }
}
