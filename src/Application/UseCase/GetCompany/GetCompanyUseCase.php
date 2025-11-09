<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\GetCompany;

use Alumni\Application\UseCase\GetCompany\GetCompanyRequest;
use Alumni\Application\UseCase\GetCompany\GetCompanyResponse;

use Alumni\Domain\Repository\DB\CompanyRepositoryInterface;

class GetCompanyUseCase
{
    public function __construct(
        private readonly CompanyRepositoryInterface $companyRepository
    ) {}

    public function execute(GetCompanyRequest $requestDTO): GetCompanyResponse
    {
        $company = $this->companyRepository->getBy(['companyName' => $requestDTO->input]);

        return new GetCompanyResponse(
            status: $company ? 200 : 500,
            company: $company
        );
    }
}