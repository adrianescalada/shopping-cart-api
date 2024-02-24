<?php

namespace App\Http\Controllers\Cart;

use Illuminate\Http\Request;
use Src\ShoppingContext\Cart\Infrastructure\DeleteCartController as DeleteCartInfrastructure;
use App\Http\Controllers\Controller;

class DeleteCartController extends Controller
{
    /**
     * @var DeleteCartInfrastructure
     */
    private $deleteCartController;

    public function __construct(DeleteCartInfrastructure $deleteCartController)
    {
        $this->deleteCartController = $deleteCartController;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $this->deleteCartController->__invoke($request);

        return response([], 204);
    }
}
