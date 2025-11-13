<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\RemoveAnnounce;

class RemoveAnnounceRequest
{
    public function __construct(
        public readonly int $userId,
        public readonly int $announceId
    ) {}
}