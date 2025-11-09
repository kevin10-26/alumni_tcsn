<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\GetAdminDashboard;

use Alumni\Domain\Entity\User;

class GetAdminDashboardResponse
{
    public function __construct(
        public readonly User $user,
        public readonly array $jobOffers,
        public readonly array $savedOffers,
        public readonly int $status
    ) {}
}