<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\Home;

class HomeRequest
{
    public function __construct(
        public int $adminId
    ) {}
}