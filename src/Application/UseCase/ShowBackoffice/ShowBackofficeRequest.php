<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\ShowBackoffice;

class ShowBackofficeRequest
{
    public function __construct(
        public readonly int $userId
    ) {}
}