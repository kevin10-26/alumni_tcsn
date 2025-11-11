<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\GetAdminDashboard;

use Alumni\Domain\Repository\DB\UserRepositoryInterface;
use Alumni\Domain\Repository\DB\JobOfferRepositoryInterface;
use Alumni\Domain\Repository\DB\StudentRepositoryInterface;

use Alumni\Domain\Service\UserServiceInterface;

use Alumni\Application\UseCase\GetAdminDashboard\GetAdminDashboardRequest;
use Alumni\Application\UseCase\GetAdminDashboard\GetAdminDashboardResponse;

class GetAdminDashboardUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserServiceInterface $userService,
        private readonly StudentRepositoryInterface $studentRepository,
        private readonly JobOfferRepositoryInterface $jobOfferRepository
    ) {}

    public function execute(GetAdminDashboardRequest $request): GetAdminDashboardResponse
    {
        $user = $this->userRepository->getBy(['id' => $request->id]);
        $jobOffers = $this->jobOfferRepository->getByAuthor($request->id);
        $savedOffers = $this->jobOfferRepository->getUserSavedOffers($request->id);
        $this->getUserPromotionsData($user->studentData);

        return new GetAdminDashboardResponse(
            user: $user,
            jobOffers: $jobOffers,
            savedOffers: $savedOffers,
            status: (!is_null($user)) ? 200 : 500
        );
    }

    private function getUserPromotionsData(array &$proms): void
    {
        foreach ($proms as $prom) {
            $students = $this->studentRepository->getStudentsForProm($prom->id);
        
            $prom->flags = [
                'delegates' => array_values(array_filter($students, fn($s) => $s->isDelegate)),
                'number_of_students' => count($students),
            ];
        }        
    }
}