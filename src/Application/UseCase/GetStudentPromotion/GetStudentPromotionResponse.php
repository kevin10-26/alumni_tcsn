<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\GetStudentPromotion;

class GetStudentPromotionResponse
{
    public function __construct(
        public readonly int $status
    ) {}
}