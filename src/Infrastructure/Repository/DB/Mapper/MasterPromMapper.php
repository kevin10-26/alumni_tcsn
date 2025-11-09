<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB\Mapper;

use Alumni\Domain\Entity\MasterProm;
use Alumni\Infrastructure\Entity\MasterPromDoctrine;

class MasterPromMapper
{
    public function toDomain(MasterPromDoctrine $masterPromDoctrine): MasterProm
    {
        return new MasterProm(
            id: $masterPromDoctrine->getId(),
            year: $masterPromDoctrine->getYear()
        );
    }

    public function toDoctrine(MasterProm $masterProm): MasterPromDoctrine
    {
        $masterPromDoctrine = new MasterPromDoctrine();
        $masterPromDoctrine->setYear($masterProm->year);
        
        return $masterPromDoctrine;
    }
}
