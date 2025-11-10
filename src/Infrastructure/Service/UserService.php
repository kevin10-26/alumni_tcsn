<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Service;

use Doctrine\ORM\EntityManagerInterface;

use Alumni\Infrastructure\Entity\UserDoctrine;
use Alumni\Infrastructure\Entity\UserDataDoctrine;

use Alumni\Infrastructure\Repository\File\Mapper\FileMapper;

use Alumni\Domain\Service\UserServiceInterface;

use Alumni\Domain\Entity\File;

class UserService implements UserServiceInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly FileMapper $fileMapper
    ) {}

    // Map UI fields to database fields
    public function getDatabaseField(string $uiField): string
    {
        $map = [
            'user-name' => 'name',
            'user-email' => 'email',
            'user-firstName' => 'firstName',
            'user-lastName' => 'lastName',
            'settings-password' => 'passwordHash',
            'settings-confirm-password' => 'passwordHash',
            'user-avatar' => 'avatar',
        ];

        if (!isset($map[$uiField])) {
            throw new \InvalidArgumentException("Unknown UI field: $uiField");
        }

        return $map[$uiField];
    }

    // Determine which entity contains the field
    public function getUserProfileType(string $dbField): string
    {
        $accountFields = ['name', 'email', 'passwordHash'];
        $dataFields = ['firstName', 'lastName', 'avatar'];

        if (in_array($dbField, $accountFields, true)) {
            return 'account';
        }

        if (in_array($dbField, $dataFields, true)) {
            return 'data';
        }

        throw new \InvalidArgumentException("Unknown database field: $dbField");
    }

    public function getAvatar(object $avatar): File
    {
        return $this->fileMapper->toDomain($avatar);
    }
}