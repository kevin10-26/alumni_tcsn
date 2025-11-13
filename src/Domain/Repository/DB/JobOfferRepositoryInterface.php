<?php declare(strict_types=1);

namespace Alumni\Domain\Repository\DB;

use Alumni\Domain\Entity\JobOffer;

interface JobOfferRepositoryInterface
{
    public function getAll(): array;
    public function getById(int $id): JobOffer;
    public function getByCompany(int $companyId): array;
    public function getByAuthor(int $authorId): array;
    public function getUserSavedOffers(int $userId): array;
    public function remove(int $id): bool;
}