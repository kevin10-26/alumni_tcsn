<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\ListAllJobOffers;

use Alumni\Domain\Repository\DB\JobOfferRepositoryInterface;

class ListAllJobOffersUseCase
{
    public function __construct(
        private readonly JobOfferRepositoryInterface $jobOfferRepository
    ) {}

    public function execute(ListAllJobOffersRequest $requestDTO): ListAllJobOffersResponse
    {
        $jobOffers = $this->jobOfferRepository->getAll();

        return new ListAllJobOffersResponse(
            allOffers: $jobOffers,
            userApplications: [],
            status: $jobOffers ? 200 : 500
        );
    }
}