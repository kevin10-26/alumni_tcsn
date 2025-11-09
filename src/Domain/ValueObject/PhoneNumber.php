<?php declare(strict_types=1);

namespace Alumni\Domain\ValueObject;

class PhoneNumber
{
    public function __construct(
        private readonly ?string $value
    ) {
        if ($value !== null && !$this->isValid($value)) {
            throw new \InvalidArgumentException('Invalid phone number');
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

    private function isValid(string $phone): bool
    {
        // Basic validation for phone number (allows international format)
        $cleaned = preg_replace('/[^0-9+]/', '', $phone);
        return strlen($cleaned) >= 8 && strlen($cleaned) <= 20;
    }

    public function __toString(): string
    {
        return $this->value ?? '';
    }
}
