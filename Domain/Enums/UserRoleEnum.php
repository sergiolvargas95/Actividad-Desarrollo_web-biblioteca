<?php

require_once __DIR__ . '/../Exceptions/InvalidUserRoleException.php';

class UserRoleEnum
{
    const ADMIN = 'ADMIN';
    const USER  = 'USER';
    const GUEST = 'GUEST';

    public static function values(): array
    {
        return array(self::ADMIN, self::USER, self::GUEST);
    }

    public static function isValid(string $value): bool
    {
        return in_array($value, self::values(), true);
    }

    public static function ensureIsValid(string $value): void
    {
        if (!self::isValid($value)) {
            throw InvalidUserRoleException::becauseValueIsInvalid($value);
        }
    }
}
