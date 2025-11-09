<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB;

use Doctrine\ORM\EntityManagerInterface;

use Alumni\Domain\Repository\DB\UserRepositoryInterface;

use Alumni\Domain\Entity\User;

use Alumni\Infrastructure\Entity\UserDoctrine;

use Alumni\Infrastructure\Repository\DB\Mapper\UserMapper;

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
    public function getBy(array $conditions): User
    {
        $adminDoctrine = $this->em->getRepository(UserDoctrine::class)->findOneBy($conditions);

        return $this->mapper->toDomain($adminDoctrine);
    }
}