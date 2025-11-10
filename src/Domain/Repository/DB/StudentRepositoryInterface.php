<?php declare(strict_types=1);

namespace Alumni\Domain\Repository\DB;

use Alumni\Domain\Entity\MasterProm;

interface StudentRepositoryInterface
{
    public function getStudentsForProm(int $promId): array;
}