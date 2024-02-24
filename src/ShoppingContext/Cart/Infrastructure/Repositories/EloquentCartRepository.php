<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Cart\Infrastructure\Repositories;

use App\Models\Cart as EloquentCartModel;
use App\Models\CartItem as eloquentCartItemsModel;
use Src\ShoppingContext\Cart\Domain\Cart;
use Src\ShoppingContext\Cart\Domain\ValueObjects\CartId;
use Src\ShoppingContext\Cart\Domain\ValueObjects\cartUserId;
use Src\ShoppingContext\Cart\Domain\ValueObjects\CartStatus;
use Src\ShoppingContext\Cart\Domain\ValueObjects\CartItemProductId;
use Src\ShoppingContext\Cart\Domain\ValueObjects\CartItemPrice;
use Src\ShoppingContext\Cart\Domain\ValueObjects\CartItemQuantity;
use Src\ShoppingContext\Cart\Domain\Contracts\CartRepositoryContract;
use Illuminate\Support\Facades\Redis;
use Src\ShoppingContext\Cart\Domain\CartItemData;
use Illuminate\Support\Facades\DB;
use Src\ShoppingContext\Cart\Domain\Enums\CartStatus as CartStatusEnum;
use Src\ShoppingContext\Cart\Domain\Exceptions\CartItemsException;
use Src\ShoppingContext\Cart\Infrastructure\Repositories\Exceptions\CartException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\MassAssignmentException;

class EloquentCartRepository implements CartRepositoryContract
{
    private $eloquentCartModel;
    private $eloquentCartItemsModel;

    public function __construct()
    {
        $this->eloquentCartModel = new EloquentCartModel;
        $this->eloquentCartItemsModel = new EloquentCartItemsModel;
    }

    /**
     * Finds and returns the cart with the specified ID.
     *
     * @param CartId $id The ID of the cart to find.
     * @return Cart The found cart.
     */
    public function find(CartId $id): Cart
    {
        $cart = $this->eloquentCartModel->with('items')->findOrFail($id->value());

        return new Cart(
            new CartId($cart->id),
            new cartUserId($cart->user_id),
            new CartStatus($cart->status),
            array($cart->items),
        );
    }

    /**
     * Adds a new cart with the specified cart items data and returns the ID of the created cart.
     *
     * @param array $cartItemsData The data of the cart items to be added.
     * @return CartId The ID of the created cart.
     */
    public function addCart(array $cartItemsData): CartId
    {
        DB::beginTransaction();

        try {

            $newCartModelId = $this->createNewCart();
            $cartId = new CartId($newCartModelId);

            foreach ($cartItemsData as $key => $cartItem) {
                $itemsData = new CartItemData($cartItem);
                $this->validateCartItem($itemsData, $key);
                $this->addItemsToCart($cartItem, $cartId);
            }

            DB::commit();
            return $cartId;
        } catch (\Exception $exception) {
            $this->handleException($exception);
        }
    }

    /**
     * Updates the cart items and returns the ID of the updated cart.
     *
     * @param int $id The ID of the cart to be updated.
     * @param array $cartItemsData The updated cart items data.
     * @return CartId The ID of the updated cart.
     */
    public function updateCart(int $id, array $cartItemsData): CartId
    {
        DB::beginTransaction();

        try {
            $cart = $this->eloquentCartModel->findOrFail($id);

            if (CartStatusEnum::ACTIVE !== $cart->status) {
                throw new CartException("The cart status is $cart->status, no changes can be made", Response::HTTP_FORBIDDEN);
            }
            $cartId = new CartId($cart->id);

            $this->removeItemsNotPresentInRequest($cartId, $cartItemsData);

            $this->updateOrCreateCartItems($cartId, $cartItemsData);

            DB::commit();

            return $cartId;
        } catch (\Exception $exception) {
            $this->handleException($exception);
        }
    }

    /**
     * Deletes a cart from the database.
     *
     * @param CartId $id The ID of the cart to be deleted.
     * @return void
     */
    public function delete(CartId $id): void
    {
        $this->eloquentCartModel
            ->findOrFail($id->value())
            ->delete();
    }

