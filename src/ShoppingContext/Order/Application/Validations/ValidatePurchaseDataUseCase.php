<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Order\Application\Validations;

use Src\ShoppingContext\Cart\Domain\Exceptions\CartException;
use Symfony\Component\HttpFoundation\Response;

class ValidatePurchaseDataUseCase
{
    public function validate(array $data): void
    {
        if (!isset(
            $data['customer'],
            $data['products'],
            $data['total_amount'],
            $data['payment'],
            $data['shipping_address'],
            $data['billing_address'],
            $data['links']
        )) {
            throw new CartException("Invalid purchase data. Missing required fields.", Response::HTTP_FORBIDDEN);
        }

        $this->validateCustomer($data['customer']);
        $this->validateProducts($data['products']);
        $this->validateTotalAmount($data['total_amount']);
    }

    private function validateCustomer(array $customer): void
    {
        if (!isset($customer['name'], $customer['email']) || !is_string($customer['name']) || !is_string($customer['email'])) {
            throw new CartException("Invalid customer data. 'name' and 'email' must be strings.", Response::HTTP_FORBIDDEN);
        }

        if (!filter_var($customer['email'], FILTER_VALIDATE_EMAIL)) {
            throw new CartException("Invalid customer email address.", Response::HTTP_FORBIDDEN);
        }
    }

    private function validateProducts(array $products): void
    {
        if (empty($products) || !is_array($products)) {
            throw new CartException("Cart must contain at least one products and be an array.", Response::HTTP_FORBIDDEN);
        }

        foreach ($products as $productId => $product) {
            if (!isset($product['quantity'], $product['price']) || !is_int($product['quantity']) || !is_float($product['price'])) {
                throw new CartException("Invalid product in the cart. 'quantity' must be an integer and 'price' must be a float.", Response::HTTP_FORBIDDEN);
            }
        }
    }

    private function validateTotalAmount($totalAmount): void
    {
        if (!is_float($totalAmount)) {
            throw new CartException("Invalid total amount. Total amount must be a float.", Response::HTTP_FORBIDDEN);
        }
    }
}
