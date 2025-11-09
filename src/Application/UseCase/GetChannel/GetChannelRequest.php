<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\GetChannel;

class GetChannelRequest
{
    public function __construct(
        public readonly int $userId,
        public readonly int $channelId
    ) {}
}
