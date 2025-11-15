<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\ShowBackoffice;

use Alumni\Domain\Repository\DB\ReportsRepositoryInterface;
use Alumni\Domain\Repository\DB\UserRepositoryInterface;
use Alumni\Domain\Repository\DB\RegistrationPoolRepositoryInterface;
use Alumni\Domain\Repository\DB\ChannelRepositoryInterface;
use Alumni\Domain\Repository\DB\AnnouncesRepositoryInterface;
use Alumni\Domain\Repository\DB\JobOfferRepositoryInterface;
use Alumni\Domain\Repository\DB\StudentRepositoryInterface;

class ShowBackofficeUseCase
{
    public function __construct(
        private readonly ReportsRepositoryInterface $reportsRepository,
        private readonly UserRepositoryInterface $userRepository,
        private readonly StudentRepositoryInterface $studentRepository,
        private readonly RegistrationPoolRepositoryInterface $registrationPoolRepository,
        private readonly AnnouncesRepositoryInterface $announcesRepository,
        private readonly ChannelRepositoryInterface $channelRepository,
        private readonly JobOfferRepositoryInterface $jobOfferRepository
    ) {}

    public function execute(ShowBackofficeRequest $request): ShowBackofficeResponse
    {
        return new ShowBackofficeResponse(
            status: 200,
            users: $this->userRepository->getAll(),
            registrationPool: $this->registrationPoolRepository->getAll(),
            promotions: $this->getPromotionsData(),
            reports: $this->reportsRepository->getAll(),
            announces: $this->announcesRepository->getAll(),
            channels: $this->channelRepository->getAll(),
            jobOffers: $this->jobOfferRepository->getAll()
        );
    }

    public function getPromotionsData(): array
    {
        $allPromotions = $this->studentRepository->getAllPromotions();

        foreach($allPromotions as $promotion)
        {
            $promotion->students = $this->studentRepository->getStudentsForPromotion($promotion->id);
        }

        return $allPromotions;
    }
}