<?php

namespace Src\ShoppingContext\User\Infrastructure\Repositories\Exceptions;

use App\Exceptions\ShoppingCartException;
use Symfony\Component\HttpFoundation\Response;

class DuplicateEmailException extends ShoppingCartException
{
    public function __construct(string $email)
    {
        $message = "Duplicate email " . $email;

        parent::__construct(
            $message,
            Response::HTTP_CONFLICT,
        );
    }
}
