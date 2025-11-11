<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\ReactivateAccount;

class ReactivateAccountRequest
{
    public function __construct(
        public readonly int $userId
    ) {}
}