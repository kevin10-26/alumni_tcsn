<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB\Mapper;

use Alumni\Domain\Entity\Event;
use Alumni\Infrastructure\Entity\EventDoctrine;

class EventMapper
{
    public function toDomain(EventDoctrine $eventDoctrine): Event
    {
        return new Event(
            id: $eventDoctrine->getId(),
            title: $eventDoctrine->getTitle(),
            description: $eventDoctrine->getDescription(),
            createdAt: $eventDoctrine->getCreatedAt(),
            updatedAt: $eventDoctrine->getUpdatedAt()
        );
    }

    public function toDoctrine(Event $event): EventDoctrine
    {
        $eventDoctrine = new EventDoctrine();
        $eventDoctrine->setTitle($event->title);
        $eventDoctrine->setDescription($event->description);
        $eventDoctrine->setCreatedAt($event->createdAt);
        $eventDoctrine->setUpdatedAt($event->updatedAt);
        
        return $eventDoctrine;
    }
}