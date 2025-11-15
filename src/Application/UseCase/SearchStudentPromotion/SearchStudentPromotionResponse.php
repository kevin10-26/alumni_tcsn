<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\SearchStudentPromotion;

class SearchStudentPromotionResponse
{
    public function __construct(
        public readonly int $status,
        public readonly array $usernames
    ) {}
}