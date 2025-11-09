<?php declare(strict_types=1);

namespace Alumni\Domain\Repository\DB;

use Alumni\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function getAll(): array;
    public function getBy(array $conditions): User;
}