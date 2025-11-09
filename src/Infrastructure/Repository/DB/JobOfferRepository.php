<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB;

use Doctrine\ORM\EntityManagerInterface;

use Alumni\Infrastructure\Repository\DB\Mapper\JobOfferMapper;
use Alumni\Infrastructure\Entity\JobOfferDoctrine;
use Alumni\Infrastructure\Entity\UserDoctrine;

use Alumni\Domain\Repository\DB\JobOfferRepositoryInterface;
use Alumni\Domain\Entity\JobOffer;

/**
 * Repository implementation for managing JobOffer entities in the database.
 * 
 * This repository handles all database operations for job offers, including
 * retrieval by various criteria (all, by ID, by company, by author, saved offers).
 */
class JobOfferRepository implements JobOfferRepositoryInterface
{
    /**
     * Creates a new instance of JobOfferRepository.
     * 
     * @param JobOfferMapper $jobOfferMapper Mapper for converting between domain and Doctrine entities
     * @param EntityManagerInterface $em Doctrine entity manager for database operations
     */
    public function __construct(
        private readonly JobOfferMapper $jobOfferMapper,
        private readonly EntityManagerInterface $em
    ) {}

    /**
     * Retrieves all job offers from the database.
     * 
     * @return array<JobOffer> Array of all job offers as domain entities
     */
    public function getAll(): array
    {
        $offersDoctrine = $this->em->getRepository(JobOfferDoctrine::class)->findAll();
        $offers = [];

        foreach($offersDoctrine as $offer)
        {
            $offers[] = $this->jobOfferMapper->toDomain($offer);
        }

        return $offers;
    }

    /**
     * Retrieves a job offer by its ID.
     * 
     * @param int $id The job offer ID
     * @return JobOffer The found job offer as a domain entity
     */
    public function getById(int $id): JobOffer
    {
        $offer = $this->em->find(JobOfferDoctrine::class, $id);

        return $this->jobOfferMapper->toDomain($offer);
    }

    /**
     * Retrieves all job offers for a specific company.
     * 
     * @param int $companyId The ID of the company
     * @return array<JobOffer> Array of job offers for the company as domain entities
     */
    public function getByCompany(int $companyId): array
    {
        $offerDoctrine = $this->em->getRepository(JobOfferDoctrine::class)->findBy(['company' => $companyId]);
        $offers = [];

        foreach($offerDoctrine as $offer)
        {
            $offers[] = $this->jobOfferMapper->toDomain($offer);
        }

        return $offers;
    }

    /**
     * Retrieves all job offers created by a specific author.
     * 
     * @param int $authorId The ID of the author/user
     * @return array<JobOffer> Array of job offers created by the author as domain entities
     */
    public function getByAuthor(int $authorId): array
    {
        $offerDoctrine = $this->em->getRepository(JobOfferDoctrine::class)->findBy(['author' => $authorId]);
        $offers = [];

        foreach($offerDoctrine as $offer)
        {
            $offers[] = $this->jobOfferMapper->toDomain($offer);
        }

        return $offers;
    }

    /**
     * Retrieves all job offers saved by a specific user.
     * 
     * @param int $userId The ID of the user
     * @return array<JobOffer> Array of saved job offers as domain entities, empty array if user not found
     */
    public function getUserSavedOffers(int $userId): array
    {
        $user = $this->em->find(UserDoctrine::class, $userId);
        if (is_null($user))
        {
            return [];
        }

        $offers = [];
        foreach($user->getSavedOffers() as $offerDoctrine)
        {
            $offers[] = $this->jobOfferMapper->toDomain($offerDoctrine);
        }
        
        return $offers;
    }
}