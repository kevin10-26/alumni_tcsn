<?php declare(strict_types=1);

namespace Alumni\Domain\Repository\DB;

use Alumni\Domain\Entity\Announce;

interface AnnouncesRepositoryInterface
{
    public function getAll(): array;
    public function getBy(array $condition): Announce;
    public function new(int $authorId, string $title, string $content): bool;
    public function update(int $announceId, string $title, string $content): bool;
    public function remove(int $id): bool;
}