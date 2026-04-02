<?php

require_once __DIR__ . '/EventDomian.php';
require_once __DIR__ . '/../Models/UserModel.php';

class UserDeletedDomainEvent extends DomainEvent
{
    private UserModel $user;

    public function __construct(UserModel $user)
    {
        parent::__construct('user.deleted');
        $this->user = $user;
    }

    public function user(): UserModel {
        return $this->user;
    }

    public function payload()
    {
        return [
            'id' => $this->user->id()->value()
        ];
    }
}