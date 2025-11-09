<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\GetAdminDashboard;

use Alumni\Domain\Repository\DB\UserRepositoryInterface;
use Alumni\Domain\Repository\DB\JobOfferRepositoryInterface;

use Alumni\Application\UseCase\GetAdminDashboard\GetAdminDashboardRequest;
use Alumni\Application\UseCase\GetAdminDashboard\GetAdminDashboardResponse;

class GetAdminDashboardUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly JobOfferRepositoryInterface $jobOfferRepository
    ) {}

    public function execute(GetAdminDashboardRequest $request): GetAdminDashboardResponse
    {
        $user = $this->userRepository->getBy(['id' => $request->id]);
        $jobOffers = $this->jobOfferRepository->getByAuthor($request->id);
        $savedOffers = $this->jobOfferRepository->getUserSavedOffers($request->id);

        return new GetAdminDashboardResponse(
            user: $user,
            jobOffers: $jobOffers,
            savedOffers: $savedOffers,
            status: (!is_null($user)) ? 200 : 500
        );
    }
}