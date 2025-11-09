<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\RefreshChannelPosts;

class RefreshChannelPostsRequest
{
    public function __construct(
        public readonly int $userId,
        public readonly int $channelId
    ) {}
}