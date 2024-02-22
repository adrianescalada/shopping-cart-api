<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Resources\User\User as UserResource;
use Illuminate\Http\Request;
use Src\ShoppingContext\User\Infrastructure\UpdateUserController as UpdateUserInfrastructure;
use App\Http\Controllers\Controller;

class UpdateUserController extends Controller
{
    /**
     * @var UpdateUserInfrastructure
     */
    private $updateUserController;

    public function __construct(UpdateUserInfrastructure $updateUserController)
    {
        $this->updateUserController = $updateUserController;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $updatedUser = new UserResource($this->updateUserController->__invoke($request));

        return response($updatedUser, 200);
    }
}
