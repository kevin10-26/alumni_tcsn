<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\ListAllAnnounces;

class ListAllAnnouncesRequest
{
    public function __construct(
        public readonly int $userId
    ) {}
}