<?php declare(strict_types=1);

namespace Alumni\Domain\Repository\DB;

use Alumni\Domain\Entity\Channel;

interface ChannelRepositoryInterface
{
    /**
     * @return Channel[]
     */
    public function getAll(): array;

    public function getById(int $id): ?Channel;

    /**
     * @return Channel[]
     */
    public function getPublicChannels(): array;

    public function update(
        int $channelId,
        array $updates
    ): bool;

    public function remove(int $channelId): bool;
}