<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB\Mapper;

use Alumni\Domain\Entity\UserRegistrationPool;
use Alumni\Domain\ValueObject\EmailAddress;

use Alumni\Infrastructure\Entity\UsersRegistrationPoolDoctrine;

class RegistrationPoolMapper
{
    public function toDomain(UsersRegistrationPoolDoctrine $registration): UserRegistrationPool
    {
        return new UserRegistrationPool(
            id: $registration->getId(),
            username: $registration->getUsername(),
            emailAddress: new EmailAddress($registration->getEmailAddress()),
            password: $registration->getPassword()
        );
    }
}