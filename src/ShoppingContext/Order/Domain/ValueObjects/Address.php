<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Order\Domain\ValueObjects;

class Address
{
    private string $addressLine1;
    private string $city;
    private string $state;
    private string $postalCode;
    private string $country;

    public function __construct(array $data)
    {
        $this->addressLine1 = $data['address_line1'];
        $this->city = $data['city'];
        $this->state = $data['state'];
        $this->postalCode = $data['postal_code'];
        $this->country = $data['country'];
    }

    public function getAddressLine1(): string
    {
        return $this->addressLine1;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function getCountry(): string
    {
        return $this->country;
    }
}
