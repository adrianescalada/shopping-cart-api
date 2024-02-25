<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use Src\ShoppingContext\Product\Infrastructure\DeleteProductController as DeleteProductInfrastructure;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class DeleteProductController extends Controller
{
    /**
     * @var DeleteProductInfrastructure
     */
    private $deleteProductController;

    public function __construct(DeleteProductInfrastructure $deleteProductController)
    {
        $this->deleteProductController = $deleteProductController;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $this->deleteProductController->__invoke($request);

        return response([], Response::HTTP_NO_CONTENT);
    }
}
