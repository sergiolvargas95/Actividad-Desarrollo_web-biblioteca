<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidBibliotecaNombreException.php';

final class BibliotecaNombre
{
    private string $value;

    public function __construct(string $value)
    {
        $normalized = trim($value);

        if ($normalized === '') {
            throw InvalidBibliotecaNombreException::becauseValueIsEmpty();
        }

        if (mb_strlen($normalized) < 3) {
            throw InvalidBibliotecaNombreException::becauseLengthIsTooShort(3);
        }

        $this->value = $normalized;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(BibliotecaNombre $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
