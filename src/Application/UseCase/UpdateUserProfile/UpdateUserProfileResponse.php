<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UpdateUserProfile;

class UpdateUserProfileResponse
{
    public function __construct(
        public readonly int $status,
        public readonly string $msg,
        public readonly mixed $updatedValue
    ) {}
}