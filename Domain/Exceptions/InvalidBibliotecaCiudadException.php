<?php

class InvalidBibliotecaCiudadException extends InvalidArgumentException
{
    public static function becauseValueIsEmpty(): self
    {
        return new self('La ciudad de la biblioteca no puede estar vacía.');
    }
}
