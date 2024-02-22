<?php

declare(strict_types=1);

namespace Src\ShoppingContext\User\Infrastructure\Repositories;

use App\Models\User as EloquentUserModel;
use Src\ShoppingContext\User\Domain\Contracts\UserRepositoryContract;
use Src\ShoppingContext\User\Domain\User;
use Src\ShoppingContext\User\Domain\ValueObjects\UserEmail;
use Src\ShoppingContext\User\Domain\ValueObjects\UserEmailVerifiedDate;
use Src\ShoppingContext\User\Domain\ValueObjects\UserId;
use Src\ShoppingContext\User\Domain\ValueObjects\UserName;
use Src\ShoppingContext\User\Domain\ValueObjects\UserPassword;
use Src\ShoppingContext\User\Domain\ValueObjects\UserRememberToken;
use Src\ShoppingContext\User\Infrastructure\Repositories\Exceptions\DuplicateEmailException;
use Symfony\Component\HttpFoundation\Response;

final class EloquentUserRepository implements UserRepositoryContract
{
    private $eloquentUserModel;

    public function __construct()
    {
        $this->eloquentUserModel = new EloquentUserModel;
    }

    public function all(): array
    {
        $users = $this->eloquentUserModel->get()->toArray();

        return $users;
    }

    public function find(UserId $id): ?User
    {
        $user = $this->eloquentUserModel->findOrFail($id->value());
        // Return Domain User model
        return new User(
            new UserName($user->name),
            new UserEmail($user->email),
            new UserEmailVerifiedDate($user->email_verified_at),
            new UserPassword($user->password),
            new UserRememberToken($user->remember_token)
        );
    }

    public function findByCriteria(UserName $name, UserEmail $email): ?User
    {
        $user = $this->eloquentUserModel
            ->where('name', $name->value())
            ->where('email', $email->value())
            ->firstOrFail();

        // Return Domain User model
        return new User(
            new UserName($user->name),
            new UserEmail($user->email),
            new UserEmailVerifiedDate($user->email_verified_at),
            new UserPassword($user->password),
            new UserRememberToken($user->remember_token)
        );
    }

    public function save(User $user): void
    {
        $newUser = $this->eloquentUserModel;

        $data = [
            'name'              => $user->name()->value(),
            'email'             => $user->email()->value(),
            'email_verified_at' => $user->emailVerifiedDate()->value(),
            'password'          => $user->password()->value(),
            'remember_token'    => $user->rememberToken()->value(),
        ];

        $userExist = $newUser
            ->where('email', $user->email()->value())
            ->first();

        if ($userExist) {
            throw new DuplicateEmailException($user->email()->value());
        }

        $newUser->create($data);
    }

    /**
     * @param UserId $id
     * @param User $user
     * @return void
     * @throws DuplicateEmailException
     */
    public function update(UserId $id, User $user): void
    {
        $userToUpdate = $this->eloquentUserModel;

        $data = [
            'name'  => $user->name()->value(),
            'email' => $user->email()->value(),
        ];

        $userExist = $userToUpdate
            ->where('id', "<>", $id->value())
            ->where('email', $user->email()->value())
            ->first();

        if ($userExist) {
            throw new DuplicateEmailException($user->email()->value());
        }

        $userToUpdate
            ->findOrFail($id->value())
            ->update($data);
    }

    public function delete(UserId $id): void
    {
        $this->eloquentUserModel
            ->findOrFail($id->value())
            ->delete();
    }
}
