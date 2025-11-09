<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\GetAdminDashboard;

class GetAdminDashboardRequest
{
    public function __construct(
        public readonly int $id
    ) {}
}