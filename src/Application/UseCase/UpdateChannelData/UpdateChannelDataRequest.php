<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UpdateChannelData;

class UpdateChannelDataRequest
{
    public function __construct(
        public readonly int $userId,
        public readonly int $channelId,
        public readonly string $field,
        public readonly string $value
    ) {}
}