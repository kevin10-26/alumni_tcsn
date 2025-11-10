<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UpdateUserProfile;

class UpdateUserProfileRequest
{
    public function __construct(
        public readonly int $userId,
        public readonly string $field,
        public readonly string $value
    ) {}
}