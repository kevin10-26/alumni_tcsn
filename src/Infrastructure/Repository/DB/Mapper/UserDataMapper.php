<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB\Mapper;

use Alumni\Domain\Entity\UserData;
use Alumni\Domain\Entity\JobOffer;

use Alumni\Domain\ValueObject\Avatar;

use Alumni\Infrastructure\Entity\UserDataDoctrine;

class UserDataMapper
{
    public function toDomain(UserDataDoctrine $userDataDoctrine): UserData
    {
        return new UserData(
            id: $userDataDoctrine->getId(),
            firstName: $userDataDoctrine->getFirstName(),
            lastName: $userDataDoctrine->getLastName(),
            avatar: new Avatar($userDataDoctrine->getAvatar()),
        );
    }

    public function toDoctrine(UserData $userData): UserDataDoctrine
    {
        $userDataDoctrine = new UserDataDoctrine();
        $userDataDoctrine->setFirstName($userData->firstName);
        $userDataDoctrine->setLastName($userData->lastName);
        $userDataDoctrine->setAvatar($userData->avatar->value());
        
        return $userDataDoctrine;
    }
}