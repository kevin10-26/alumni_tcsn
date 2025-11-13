<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\EditAnnounce;

class EditAnnounceResponse
{
    public function __construct(
        public readonly int $status
    ) {}
}