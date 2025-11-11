<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\DeactivateAccount;

class DeactivateAccountResponse
{
    public function __construct(
        public readonly int $status
    ) {}
}