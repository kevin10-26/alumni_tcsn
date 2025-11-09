<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\DeletePost;

class DeletePostResponse
{
    public function __construct(
        public int $status,
        public string $msg
    ) {}
}