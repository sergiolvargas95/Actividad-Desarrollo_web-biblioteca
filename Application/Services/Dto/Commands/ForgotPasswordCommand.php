<?php

declare(strict_types=1);

final class ForgotPasswordCommand
{
    private string $email;

    public function __construct(string $email)
    {
        $this->email = trim(strtolower($email));
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
