<?php declare(strict_types=1);

namespace Alumni\Domain\Service;

interface ChannelServiceInterface
{
    public function getRealColumns(string $frontendField): string;

    public function checkFounder(
        int $userId,
        int $channelId,
        string $userPassword
    ): bool;
}