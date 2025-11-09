<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\RemoveChannel;

class RemoveChannelResponse
{
    public function __construct(
        public readonly int $status,
        public readonly bool $channelHasBeenRemoved,
        public readonly ?string $msg = ''
    ) {}
}