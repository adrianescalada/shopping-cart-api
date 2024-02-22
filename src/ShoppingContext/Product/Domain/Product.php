<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Product\Domain;

use Src\ShoppingContext\Product\Domain\ValueObjects\ProductCode;
use Src\ShoppingContext\Product\Domain\ValueObjects\ProductName;
use Src\ShoppingContext\Product\Domain\ValueObjects\ProductPrice;
use Src\ShoppingContext\Product\Domain\ValueObjects\ProductQuantity;
use Src\ShoppingContext\Product\Domain\ValueObjects\ProductDescription;

final class Product
{
    private $code;
    private $name;
    private $price;
    private $quantity;
    private $description;

    public function __construct(
        ProductCode $code,
        ProductName $name,
        ProductPrice $price,
        ProductQuantity $quantity,
        ProductDescription $description,
    ) {
        $this->code         = $code;
        $this->name         = $name;
        $this->price        = $price;
        $this->quantity     = $quantity;
        $this->description  = $description;
    }

    public function code(): ProductCode
    {
        return $this->code;
    }

    public function name(): ProductName
    {
        return $this->name;
    }

    public function price(): ProductPrice
    {
        return $this->price;
    }

    public function quantity(): ProductQuantity
    {
        return $this->quantity;
    }

    public function description(): ProductDescription
    {
        return $this->description;
    }

    public static function create(
        ProductCode $code,
        ProductName $name,
        ProductPrice $price,
        ProductQuantity $quantity,
        ProductDescription $description,
    ): Product {
        $product = new self($code, $name, $price, $quantity, $description);

        return $product;
    }
}
