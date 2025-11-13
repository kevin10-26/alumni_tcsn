<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\RefreshBackofficeTab;

class RefreshBackofficeTabResponse
{
    public function __construct(
        public readonly int $status,
        public readonly array $content,
        public readonly string $templateName
    ) {}
}