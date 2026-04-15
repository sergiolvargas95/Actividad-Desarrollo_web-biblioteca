<?php

class InvalidBibliotecaNombreException extends InvalidArgumentException
{
    public static function becauseValueIsEmpty(): self
    {
        return new self('El nombre de la biblioteca no puede estar vacío.');
    }

    public static function becauseLengthIsTooShort(int $min): self
    {
        return new self('El nombre de la biblioteca debe tener al menos ' . $min . ' caracteres.');
    }
}
