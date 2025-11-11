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
            company: $userJobDataDoctrine->getCompany(),
            position: $userJobDataDoctrine->getPosition(),
            startedAt: $userJobDataDoctrine->getStartDate(),
            stoppedAt: $userJobDataDoctrine->getEndDate()
        );
    }

    public function toDoctrine(UserJobData $userJobData): UserJobDataDoctrine
    {
        $userJobDataDoctrine = new UserJobDataDoctrine();
        $userJobDataDoctrine->setCompany($userJobDataDoctrine->company);
        $userJobDataDoctrine->setPosition($userJobDataDoctrine->position);
        $userJobDataDoctrine->setStartDate($userJobData->startedAt);
        $userJobDataDoctrine->setEndDate($userJobData->stoppedAt);
        
        return $userJobDataDoctrine;
    }
}
