<?php

require_once __DIR__ . '/../Exceptions/InvalidUserPasswordException.php';

class UserPassword
{
    private $value;

    public function __construct($value)
    {
        $normalized = trim((string) $value);

        if($normalized === '') {
            throw InvalidUserPasswordException::becauseValueIsEmpty();
        }

        if(strlen($normalized) < 8) {
            throw InvalidUserPasswordException::becauseLengthIsTooShort(8);
        }

        $this->value = $normalized;
    }

    public function value() {
        return $this->value;
    }

    public function equals(UserPassword $other): bool
    {
        return $this->value === $other->value();
    }

    public static function fromHash(string $hash): self
    {
        $instance = new self($hash);
        return $instance;
    }

    public static function fromPlainText(string $plain): self
    {
        return new self($plain);
    }

    public function __toString()
    {
        return $this->value;
    }
}