<?php

class BibliotecaAlreadyExistsException extends DomainException
{
    public static function becauseNombreAlreadyExists(string $nombre): self
    {
        return new self('Ya existe una biblioteca con el nombre: ' . $nombre);
    }
}
