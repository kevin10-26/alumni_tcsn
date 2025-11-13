<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB;

use Alumni\Domain\Entity\Channel;
use Alumni\Domain\Repository\DB\ChannelRepositoryInterface;
use Alumni\Infrastructure\Entity\ChannelDoctrine;
use Alumni\Infrastructure\Entity\UserDoctrine;
use Alumni\Infrastructure\Repository\DB\Mapper\ChannelMapper;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Repository implementation for managing Channel entities in the database.
 * 
 * This repository handles all database operations for channels, including
 * retrieval, updates, and deletion.
 */
class ChannelRepository implements ChannelRepositoryInterface
{
    /**
     * Creates a new instance of ChannelRepository.
     * 
     * @param EntityManagerInterface $em Doctrine entity manager for database operations
     * @param ChannelMapper $mapper Mapper for converting between domain and Doctrine entities
     */
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly ChannelMapper $mapper
    ) {}

    /**
     * Retrieves all channels from the database.
     * 
     * @return array<Channel> Array of all channels as domain entities
     */
    public function getAll(): array
    {
        $channels = $this->em->getRepository(ChannelDoctrine::class)->findAll();
        
        return array_map(
            fn(ChannelDoctrine $channel) => $this->mapper->toDomain($channel),
            $channels
        );
    }

    /**
     * Retrieves a channel by its ID.
     * 
     * @param int $id The channel ID
     * @return Channel|null The found channel as a domain entity, or null if not found
     */
    public function getById(int $id): ?Channel
    {
        $channel = $this->em->getRepository(ChannelDoctrine::class)->find($id);
        
        return $channel ? $this->mapper->toDomain($channel) : null;
    }

    /**
     * Retrieves all public channels.
     * 
     * @return array<Channel> Array of public channels as domain entities
     */
    public function getPublicChannels(): array
    {
        $channels = $this->em->getRepository(ChannelDoctrine::class)
            ->findBy(['isPublic' => true]);
            
        return array_map(
            fn(ChannelDoctrine $channel) => $this->mapper->toDomain($channel),
            $channels
        );
    }

    public function create(
        int $userId,
        string $name,
        string $description,
        bool $isPublic
    ): int
    {
        $channel = new ChannelDoctrine();
        $channel->setName($name);
        $channel->setDescription($description);
        $channel->setIsPublic($isPublic);
        $channel->setFounder($this->em->getReference(UserDoctrine::class, $userId));

        $this->em->persist($channel);
        $this->em->flush();

        return $channel->getId();
    }

    /**
     * Updates a channel field with a new value.
     * 
     * This method uses a DQL UPDATE query to update a single field of the channel.
     * Only the first key-value pair in the updates array is processed.
     * 
     * @param int $channelId The ID of the channel to update
     * @param array<string, mixed> $updates Associative array with field name as key and new value as value
     * @return bool Always returns true on success
     */
    public function update(
        int $channelId,
        array $updates
    ): bool
    {
        $channel = $this->em->find(ChannelDoctrine::class, $channelId);
        $field = array_key_first($updates);

        $updateQuery = $this->em->createQuery("UPDATE Alumni\Infrastructure\Entity\ChannelDoctrine c SET c.$field = :newValue WHERE c.id = :channelId");
        $updateQuery->setParameter('newValue', $updates[$field]);
        $updateQuery->setParameter('channelId', $channelId);
        $updateQuery->execute();

        return true;
    }

    /**
     * Removes a channel from the database.
     * 
     * @param int $channelId The ID of the channel to remove
     * @return bool Always returns true on success
     */
    public function remove(int $channelId): bool
    {
        $channel = $this->em->find(ChannelDoctrine::class, $channelId);
        
        $this->em->remove($channel);
        $this->em->flush();

        return true;
    }
}