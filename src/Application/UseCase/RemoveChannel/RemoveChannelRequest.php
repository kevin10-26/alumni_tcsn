<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\RemoveChannel;

class RemoveChannelRequest
{
    public function __construct(
        public readonly int $userId,
        public readonly int $channelId,
        public readonly string $userPassword
    ) {}
}