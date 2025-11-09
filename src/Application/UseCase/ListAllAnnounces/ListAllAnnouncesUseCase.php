<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\ListAllAnnounces;

use Alumni\Domain\Repository\DB\AnnouncesRepositoryInterface;

class ListAllAnnouncesUseCase
{
    public function __construct(
        private readonly AnnouncesRepositoryInterface $announcesRepository
    ) {}

    public function execute(ListAllAnnouncesRequest $requestDTO): ListAllAnnouncesResponse
    {
        $announces = $this->announcesRepository->getAll();

        return new ListAllAnnouncesResponse(
            announces: $announces,
            status: $announces ? 200 : 500
        );
    }
}