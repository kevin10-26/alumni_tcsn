<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\ListAllJobOffers;

class ListAllJobOffersResponse
{
    public function __construct(
        public readonly array $allOffers,
        public readonly array $userApplications,
        public readonly int $status
    ) {}
}