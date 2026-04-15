<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidBibliotecaEmailException.php';

final class BibliotecaEmail
{
    private string $value;

    public function __construct(string $value)
    {
        $normalized = trim($value);

        if ($normalized === '') {
            throw InvalidBibliotecaEmailException::becauseValueIsEmpty();
        }

        if (!filter_var($normalized, FILTER_VALIDATE_EMAIL)) {
            throw InvalidBibliotecaEmailException::becauseFormatIsInvalid($normalized);
        }

        $this->value = strtolower($normalized);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(BibliotecaEmail $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
