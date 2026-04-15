<?php

class InvalidBibliotecaIdException extends InvalidArgumentException
{
    public static function becauseValueIsEmpty(): self
    {
        return new self('El ID de la biblioteca no puede estar vacío.');
    }
}
