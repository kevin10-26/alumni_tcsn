<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\ListAllJobOffers;

class ListAllJobOffersRequest
{
    public function __construct(
        public readonly int $userId
    ) {}
}