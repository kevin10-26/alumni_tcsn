<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB;

use Doctrine\ORM\EntityManagerInterface;

use Alumni\Infrastructure\Repository\DB\Mapper\StudentDataMapper;
use Alumni\Infrastructure\Repository\DB\Mapper\MasterPromMapper;

use Alumni\Infrastructure\Entity\StudentDataDoctrine;
use Alumni\Infrastructure\Entity\MasterPromDoctrine;
use Alumni\Infrastructure\Entity\UserDoctrine;

use Alumni\Domain\Entity\MasterProm;
use Alumni\Domain\Entity\StudentData;

use Alumni\Domain\Repository\DB\StudentRepositoryInterface;

class StudentRepository implements StudentRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly StudentDataMapper $studentDataMapper,
        private readonly MasterPromMapper $masterPromMapper,
    ) {}

    public function getStudentsForPromotion(int $promId): array
    {
        $studentsDoctrine = $this->em->getRepository(StudentDataDoctrine::class)->findBy(['prom' => $promId]);
        $students = [];

        foreach($studentsDoctrine as $student)
        {
            $students[] = $this->studentDataMapper->toDomain($student);
        }
        return $students;
    }

    public function getPromotionBy(array $conditions): MasterProm
    {
        $promotion = $this->em->getRepository(MasterPromDoctrine::class)->findOneBy($conditions);
        $students = $this->getStudentsForPromotion($promotion->getId());
        $delegates = $this->getPromotionDelegates($promotion->getId());

        return $this->masterPromMapper->toDomain($promotion, $students, $delegates);
    }

    public function getPromotionDelegates(int $promotionId): array
    {
        $delegatesDoctrine = $this->em->getRepository(StudentDataDoctrine::class)->findBy(['prom' => $promotionId, 'isDelegate' => true]);
        $delegates = [];
        
        foreach($delegatesDoctrine as $delegate)
        {
            $delegates[] = $this->studentDataMapper->toDomain($delegate);
        }
        return $delegates;
    }

    public function getAllPromotions(): array
    {
        $promotionsDoctrine = $this->em->getRepository(MasterPromDoctrine::class)->findBy([], ['id' => 'DESC']);
        $promotions = [];

        foreach($promotionsDoctrine as $promotion)
        {
            $promotions[] = $this->masterPromMapper->toDomain($promotion);
        }
        return $promotions;
    }

    public function createPromotion(string $name, int $year, array $users, array $delegates): bool
    {
        $promotion = new MasterPromDoctrine();
        $promotion->setName($name);
        $promotion->setYear($year);

        $this->em->persist($promotion);
        $this->em->flush();

        foreach ($users as $username)
        {
            $this->assignPromotionToStudent($promotion->getId(), $username, in_array($username, $delegates));
        }

        return true;
    }

    public function editPromotion(string $name, int $promId, int $year, array $users, array $delegates): bool
    {
        $promotion = $this->em->find(MasterPromDoctrine::class, $promId);
        if (is_null($promotion)) return false;

        $promotion->setName($name);
        $promotion->setYear($year);

        $this->em->persist($promotion);
        $this->em->flush();

        return true;
    }

    public function removePromotion(int $promotionId): bool
    {
        $promotion = $this->em->find(MasterPromDoctrine::class, $promotionId);
        if (is_null($promotion)) return false;

        $this->em->remove($promotion);
        $this->em->flush();

        return true;
    }

    public function assignPromotionToStudent(int $promotionId, string $username, bool $isDelegate): bool
    {
        $user = $this->em->getRepository(UserDoctrine::class)->findOneBy(['name' => $username]);
        $promotion = $this->em->find(MasterPromDoctrine::class, $promotionId);
        if (is_null($user) || is_null($promotion)) return false;

        $studentData = new StudentDataDoctrine();
        $studentData->setProm($promotion);
        $studentData->setUser($user);
        $studentData->setIsDelegate($isDelegate);

        $this->em->persist($studentData);
        $this->em->flush();

        return true;
    }

    public function removeStudentFromPromotion(int $promotionId, int $userId): bool
    {
        $studentData = $this->em->getRepository(StudentDataDoctrine::class)->findOneBy(['user' => $userId]);
        if (is_null($studentData)) return false;
        
        $this->em->remove($studentData);
        $this->em->flush();

        return true;
    }

    public function setStudentData(int $promotionId, int $userId, array $data): bool
    {
        $dql = sprintf(
            "UPDATE %s u SET u.%s = :value WHERE u.user = :userId AND u.prom = :promotion",
            StudentDataDoctrine::class,
            $data['field']
        );
        
        // Récupérer l'entité MasterPromDoctrine
        $promotion = $this->em->getReference(MasterPromDoctrine::class, $promotionId);
        $user = $this->em->getReference(UserDoctrine::class, $userId);

        $rows = $this->em->createQuery($dql)
            ->setParameter('value', $data['value'])
            ->setParameter('userId', $user)
            ->setParameter('promotion', $promotion) // Passer l'objet entité
            ->execute();

        return $rows > 0;
        
    }
}