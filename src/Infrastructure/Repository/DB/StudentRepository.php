<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB;

use Doctrine\ORM\EntityManagerInterface;

use Alumni\Infrastructure\Repository\DB\Mapper\StudentDataMapper;

use Alumni\Infrastructure\Entity\StudentDataDoctrine;

use Alumni\Domain\Repository\DB\StudentRepositoryInterface;

class StudentRepository implements StudentRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly StudentDataMapper $studentDataMapper
    ) {}

    public function getStudentsForProm(int $promId): array
    {
        $studentsDoctrine = $this->em->getRepository(StudentDataDoctrine::class)->findBy(['prom' => $promId]);
        $students = [];

        foreach($studentsDoctrine as $student)
        {
            $students[] = $this->studentDataMapper->toDomain($student);
        }
        return $students;
    }
}