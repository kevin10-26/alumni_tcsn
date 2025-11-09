<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB;

use Alumni\Domain\Repository\DB\EventRepositoryInterface;

use Alumni\Infrastructure\Entity\EventDoctrine;

use Alumni\Infrastructure\Repository\DB\Mapper\EventMapper;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Repository implementation for managing Event entities in the database.
 * 
 * This repository handles database operations for events, including
 * retrieval of recent events.
 */
class EventRepository implements EventRepositoryInterface
{
    /**
     * Creates a new instance of EventRepository.
     * 
     * @param EntityManagerInterface $em Doctrine entity manager for database operations
     * @param EventMapper $mapper Mapper for converting between domain and Doctrine entities
     */
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly EventMapper $mapper
    ) {}

    /**
     * Retrieves the last 5 events ordered by creation date (newest first).
     * 
     * @return array<Event> Array of the 5 most recent events as domain entities
     */
    public function getLastEvents(): array
    {
        $events = $this->em->getRepository(EventDoctrine::class)->findBy([], ['createdAt' => 'DESC'], 5);

        return array_map(fn(EventDoctrine $event) => $this->mapper->toDomain($event), $events);
    }
}