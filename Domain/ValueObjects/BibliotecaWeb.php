<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidBibliotecaWebException.php';

final class BibliotecaWeb
{
    private string $value;

    // La web es opcional: se permite cadena vacía (sin sitio web).
    public function __construct(string $value)
    {
        $normalized = trim($value);

        if ($normalized !== '' && !filter_var($normalized, FILTER_VALIDATE_URL)) {
            throw InvalidBibliotecaWebException::becauseFormatIsInvalid($normalized);
        }

        $this->value = $normalized;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function isEmpty(): bool
    {
        return $this->value === '';
    }

    public function equals(BibliotecaWeb $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
