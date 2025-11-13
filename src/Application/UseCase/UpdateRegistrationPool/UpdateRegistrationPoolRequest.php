<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UpdateRegistrationPool;

class UpdateRegistrationPoolRequest
{
    public function __construct(
        public readonly int $loggedUserId,
        public readonly int $poolId,
        public readonly string $decision,
        public readonly ?int $promId
    ) {}
}