<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Service;

use Alumni\Domain\Service\ChannelServiceInterface;
use Alumni\Domain\Repository\DB\ChannelRepositoryInterface;

/**
 * Service implementation for channel-related business logic.
 * 
 * This service handles operations such as field mapping between frontend
 * and database, and founder verification.
 */
class ChannelService implements ChannelServiceInterface
{
    /**
     * Mapping between frontend field names and database column names.
     * 
     * @var array<string, string>
     */
    private const MAPPED_COLUMNS = [
        'channel-title' => 'name',
        'channel-description' => 'description'
    ];

    /**
     * Creates a new instance of ChannelService.
     * 
     * @param ChannelRepositoryInterface $channelRepository Repository for channel operations
     */
    public function __construct(
        private readonly ChannelRepositoryInterface $channelRepository
    ) {}

    /**
     * Maps a frontend field name to its corresponding database column name.
     * 
     * @param string $frontendField The frontend field name (e.g., 'channel-title')
     * @return string The corresponding database column name (e.g., 'name')
     */
    public function getRealColumns(string $frontendField): string
    {
        return self::MAPPED_COLUMNS[$frontendField];
    }

    /**
     * Verifies if a user is the founder of a channel and validates their password.
     * 
     * This method checks if the given user ID matches the channel's founder ID
     * and verifies the provided password against the founder's password hash.
     * 
     * @param int $userId The ID of the user to verify
     * @param int $channelId The ID of the channel
     * @param string $userPassword The password to verify
     * @return bool Returns true if the user is the founder and the password is correct, false otherwise
     */
    public function checkFounder(
        int $userId,
        int $channelId,
        string $userPassword
    ): bool
    {
        $channel = $this->channelRepository->getById($channelId);

        return $userId === $channel->founder->id && password_verify($userPassword, $channel->founder->passwordHash);
    }
}