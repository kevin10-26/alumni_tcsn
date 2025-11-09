<?php declare(strict_types=1);

namespace Alumni\Domain\Repository\DB;

use Alumni\Domain\Entity\Announce;

interface AnnouncesRepositoryInterface
{
    public function getAll(): array;
    public function getBy(array $condition): Announce;
}