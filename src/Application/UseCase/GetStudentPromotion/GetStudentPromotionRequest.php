<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\GetStudentPromotion;

class GetStudentPromotionRequest
{
    public function __construct(
        public readonly int $userId,
        public readonly string $input
    ) {}
}