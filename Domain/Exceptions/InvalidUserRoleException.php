<?php

class InvalidUserRoleException extends InvalidArgumentException
{
    public static function becauseValueIsInvalid($value)
    {
        return new self("El rol " . $value . "No es un rol válido.");
    }
}