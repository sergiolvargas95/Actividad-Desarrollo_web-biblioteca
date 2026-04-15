<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidBibliotecaDireccionException.php';

final class BibliotecaDireccion
{
    private string $value;

    public function __construct(string $value)
    {
        $normalized = trim($value);

        if ($normalized === '') {
            throw InvalidBibliotecaDireccionException::becauseValueIsEmpty();
        }

        $this->value = $normalized;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(BibliotecaDireccion $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
