<?php
declare(strict_types=1);


require_once __DIR__ . '/../../../Domain'

interface DeleteUserPort
{
    public function delete(UserId $userId): void;
}
