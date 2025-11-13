<?php declare(strict_types=1);

namespace Alumni\Domain\Entity;

class ChannelPost
{
    public function __construct(
        public readonly int $id,
        public readonly string $content,
        public readonly ?User $author,
        public readonly Channel $channel,
        public readonly \DateTime $createdAt,
        public readonly bool $modified,
        public readonly ?Survey $survey = null,
        public readonly array $attachments = []
    ) {}
}