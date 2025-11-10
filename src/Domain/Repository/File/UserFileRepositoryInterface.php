<?php declare(strict_types=1);

namespace Alumni\Domain\Repository\File;

use Alumni\Domain\Entity\File;

interface UserFileRepositoryInterface
{
    public function moveAvatar(int $userId, File $avatar): string;
}