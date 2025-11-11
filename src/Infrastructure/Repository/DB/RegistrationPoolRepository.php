<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB;

use Doctrine\ORM\EntityManagerInterface;
use Alumni\Infrastructure\Repository\DB\Mapper\RegistrationPoolMapper;

use Alumni\Infrastructure\Entity\UsersRegistrationPoolDoctrine;
use Alumni\Domain\Entity\UserRegistrationPool;

use Alumni\Domain\Repository\DB\RegistrationPoolRepositoryInterface;

class RegistrationPoolRepository implements RegistrationPoolRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em,
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
}