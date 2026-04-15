<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/ForgotPasswordUseCase.php';
require_once __DIR__ . '/../Ports/Out/GetUserByEmailPort.php';
require_once __DIR__ . '/../Ports/Out/UpdateUserPort.php';
require_once __DIR__ . '/../../Domain/ValueObjects/UserEmail.php';
require_once __DIR__ . '/../../Domain/ValueObjects/UserPassword.php';
require_once __DIR__ . '/../../Domain/Enums/UserStatusEnum.php';

final class ForgotPasswordService implements ForgotPasswordUseCase
{
    private GetUserByEmailPort $getUserByEmailPort;
    private UpdateUserPort $updateUserPort;

    public function __construct(
        GetUserByEmailPort $getUserByEmailPort,
        UpdateUserPort $updateUserPort
    ) {
        $this->getUserByEmailPort = $getUserByEmailPort;
        $this->updateUserPort     = $updateUserPort;
    }

    public function execute(ForgotPasswordCommand $command): ?array
    {
        $email = new UserEmail($command->getEmail());
        $user  = $this->getUserByEmailPort->getByEmail($email);

        if ($user === null || $user->status() !== UserStatusEnum::ACTIVE) {
            return null;
        }

        $tempPassword = bin2hex(random_bytes(5)); // 10 hex chars, always >= 8
        $newPassword  = UserPassword::fromPlainText($tempPassword);
        $updatedUser  = $user->changePassword($newPassword);

        $this->updateUserPort->update($updatedUser);

        return array(
            'email'        => $user->email()->value(),
            'name'         => $user->name()->value(),
            'tempPassword' => $tempPassword,
        );
    }
}
