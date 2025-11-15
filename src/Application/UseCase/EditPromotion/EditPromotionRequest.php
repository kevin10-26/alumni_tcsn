<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\EditPromotion;

class EditPromotionRequest
{
    public function __construct(
        public readonly int $userId,
        public readonly int $promId,
        public readonly string $name,
        public readonly int $year,
        public readonly array $students,
        public readonly array $delegates
    ) {}
}