<?php declare(strict_types=1);

namespace Alumni\Domain\Repository\DB;

interface RefreshTokenRepositoryInterface
{
    public function create (
        string $token,
        int $adminId,
        \DateTime $expiresAt
    ): bool;

    public function remove(string $token): bool|int;

    public function findByToken(string $token): ?object;

    public function deleteByAdminId(int $adminId): bool;

    /**
     * Backwards-compatible alias using user terminology.
     */
    public function deleteByUserId(int $userId): bool;
}