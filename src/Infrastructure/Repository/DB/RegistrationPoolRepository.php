<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB;

use Doctrine\ORM\EntityManagerInterface;
use Alumni\Infrastructure\Repository\DB\Mapper\RegistrationPoolMapper;

use Alumni\Infrastructure\Entity\UsersRegistrationPoolDoctrine;
use Alumni\Domain\Entity\UserRegistrationPool;

use Alumni\Domain\Repository\DB\RegistrationPoolRepositoryInterface;
use Alumni\Domain\Repository\DB\UserRepositoryInterface;

class RegistrationPoolRepository implements RegistrationPoolRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UserRepositoryInterface $userRepository,
        private readonly RegistrationPoolMapper $registrationPoolMapper
    ) {}

    public function getAll(): array
    {
        $registrationsDoctrine = $this->em->getRepository(UsersRegistrationPoolDoctrine::class)->findAll();
        $registrations = [];

        foreach ($registrationsDoctrine as $registration)
        {
            $registrations[] = $this->registrationPoolMapper->toDomain($registration);
        }
        return $registrations;
    }

    public function getBy(array $condition): ?UserRegistrationPool
    {
        $registrationDoctrine = $this->em->getRepository(UsersRegistrationPoolDoctrine::class)->findOneBy($condition);
        if(is_null($registrationDoctrine))
        {
            return null;
        }

        return $this->registrationPoolMapper->toDomain($registrationDoctrine);
    }
    
    public function register(string $username, string $emailAddress, string $password): bool
    {
        $registration = new UsersRegistrationPoolDoctrine();
        $registration->setUsername($username);
        $registration->setEmailAddress($emailAddress);
        $registration->setPassword(password_hash($password, PASSWORD_DEFAULT));

        $this->em->persist($registration);
        $this->em->flush();

        return true;
    }

    public function moveUser(int $id, int $promId): ?bool
    {
        $pool = $this->getBy(['id' => $id]);
        if (is_null($pool)) return null;

        if ($this->userRepository->registerNewUser($pool))
        {
            $this->deleteUser($id);
            return true;
        }

        return false;
    }

    public function deleteUser(int $id): bool
    {
        $pool = $this->em->find(UsersRegistrationPoolDoctrine::class, $id);
        if (is_null($pool)) return null;
        
        $this->em->remove($pool);
        $this->em->flush();

        return false;
    }
}