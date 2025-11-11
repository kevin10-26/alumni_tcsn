<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UpdateUserJobProfile;

class UpdateUserJobProfileRequest
{
    public function __construct(
        public int $userId,
        public string $field,
        public string $value
    ) {}
}