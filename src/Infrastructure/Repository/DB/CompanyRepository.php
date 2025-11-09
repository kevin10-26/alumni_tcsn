<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB;

use Doctrine\ORM\EntityManagerInterface;
use Alumni\Infrastructure\Repository\DB\Mapper\CompanyMapper;

use Alumni\Domain\Entity\Company;
use Alumni\Infrastructure\Entity\CompanyDoctrine;

use Alumni\Domain\Repository\DB\CompanyRepositoryInterface;

/**
 * Repository implementation for managing Company entities in the database.
 * 
 * This repository handles all database operations for companies, including
 * retrieval and search functionality.
 */
class CompanyRepository implements CompanyRepositoryInterface
{
    /**
     * Creates a new instance of CompanyRepository.
     * 
     * @param EntityManagerInterface $em Doctrine entity manager for database operations
     * @param CompanyMapper $companyMapper Mapper for converting between domain and Doctrine entities
     */
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly CompanyMapper $companyMapper
    ) {}

    /**
     * Retrieves all companies from the database.
     * 
     * @return array<Company> Array of all companies as domain entities
     */
    public function getAll(): array
    {
        $doctrineCompanies = $this->em->getRepository(CompanyDoctrine::class)->findAll();
        $companies = [];

        foreach($doctrineCompanies as $company)
        {
            $companies[] = $this->companyMapper->toDomain($company);
        }

        return $companies;
    }

    /**
     * Retrieves a single company by the given conditions.
     * 
     * @param array<string, mixed> $condition Associative array of field => value pairs to search for
     * @return Company The found company as a domain entity
     */
    public function getBy(array $condition): Company
    {
        $company = $this->em->getRepository(CompanyDoctrine::class)->findBy($condition)[0];

        return $this->companyMapper->toDomain($company);
    }

    /**
     * Searches for companies by name using a LIKE query.
     * 
     * This method performs a case-insensitive partial match on company names.
     * 
     * @param string $name The search term (partial company name)
     * @return array<Company> Array of matching companies as domain entities
     */
    public function searchCompanies(string $name): array
    {
        $qb = $this->em->getRepository(CompanyDoctrine::class)->createQueryBuilder('c')
            ->where('c.companyName LIKE :companyName')
            ->setParameter('companyName', "%$name%")
            ->getQuery()
            ->getResult();
        
        $companies = [];

        foreach($qb as $company)
        {
            $companies[] = $this->companyMapper->toDomain($company);
        }

        return $companies;
    }
}