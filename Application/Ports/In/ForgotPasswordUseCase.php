<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Commands/ForgotPasswordCommand.php';

/**
 * Returns an associative array with keys 'email', 'name', 'tempPassword'
 * when the user was found and updated, or null when not found / inactive
 * (null keeps the response generic to avoid user enumeration).
 */
interface ForgotPasswordUseCase
{
    public function execute(ForgotPasswordCommand $command): ?array;
}
