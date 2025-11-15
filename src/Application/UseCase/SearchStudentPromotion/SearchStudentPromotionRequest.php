<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\SearchStudentPromotion;

class SearchStudentPromotionRequest
{
    public function __construct(
        public readonly int $userId,
        public readonly string $input
    ) {}
}