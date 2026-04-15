<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/LoginUseCase.php';
require_once __DIR__ . '/../Ports/Out/GetUserByEmailPort.php';
require_once __DIR__ . '/Dto/Commands/LoginCommand.php';
require_once __DIR__ . '/../../Domain/Exceptions/InvalidCredentialsException.php';
require_once __DIR__ . '/../../Domain/ValueObjects/UserEmail.php';

final class LoginService implements LoginUseCase
{
    private GetUserByEmailPort $getUserByEmailPort;

    public function __construct(GetUserByEmailPort $getUserByEmailPort)
    {
        $this->getUserByEmailPort = $getUserByEmailPort;
    }

    public function execute(LoginCommand $command): UserModel
    {
        $email = new UserEmail($command->getEmail());
        $user  = $this->getUserByEmailPort->getByEmail($email);

        if ($user === null) {
            throw InvalidCredentialsException::becauseCredentialsAreInvalid();
        }

        if ($user->password()->value() !== $command->getPassword()) {
            throw InvalidCredentialsException::becauseCredentialsAreInvalid();
        }

        return $user;
    }
}
