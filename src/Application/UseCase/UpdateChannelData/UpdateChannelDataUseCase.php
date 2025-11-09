<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UpdateChannelData;

use Alumni\Domain\Repository\DB\ChannelRepositoryInterface;
use Alumni\Domain\Service\ChannelServiceInterface;

class UpdateChannelDataUseCase
{
    public function __construct(
        private readonly ChannelRepositoryInterface $channelRepository,
        private readonly ChannelServiceInterface $channelService
    ) {}

    public function execute(UpdateChannelDataRequest $requestDTO): UpdateChannelDataResponse
    {
        $field = $this->channelService->getRealColumns($requestDTO->field);
        $update = $this->channelRepository->update($requestDTO->channelId, [$field => $requestDTO->value]);

        return new UpdateChannelDataResponse(
            status: $update ? 200 : 500,
            msg: $update ? 'Le channel a bien été mis à jour' : 'Erreur lors de la mise à jour du channel'
        );
    }
}