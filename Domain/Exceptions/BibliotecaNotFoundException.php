<?php

class BibliotecaNotFoundException extends DomainException
{
    public static function becauseIdWasNotFound(string $id): self
    {
        return new self('No se encontró una biblioteca con el ID: ' . $id);
    }
}
