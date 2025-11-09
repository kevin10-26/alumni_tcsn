<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB\Mapper;

use Alumni\Infrastructure\Entity\AnnounceDoctrine;
use Alumni\Domain\Entity\Announce;

class AnnounceMapper
{
    public function __construct(
        private readonly UserMapper $userMapper
    ) {}

    public function toDomain(AnnounceDoctrine $announce): Announce
    {
        return new Announce(
            id: $announce->getId(),
            title: $announce->getTitle(),
            content: $announce->getContent(),
            author: $this->userMapper->toDomain($announce->getAuthor()),
            publishedAt: $announce->getPublishedAt(),
            updatedAt: $announce->getUpdatedAt(),
        );
    }

    public function toDoctrine(Announce $announce): AnnounceDoctrine
    {
        $announceDoctrine = new AnnounceDoctrine();

        $announceDoctrine->setTitle($announce->title);
        $announceDoctrine->setContent($announce->content);
        $announceDoctrine->setAuthor($this->userMapper->toDoctrine($announce->author));
        $announceDoctrine->setPublishedAt($announce->getPublishedAt());
        $announceDoctrine->setUpdatedAt($announce->getUpdatedAt());

        return $announceDoctrine;
    }
}