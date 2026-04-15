<?php

class InvalidBibliotecaDireccionException extends InvalidArgumentException
{
    public static function becauseValueIsEmpty(): self
    {
        return new self('La dirección de la biblioteca no puede estar vacía.');
    }
}
