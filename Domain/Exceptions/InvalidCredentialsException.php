<?php

class InvalidCredentialsException extends DomainException
{
    public static function becauseCredentialsAreInvalid(): self
    {
        return new self('Correo o contraseña incorrectos.');
    }
}
