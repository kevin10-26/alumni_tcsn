<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\DeactivateAccount;

class DeactivateAccountRequest
{
    public function __construct(
        public readonly int $userId,
        public readonly int $daysDeactivated
    ) {}
}