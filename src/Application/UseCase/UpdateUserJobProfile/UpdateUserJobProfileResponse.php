<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UpdateUserJobProfile;

class UpdateUserJobProfileResponse
{
    public function __construct(
        public int $status,
        public string $msg
    ) {}
}