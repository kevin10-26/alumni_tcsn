<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\ReactivateAccount;

class ReactivateAccountResponse
{
    public function __construct(
        public readonly int $status
    ) {}
}