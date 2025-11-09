<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UploadPost;

class UploadPostRequest
{
    public function __construct(
        public readonly int $userId,
        public readonly int $channelId,
        public array $content
    ) {}
}