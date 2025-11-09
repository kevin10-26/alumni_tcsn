<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\DB\Mapper;

use Alumni\Domain\Entity\JobOffer;
use Alumni\Infrastructure\Entity\JobOfferDoctrine;

class JobOfferMapper
{
    public function __construct(
        private readonly UserMapper $userMapper,
        private readonly CompanyMapper $companyMapper
    ) {}

    public function toDomain(JobOfferDoctrine $jobOffer): JobOffer
    {
        return new JobOffer(
            id: $jobOffer->getId(),
            jobName: $jobOffer->getJobName(),
            jobDescription: $jobOffer->getJobDescription(),
            company: $this->companyMapper->toDomain($jobOffer->getCompany()),
            jobType: $jobOffer->getJobType(),
            minimumDuration: $jobOffer->getMinimumDuration(),
            author: $this->userMapper->toDomain($jobOffer->getAuthor())
        );
    }

    public function toDoctrine(JobOffer $jobOffer): JobOfferDoctrine
    {
        $jobOfferDoctrine = new JobOfferDoctrine();

        $jobOfferDoctrine->setJobName($jobOffer->name);
        $jobOfferDoctrine->setJobDescription($jobOffer->description);
        $jobOfferDoctrine->setCompany($this->companyMapper->toDoctrine($jobOffer->company));
        $jobOfferDoctrine->setJobType($jobOffer->jobType);
        $jobOfferDoctrine->setMinimumDuration($jobOffer->minimumDuration);
        $jobOfferDoctrine->setAuthor($this->userMapper->toDoctrine($jobOffer->author));

        return $jobOfferDoctrine;
    }
}