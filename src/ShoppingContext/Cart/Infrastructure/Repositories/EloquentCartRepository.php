<?php

namespace Src\ShoppingContext\Cart\Infrastructure\Repositories;

use App\Models\Cart as EloquentCartModel;
use Src\ShoppingContext\Cart\Domain\Cart;
use Src\ShoppingContext\Cart\Domain\ValueObjects\CartId;
use Src\ShoppingContext\Cart\Domain\ValueObjects\cartUserId;
use Src\ShoppingContext\Cart\Domain\ValueObjects\CartStatus;
use Src\ShoppingContext\Cart\Domain\Contracts\CartRepositoryContract;
use Illuminate\Support\Facades\DB;
use Src\ShoppingContext\Cart\Domain\Enums\CartStatus as CartStatusEnum;
use Src\ShoppingContext\Cart\Infrastructure\Repositories\Exceptions\CartException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\MassAssignmentException;

class EloquentCartRepository implements CartRepositoryContract
{
    private $eloquentCartModel;
    private $cartItemRepository;

    public function __construct(CartItemRepository $cartItemRepository)
    {
        $this->eloquentCartModel = new EloquentCartModel;
        $this->cartItemRepository = $cartItemRepository;
    }

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
     * @param ProductCode $code
     * @param ProductName $name
     * @return Product
     */
    public function findByCriteria(CartId $id, ?CartUserId $userId): ?Cart
    {
        $query = $this->eloquentCartModel->with('items')
            ->where('id', $id->value());

        if ($userId !== null) {
            $query->where('user_id', $userId->value());
        }

        $cart = $query->firstOrFail();

        return new Cart(
            new CartId($cart->id),
            new cartUserId($cart->user_id),
            new CartStatus($cart->status),
            array($cart->items),
        );
    }

    public function addCart(array $cartItemsData): CartId
    {
        DB::beginTransaction();

        try {

            $newCartModelId = $this->createNewCart();
            $cartId = new CartId($newCartModelId);

            $this->cartItemRepository->updateOrCreateCartItems($cartId, $cartItemsData);

            DB::commit();
            return $cartId;
        } catch (\Exception $exception) {
            $this->handleException($exception);
        }
    }

    public function updateCart(int $id, array $cartItemsData): CartId
    {
        DB::beginTransaction();

        try {
            $cart = $this->eloquentCartModel->findOrFail($id);

            if (CartStatusEnum::ACTIVE !== $cart->status) {
                throw new CartException("The cart status is $cart->status, no changes can be made", Response::HTTP_FORBIDDEN);
            }
            $cartId = new CartId($cart->id);

            $this->cartItemRepository->removeItemsNotPresentInRequest($cartId, $cartItemsData);
            $this->cartItemRepository->updateOrCreateCartItems($cartId, $cartItemsData);

            DB::commit();

            return $cartId;
        } catch (\Exception $exception) {
            $this->handleException($exception);
        }
    }

    public function delete(CartId $id): void
    {
        $this->eloquentCartModel
            ->findOrFail($id->value())
            ->delete();
    }

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
    }
}