    /**
     * Removes cart items that are not present in the request from the database.
     *
     * @param CartId $cartId The ID of the cart.
     * @param array $cartItemsData The data of the cart items sent in the request.
     *                             The format should be: ['product_id' => ['quantity' => $quantity, 'price' => $price], ...]
     * @return void
     */
    private function removeItemsNotPresentInRequest(CartId $cartId, array $cartItemsData): void
    {
        // Get all product IDs currently in cart
        $currentProductIds = $this->eloquentCartItemsModel
            ->where('cart_id', $cartId->value())
            ->pluck('product_id')
            ->toArray();

        // Get product IDs sent in the request
        $requestProductIds = array_keys($cartItemsData);

        // Calculate product IDs to remove
        $productIdsToRemove = array_diff($currentProductIds, $requestProductIds);

        // Delete items from the cart that are not present in the request
        $this->eloquentCartItemsModel
            ->where('cart_id', $cartId->value())
            ->whereIn('product_id', $productIdsToRemove)
            ->delete();
    }

    /**
     * Updates or creates cart items in the database.
     *
     * @param CartId $cartId The ID of the cart.
     * @param array $cartItemsData The data of the cart items to update or create.
     *                             The format should be: ['product_id' => ['quantity' => $quantity, 'price' => $price], ...]
     * @return void
     */
    private function updateOrCreateCartItems(CartId $cartId, array $cartItemsData): void
    {
        foreach ($cartItemsData as $key => $cartItem) {
            $itemsData = new CartItemData($cartItem);
            $this->validateCartItem($itemsData, $key);

            foreach ($cartItem as $productId => $item) {
                $quantity = new CartItemQuantity($item['quantity']);
                $price = new CartItemPrice($item['price']);

                $cartItem = $this->eloquentCartItemsModel
                    ->where('cart_id', $cartId->value())
                    ->where('product_id', $productId)
                    ->first();

                if ($cartItem) {
                    $cartItem->update([
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
     * Creates a new cart in the database and returns its ID.
     *
     * @return int The ID of the newly created cart.
     */
    private function createNewCart(): int
    {
        try {
            $newCart = $this->eloquentCartModel->create(['status' => CartStatusEnum::ACTIVE]);
            return $newCart->id;
        } catch (ModelNotFoundException | MassAssignmentException $exception) {
            $errorMessage = $exception->getMessage();
            $errorCode = $exception->getCode();
            throw new CartException("$errorMessage", $errorCode);
        }
    }

    /**
     * Validates a cart item.
     *
     * @param mixed $cartItem The cart item data to validate.
     * @param mixed $key The key associated with the cart item in the input array.
     * @throws CartValidationException If the cart item data is invalid.
     */
    private function validateCartItem(CartItemData $cartItem,  int $key)
    {
        if (!$cartItem instanceof CartItemData) {
            throw new CartItemsException("Items", "array", "$key");
        }
    }

    private function addItemsToCart(array $cartItem, CartId $cartId)
    {
        $newCartItem = $this->eloquentCartItemsModel;

        foreach ($cartItem as $KeyProductId => $item) {
            $productId = new CartItemProductId($KeyProductId);
            $quantity = new CartItemQuantity($item['quantity']);
            $price = new CartItemPrice($item['price']);

            $cartItemData = [
                'cart_id'   => $cartId->value(),
                'product_id'   => $productId->value(),
                'quantity'   => $quantity->value(),
                'price'   => $price->value()
            ];

            $newCartItem->create($cartItemData);
        }
    }

    private function handleException(\Exception $exception): void
    {
        DB::rollback();
        $errorMessage = $exception->getMessage();
        $errorCode = $exception->getCode();
        if (strpos($exception->getMessage(), 'Integrity constraint violation') !== false) {
            $errorMessage = "Integrity constraint violation";
            throw new CartException("$errorMessage", Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        throw new CartException("$errorMessage", $errorCode);
        throw new CartItemsException("Items", "array", "$errorMessage");
    }
}
