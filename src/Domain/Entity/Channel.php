<?php declare(strict_types=1);

namespace Alumni\Domain\Entity;

class Channel
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $description,
        public readonly ?string $thumbnail,
        public readonly bool $isPublic,
        public readonly ?User $founder
    ) {}
}