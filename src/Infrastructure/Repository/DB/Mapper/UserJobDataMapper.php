<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB\Mapper;

use Alumni\Domain\Entity\UserJobData;
use Alumni\Infrastructure\Entity\UserJobDataDoctrine;

class UserJobDataMapper
{
    public function toDomain(UserJobDataDoctrine $userJobDataDoctrine): UserJobData
    {
        return new UserJobData(
            id: $userJobDataDoctrine->getId(),
            startedAt: $userJobDataDoctrine->getStartedAt(),
            stoppedAt: $userJobDataDoctrine->getStoppedAt()
        );
    }

    public function toDoctrine(UserJobData $userJobData): UserJobDataDoctrine
    {
        $userJobDataDoctrine = new UserJobDataDoctrine();
        $userJobDataDoctrine->setStartedAt($userJobData->startedAt);
        $userJobDataDoctrine->setStoppedAt($userJobData->stoppedAt);
        
        return $userJobDataDoctrine;
    }
}
