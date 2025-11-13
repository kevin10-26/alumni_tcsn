<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\CreateChannel;

class CreateChannelRequest
{
    public function __construct(
        public readonly int $userId,
        public readonly string $name,
        public readonly string $description,
        public readonly bool $isPublic
    ) {}
}