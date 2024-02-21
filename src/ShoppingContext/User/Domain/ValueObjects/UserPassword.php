<?php

declare(strict_types=1);

namespace Src\ShoppingContext\User\Domain\ValueObjects;

final class UserPassword
{
    private $value;

    public function __construct(string $password)
    {
        $this->value = $password;
    }

    public function value(): string
    {
        return $this->value;
    }
}
