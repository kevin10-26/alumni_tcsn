<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\RemovePromotion;

class RemovePromotionRequest
{
    public function __construct(
        public readonly int $userId,
        public readonly int $promId
    ) {}
}