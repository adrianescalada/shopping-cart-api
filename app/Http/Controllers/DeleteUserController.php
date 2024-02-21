<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Src\ShoppingContext\User\Infrastructure\DeleteUserController as DeleteUserInfrastructure;

class DeleteUserController extends Controller
{
    /**
     * @var DeleteUserInfrastructure
     */
    private $deleteUserController;

    public function __construct(DeleteUserInfrastructure $deleteUserController)
    {
        $this->deleteUserController = $deleteUserController;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $this->deleteUserController->__invoke($request);

        return response([], 204);
    }
}
