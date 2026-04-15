<?php

class InvalidBibliotecaEmailException extends InvalidArgumentException
{
    public static function becauseValueIsEmpty(): self
    {
        return new self('El email de la biblioteca no puede estar vacío.');
    }

    public static function becauseFormatIsInvalid(string $value): self
    {
        return new self('El formato del email de la biblioteca es inválido: ' . $value);
    }
}
