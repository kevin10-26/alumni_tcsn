<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB\Mapper;

use Alumni\Domain\Entity\ChannelMembership;
use Alumni\Infrastructure\Entity\ChannelMembershipDoctrine;

class ChannelMembershipMapper
{
    public function __construct(
        private readonly UserMapper $userMapper,
        private readonly ChannelMapper $channelMapper
    ) {}

    public function toDomain(ChannelMembershipDoctrine $membershipDoctrine): ChannelMembership
    {
        return new ChannelMembership(
            id: $membershipDoctrine->getId(),
            user: $this->userMapper->toDomain($membershipDoctrine->getUser()),
            channel: $this->channelMapper->toDomain($membershipDoctrine->getChannel()),
            joinedAt: $membershipDoctrine->getJoinedAt(),
            role: $membershipDoctrine->getRole()
        );
    }

    public function toDoctrine(ChannelMembership $membership): ChannelMembershipDoctrine
    {
        $membershipDoctrine = new ChannelMembershipDoctrine();
        $membershipDoctrine->setUser($this->userMapper->toDoctrine($membership->user));
        $membershipDoctrine->setChannel($this->channelMapper->toDoctrine($membership->channel));
        $membershipDoctrine->setJoinedAt($membership->joinedAt);
        $membershipDoctrine->setRole($membership->role);

        return $membershipDoctrine;
    }
}