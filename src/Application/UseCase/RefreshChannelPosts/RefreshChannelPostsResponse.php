<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\RefreshChannelPosts;

use Alumni\Domain\Entity\User;

class RefreshChannelPostsResponse
{
    public function __construct(
        public readonly int $status,
        public readonly User $user,
        public readonly array $posts
    ) {}
}