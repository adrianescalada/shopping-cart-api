<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Cart\Domain\Enums;

class CartStatus
{
    const ACTIVE = 'active';
    const PENDING_PAYMENT = 'pending_payment';
    const COMPLETED = 'completed';
    const CANCELLED = 'cancelled';
    const EXPIRED = 'expired';
}
