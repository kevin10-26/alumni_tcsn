<?php declare(strict_types=1);

namespace Alumni\Domain\ValueObject;

class EmailAddress
{
    public function __construct(
        private readonly string $value
    ) {
        if (!$this->isValid($value)) {
            throw new \InvalidArgumentException('Invalid email address');
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    private function isValid(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
