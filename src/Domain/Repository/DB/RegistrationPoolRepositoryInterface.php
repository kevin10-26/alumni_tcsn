<?php declare(strict_types=1);

namespace Alumni\Domain\Repository\DB;

use Alumni\Domain\Entity\UserRegistrationPool;

interface RegistrationPoolRepositoryInterface
{
    public function getAll(): array;
    public function getBy(array $condition): ?UserRegistrationPool;
    public function register(string $username, string $emailAddress, string $password): bool;
}