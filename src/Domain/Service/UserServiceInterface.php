<?php declare(strict_types=1);

namespace Alumni\Domain\Service;

use Alumni\Domain\Entity\File;
use Alumni\Domain\Entity\User;

interface UserServiceInterface
{
    /**
     * Map a UI field name to a database field name.
     *
     * @param string $uiField
     * @return string
     */
    public function getDatabaseField(string $uiField): string;

    /**
     * Determine which entity holds the given database field.
     *
     * @param string $dbField
     * @return string 'account' for UserDoctrine, 'data' for UserDataDoctrine
     */
    public function getUserProfileType(string $dbField): string;
    public function getCorrectValue(string $field, mixed $value): mixed;

    public function getAvatar(object $avatar): File;
}