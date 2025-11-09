<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UpdateChannelData;

class UpdateChannelDataResponse
{
    public function __construct(
        public readonly int $status,
        public readonly string $msg
    ) {}
}