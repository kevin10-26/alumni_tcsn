<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB;

use Doctrine\ORM\EntityManagerInterface;
use Alumni\Infrastructure\Entity\AnnounceDoctrine;

use Alumni\Infrastructure\Repository\DB\Mapper\AnnounceMapper;
use Alumni\Infrastructure\Entity\UserDoctrine;

use Alumni\Domain\Entity\Announce;
use Alumni\Domain\Repository\DB\AnnouncesRepositoryInterface;

/**
 * Repository implementation for managing Announce entities in the database.
 * 
 * This repository handles all database operations for announcements, including
 * retrieval by various criteria.
 */
class AnnouncesRepository implements AnnouncesRepositoryInterface
{
    /**
     * Creates a new instance of AnnouncesRepository.
     * 
     * @param EntityManagerInterface $em Doctrine entity manager for database operations
     * @param AnnounceMapper $announceMapper Mapper for converting between domain and Doctrine entities
     */
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly AnnounceMapper $announceMapper
    ) {}

    /**
     * Retrieves all announcements from the database.
     * 
     * @return array<Announce> Array of all announcements as domain entities
     */
    public function getAll(): array
    {
        $announcesDoctrine = $this->em->getRepository(AnnounceDoctrine::class)->findAll();
        $announces = [];

        foreach ($announcesDoctrine as $announce)
        {
            $announces[] = $this->announceMapper->toDomain($announce);
        }

        return $announces;
    }

    /**
     * Retrieves a single announcement by the given conditions.
     * 
     * @param array<string, mixed> $condition Associative array of field => value pairs to search for
     * @return Announce The found announcement as a domain entity
     */
    public function getBy(array $condition): Announce
    {
        $announceDoctrine = $this->em->getRepository(AnnounceDoctrine::class)->findOneBy($condition);

        return $this->announceMapper->toDomain($announceDoctrine);
    }

    public function new(int $authorId, string $title, string $content): bool
    {
        $announce = new AnnounceDoctrine();
        $announce->setTitle($title);
        $announce->setContent($content);
        $announce->setAuthor($this->em->getReference(UserDoctrine::class, $authorId));
        $announce->setPublishedAt(new \DateTime('now'));
    
        $this->em->persist($announce);
        $this->em->flush();

        return true;
    }

    public function update(int $announceId, string $title, string $content): bool
    {
        $announce = $this->em->find(AnnounceDoctrine::class, $announceId);
        if (is_null($announce)) return null;

        $announce->setTitle($title);
        $announce->setContent($content);
        $announce->setUpdatedAt(new \DateTime('now'));
    
        $this->em->flush();

        return true;
    }

    public function remove(int $id): bool
    {
        $announce = $this->em->find(AnnounceDoctrine::class, $id);
        if (is_null($announce))
        {
            return false;
        }

        $this->em->remove($announce);
        $this->em->flush();

        return true;
    }
}