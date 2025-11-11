<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Service;

use Doctrine\ORM\EntityManagerInterface;

use Alumni\Infrastructure\Entity\UserDoctrine;
use Alumni\Infrastructure\Entity\UserDataDoctrine;

use Alumni\Infrastructure\Repository\File\Mapper\FileMapper;

use Alumni\Domain\Service\UserServiceInterface;

use Alumni\Domain\Entity\File;
use Alumni\Domain\Entity\User;

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
            'settings-company-name' => 'company',
            'settings-position-name' => 'position',
            'settings-position-started' => 'startDate',
            'settings-position-ended' => 'endDate'
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
        $jobFields = ['company', 'position', 'startDate', 'endDate'];

        if (in_array($dbField, $accountFields, true)) {
            return 'account';
        }

        if (in_array($dbField, $dataFields, true)) {
            return 'data';
        }

        if (in_array($dbField, $jobFields, true))
        {
            return 'job';
        }

        throw new \InvalidArgumentException("Unknown database field: $dbField");
    }

    public function getAvatar(object $avatar): File
    {
        return $this->fileMapper->toDomain($avatar);
    }
}