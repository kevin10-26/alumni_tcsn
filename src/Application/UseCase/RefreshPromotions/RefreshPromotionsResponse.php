<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\RefreshPromotions;

class RefreshPromotionsResponse
{
    public function __construct(
        public readonly array $promotions
    ) {}
}