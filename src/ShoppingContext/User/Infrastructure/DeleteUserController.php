<?php

declare(strict_types=1);

namespace Src\ShoppingContext\User\Infrastructure;

use Illuminate\Http\Request;
use Src\ShoppingContext\User\Application\DeleteUserUseCase;
use Src\ShoppingContext\User\Infrastructure\Repositories\EloquentUserRepository;

final class DeleteUserController
{
    private $repository;

    public function __construct(EloquentUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Request $request)
    {
        $userId = (int)$request->id;

        $deleteUserUseCase = new DeleteUserUseCase($this->repository);
        $deleteUserUseCase->__invoke($userId);
    }
}