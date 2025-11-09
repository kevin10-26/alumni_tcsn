<?php declare(strict_types=1);

namespace Alumni\Domain\ValueObject;

class Avatar
{
    public function __construct(
        private readonly ?string $value
    ) {
        if ($value !== null && !$this->isValid($value)) {
            throw new \InvalidArgumentException('Invalid avatar path');
        }
    }

    public function value(): ?string
    {
        return $this->value;
    }

    public function isEmpty(): bool
    {
        return $this->value === null || $this->value === '';
    }

    private function isValid(string $path): bool
    {
        // Basic validation for avatar path
        return strlen($path) <= 255 && !str_contains($path, '..');
    }

    public function __toString(): string
    {
        return $this->value ?? '';
    }
}
