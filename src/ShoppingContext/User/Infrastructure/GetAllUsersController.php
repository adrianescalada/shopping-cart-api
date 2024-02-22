<?php

declare(strict_types=1);

namespace Src\ShoppingContext\User\Infrastructure;

use Illuminate\Http\Request;
use Src\ShoppingContext\User\Application\GetAllUserUseCase;
use Src\ShoppingContext\User\Infrastructure\Repositories\EloquentUserRepository;

final class GetAllUsersController
{
    private $repository;

    public function __construct(EloquentUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Request $request)
    {
        $getAllUserUseCase = new GetAllUserUseCase($this->repository);
        $users = $getAllUserUseCase->__invoke();

        return $users;
    }
}
