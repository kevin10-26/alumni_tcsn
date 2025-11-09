<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\ListAllChannels;

class ListAllChannelsResponse
{
    public function __construct(
        public readonly int $status,
        public readonly array $channels,
        public readonly array $userChannels
    ) {}
}