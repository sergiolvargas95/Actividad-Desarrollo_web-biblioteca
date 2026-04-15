<?php

class InvalidBibliotecaPaisException extends InvalidArgumentException
{
    public static function becauseValueIsEmpty(): self
    {
        return new self('El país de la biblioteca no puede estar vacío.');
    }
}
