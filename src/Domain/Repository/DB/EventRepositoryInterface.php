<?php declare(strict_types=1);

namespace Alumni\Domain\Repository\DB;

use Alumni\Domain\Entity\Event;

interface EventRepositoryInterface
{
    public function getLastEvents(): array;
}