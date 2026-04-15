<?php

class InvalidBibliotecaTelefonoException extends InvalidArgumentException
{
    public static function becauseValueIsEmpty(): self
    {
        return new self('El teléfono de la biblioteca no puede estar vacío.');
    }

    public static function becauseFormatIsInvalid(string $value): self
    {
        return new self('El formato del teléfono es inválido: ' . $value);
    }
}
