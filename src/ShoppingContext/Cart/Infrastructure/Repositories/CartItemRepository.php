<?php

namespace Src\ShoppingContext\Cart\Infrastructure\Repositories;

use App\Models\CartItem as EloquentCartItemsModel;
use Src\ShoppingContext\Cart\Domain\ValueObjects\CartId;
use Src\ShoppingContext\Cart\Domain\ValueObjects\CartItemPrice;
use Src\ShoppingContext\Cart\Domain\ValueObjects\CartItemQuantity;

class CartItemRepository
{
    private $eloquentCartItemsModel;

    public function __construct()
    {
        $this->eloquentCartItemsModel = new EloquentCartItemsModel;
    }

    /**
     * Updates or creates cart items in the database.
     *
     * @param CartId $cartId The ID of the cart.
     * @param array $cartItemsData The data of the cart items to update or create.
     *                             The format should be: ['product_id' => ['quantity' => $quantity, 'price' => $price], ...]
     * @return void
     */
    public function updateOrCreateCartItems(CartId $cartId, array $cartItemsData): void
    {
        foreach ($cartItemsData as $key => $cartItem) {
            foreach ($cartItem as $productId => $item) {
                $quantity = new CartItemQuantity($item['quantity']);
                $price = new CartItemPrice($item['price']);

                $cartItemModel = $this->eloquentCartItemsModel
                    ->where('cart_id', $cartId->value())
                    ->where('product_id', $productId)
                    ->first();

                if ($cartItemModel) {
                    $cartItemModel->update([
                        'quantity' => $quantity->value(),
                        'price' => $price->value(),
                    ]);
                } else {
                    $this->eloquentCartItemsModel->create([
                        'cart_id' => $cartId->value(),
                        'product_id' => $productId,
                        'quantity' => $quantity->value(),
                        'price' => $price->value(),
                    ]);
                }
            }
        }
    }


    /**
     * Removes cart items that are not present in the request from the database.
     *
     * @param CartId $cartId The ID of the cart.
     * @param array $cartItemsData The data of the cart items sent in the request.
     *                             The format should be: ['product_id' => ['quantity' => $quantity, 'price' => $price], ...]
     * @return void
     */
    public function removeItemsNotPresentInRequest(CartId $cartId, array $cartItemsData): void
    {
        $currentProductIds = $this->eloquentCartItemsModel
            ->where('cart_id', $cartId->value())
            ->pluck('product_id')
            ->toArray();

        $requestProductIds = array_keys($cartItemsData);
        $productIdsToRemove = array_diff($currentProductIds, $requestProductIds);

        $this->eloquentCartItemsModel
            ->where('cart_id', $cartId->value())
            ->whereIn('product_id', $productIdsToRemove)
            ->delete();
    }
}
