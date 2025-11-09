<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UploadPost;

class UploadPostResponse
{
    public function __construct(
        public readonly int $status,
        public readonly string $msg
    ) {}
}