<?php

declare(strict_types=1);

namespace Src\ShoppingContext\User\Domain\Contracts;

use Src\ShoppingContext\User\Domain\User;
use Src\ShoppingContext\User\Domain\ValueObjects\UserEmail;
use Src\ShoppingContext\User\Domain\ValueObjects\UserEmailVerifiedDate;
use Src\ShoppingContext\User\Domain\ValueObjects\UserId;
use Src\ShoppingContext\User\Domain\ValueObjects\UserName;

interface UserRepositoryContract
{
    public function all(): array;

    public function find(UserId $id): ?User;

    public function findByCriteria(UserName $userName, UserEmail $userEmail): ?User;

    public function save(User $user): void;

    public function update(UserId $userId, User $user): void;

    public function delete(UserId $id): void;
}
