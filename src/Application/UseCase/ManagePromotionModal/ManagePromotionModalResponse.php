<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\ManagePromotionModal;

use Alumni\Domain\Entity\MasterProm;

class ManagePromotionModalResponse
{
    public function __construct(
        public readonly int $status,
        public readonly MasterProm $promotion,
        public readonly array $attachedDelegates
    ) {}
}