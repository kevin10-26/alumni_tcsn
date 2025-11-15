<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB\Mapper;

use Alumni\Domain\Entity\MasterProm;
use Alumni\Infrastructure\Entity\MasterPromDoctrine;

class MasterPromMapper
{
    public function toDomain(MasterPromDoctrine $masterPromDoctrine, ?array $students = [], ?array $delegates = []): MasterProm
    {
        return new MasterProm(
            id: $masterPromDoctrine->getId(),
            year: $masterPromDoctrine->getYear(),
            name: $masterPromDoctrine->getName(),
            students: $students,
            delegates: $delegates
        );
    }

    public function toDoctrine(MasterProm $masterProm): MasterPromDoctrine
    {
        $masterPromDoctrine = new MasterPromDoctrine();
        $masterPromDoctrine->setYear($masterProm->year);
        $masterPromDoctrine->setName($masterProm->name);
        
        return $masterPromDoctrine;
    }
}
