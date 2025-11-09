<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB\Mapper;

use Alumni\Domain\Entity\StudentData;
use Alumni\Infrastructure\Entity\StudentDataDoctrine;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class StudentDataMapper
{
    public function __construct(
        private readonly MasterPromMapper $masterPromMapper
    ) {}

    public function toDomain(StudentDataDoctrine $studentDataDoctrine): StudentData
    {
        return new StudentData(
            id: $studentDataDoctrine->getId(),
            prom: $this->masterPromMapper->toDomain($studentDataDoctrine->getProm()),
            startedAt: $studentDataDoctrine->getStartedAt(),
            graduatedAt: $studentDataDoctrine->getGraduatedAt(),
            yearName: $studentDataDoctrine->getYearName(),
            isDelegate: $studentDataDoctrine->isDelegate()
        );
    }

    public function toDoctrine(StudentData $studentData): StudentDataDoctrine
    {
        $studentDataDoctrine = new StudentDataDoctrine();
        $studentDataDoctrine->setProm($this->masterPromMapper->toDoctrine($studentData->prom));
        $studentDataDoctrine->setStartedAt($studentData->startedAt);
        $studentDataDoctrine->setGraduatedAt($studentData->graduatedAt);
        $studentDataDoctrine->setYearName($studentData->yearName);
        $studentDataDoctrine->setIsDelegate($studentData->isDelegate);
        
        return $studentDataDoctrine;
    }

    public function mapStudentDataToArray(Collection $studentData): array
    {
        $data = [];
        foreach($studentData as $dataDoctrine)
        {
            $data[] = $this->toDomain($dataDoctrine);
        }

        return $data;
    }

    public function mapStudentDataToCollection(array $studentData): Collection
    {
        $studentDataDoctrine = new ArrayCollection();
        foreach($studentData as $data)
        {
            $studentDataDoctrine->add($this->toDoctrine($data));
        }

        return $studentDataDoctrine;
    }
}
