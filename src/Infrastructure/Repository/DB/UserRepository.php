<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB;

use Doctrine\ORM\EntityManagerInterface;

use Alumni\Domain\Repository\DB\UserRepositoryInterface;

use Alumni\Domain\Entity\User;

use Alumni\Infrastructure\Entity\UserDoctrine;
use Alumni\Infrastructure\Entity\UsersDeactivatedDoctrine;

use Alumni\Infrastructure\Repository\DB\Mapper\UserMapper;

use Alumni\Domain\Service\UserServiceInterface;

/**
 * Repository implementation for managing User entities in the database.
 * 
 * This repository handles all database operations for users, including
 * retrieval by various criteria.
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * Creates a new instance of UserRepository.
     * 
     * @param EntityManagerInterface $em Doctrine entity manager for database operations
     * @param UserMapper $mapper Mapper for converting between domain and Doctrine entities
     */
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UserServiceInterface $userService,
        private readonly UserMapper $mapper
    ) {}

    /**
     * Retrieves all users from the database.
     * 
     * @return array<User> Array of all users as domain entities
     */
    public function getAll(): array
    {
        $users = $this->em->getRepository(UserDoctrine::class)->findAll();
        $domainUsers = [];

        foreach($users as $user)
        {
            $domainUsers[] = $this->mapper->toDomain($user);
        }

        return $domainUsers;
    }

    /**
     * Retrieves a single user by the given conditions.
     * 
     * @param array<string, mixed> $conditions Associative array of field => value pairs to search for
     * @return User The found user as a domain entity
     */
    public function getBy(array $conditions): ?User
    {
        $adminDoctrine = $this->em->getRepository(UserDoctrine::class)->findOneBy($conditions);
        if(is_null($adminDoctrine)) return null;

        return $this->mapper->toDomain($adminDoctrine);
    }

    public function update(int $userId, string $field, mixed $value): bool
    {
        $matchingField = $this->userService->getDatabaseField($field);
        $userProfileType = $this->userService->getUserProfileType($matchingField);

        switch ($userProfileType)
        {
            case 'account':
                $dql = sprintf(
                    'UPDATE Alumni\Infrastructure\Entity\UserDoctrine u SET u.%s = :value WHERE u.id = :id',
                    $matchingField
                );
                break;

            case 'data':
                $dql = sprintf(
                    'UPDATE Alumni\Infrastructure\Entity\UserDataDoctrine d SET d.%s = :value WHERE d.user = :id',
                    $matchingField
                );
                break;

            case 'job':
                $dql = sprintf(
                    'UPDATE Alumni\Infrastructure\Entity\UserJobDataDoctrine j SET j.%s = :value WHERE j.user = :id',
                    $matchingField
                );
                break;

            default:
                throw new \RuntimeException("Type de profil inconnu : $userProfileType");
        }

        $value = $this->userService->getCorrectValue($matchingField, $value);

        $query = $this->em->createQuery($dql)
            ->setParameter('value', $value)
            ->setParameter('id', $userId);

        $query->execute();

        return true;
    }

    public function authenticate(string $emailAddress, string $password): ?User
    {
        $user = $this->em->getRepository(UserDoctrine::class)->findOneBy(['email' => $emailAddress]);
        if (is_null($user)) return null;

        return (password_verify($password, $user->getPasswordHash())) ? $this->mapper->toDomain($user) : null;
    }

    public function deactivate(int $userId, string $deactivationEndsTimestamps, string $origin): bool
    {
        $user = $this->em->find(UserDoctrine::class, $userId);
        if (is_null($user))
        {
            return false;
        }

        $deactivation = new UsersDeactivatedDoctrine();
        $deactivation->setUser($user);
        $deactivation->setStartedAt(new \DateTime('now'));
        $deactivation->setEndsAt(new \DateTime($deactivationEndsTimestamps));
        $deactivation->setOrigin($origin);

        $this->em->persist($deactivation);
        $this->em->flush();

        return true;
    }

    public function reactivate(int $userId): bool
    {
        $user = $this->em->find(UserDoctrine::class, $userId);
        if (is_null($user))
        {
            return false;
        }

        $lastDeactivation = $this->em->getRepository(UsersDeactivatedDoctrine::class)->findOneBy(['endsAt' => null]);
        if (is_null($lastDeactivation))
        {
            return false;
        }

        $this->em->remove($lastDeactivation);
        $this->em->flush();

        return true;
    }

    public function remove(int $userId): bool
    {
        $user = $this->em->find(UserDoctrine::class, $userId);
        if (is_null($user))
        {
            return false;
        }

        $this->em->remove($user);
        $this->em->flush();

        return true;
    }
}