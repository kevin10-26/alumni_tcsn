<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB;

use Doctrine\ORM\EntityManagerInterface;

use Alumni\Infrastructure\Repository\DB\Mapper\StudentDataMapper;
use Alumni\Infrastructure\Repository\DB\Mapper\MasterPromMapper;

use Alumni\Infrastructure\Entity\StudentDataDoctrine;
use Alumni\Infrastructure\Entity\MasterPromDoctrine;

use Alumni\Domain\Repository\DB\StudentRepositoryInterface;

class StudentRepository implements StudentRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly StudentDataMapper $studentDataMapper,
        private readonly MasterPromMapper $masterPromMapper,
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

    public function getAllPromotions(): array
    {
        $promotionsDoctrine = $this->em->getRepository(MasterPromDoctrine::class)->findAll();
        $promotions = [];

        foreach($promotionsDoctrine as $promotion)
        {
            $promotions[] = $this->masterPromMapper->toDomain($promotion);
        }
        return $promotions;
    }
}