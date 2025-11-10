<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UpdatePost;

class UpdatePostRequest
{
    public function __construct(
        public readonly int $userId,
        public readonly int $channelId,
        public readonly int $postId,
        public array $content
    ) {}
}