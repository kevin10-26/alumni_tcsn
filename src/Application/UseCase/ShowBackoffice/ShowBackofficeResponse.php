<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\ShowBackoffice;

class ShowBackofficeResponse
{
    public function __construct(
        public readonly int $status,
        public readonly array $users,
        public readonly array $reports,
        public readonly array $announces,
        public readonly array $channels,
        public readonly array $jobOffers
    ) {}
}