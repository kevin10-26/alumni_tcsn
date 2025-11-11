<?php declare(strict_types=1);

namespace Alumni\Domain\Service;

interface MailingServiceInterface
{
    public function send(string $body, string $to, array $flags = []): bool;
}