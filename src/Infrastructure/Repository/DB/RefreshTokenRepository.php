<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB;

use Doctrine\ORM\EntityManager;

use Alumni\Infrastructure\Entity\RefreshToken;
use Alumni\Infrastructure\Entity\UserDoctrine;

use Alumni\Domain\Repository\DB\RefreshTokenRepositoryInterface;

/**
 * Repository implementation for managing RefreshToken entities in the database.
 * 
 * This repository handles all database operations for refresh tokens, including
 * creation, removal, and lookup by token or user ID.
 */
class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{
    /**
     * Creates a new instance of RefreshTokenRepository.
     * 
     * @param EntityManager $em Doctrine entity manager for database operations
     */
    public function __construct(
        private readonly EntityManager $em
    ) {}

    /**
     * Creates a new refresh token for a user.
     * 
     * @param string $token The refresh token string
     * @param int $adminId The ID of the user/admin
     * @param \DateTime $expiresAt The expiration date and time of the token
     * @return bool Returns true on success, false if user is not found
     */
    public function create(
        string $token,
        int $adminId,
        \DateTime $expiresAt
    ): bool
    {
        if (!$this->em->getRepository(UserDoctrine::class)->find($adminId))
        {
            return false;
        }

        $token = new RefreshToken(
            $token,
            $adminId,
            $expiresAt
        );

        $this->em->persist($token);
        $this->em->flush();

        return true;
    }

    /**
     * Removes a refresh token by its token string.
     * 
     * @param string $tokenName The refresh token string to remove
     * @return bool|int Returns the user ID if successful, false if token not found
     */
    public function remove(string $tokenName): bool|int
    {
        $token = $this->em->getRepository(RefreshToken::class)->findBy(['token' => $tokenName]);

        if (!$token)
        {
            return false;
        }
        
        $adminId = $token[0]->getUserId();

        $this->em->remove($token[0]);
        $this->em->flush();

        return $adminId;
    }

    /**
     * Finds a refresh token by its token string.
     * 
     * @param string $token The refresh token string to find
     * @return object|null The refresh token entity, or null if not found
     */
    public function findByToken(string $token): ?object
    {
        return $this->em->getRepository(RefreshToken::class)->findOneBy(['token' => $token]);
    }

    /**
     * Deletes all refresh tokens for a specific admin/user ID.
     * 
     * @param int $adminId The ID of the admin/user
     * @return bool Returns true on success, false if no tokens found
     */
    public function deleteByAdminId(int $adminId): bool
    {
        $tokens = $this->em->getRepository(RefreshToken::class)->findBy(['adminId' => $adminId]);
        
        if (empty($tokens)) {
            return false;
        }

        foreach ($tokens as $token) {
            $this->em->remove($token);
        }
        
        $this->em->flush();
        return true;
    }

    /**
     * Deletes all refresh tokens for a specific user ID.
     * 
     * This is an alias method for deleteByAdminId() to maintain compatibility
     * with AuthService which uses userId terminology.
     * 
     * @param int $userId The ID of the user
     * @return bool Returns true on success, false if no tokens found
     */
    public function deleteByUserId(int $userId): bool
    {
        // Alias to deleteByAdminId for compatibility with AuthService
        return $this->deleteByAdminId($userId);
    }
}