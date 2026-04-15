<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidBibliotecaTelefonoException.php';

final class BibliotecaTelefono
{
    private string $value;

    public function __construct(string $value)
    {
        $normalized = trim($value);

        if ($normalized === '') {
            throw InvalidBibliotecaTelefonoException::becauseValueIsEmpty();
        }

        // Acepta dígitos, espacios, guiones, paréntesis y el signo +
        if (!preg_match('/^\+?[\d\s\-().]{6,20}$/', $normalized)) {
            throw InvalidBibliotecaTelefonoException::becauseFormatIsInvalid($normalized);
        }

        $this->value = $normalized;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(BibliotecaTelefono $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
