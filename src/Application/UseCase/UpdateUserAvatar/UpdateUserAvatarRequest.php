<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UpdateUserAvatar;

class UpdateUserAvatarRequest
{
    public function __construct(
        public readonly int $userId,
        public readonly object $avatar
    ) {}
}