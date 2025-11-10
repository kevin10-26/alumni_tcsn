<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\DeletePost;

class DeletePostRequest
{
    public function __construct(
        public int $userId,
        public int $channelId,
        public int $postId
    ) {}
}