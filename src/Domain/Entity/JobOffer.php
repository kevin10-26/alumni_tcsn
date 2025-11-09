<?php declare(strict_types=1);

namespace Alumni\Domain\Entity;

class JobOffer
{
    public function __construct(
        public readonly int $id,
        public readonly string $jobName,
        public readonly string $jobDescription,
        public readonly Company $company,
        public readonly string $jobType,
        public readonly ?string $minimumDuration,
        public readonly User $author
    ) {}
}