<?php declare(strict_types=1);

namespace Alumni\Domain\Entity;

use Alumni\Domain\ValueObject\EmailAddress;

class User
{
    public function __construct(
        public readonly int $id,
        public readonly string $username,
        public readonly string $passwordHash,
        public readonly EmailAddress $emailAddress,
        public readonly string $status,
        public readonly bool $isAnonymous,
        public readonly ?UserData $userData = null,
        public ?array $studentData = null,
        public readonly ?UserJobData $userJobData = null,
        public readonly array $deactivations = []
    ) {}

    public function hasBeenDelegate()
    {
        return in_array(1, array_column($this->studentData, 'isDelegate'));
    }
}