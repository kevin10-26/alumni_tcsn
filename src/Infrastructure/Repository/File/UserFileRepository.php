<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\File;

use Alumni\Domain\Entity\File;
use Alumni\Domain\Repository\File\UserFileRepositoryInterface;

class UserFileRepository implements UserFileRepositoryInterface
{
    public function moveAvatar(int $userId, File $avatar): string
    {
        $relativePath = "img/users/$userId/profile_pictures/$avatar->name";

        move_uploaded_file($avatar->tmpName, $_ENV['APP_DIR'] . 'public/' . $relativePath);

        return $relativePath;
    }
}