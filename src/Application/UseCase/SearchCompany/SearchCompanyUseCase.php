<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\SearchCompany;

use Alumni\Application\UseCase\SearchCompany\SearchCompanyRequest;
use Alumni\Application\UseCase\SearchCompany\SearchCompanyResponse;

use Alumni\Domain\Repository\DB\CompanyRepositoryInterface;

class SearchCompanyUseCase
{
    public function __construct(
        private readonly CompanyRepositoryInterface $companyRepository
    ) {}

    public function execute(SearchCompanyRequest $requestDTO): SearchCompanyResponse
    {
        $companies = $this->companyRepository->searchCompanies($requestDTO->input);

        return new SearchCompanyResponse(
            status: $companies ? 200 : 500,
            companies: $companies
        );
    }
}