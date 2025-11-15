<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\RefreshPromotions;

class RefreshPromotionsRequest
{
    public function __construct(
        public readonly int $userId
    ) {}
}