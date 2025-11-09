<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB\Mapper;

use Alumni\Domain\Entity\Channel;
use Alumni\Infrastructure\Entity\ChannelDoctrine;

class ChannelMapper
{
    public function __construct(
        private readonly UserMapper $userMapper
    ) {}

    public function toDomain(ChannelDoctrine $channelDoctrine): Channel
    {
        return new Channel(
            id: $channelDoctrine->getId(),
            name: $channelDoctrine->getName(),
            description: $channelDoctrine->getDescription(),
            thumbnail: $channelDoctrine->getThumbnail(),
            isPublic: $channelDoctrine->getIsPublic(),
            founder: $this->userMapper->toDomain($channelDoctrine->getFounder())
        );
    }

    public function toDoctrine(Channel $channel): ChannelDoctrine
    {
        $channelDoctrine = new ChannelDoctrine();
        $channelDoctrine->setName($channel->name);
        $channelDoctrine->setDescription($channel->description);
        $channelDoctrine->setThumbnail($channel->thumbnail);
        $channelDoctrine->setIsPublic($channel->isPublic);
        $channelDoctrine->setFounder($this->userMapper->toDoctrine($channel->founder));

        return $channelDoctrine;
    }
}