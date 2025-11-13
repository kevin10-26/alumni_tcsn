<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UploadAnnounce;

class UploadAnnounceResponse
{
    public function __construct(
        public readonly int $status
    ) {}
}