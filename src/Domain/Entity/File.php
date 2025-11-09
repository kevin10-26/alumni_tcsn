<?php declare(strict_types=1);

namespace Alumni\Domain\Entity;

/**
 * May be moved to Alumni\Domain\Entity\File later.
 */
class File
{
    public function __construct(
        public readonly string $name,
        public readonly string $tmpName,
        public readonly int $size,
        public readonly string $mimeType,
        public readonly int $errors,
        public ?string $url = '',
        public ?string $poolName = ''
    ) {}    
}