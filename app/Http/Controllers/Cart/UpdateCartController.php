<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Resources\Cart\Cart as CartResource;
use Illuminate\Http\Request;
use Src\ShoppingContext\Cart\Infrastructure\UpdateCartController as UpdateCartInfrastructure;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class UpdateCartController extends Controller
{

    /**
     * @var UpdateCartInfrastructure
     */
    private $updateCartController;

    public function __construct(UpdateCartInfrastructure $updateCartController)
    {
        $this->updateCartController = $updateCartController;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $addCart = new CartResource($this->updateCartController->__invoke($request));

        return response($addCart, Response::HTTP_OK);
    }
}
