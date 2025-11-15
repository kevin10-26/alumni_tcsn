<?php declare(strict_types=1);

namespace Alumni\Domain\Repository\DB;

use Alumni\Domain\Entity\MasterProm;

interface StudentRepositoryInterface
{
    public function getStudentsForPromotion(int $promId): array;
    public function getPromotionBy(array $conditions): MasterProm;
    public function getPromotionDelegates(int $promotionId): array;
    public function getAllPromotions(): array;
    public function createPromotion(string $name, int $year, array $users, array $delegates): bool;
    public function editPromotion(string $name, int $promId, int $year, array $users, array $delegates): bool;
    public function removePromotion(int $promotionId): bool;
    public function assignPromotionToStudent(int $promotionId, string $username, bool $isDelegate);
    public function removeStudentFromPromotion(int $promotionId, int $userId): bool;

    public function setStudentData(int $promotionId, int $userId, array $data): bool;
}