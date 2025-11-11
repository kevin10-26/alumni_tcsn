<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB;

use Doctrine\ORM\EntityManagerInterface;

use Alumni\Infrastructure\Entity\ChannelMembershipDoctrine;
use Alumni\Infrastructure\Entity\ChannelDoctrine;
use Alumni\Infrastructure\Entity\UserDoctrine;

use Alumni\Infrastructure\Repository\DB\Mapper\ChannelMembershipMapper;
use Alumni\Infrastructure\Repository\DB\Mapper\UserMapper;

use Alumni\Domain\Entity\ChannelMembership;
use Alumni\Domain\Entity\User;

use Alumni\Domain\Repository\DB\ChannelMembershipRepositoryInterface;
use Alumni\Domain\Repository\DB\ChannelPostRepositoryInterface;

/**
 * Repository implementation for managing ChannelMembership entities in the database.
 * 
 * This repository handles all database operations for channel memberships, including
 * adding users to channels, removing users from channels, and retrieving membership information.
 */
class ChannelMembershipRepository implements ChannelMembershipRepositoryInterface
{
    /**
     * Creates a new instance of ChannelMembershipRepository.
     * 
     * @param EntityManagerInterface $em Doctrine entity manager for database operations
     * @param ChannelMembershipMapper $mapper Mapper for converting ChannelMembership entities
     * @param UserMapper $userMapper Mapper for converting User entities
     */
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly ChannelMembershipMapper $mapper,
        private readonly ChannelPostRepositoryInterface $channelPostRepository,
        private readonly UserMapper $userMapper
    ) {}

    /**
     * Retrieves all members for a specific channel.
     * 
     * @param int $channelId The ID of the channel
     * @return array<ChannelMembership> Array of memberships for the channel as domain entities
     */
    public function getMembersForChannel(int $channelId): array
    {
        $memberships = $this->em->getRepository(ChannelMembershipDoctrine::class)
            ->findBy(['channel' => $channelId]);

        return array_map(
            fn($membership) => $this->mapper->toDomain($membership),
            $memberships
        );
    }

    /**
     * Retrieves all channels that a user is a member of.
     * 
     * @param int $userId The ID of the user
     * @return array<ChannelMembership> Array of memberships for the user as domain entities
     */
    public function getChannelsForUser(int $userId): array
    {
        $memberships = $this->em->getRepository(ChannelMembershipDoctrine::class)
            ->findBy(['user' => $userId]);

        return array_map(
            fn($membership) => $this->mapper->toDomain($membership),
            $memberships
        );
    }

    /**
     * Retrieves all channels that a user is a member of for portability data.
     * 
     * @param int $userId The ID of the user
     * @return array<ChannelMembership> Array of memberships for the user as domain entities + the posts of this author per channel
     */
    public function getAllChannelsDataForUser(int $userId): array
    {
        $memberships = $this->em->getRepository(ChannelMembershipDoctrine::class)
            ->findBy(['user' => $userId]);

        return array_map(
            function($membership) {
                return [
                    'memberOf' => $this->mapper->toDomain($membership),
                    'posts' => $this->channelPostRepository->getPostsOfAuthorPerChannel($membership->getUser()->getId(), $membership->getChannel()->getId())
                ];
            },
            $memberships
        );
    }

    /**
     * Retrieves a specific user's membership in a specific channel.
     * 
     * @param int $userId The ID of the user
     * @param int $channelId The ID of the channel
     * @return ChannelMembership|null The membership as a domain entity, or null if not found
     */
    public function getUserChannelMembership(int $userId, int $channelId): ?ChannelMembership
    {
        $membership = $this->em->getRepository(ChannelMembershipDoctrine::class)
            ->findOneBy(['user' => $userId, 'channel' => $channelId]);

        return $membership ? $this->mapper->toDomain($membership) : null;
    }

    /**
     * Removes a user from a channel by channel name.
     * 
     * @param User $user The user to remove
     * @param string $channelName The name of the channel
     * @return bool Returns true on success, false if channel is not found
     */
    public function removeUserFromChannel(User $user, int $channelId): bool
    {
        $channel = $this->em->getRepository(ChannelDoctrine::class)->findOneBy(['id' => $channelId]);
        if (is_null($channel))
        {
            return false;
        }

        $membership = $this->em->getRepository(ChannelMembershipDoctrine::class)->findOneBy(['channel' => $channel]);

        $this->em->remove($membership);
        $this->em->flush();

        return true;
    }

    /**
     * Adds a user to a channel with the default 'student' role.
     * 
     * @param User $user The user to add to the channel
     * @param int $channelId The ID of the channel
     * @return bool Returns true on success, false if channel or user is not found
     */
    public function addUserToChannel(User $user, int $channelId): bool
    {
        $channel = $this->em->find(ChannelDoctrine::class, $channelId);
        $user = $this->em->getReference(UserDoctrine::class, $user->id);
        if (is_null($channel) || is_null($user))
        {
            return false;
        }

        $membership = new ChannelMembershipDoctrine();
        $membership->setUser($user);
        $membership->setChannel($channel);
        $membership->setJoinedAt(new \DateTime());
        $membership->setRole('student');

        $this->em->persist($membership);
        $this->em->flush();

        return true;
    }
}