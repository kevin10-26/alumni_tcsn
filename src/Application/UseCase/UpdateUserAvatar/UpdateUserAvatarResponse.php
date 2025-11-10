<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UpdateUserAvatar;

class UpdateUserAvatarResponse
{
    public function __construct(
        public readonly int $status,
        public readonly string $msg,
        public readonly string $updatedAvatarPath
    ) {}
}