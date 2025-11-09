<?php declare(strict_types=1);

namespace Alumni\Domain\Repository\DB;

use Doctrine\ORM\EntityManagerInterface;

use Alumni\Domain\Entity\ChannelMembership;
use Alumni\Domain\Entity\User;

interface ChannelMembershipRepositoryInterface
{
    public function getMembersForChannel(int $channelId): array;

    public function getChannelsForUser(int $userId): array;

    public function getUserChannelMembership(int $userId, int $channelId): ?ChannelMembership;

    public function removeUserFromChannel(User $user, string $channelName): bool;

    public function addUserToChannel(User $user, int $channelId): bool;
}