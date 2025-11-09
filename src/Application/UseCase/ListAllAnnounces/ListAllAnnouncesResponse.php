<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\ListAllAnnounces;

class ListAllAnnouncesResponse
{
    public function __construct(
        public readonly array $announces,
        public readonly int $status
    ) {}
}