<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\GetPortability;

class GetPortabilityRequest
{
    public function __construct(
        public readonly int $userId
    ) {}
}