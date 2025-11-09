<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\JoinChannel;

class JoinChannelRequest
{
    public function __construct(
        public readonly int $channelId,
        public readonly int $userId
    ) {}
}