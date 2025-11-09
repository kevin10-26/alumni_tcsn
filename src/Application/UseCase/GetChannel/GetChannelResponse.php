<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\GetChannel;

use Alumni\Domain\Entity\Channel;
use Alumni\Domain\Entity\User;

class GetChannelResponse
{
    public function __construct(
        public readonly int $status,
        public readonly Channel $channel,
        public readonly array $posts,
        public readonly User $user,
        public readonly array $attachments,
        public readonly array $members
    ) {}
}