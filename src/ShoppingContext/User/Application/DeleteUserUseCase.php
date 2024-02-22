<?php

declare(strict_types=1);

namespace Src\ShoppingContext\User\Application;

use Src\ShoppingContext\User\Domain\Contracts\UserRepositoryContract;
use Src\ShoppingContext\User\Domain\ValueObjects\UserId;

final class DeleteUserUseCase
{
    private $repository;

    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(int $userId): void
    {
        $id = new UserId($userId);

        $this->repository->delete($id);
    }
}
