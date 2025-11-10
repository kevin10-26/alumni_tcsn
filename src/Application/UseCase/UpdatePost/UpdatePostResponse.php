<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UpdatePost;

class UpdatePostResponse
{
    public function __construct(
        public readonly int $status,
        public readonly string $msg
    ) {}
}