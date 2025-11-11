<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\GetPortability;

class GetPortabilityResponse
{
    public function __construct(
        public readonly int $status,
        public readonly string $pathToPortabilityFile
    ) {}
}