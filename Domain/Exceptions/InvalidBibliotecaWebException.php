<?php

class InvalidBibliotecaWebException extends InvalidArgumentException
{
    public static function becauseFormatIsInvalid(string $value): self
    {
        return new self('El formato de la URL web de la biblioteca es inválido: ' . $value);
    }
}
