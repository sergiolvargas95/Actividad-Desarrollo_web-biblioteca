<?php

require_once __DIR__ . '/../ValueObjects/UserId.php';
require_once __DIR__ . '/../ValueObjects/UserName.php';
require_once __DIR__ . '/../ValueObjects/UserEmail.php';
require_once __DIR__ . '/../ValueObjects/UserPassword.php';
require_once __DIR__ . '/../Enums/UserRoleEnum.php';
require_once __DIR__ . '/../Enums/UserStatusEnum.php';

final class UserModel
{
    private UserId $id;
    private UserName $name;
    private UserEmail $email;
    private UserPassword $password;
    private string $role;
    private string $status;

    public function __construct(
        UserId $id, UserName $name, UserEmail $email, UserPassword $password, string $role, string $status
    )
    {
        UserRoleEnum::ensureIsValid($role);
        UserStatusEnum::ensureIsValid($status);

        $this->id       = $id;
        $this->name     = $name;
        $this->email    = $email;
        $this->password = $password;
        $this->role     = $role;
        $this->status   = $status;
    }

    //Factory: siempre crea con estado PENDING
    public static function create (
        UserId $id, UserName $name, UserEmail $email,
        UserPassword $password, string $role
    ): self {
        return new self($id, $name, $email, $password, $role, UserStatusEnum::PENDING);
    }

    //Getters
    public function id(): UserId {
        return $this->id;
    }

    public function name(): UserName {
        return $this->name;
    }

    public function email(): UserEmail {
        return $this->email;
    }

    public function password(): UserPassword {
        return $this->password;
    }

    public function role(): string {
        return $this->role;
    }

    public function status(): string {
        return $this->status;
    }

    // Comportamiento de dominio: inmutable, retorna nuevo objeto
    public function active(): self
    {
        return new self(
            $this->id, $this->name, $this->email,
            $this->password, $this->role, UserStatusEnum::ACTIVE
        );
    }

    public function desactive(): self
    {
        return new self(
            $this->id, $this->name, $this->email,
            $this->password, $this->role, UserStatusEnum::INACTIVE
        );
    }

    public function changePassword(UserPassword $password): self
    {
        return new self(
            $this->id, $this->name, $this->email,
            $password, $this->role, $this->status
        );
    }
}