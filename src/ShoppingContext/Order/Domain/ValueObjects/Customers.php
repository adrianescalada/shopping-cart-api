<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Order\Domain\ValueObjects;

class Customers
{
    private string $name;
    private string $email;

    public function __construct(array $customerData)
    {
        $this->name = $customerData['name'] ?? '';
        $this->email = $customerData['email'] ?? '';
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
