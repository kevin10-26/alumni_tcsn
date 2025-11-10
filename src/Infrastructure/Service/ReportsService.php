<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Service;

use Alumni\Domain\Repository\DB\ChannelRepositoryInterface;
use Alumni\Domain\Repository\DB\ChannelPostRepositoryInterface;
use Alumni\Domain\Repository\DB\UserRepositoryInterface;

use Alumni\Domain\Service\ReportsServiceInterface;

/**
 * Service implementation for reporting operations.
 * 
 * This service handles reporting routing (for post, channel, user, etc.).
 * It uses a string corresponding to the origin of the report to determine the entity to return.
 */
class ReportsService implements ReportsServiceInterface
{
    public function __construct(
        private readonly ChannelRepositoryInterface $channelRepository,
        private readonly ChannelPostRepositoryInterface $channelPostRepository,
        private readonly UserRepositoryInterface $userRepository
    ) {}
    /**
     * Routing for reporting type
     * 
     * This method returns the entity corresponding to the report type provided by the UI.
     * 
     * @param string $reportType: the report type provided by the frontend.
     * @param int $entityId: the entity id to fetch.
     * @return mixed<Channel|ChannelPost|User>
     * @throws \RuntimeException if the $reportType doesn't exist.
     */
    public function getReportType(string $reportType, int $entityId): object
    {
        switch ($reportType)
        {
            case 'channel':
                return $this->channelRepository->getById($entityId);
                break;
            
            case 'channelPost':
                return $this->channelPostRepository->getPostBy(['id' => $entityId]);
                break;
            
            case 'channelPost':
                return $this->userRepository->getBy(['id' => $entityId]);
                break;

            default:
                throw new \RuntimeException('Ce type d\'entité n\'existe pas.');
        }
    }
}