<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\ListAllChannels;

class ListAllChannelsRequest
{
    public function __construct(
        public readonly int $userId
    ) {}
}