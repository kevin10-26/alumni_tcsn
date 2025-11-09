<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\JoinChannel;

class JoinChannelResponse
{
    public function __construct(
        public readonly int $status,
        public readonly int $channelId
    ) {}
}