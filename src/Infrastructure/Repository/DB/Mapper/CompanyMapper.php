<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB\Mapper;

use Alumni\Domain\Entity\Company;
use Alumni\Infrastructure\Entity\CompanyDoctrine;

class CompanyMapper
{
    public function toDomain(CompanyDoctrine $companyDoctrine): Company
    {
        return new Company(
            id: $companyDoctrine->getId(),
            companyName: $companyDoctrine->getCompanyName(),
            logo: $companyDoctrine->getLogo()
        );
    }

    public function toDoctrine(Company $company): CompanyDoctrine
    {
        $companyDoctrine = new CompanyDoctrine();
        $companyDoctrine->setCompanyName($company->companyName);
        $companyDoctrine->setLogo($company->logo);
        
        return $companyDoctrine;
    }
}
