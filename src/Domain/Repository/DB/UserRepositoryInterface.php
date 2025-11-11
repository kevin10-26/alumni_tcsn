<?php declare(strict_types=1);

namespace Alumni\Domain\Repository\DB;

use Alumni\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function getAll(): array;
    public function getBy(array $conditions): User;
    public function update(int $userId, string $field, mixed $value): bool;
    public function authenticate(string $username, string $password): ?User;
    public function deactivate(int $userId, string $deactivationEndsTimestamps, string $origin): bool;
    public function reactivate(int $userId): bool;
}