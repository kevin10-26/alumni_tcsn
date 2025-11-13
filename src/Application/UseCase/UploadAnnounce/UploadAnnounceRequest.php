<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UploadAnnounce;

class UploadAnnounceRequest
{
    public function __construct(
        public readonly int $userId,
        public readonly string $title,
        public readonly string $content
    ) {}
}