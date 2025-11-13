<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\RefreshBackofficeTab;

class RefreshBackofficeTabRequest
{
    public function __construct(
        public readonly int $userId,
        public readonly string $tabName
    ) {}
}