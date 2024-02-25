<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Resources\Cart\Cart as CartResource;
use Illuminate\Http\Request;
use Src\ShoppingContext\Cart\Infrastructure\AddItemCartController as AddItemCartInfrastructure;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class AddItemCartController extends Controller
{
    /**
     * @var AddItemCartInfrastructure
     */
    private $addItemCartController;

    public function __construct(AddItemCartInfrastructure $addItemCartController)
    {
        $this->addItemCartController = $addItemCartController;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $addCart = new CartResource($this->addItemCartController->__invoke($request));

        return response($addCart, Response::HTTP_CREATED);
    }
}
