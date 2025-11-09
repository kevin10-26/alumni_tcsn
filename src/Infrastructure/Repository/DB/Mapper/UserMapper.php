<?php

declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB\Mapper;

use Alumni\Domain\Entity\User;
use Alumni\Domain\ValueObject\EmailAddress;
use Alumni\Infrastructure\Entity\UserDoctrine;

class UserMapper
{
    public function __construct(
        private readonly UserDataMapper $userDataMapper,
        private readonly StudentDataMapper $studentDataMapper,
        private readonly UserJobDataMapper $userJobDataMapper
    ) {}

    public function toDomain(UserDoctrine $userDoctrine): User
    {
        return new User(
            id: $userDoctrine->getId(),
            username: $userDoctrine->getName(),
            passwordHash: $userDoctrine->getPasswordHash(),
            emailAddress: new EmailAddress($userDoctrine->getEmail()),
            status: $userDoctrine->getStatus(),
            userData: $userDoctrine->getUserData() ? $this->userDataMapper->toDomain($userDoctrine->getUserData()) : null,
            studentData: $userDoctrine->getStudentData() ? $this->studentDataMapper->mapStudentDataToArray($userDoctrine->getStudentData()) : null,
            userJobData: $userDoctrine->getUserJobData() ? $this->userJobDataMapper->toDomain($userDoctrine->getUserJobData()) : null,
            isAnonymous: $userDoctrine->isAnonymous() ? $userDoctrine->isAnonymous() : true
        );
    }

    public function toDoctrine(User $user): UserDoctrine
    {
        $userDoctrine = new UserDoctrine();
        $userDoctrine->setName($user->username);
        $userDoctrine->setPasswordHash($user->passwordHash);
        $userDoctrine->setEmail($user->emailAddress->value());
        $userDoctrine->setStatus($user->status);
        $userDoctrine->setAnonymousStatus($user->isAnonymous);

        if ($user->userData) {
            $userDoctrine->setUserData($this->userDataMapper->toDoctrine($user->userData));
        }

        if ($user->studentData) {
            $userDoctrine->setStudentData($this->studentDataMapper->mapStudentDataToCollection($user->studentData));
        }

        if ($user->userJobData) {
            $userDoctrine->setUserJobData($this->userJobDataMapper->toDoctrine($user->userJobData));
        }

        return $userDoctrine;
    }
}