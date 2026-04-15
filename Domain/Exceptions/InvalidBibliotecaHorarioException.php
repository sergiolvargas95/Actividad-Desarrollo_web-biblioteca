<?php

class InvalidBibliotecaHorarioException extends InvalidArgumentException
{
    public static function becauseValueIsEmpty(): self
    {
        return new self('El horario de la biblioteca no puede estar vacío.');
    }

    public static function becauseFormatIsInvalid(string $value): self
    {
        return new self('El formato del horario es inválido (se espera HH:MM): ' . $value);
    }
}
