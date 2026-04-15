<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidBibliotecaHorarioException.php';

final class BibliotecaHorario
{
    private string $value;

    public function __construct(string $value)
    {
        $normalized = trim($value);

        if ($normalized === '') {
            throw InvalidBibliotecaHorarioException::becauseValueIsEmpty();
        }

        // Formato HH:MM (00:00 – 23:59)
        if (!preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', $normalized)) {
            throw InvalidBibliotecaHorarioException::becauseFormatIsInvalid($normalized);
        }

        $this->value = $normalized;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(BibliotecaHorario $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
